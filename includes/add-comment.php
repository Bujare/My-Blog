<?php

require_once("../admin/includes/dbh.php");

$blogPostId = isset($_POST['blogPostId']) ? $_POST['blogPostId'] : "";
$commentSenderName = isset($_POST['cName']) ? $_POST['cName'] : "";
$commentEmail = isset($_POST['cEmail']) ? $_POST['cEmail'] : "";
$comment = isset($_POST['cMessage']) ? $_POST['cMessage'] : "";

$date = date("Y-m-d");
$time = date("H:i:s");

$sqlAddComment = "INSERT INTO blog_comments (blog_post_id, comment_author, comment_author_email, comment, date_created, time_created) VALUES ('$blogPostId', '$commentSenderName', '$commentEmail', '$comment', '$date', '$time')";
$queryAddComment = mysqli_query($connection, $sqlAddComment);

if (!$queryAddComment) {
    $result = "error";
}
else {
    $result = "success";
}
echo $result;