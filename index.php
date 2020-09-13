<?php
header("Content-Type:text/html;charset=UTF-8");

require_once(getcwd()."/config.php");


include_once("controller/Controller.php");
$controller = new Controller();
$controller->invoke();

?>