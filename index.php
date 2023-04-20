<?php
   require_once "functions/pdo.php";
   session_start();

   
   require_once "functions/add.php";
   require_once 'functions/auth.php';
   require_once 'functions/get.php';
   require_once 'functions/edit.php';
   require_once 'functions/delete.php';
   require_once 'functions/search.php';
   
   if(isset($_POST['email']) && isset($_POST['password']))
   {
    signUp($pdo);
   }

   if(isset($_POST['login_email']) && isset($_POST['login_password']))
     {
        login($pdo);
     }

     $posts = getAllPost($pdo);

  
     
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js">
 
    <title>Document</title>
</head>
<body>

    <div class="container mt-5" id="parent" style="background-color:burlywood; padding: 30px;">
      

        <section>
            <div class="row">
                <div class="col-md-9">
                    <div class=" text-center mt-5 mb-5"> 
                        <h2 class="text-bold" style="font-size: 50px;">
                            Post Listing App
                        </h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <button data-bs-toggle="modal" data-bs-target="#exampleModal2" style="background-color: black; color: white; padding: 10px; border-radius: 10px;">Sign Up</button>
                    <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal4" style="text-decoration: none; padding-left: 5px; background-color: bisque; padding: 10px; border-radius: 5px; color: tomato; font-weight: bolder;">Log In</a>
                </div>
            </div>

        </section>
        <section class=" mb-5">
        <span style="color:red" >
            <?php  if(isset($_SESSION['error']))
            {
              echo $_SESSION['error'];
              unset($_SESSION['error']);
            }   ?>
        </span>
        
        <span style="color:green" >
            <?php  if(isset($_SESSION['success']))
            {
              echo $_SESSION['success'];
              unset($_SESSION['success']);
            }   ?>
        </span>
        <p class="lead">Search Posts</p>
            <form action="" method="POST">
            <div class="row">
                from:
                <div class="col">
                    
                     <input class="form-control" name="from" type="date">
                    First Added <form method="POST"><input  value='1' type="checkbox" name="asc"/></form>
                   
                </div>
                to:
                <div class="col">
                 <input class="form-control" name="to" type="date" name="" id="">
                 <button class="btn btn-dark float-left mt-3" type="submit">Filter</button>
                 Last Added <input type="checkbox" value='1' name="dsc" class="btn btn-primary"/>
                </div>
               
            </div>
         
            </form>

        </section>
       <!-- SEARCH POSTS -->
       <?php  
          if(isset($searchedPosts))
          {

            // SEARCHED POSTS

            foreach($searchedPosts as $post)
            {
             
               echo '
               <div class="row mb-3 post" >
               <div class="col-md-12">
                   <div class="card">
                       <!-- <div class="card-header">
                         Featured
                       </div> -->
   
   
                       <div class="row">
                           <div class="col-md-9">
                               <div class="card-body">
                                   <h5 class="card-title">'.$post['title'].'</h5>
                                   <p class="">'.$post['body'].'</p>
                                   <p>By: <span>'.$post['email'].'</span></p>
                                   <small><mark>Date: '.$post['date'].'</mark></small>
                                 </div>
                           </div>
                           <div class="col-md-3">
                               <div class="card-body text-center">
                                   <button data-bs-toggle="modal" data-bs-target="#editPost'.$post['id'].'" class=" btn btn-success">Edit</button>
                                   <button data-bs-toggle="modal" data-bs-target="#deletePost'.$post['id'].'" class="btn btn-danger">Delete</button>
                               </div>
                           </div>
                       </div>
                     </div>
               </div>
   
          
          
          
           </div>';
               
           // EDIT POST MODAL
             
              echo'<div  id="editPost'.$post['id'].'"  class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog">
                 <div class="modal-content">
                   <div class="modal-header">
                     <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Post</h1>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                   </div>
                   <div class="modal-body">
                       <form method="POST">
                           <div class="mb-3">
                             <label for="" class="form-label">Post Title</label>
                             <input name="new_title" class="form-control" value='.$post['title'].' id="" aria-describedby="emailHelp">
                             <div id="emailHelp" class="form-text">We\'ll never share your email with anyone else.</div>
                           </div>
                           <div class="mb-3">
                           <input type="hidden" name="id" value='.$post['id'].'>
                             <label for="exampleInputPassword1" class="form-label">Content</label>
                             <textarea maxlength="" type="text" name="new_body" value="" class="form-control" id="exampleInputPassword1">'.$post['body'].'</textarea>
                           </div>
           
                           <button type="submit" class="btn btn-primary">Submit</button>
                         </form>
                   </div>
                   <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     <button type="button" class="btn btn-primary">Save changes</button>
                   </div>
                 </div>
               </div>
             </div>';
  
  
  
             // <!-- Delete Post MODAL -->
  
            echo '<div class="modal fade" id="deletePost'.$post['id'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
             <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-header">
                   <h1 class="modal-title fs-5" id="exampleModalLabel">Login into your Account</h1>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <form id="account" method="POST">
                         <div class="mb-3">
                           <input type="hidden" name="del_id" value="'.$post['id'].'" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">  
                         </div>
                         <div class="mb-3">
                         <p>Are you sure you want to delete this post? ' .$post['title']. '.. </p>
                         </div>
                         <button  class="btn btn-warning"><a href="index.php" style="text-decoration:none;">Cancel</a></button>
                         <button name="account_submit" type="submit" class="btn btn-danger">Delete</button>
                       </form>
                 </div>
                 <div class="modal-footer">
                   created by IFNOTGOD TECH
                 </div>
               </div>
             </div>
           </div>';
            }
          }else{
            foreach($posts as $post)
            {
             
               echo '
               <div class="row mb-3 post" >
                <div class="col-md-12">
                   <div class="card">
                       <div class="row">
                           <div class="col-md-9">
                               <div class="card-body">
                                   <h5 class="card-title">'.$post['title'].'</h5>
                                   <p class="">'.$post['body'].'</p>
                                   <p>By: <span>'.$post['email'].'</span></p>
                                   <small>Date: '.$post['date'].'</small>
                                 </div>
                           </div>
                           <div class="col-md-3">
                               <div class="card-body text-center">
                                   <button data-bs-toggle="modal" data-bs-target="#editPost'.$post['id'].'" class=" btn btn-success">Edit</button>
                                   <button data-bs-toggle="modal" data-bs-target="#deletePost'.$post['id'].'" class="btn btn-danger">Delete</button>
                               </div>
                           </div>
                       </div>
                     </div>
               </div>
            </div>';
               
           // EDIT POST MODAL
             
              echo'<div  id="editPost'.$post['id'].'"  class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog">
                 <div class="modal-content">
                   <div class="modal-header">
                     <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Post</h1>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                   </div>
                   <div class="modal-body">
                       <form method="POST">
                           <div class="mb-3">
                             <label for="" class="form-label">Post Title</label>
                             <input name="new_title" class="form-control" value='.$post['title'].' id="" aria-describedby="emailHelp">
                             <div id="emailHelp" class="form-text">We\'ll never share your email with anyone else.</div>
                           </div>
                           <div class="mb-3">
                           <input type="hidden" name="id" value='.$post['id'].'>
                             <label for="exampleInputPassword1" class="form-label">Content</label>
                             <textarea maxlength="" type="text" name="new_body" value="" class="form-control" id="exampleInputPassword1">'.$post['body'].'</textarea>
                           </div>
           
                           <button type="submit" class="btn btn-primary">Submit</button>
                         </form>
                   </div>
                   <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     <button type="button" class="btn btn-primary">Save changes</button>
                   </div>
                 </div>
               </div>
             </div>';
  
  
  
             // <!-- Delete Post MODAL -->
  
            echo '<div class="modal fade" id="deletePost'.$post['id'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
             <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-header">
                   <h1 class="modal-title fs-5" id="exampleModalLabel">Login into your Account</h1>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <form id="account" method="POST">
                         <div class="mb-3">
                           <input type="hidden" name="del_id" value="'.$post['id'].'" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">  
                         </div>
                         <div class="mb-3">
                         <p>Are you sure you want to delete this post? ' .$post['title']. '.. </p>
                         </div>
                         <button name="" class="btn btn-warning"><a href="index.php" style="text-decoration:none;">Cancel</a></button>
                         <button name="account_submit" type="submit" class="btn btn-danger">Delete</button>
                       </form>
                 </div>
                 <div class="modal-footer">
                   created by IFNOTGOD TECH
                 </div>
               </div>
             </div>
           </div>';
            }
          }

    ?>




 
            <!-- Button trigger modal -->
<button style="position: fixed; bottom: 20px; right: 50px;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Add a Post
</button>
    </div>



  
  <!-- ADD POST Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST">
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Post Title</label>
                  <input type="text" name="title" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                  <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Content</label>
                  <textarea col="2" row="2" type="text" name="content" class="form-control" id="exampleInputPassword1"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

       
     
      <!-- CREATE ACCOUNT Modal -->
  <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Create an Account</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <span style="color:red" >
            <?php  if(isset($_SESSION['error']))
            {
              echo $_SESSION['error'];
              unset($_SESSION['error']);
            }   ?>
        </span>
            <form id="account" method="POST">
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Email Address</label>
                  <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                  <span id="email_error" style="color:red;"></span>
                  <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Password</label>
                  <input  type="password" class="form-control" name="password" id="exampleInputPassword1">
                  <span id="password_error"></span>
                </div>

                <button name="account_submit" type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
        <div class="modal-footer">
          created by IFNOTGOD TECH
        </div>
      </div>
    </div>
  </div>

  <!-- LOGIN ACCOUNT MODAL -->
  <div class="modal fade" id="exampleModal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Login into your Account</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <span style="color:red" >
            <?php  if(isset($_SESSION['error']))
            {
              echo $_SESSION['error'];
              unset($_SESSION['error']);
            }   ?>
        </span>
            <form id="account" method="POST">
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Email Address</label>
                  <input type="email" name="login_email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                  <span id="email_error" style="color:red;"></span>
                  <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Password</label>
                  <input  type="password" class="form-control" name="login_password" id="exampleInputPassword1">
                  <span id="password_error"></span>
                </div>

                <button name="account_submit" type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
        <div class="modal-footer">
          created by IFNOTGOD TECH
        </div>
      </div>
    </div>
  </div>




  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="assets/jquery.min.js">
    </script>
   <script type="text/javascript" src="assets/scripts.js"></script>

   <script>
    var asc =  $('input[name="asc"]').val();
    var state = true;
     $('input[name="asc"]').click(function(){
     
      console.log('This is '+asc);
      if(!state)
        {
          console.log('inside if statement');
          location.reload();
          return;
        }
     
      $.post('functions/search.php',{'asc':asc},function(array){
        var asc =  $('input[name="asc"]').val(); 
       
          var asc =  $('input[name="asc"]').val('0');
       
        $('#parent div.post').remove();
        for(var i=0; i < array.length; i++)
        {
          var ar = array[i];
          $('#parent').append('<div class="row mb-3 post" ><div class="col-md-12"><div class="card"><div class="row"><div class="col-md-9"><div class="card-body"><h5 class="card-title">'+ar.title+'</h5><p class="">'+ar.body+'</p><p>By: <span>'+ar.email+'</span></p><small><mark>Date: '+ar.date+'</mark></small></div></div><div class="col-md-3"><div class="card-body text-center"><button style="margin-right:5px" data-bs-toggle="modal" data-bs-target="#editPost'+ar.id+'" class=" btn btn-success">Edit</button><button data-bs-toggle="modal" data-bs-target="#deletePost'+asc+'" class="btn btn-danger">Delete</button></div></div></div></div></div></div>');
        }
        state = false;
              });
     })
   </script>

</body>
</html>