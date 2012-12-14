<?php
header("Content-type: text/html; charset=utf-8");
include("base.php");
include("vrbo.php");
include("icietlavillas.php");

//$vrbo = new vrbo("http://www.vrbo.com/Calendar.mvc/Calendar/49395");
//$vrbo->getinfo();

$icietlavillas = new icietlavillas("http://www.icietlavillas.com/estate-details/villa/weekly-rental/adamas/st-barts?locale=en-US");
$icietlavillas->getinfo();
?>