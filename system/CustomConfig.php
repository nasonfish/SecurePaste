<?php
global $_CONFIG;
$_CONFIG = array();

$_CONFIG['text'] = 'Paste your text in here and pick a syntax for highlighting below!';

$_CONFIG['main:title'] = '"Paste it!"';

include('../libs/Handler.class.php');
global $handler;
$handler = new Handler;
