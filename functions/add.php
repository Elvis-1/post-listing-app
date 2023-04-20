<?php
// session_start();

// if(!isset($_SESSION['user_id']))
// {
//     $_SESSION['error'] = 'Sign up as user to add posts';
//     header('Location: '.$_SERVER['PHP_SELF']);
//     die;


// }

if(isset($_POST['title']) && isset($_POST['content']))
{
 
    
    $title = $_POST['title'];
    $body = $_POST['content'];
    $date = date('d-m-Y');
   
    // echo $date;
    // return;
    if(!$_SESSION['user_id'])
    {
      $_SESSION['success'] = 'Login to add content';
      header('Location: '.$_SERVER['PHP_SELF']);
      die;
    }
    $user_id = $_SESSION['user_id'];
    if(strlen($title) > 50)
    {
        $_SESSION['error'] = 'String length must not be more than 50';
        header('Location: index.php');
        return;
    }
    if(strlen($body) > 200)
    {
        $_SESSION['error'] = 'String length must not be more than 200';
        header('Location: index.php');
        return;
    }

    $stmt = $pdo->prepare("INSERT INTO posts(title,body,date,user_id) VALUES(:ti,:bd,:dt,:ui)");
    $stmt->execute(array(
      ':ti'=>$title,
      ':bd'=>$body,
      ':dt'=>$date,
      'ui'=>$user_id
    //   ':yr'=>$date
    ));

   
    if($stmt)
    {
        $_SESSION['success'] = 'Post added';
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
    }else{
      echo $stmt->error_get_last;
    }
}