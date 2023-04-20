<?php

function getAllPost($pdo)
{
    $posts = [];
    $stmt = $pdo->prepare("SELECT title,body,email,posts.id as id, date FROM user JOIN posts ON user.id = posts.user_id ORDER BY posts.id DESC");
    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
$orgDate = $row['date'];  
$newDate = date("F d, Y", strtotime($orgDate));  
$row['date'] = $newDate;
        $posts[] = $row;
    };
    return $posts;
}

// $orgDate = "2019-02-26";  
// $newDate = date("m-d-Y", strtotime($orgDate));  
// echo "New date format is: ".$newDate. " (MM-DD-YYYY)";  
// // $date=date_create("2013-03-15");
// echo date_format($date,"Y/m/d H:i:s");

