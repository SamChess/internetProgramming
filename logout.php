<?php 
	include_once 'user.php';
    $instance = new User('','','',$username,$password);
	$instance->logout();
 ?>