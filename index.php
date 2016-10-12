<?php
   error_reporting(E_ALL & ~E_NOTICE);

   session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>myforms</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="inc/style.css" />
  </head>
  <body>
    <div id="header">
       <img src="inc/bird.jpeg" width="200" height="200" class="logo"/>
	<h2 class="slogan">Робота з формами</h2>
	
    </div>
    
    

    <div id="nav">
       <h3>Навігація</h3>
       <ul>
         <li><a href='index.php'>Блоги</a></li>
	 <li><a href='index.php?id=add'>Додати блог</a></li>
         <li><a href='index.php?id=del'>Видалити блог</a></li>
       <ul>
    </div>

    <div id="content">
      
      <?php
	
	include 'inc/routing.php';


      ?>

    </div>

    <div id="footer">
      &#174; Блоги 01.09.2015&#151;<?=date('d.m.Y');?>
    </div>
  </body>
</html>

