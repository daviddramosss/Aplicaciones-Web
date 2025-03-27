<?php

namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw\entidades\usuario\userAppService;
use mysqli; // Importamos la clase mysqli que no está en nuestro namespace

class application
{
	private static $instancia;
	
	public static function getInstance() 
	{
		if ( !self::$instancia instanceof self ) 
		{
			self::$instancia = new static();
		}
		
		return self::$instancia;
	}

	private function __construct()
	{
	}

	private $bdDatosConexion;
	
	private $inicializada = false;
	
	private $conn;

	private $atributosPeticion;

	const ATRIBUTOS_PETICION = 'attsPeticion';
	
	public function init($bdDatosConexion)
	{
        if ( ! $this->inicializada ) 
		{
    	    $this->bdDatosConexion = $bdDatosConexion;
    		
			$this->inicializada = true;
    		
			if (session_status() === PHP_SESSION_NONE) {
				session_start();
			}

			$this->atributosPeticion = $_SESSION[self::ATRIBUTOS_PETICION] ?? [];
			
			unset($_SESSION[self::ATRIBUTOS_PETICION]);
        }
	}
	
	public function shutdown()
	{
	    $this->compruebaInstanciaInicializada();
	    
		if ($this->conn !== null && ! $this->conn->connect_errno) 
		{
	        $this->conn->close();
	    }
	}
	
	private function compruebaInstanciaInicializada()
	{
	    if (! $this->inicializada ) 
		{
	        echo "Aplicacion no inicializa";
	        exit();
	    }
	}
	
	public function getConexionBd()
	{
	    $this->compruebaInstanciaInicializada();
		
		if (! $this->conn ) 
		{
			$bdHost = $this->bdDatosConexion['host'];
			$bdUser = $this->bdDatosConexion['user'];
			$bdPass = $this->bdDatosConexion['pass'];
			$bd     = $this->bdDatosConexion['bd'];
			
			//$driver = new mysqli_driver();
			
			//$driver->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;

			$conn = new mysqli($bdHost, $bdUser, $bdPass, $bd);
			
			if ( $conn->connect_errno ) 
			{
				echo "Error de conexión a la BD ({$conn->connect_errno}):  {$conn->connect_error}";
				exit();
			}
			
			if ( ! $conn->set_charset("utf8mb4")) 
			{
				echo "Error al configurar la BD ({$conn->errno}):  {$conn->error}";
				exit();
			}
			
			$this->conn = $conn;
		}
		
		return $this->conn;
	}

	public function putAtributoPeticion($clave, $valor)
	{
		$atts = null;
		
		if (isset($_SESSION[self::ATRIBUTOS_PETICION])) 
		{
			$atts = &$_SESSION[self::ATRIBUTOS_PETICION];
		} 
		else 
		{
			$atts = array();
			
			$_SESSION[self::ATRIBUTOS_PETICION] = &$atts;
		}

		$atts[$clave] = $valor;
	}

	public function getAtributoPeticion($clave)
	{
		$result = $this->atributosPeticion[$clave] ?? null;
		
		if(is_null($result) && isset($_SESSION[self::ATRIBUTOS_PETICION])) 
		{
			$result = $_SESSION[self::ATRIBUTOS_PETICION][$clave] ?? null;
		}
		
		return $result;
	}

	public function getIdUsuario()
	{
		if(isset($_SESSION['login'])){

			$ususarioService = userAppService::GetSingleton();

			$foundedUser = $ususarioService->buscarUsuario($_SESSION['usuario']);

			if($foundedUser)
				return $foundedUser->getId();
			else	
				return false;
		}
	}

	public function isLogged()
	{
		if(isset($_SESSION['login'])){
			return true;
		}
		return false;
	}

	public function getEmail()
	{
		return $_SESSION['usuario'];
	}
}