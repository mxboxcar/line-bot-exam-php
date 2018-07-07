<?php 
error_reporting( error_reporting() & ~E_NOTICE );

define( 'dbname', 'admin_p_yd' );
define( 'host', '207.148.67.204' );
define( 'username', 'admin_p_yd' );
define( 'password', 'antonioreyes123A' );


function OpenDB() {
	$connection = mysql_connect(host,username,password);
	mysql_select_db(dbname);
	mysql_query("SET NAMES utf8");
	mysql_query("SET character_set_results=utf8");
	mysql_query("SET character_set_client=utf8");
	mysql_query("SET character_set_connection=utf8");
	mysql_query("SET time_zone = '+7:00'");
}

function CloseDB() {
	mysql_close();
}

?>