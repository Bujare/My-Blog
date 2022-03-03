<?php 

require "dbh.php";

if (isset($_POST['delete-blog-post-btn'])) {

    $id = $_POST['blog-post-id'];

    $sqlDeleteBlogPost = "UPDATE blog_post SET post_status = '2' WHERE blog_post_id = '$id'";

    if (mysqli_query($connection, $sqlDeleteBlogPost)) {
        mysqli_close($connection);
        header("Location: ../blogs.php?deleteblogpost=success");
        exit();
    }
    else {
        mysqli_close($connection);
        header("Location: ../blogs.php?deleteblogpost=error");
        exit();
    }

}
else{
    header("Location: ../index.php");
    exit();
}