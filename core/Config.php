<?php

session_start();
ob_start();

date_default_timezone_set("America/Sao_Paulo");

define('URL', 'http://localhost/mercury/');
define('URLADM', 'http://localhost/mercury/');

define('CONTROLER', 'Home');
define('METODO', 'index');
define('LIMIT', 20);
define('SUPADMPERMITION', 1);
define('ADMPERMITION', 2);
define('STOREPERMITION', 17);
define('FINANCIALPERMITION', 9);
define('FINANCIALPERMITIONONE', 10);
define('DP', 7);

define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DBNAME', 'meiaso26_bd_meiasola');
define('PORT', 3306);
define('POWERBI', 'fSKnOXkXyNAV3U5B');

define('HOSTCIGAM', 'meiasolab.cigamgestor.com.br');
define('USERCIGAM', 'bi_msl');
define('PASSCIGAM', 'bi_msl102030');
define('DBNAMECIGAM', 'RZMS');
