<?php
if(isset($_POST['del_id']))
{
 
    $post_id = $_POST['del_id'];
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


    $stmt = $pdo->prepare("DELETE FROM posts WHERE id =:pi AND user_id =:ui");
    $stmt->execute(array(
      'pi'=>$post_id,
      'ui'=>$user_id
    //   ':yr'=>$date
    ));

   
    if($stmt->rowCount()> 0)
    {
        $_SESSION['success'] = 'Post DELETED';
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
    }else{
        $_SESSION['error'] = 'Post does not belong to you';
        header('Location: '.$_SERVER['PHP_SELF']);
        
    //   echo $stmt->error_get_last;
      die;
    }
}