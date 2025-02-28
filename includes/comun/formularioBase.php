<?php

abstract class formBase
{
    private $formId;

    private $action;

    public function __construct($formId, $opciones = array() )
    {
        $this->formId = $formId;

        $opcionesPorDefecto = array( 'action' => null, );
        
        $opciones = array_merge($opcionesPorDefecto, $opciones);

        $this->action   = $opciones['action'];
        
        if ( !$this->action ) 
        {
            $this->action = htmlentities($_SERVER['PHP_SELF']);
        }
    }
  
    public function Manage()
    {   
        if ( ! $this->IsSent($_POST) ) 
		{
            return $this->Create();
        } 
		else 
		{
            $result = $this->Process($_POST);
            
			if ( is_array($result) ) 
			{
                return $this->Create($result, $_POST);
            } 
			else 
			{
                header('Location: '.$result);
                
				exit();
            }
        }  
    }

    private function IsSent(&$params)
    {
        return isset($params['action']) && $params['action'] == $this->formId;
    } 

    private function Create($errores = array(), &$datos = array())
    {
        $html= $this->CreateErrors($errores);

        $html .= '<form method="POST" action="'.$this->action.'" id="'.$this->formId.'" >';
        $html .= '<input type="hidden" name="action" value="'.$this->formId.'" />';

        $html .= $this->CreateFields($datos);
        $html .= '</form>';
        
        return $html;
    }

    private function CreateErrors($errores)
    {
        $html='';
        $numErrores = count($errores);
        if (  $numErrores == 1 ) 
		{
            $html .= "<ul><li>".$errores[0]."</li></ul>";
        } 
		else if ( $numErrores > 1 ) 
		{
            $html .= "<ul><li>";
            $html .= implode("</li><li>", $errores);
            $html .= "</li></ul>";
        }
        return $html;
    }

    protected function CreateFields($datosIniciales)
    {
        return '';
    }

    protected function Process($datos)
    {
        return array();
    }
}
