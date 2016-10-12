<?php
	
   $id=trim(htmlspecialchars($_GET['id']));
 
    switch($id){
    case 'add': include 'inc/add.php'; break;
    case 'del': include 'inc/del.php';break;
    case 'query': include 'inc/query.php';break;
    default: include 'inc/index.inc.php';
  }

?>

