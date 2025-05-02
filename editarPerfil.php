<?php

require_once("includes/config.php");

use es\ucm\fdi\aw\helpers\editarPerfilForm;

// Se define el título de la página.
$tituloPagina = 'Editar Perfil';

// Se instancia un objeto de la clase crearRecetaForm.
$form = new editarPerfilForm();
$form->init();
$htmlFormEditarPerfil = $form->Manage();

// Define el contenido principal de la página, que será insertado en la plantilla
$contenidoPrincipal = <<<EOS
    $htmlFormEditarPerfil
EOS;

// Se incluye la plantilla principal, que estructura la página con cabecera, pie y contenido principal
require("includes/comun/plantilla.php");


?> 