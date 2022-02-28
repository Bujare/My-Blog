<?php

require "dbh.php";

if (isset($_POST['submit-blog'])) {

    $title = $_POST['blog-title'];
    $metaTitle = $_POST['blog-meta-title'];
    $blogCategoryId = $_POST['blog-category'];
    $blogSummary = $_POST['blog-summary'];
    $blogContent = $_POST['blog-content'];
    $blogTags = $_POST['blog-tags'];
    $blogPath = $_POST['blog-path'];
    $homePagePlacement = $_POST['blog-home-page-placement'];

    $date = date("Y-m-d");
    $time = date("H:i:s");

    if (empty($title)) {
        formError("emptytitle");
    }
    else if (empty($blogCategoryId)) {
        formError("emptycategory");
    }
    else if (empty($blogSummary)) {
        formError("emptysummary");
    }
    else if (empty($blogContent)) {
        formError("emptycontent");
    }
    else if (empty($blogTags)) {
        formError("emptytags");
    }
    else if (empty($blogPath)) {
        formError("emptypath");
    }

    if (strpos($blogPath, " ") !== false) {
        formError("pathcontainsspaces");
    }

    if (empty($homePagePlacement)) {
        $homePagePlacement = 0;
    }

    $sqlCheckBlogTitle = "SELECT post_title FROM blog_post WHERE post_title = '$title' AND post_status != '2'";
    $queryCheckBlogTitle = mysqli_query($connection, $sqlCheckBlogTitle);

    $sqlCheckBlogPath = "SELECT post_path FROM blog_post WHERE post_path = '$blogPath' AND post_status != '2'";
    $queryCheckBlogPath = mysqli_query($connection, $sqlCheckBlogPath);

    if (mysqli_num_rows($queryCheckBlogTitle) > 0) {
        formError("titlebeingused");
    }
    else if (mysqli_num_rows($queryCheckBlogPath) > 0) {
        formError("pathbeingused");
    }

    if ($homePagePlacement != 0) {

        $sqlCheckBlogHomePagePlacement = "SELECT * FROM blog_post WHERE home_page_placement = '$homePagePlacement'";
        $queryCheckBlogHomePagePlacement = mysqli_query($connection, $sqlCheckBlogHomePagePlacement);

        if (mysqli_num_rows($queryCheckBlogHomePagePlacement) > 0) {

            $sqlUpdateBlogHomePagePlacement = "UPDATE blog_post SET home_page_placement = '0' WHERE home_page_placement
            = '$homePagePlacement' AND post_status != '2'";

            if (!mysqli_query($connection, $sqlUpdateBlogHomePagePlacement)) {
                formError("homepageplacementerror");
            }

        }

    }

    $sqlAddBlog = "INSERT INTO blog_post (category_id, post_title, post_meta_title, post_path, post_sumary, 
    post_content, home_page_placement, post_status, date_created, time_created) VALUES ('$blogCategoryId', 
    '$title', '$metaTitle', '$blogPath', '$blogSummary', '$blogContent', '$homePagePlacement', '1', '$date', '$time')";

    if (mysqli_query($connection, $sqlAddBlog)) {
        mysqli_close($connection);
        header("Location: ../blogs.php?addblog=success");
        exit();
    }
    else {
        formError("sqlerror");
    }

}
else {
    header("Location: ../index.php");
    exit();
}

function formError($errorCode) {
    header("Location: ../write-a-blog.php?addblog=".$errorCode);
    exit();
}