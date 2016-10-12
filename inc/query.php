<?php
	session_start();
	
 	 $_SESSION['error_name'] = "";
	 $_SESSION['error_email'] = "";
	 $_SESSION['error_msg '] = "";	
 	 $_SESSION['error_pass'] = "";
	 $_SESSION['name'] = "";
	 $_SESSION['email'] = "";
	 $_SESSION['msg'] = "";
         $_SESSION['del'] = "";
	
	
   require "lib.php";
  
 

 $link=mysqli_connect(DB_HOST,DB_LOGIN,DB_PASSWORD,DB_NAME) or die ("ERROR connect to db!");
  
   $check=mysqli_query($link,"SET NAMES 'utf8'");
  

if(isset($_POST["add"])){

	$name=filter($_POST['name'],'s');
	$pass=filter($_POST['pass'],'s');
	$email=filter($_POST['email'],'s');
	$msg=filter($_POST['msg'],'s');

		
	$_SESSION['name']=$name;
	$_SESSION['pass']=$pass;
	$_SESSION['email']=$email;
	$_SESSION['msg']=$msg;

	$error=false;
	if(strlen($name)==0){
	   $_SESSION['error_name']="Введите логин";
	   $error=true;
	}
	if(strlen($pass)==0){
	   $_SESSION['error_pass']="Введите пароль";
	   $error=true;
	}
	
	if($email=="" || !preg_match("/@/",$email)){
	   $_SESSION['error_email']="ВВедите корректный email";
	   $error=true;
	}
	

	if(strlen($msg)==0){
	   $_SESSION['error_msg']="Введите сообщение";
	   $error=true;
	}
		   
	
	if($error){
	     header("Location: http://myforms.com/index.php?id=add");
	     exit;
	}
	 else{
	 
	   if(!addBloger($name, $pass,$email, $msg)){
	       echo "<br/>".$_SESSION['error_pass']."<br/>";
	       header("Location: http://myforms.com/index.php?id=add");
	       exit;
	   }
	   else{
	     mysqli_close($link);
	     session_destroy();
	     header("Location: http://myforms.com/index.php");
	     exit;
	   } 


	
	}
}

if(isset($_POST["del_art"])){
   $name=filter($_POST["name"],'s');
   $pass=filter($_POST["pass"],'s');

   $_SESSION['name']=$name;
   $_SESSION['pass']=$pass;

   $error=false;

   if(strlen($name)==0){
      $_SESSION["error_name"]="Введите логин";
      $error=true;
   }
   if(strlen($pass)==0){
      $_SESSION["error_pass"]="Введите пароль";
      $error=true;
   }

   if($error){
      header("Location:http://myforms.com/index.php/?id=del.php");
      exit;
   }
   else{
   
     $ids=searchLogin($name,$pass);
     $ids=filter($ids,'i');
  
      switch($ids){
         case -1:
             $_SESSION['error_name']= mysqli_error($link);
	     break;
         case -2:
            $_SESSION['error_name']="Укажите правильный логин или пароль!";
	    break;
         default:
            $_SESSION['del']=$ids;
	   
     }
    header("Location:http://myforms.com/index.php?id=del");
    exit;

   }
   
}

if($_SERVER['REQUEST_METHOD']=="GET" AND (isset($_GET['del']))){
   $ids=filter($_GET['del'],'i');
   if($ids>0){
      $delete="DELETE FROM posts WHERE id=$ids";
      $res=mysqli_query($link,$delete) or die(mysqli_error());
      mysqli_close();
      header("Location:http://myforms.com/index.php?id=del");
      exit;
   }
   
}


