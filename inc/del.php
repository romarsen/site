<?php
   session_start();
?>
<p>Для удаления своей публикации подтвердите регистрацию</p>
<br/>
<br/>
<form name="del" action="inc/query.php" method="post">
   <label>Логин</label><br/>
   <input type="text" name="name" value="<?=$_SESSION['name'];?>"/>
   <span style="color:red"><?=$_SESSION['error_name'];?></span>
   <br/><label>Пароль</label><br/>
   <input type="password" name="pass" value="<?=$_SESSION['pass'];?>"/>
   <span style="color:red"><?=$_SESSION["error_pass"];?></span>
   <br/>
   <br/>
   <input type="submit" name="del_art" value="Войти"/>
   <br/>
</form>
   <br/><hr/>
<?php
   require "lib.php";
   delMessage();
  
?>
    
<?php
   session_destroy();
?>





