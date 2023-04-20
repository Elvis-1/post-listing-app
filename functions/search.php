<?php
   require_once "pdo.php";
function searchPost($pdo)
{
    $posts = [];
    if(isset($_POST['to']) && isset($_POST['from']))
    { 

    $posts = [];
    $to = $_POST['to'];
    $from = $_POST['from'];
$toNew = date("d-m-Y", strtotime($to));
$fromNew = date("d-m-Y", strtotime($from));

 
        $stmt = $pdo->prepare("SELECT title,body,email,posts.id as id, date FROM user JOIN posts ON user.id = posts.user_id WHERE date >= :from AND date <= :to  ORDER BY date ASC ");
        $stmt->execute(array(
            ':from'=>$fromNew,
            ':to'=>$toNew
        ));

        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            
            $posts[] = $row;
        }
        return $posts;


    }
}


if(isset($_POST['asc']) && $_POST['asc'] == '1')
{
  
 checkBoxSearch($pdo);

}else{
    $searchedPosts = searchPost($pdo); 
}
function checkBoxSearch($pdo){
$posts = [];
$stmt = $pdo->prepare("SELECT title,body,email,posts.id as id, date FROM user JOIN posts ON user.id = posts.user_id ORDER BY date ASC ");
$stmt->execute();

while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
    
    $posts[] = $row;
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($posts, JSON_PRETTY_PRINT);
}
