<?php
require_once('paxwaxmix.php');

$link = mysqli_connect($mysql_server, $paxwaxmixu,$paxwaxmixp );
if (!$link)
{
  echo 'Unable to connect to the database server.';
  exit();
}

if (!mysqli_set_charset($link, 'UTF8'))
{
  echo 'Unable to set database connection encoding.';
  exit();
}

if(!mysqli_select_db($link, $dbname))
{
  echo 'Unable to locate demo database.';
  exit();
}
?>
