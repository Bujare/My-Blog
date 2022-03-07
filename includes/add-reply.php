<?php

require_once("../admin/includes/dbh.php");

$blogPostId = isset($_POST['replyBlogPostId']) ? $_POST['replyBlogPostId'] : "";
$commentParentId = isset($_POST['commentParentId']) ? $_POST['commentParentId'] : "";
$commentSenderName = isset($_POST['replyCName']) ? $_POST['replyCName'] : "";
$commentEmail = isset($_POST['replyCEmail']) ? $_POST['replyCEmail'] : "";
$comment = isset($_POST['replyCMessage']) ? $_POST['replyCMessage'] : "";

$date = date("Y-m-d");
$time = date("H:i:s");

$sqlAddReply = "INSERT INTO blog_comments (blog_comment_parent_id, blog_post_id, comment_author, comment_author_email, comment, date_created, time_created) VALUES ('$commentParentId', '$blogPostId', '$commentSenderName', '$commentEmail', '$comment', '$date', '$time')";
$queryAddReply = mysqli_query($connection, $sqlAddReply);

if (!$queryAddReply) {
    $result = "error";
}
else {
    $result = "success";
}
echo $result;