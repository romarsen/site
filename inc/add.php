<?php
	session_start();
	
	/*if(isset($_COOKIE["user"]))//проверяем пришла ли кука с таким именем
	    $user=unserialize(base64_decode($_COOKIE["user"]));*/
	
?>  
 
 <form name="add" action='inc/query.php' method="post">
   <label>Имя: </label><br />
   <input type="text" name="name" value="<?=$_SESSION['name'];/*$user['name'];*/?>"/>
   <span style="color:red"><?=$_SESSION['error_name']?></span>
   <br />
   <label>Пароль: </label><br />
   <input type="password" name="pass" value="<?=$_SESSION['pass'];?>"/>
   <span style="color:red"><?=$_SESSION['error_pass']?></span>
   <br />
   <label>Email: </label><br />
   <input type="text" name="email" value="<?=$_SESSION['email'];/*$user['email'];*/?>"/>
   <span style="color:red"><?=$_SESSION['error_email']?></span>
   <br />
   <label>Сообщение: </label><br />
   <textarea name="msg" cols="50" rows="5"><?=$_SESSION['msg'];/*$user['msg'];*/?></textarea>
   <span style="color:red"><?=$_SESSION['error_msg']?></span>
   <br />
   <br />

   <input type="submit" name="add" value="Отправить!" />


</form>
<?
	session_destroy();
?>

