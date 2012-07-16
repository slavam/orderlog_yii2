<?php
// ** MySQL settings ** //
//define('DB_NAME', 'northwind');    // The name of the database
//define('DB_HOST', 'localhost');    // 99% chance you won't need to change this value
define('DB_DSN','pgsql:host=dev1-d00;port=5432;dbname=orderlog_development');
define('DB_USER', 'postgres');     // Your MySQL username
define('DB_PASSWORD', 'postgres'); // ...and password

define('ABSPATH', dirname(__FILE__).'/');
//require_once(ABSPATH.'tabs.php');
?>