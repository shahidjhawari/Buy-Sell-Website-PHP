<?php
session_start();
$con=mysqli_connect("localhost","root","","barayefrokht");
define('SERVER_PATH',$_SERVER['DOCUMENT_ROOT'].'/barayefrokht');
define('SITE_PATH','http://127.0.0.1/barayefrokht');

define('PRODUCT_IMAGE_SERVER_PATH',SERVER_PATH.'media/images/');
define('PRODUCT_IMAGE_SITE_PATH',SITE_PATH.'media/images/');
?>