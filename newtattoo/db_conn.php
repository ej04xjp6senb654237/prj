<?php

//�{���\��
//	�]�wmysql���|
$DBUSER="root";
$DBNAME="ec004";
$DBPSWD="54321bi";
$link = mysql_connect ("localhost", $DBUSER, $DBPSWD) or die("�L�k�s����Ʈw: " . mysql_error( ));

 if(!$link){
      die("�L�k�s����Ʈw<br>" . mysql_error( )); }

$DB=mysql_select_db($DBNAME,$link)or die("�L�k��ܸ�Ʈw");
 if(!$DB){
      die("�L�k��ܸ�Ʈw:<br> " . mysql_error( )); }

$SQL_select="SET CHARACTER SET utf8";
mysql_query($SQL_select,$link) or die ("<br>�L�k����d��");

$SQL_select="SET NAMES 'utf8'";
mysql_query($SQL_select,$link) or die ("<br>�L�k����d��");

$SQL_select="SET CHARACTER_SET_RESULTS=UTF8";
mysql_query($SQL_select,$link) or die ("<br>�L�k����d��"); 

?>
<?php
/*
//�{���\��
//	�]�wmysql���|
$DBUSER="webuser";
$DBNAME="TSC";
$DBPSWD="4pGyMTRfva73ezrU";
$link = mysql_connect ("localhost", $DBUSER, $DBPSWD) or die("�L�k�s����Ʈw: " . mysql_error( ));  
mysql_select_db($DBNAME,$link)or die("�L�k��ܸ�Ʈw");

$SQL_select="SET CHARACTER SET utf8";
mysql_query($SQL_select,$link) or die ("�L�k����d��");

$SQL_select="SET NAMES 'utf8'";
mysql_query($SQL_select,$link) or die ("�L�k����d��");

$SQL_select="SET CHARACTER_SET_RESULTS=UTF8";
mysql_query($SQL_select,$link) or die ("�L�k����d��");
*/ 
?>
