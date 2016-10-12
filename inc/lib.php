<?php
   session_start();
  function filter($str, $param='s'){
	if($param=='s')
		return trim(htmlspecialchars($str));
		//return trim(strip_tags($str));
	else
		return (int)trim($str);
   }


   const DB_HOST='localhost';
   const DB_LOGIN='root';
   const DB_PASSWORD="123";
   const DB_NAME='myforms_db';
   
 

 function addBloger($name, $pass,$email, $msg){
	global $link;
	//экранируем стринги
	$name = mysqli_real_escape_string($link, $name);
	$pass = md5(mysqli_real_escape_string($link, $pass));
	$email = mysqli_real_escape_string($link, $email);
	$msg = mysqli_real_escape_string($link, $msg);
	

	$sql='SELECT * FROM blogs WHERE name="'.$name.'"'; //перевірка: чи існує в базі даних цей блогер 
        $res=mysqli_query($link,$sql);
	$row=mysqli_num_rows($res);
	if($row>0){  //цей блогер зареєстрований  
	    $sel=mysqli_fetch_assoc($res);
	   if($sel['password']==$pass)  //перевіряємо коректність введеного паролю
	      $check=true;
	   else{
	      $_SESSION['error_pass']="НЕВЕРНЫЙ ПАРОЛЬ!";
	      $check=false;
	   }
	}
	else{  //це новий блогер, реєструємо його
	    $sql = "INSERT INTO blogs (name,password, email) VALUES ('$name', '$pass','$email')";//$sql2
	    $res=mysqli_query($link,$sql);//$res2
	    if(!$res){//$res2
		echo mysqli_error($link);		
		return false;
	    }
	    else{   //новий блогер зареєстрований, вибираємо його id
		$sql='SELECT * FROM blogs WHERE name="'.$name.'"';
		 $res=mysqli_query($link,$sql);
		if(!$res){
		  echo mysqli_error($link);		
		  return false;
	        }
		$sel=mysqli_fetch_assoc($res);
	        $check=true;
	    }
	}
	if(!$check){
	   return false;
	}
	else{
	   $sql = "INSERT INTO posts (post,user_id) VALUES ('$msg', {$sel['id']})";
	   $res=mysqli_query($link,$sql);
	   if(!$res){
		echo mysqli_error($link);		
		return false;
	   }
	   return true;
	}
}




function selectBlogs(){ 
   
   $link=mysqli_connect(DB_HOST,DB_LOGIN,DB_PASSWORD,DB_NAME) or die ("ERROR connect to db!");
  
   $check=mysqli_query($link,"SET NAMES 'utf8'");

   $sql="SELECT blogs.name as name, posts.post as post, posts.datetime as datetime FROM blogs, posts WHERE blogs.id=posts.user_id ORDER BY posts.datetime DESC";
   $res=mysqli_query($link,$sql);
   
   if(!$res){
	echo mysqli_error($link);
        mysqli_close($link);
   }
   else{
       mysqli_close($link);
       $row_count=mysqli_num_rows($res);
       if($row_count>0){
          echo "<p>На данный момент на нашем сайте опубликовано $row_count статей</p>";
          while($sel=mysqli_fetch_assoc($res)){
	
	      echo "<hr><p style='margin-left:15px;font-weight:bold'>{$sel['datetime']}<br/>{$sel['name']} написал<br/>{$sel['post']}</p>";
          }
       }
       else{
	  echo "<p>На данный момент на нашем сайте публикаций нет</p>";
       }
     }
  

}

function searchLogin($name,$pass){
   global $link;
   $name=mysqli_real_escape_string($link,$name);
   $pass=md5(mysqli_real_escape_string($link,$pass));

   $sql='SELECT * FROM blogs WHERE name="'.$name.'"';
     $res=mysqli_query($link,$sql);  
     if(!$res)
	 return -1;
     $row = mysqli_fetch_assoc($res);  
     if($row['password']==$pass){
	return $row['id'];
     }
     else{
	return -2;
     }
        
}

function delMessage(){
   
   $link=mysqli_connect(DB_HOST,DB_LOGIN,DB_PASSWORD,DB_NAME) or die ("ERROR connect to db!");
  
   $check=mysqli_query($link,"SET NAMES 'utf8'");
   if($_SESSION['del']!=0){
      $sql="SELECT posts.id as id,posts.post as post,posts.datetime as datetime FROM blogs, posts WHERE blogs.id=posts.user_id AND blogs.id={$_SESSION['del']} ORDER BY datetime DESC";
      $res=mysqli_query($link,$sql);
   
      if(!$res){
	echo mysqli_error($link);
	mysqli_close($link);
      }
      else{
       $row_count=mysqli_num_rows($res);
       if($row_count>0){
         echo "<p>На данный момент Вами опубликовано $row_count статей</p>";
	 while($sel=mysqli_fetch_assoc($res)){
	     echo "<hr><p style='margin-left:15px;font-weight:bold'>{$sel['datetime']}<br/>{$sel['post']} </p>";
	     echo "<div align='right' style='margin-right:20px'><a href='http://myforms.com/index.php?id=query&del={$sel['id']}'>удалить публикацию</a></div>";
	     
         }
       }
       else
	  echo "<p>На данный момент на сайте Ваших публикаций нет</p>";
   }
}

}

