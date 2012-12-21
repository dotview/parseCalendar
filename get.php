<?php
header("Content-type: text/html; charset=utf-8");
include("lib/base.php");
include("lib/simple_html_dom.php");
include("lib/vrbo.php");
include("lib/icietlavillas.php");
include("lib/bajanservices.php");
include("lib/exclusivecaribbean.php");

//$svr = new vrbo();
//$svr->getinfo("http://www.vrbo.com/Calendar.mvc/Calendar/49395");

//$svr = new icietlavillas();
//$svr->getinfo("http://www.icietlavillas.com/estate-details/villa/weekly-rental/adamas/st-barts?locale=en-US");

//$svr = new bajanservices();
//$svr->getinfo("http://reservations.bajanservices.com/IRMNet/(S(2oxaypefoudv2v45mdfq1x55))/res/RoomDetailsPage.aspx?Resort=01&RoomNum=ALLYN");

$svr = new exclusivecaribbean();
$svr->getinfo("http://calendar.exclusivecaribbeanproperty.com/index.php/bookings/get_year/104/2012-12-01/TRUE/");


?>