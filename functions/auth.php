<?php

//require_once "pdo.php";

function signUp($pdo)
{
   
   
   if(isset($_POST['email']) && isset($_POST['password']))
   {
     $email = $_POST['email'];
     $password = $_POST['password'];
    
     
    
     if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
     {
        $_SESSION['error'] = 'Wrong password';
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
     }else if(strlen($password) < 6)
     {
     
        $_SESSION['error'] = 'Password must be more than 5 characters';
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
     }else{
        $salt = 'XyZzy12*_';
        $password = hash('md5', $salt.$password);
        // check if email already exist
        $stmt = $pdo->prepare("SELECT email FROM user WHERE email = :em");
        $stmt->execute(array(':em'=>$email));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
      

        if($row !== false)
        {
            $_SESSION['error'] = 'Email already exist';
           
            header('Location: '.$_SERVER['PHP_SELF']);
            die;
        }

        $stmt = $pdo->prepare("INSERT INTO user(email, password) VALUES(:em,:pw)");
        $stmt->execute(array(
          ':em'=>$email,
          ':pw'=>$password
        //   ':yr'=>$date
        ));
        $_SESSION['user_id'] = $pdo->lastInsertId();

        if($stmt)
        {
            $_SESSION['success'] = 'Successful signup';
            $uid = $_SESSION['user_id'];
            header('Location: '.$_SERVER['PHP_SELF']);
            die;
        }


     }  
   }
}

function login($pdo)
{
   if(isset($_POST['login_email']) && isset($_POST['login_password']))
   {
     $email = $_POST['login_email'];
     $password = $_POST['login_password'];
   // check if email  exist
   $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :em");
   $stmt->execute(array(
      ':em'=>$email
   ));
   $row = $stmt->fetch(PDO::FETCH_ASSOC);
           
     
   if($row === false)
   {
     $_SESSION['error'] = 'User not found';          
     header('Location: '.$_SERVER['PHP_SELF']);
     die;
   }

  $db_pw = $row['password'];
    $db_em = $row['email'];
   
    $db_ui = $row['id'];

   
   // check password
   $salt = 'XyZzy12*_';
   $check = hash('md5', $salt.$password);
   if( $db_pw != $check)
   {
      $_SESSION['error'] = 'Password not Correct';          
      header('Location: '.$_SERVER['PHP_SELF']);
      die;
   }

   echo $_SESSION['user_id'] = $db_ui;
   $_SESSION['success'] = 'Successful login';
   header('Location: '.$_SERVER['PHP_SELF']);
   die;
   }
}




//    <?php
// Output — 11:03:37 AM 
// echo date('h:i:s A');
// // Output — Thursday, 11:04:09 AM 
// echo date('l, h:i:s A');
// // Output — 13 September 2018, 11:05:00 AM 
// echo date('d F Y, h:i:s A');
// Output — 2018 
// echo date('Y');
// // Output — September 2018 
// echo date('F Y');
// // Output — 13 September, 2018 
// echo date('d F, Y');
// // Output — 13 September, 2018 (Thursday) 
// echo date('d F, Y (l)');


// $ten_days_later = time() + 10*60*60*24;
// // Output — It will be Sunday 10 days later. 
// echo 'It will be '.date('l', $ten_days_later).' 10 days later.';
// $ten_days_ago = time() - 10*60*60*24;
// // Output — It was Monday 10 days ago. 
// echo 'It was '.date('l', $ten_days_ago).' 10 days ago.';

// Output — CEST201813am18 1115 Thursday. 
// echo date('Today is l.');
// // Output — Today is Thursday. 
// echo date('\T\o\d\a\y \i\s l.');
// // Output — Today is Thursday. 
// echo 'Today is '.date('l.');
// ?>
