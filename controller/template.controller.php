<?php

class ControllerTemplate
{

	/*=============================================
	Llamada a la plantilla
	=============================================*/

	public function ctrBringTemplate()
	{

		$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 'inicio';

		if ($pagina != "404") {
			include "view/dashboard.php";
		} else {
			include "view/error404.php";
		}

	}

}