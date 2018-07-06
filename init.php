<?php
$opt = array(
		'host' => 'localhost',
		'user' => 'omsk_cash-flow',
		'pass' => 'cash-flow12021982',
		'db' => 'omsk_monetka'
);

require_once('class.DB.php');

$db = new SafeMySQL($opt);

?>