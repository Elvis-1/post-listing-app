<?php
if(isset($_POST['new_title']) && isset($_POST['new_body']))
{
 
    
    
    $title = $_POST['new_title'];
    $body =$_POST['new_body'];
    $post_id = $_POST['id'];
    $date = date('d-m-Y');
   
    // echo $date;
    // return;
    $user_id = $_SESSION['user_id'];
    
    if(!$user_id)
    {
        $_SESSION['error'] = 'Not signed in';
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
    }

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



    $stmt = $pdo->prepare("UPDATE posts SET title =:ti,body=:bd,date =:dt WHERE id =:pi AND user_id =:ui");
    $stmt->execute(array(
      ':ti'=>$title,
      ':bd'=>$body,
      ':dt'=>$date,
      'pi'=>$post_id,
      'ui'=>$user_id
    //   ':yr'=>$date
    ));

   
    if($stmt->rowCount()> 0)
    {
        $_SESSION['success'] = 'Post edited';
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
    }else{
        $_SESSION['error'] = 'Post does not belong to you';
        header('Location: '.$_SERVER['PHP_SELF']);
        
     
      die;
    }
}