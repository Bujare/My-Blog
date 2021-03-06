<?php

require "dbh.php";
session_start();

if (isset($_POST['submit-blog'])) {


    $title = $_POST['blog-title'];
    $metaTitle = $_POST['blog-meta-title'];
    $blogCategoryId = $_POST['blog-category'];
    $blogSummary = $_POST['blog-sumary'];
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
        formError("emptysumary");
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

        $sqlCheckBlogHomePagePlacement = "SELECT * FROM blog_post WHERE home_page_placement = '$homePagePlacement' AND post_status != '2'";
        $queryCheckBlogHomePagePlacement = mysqli_query($connection, $sqlCheckBlogHomePagePlacement);

        if (mysqli_num_rows($queryCheckBlogHomePagePlacement) > 0) {

            $sqlUpdateBlogHomePagePlacement = "UPDATE blog_post SET home_page_placement = '0' WHERE home_page_placement
            = '$homePagePlacement' AND post_status != '2'";

            if (!mysqli_query($connection, $sqlUpdateBlogHomePagePlacement)) {
                formError("homepageplacementerror");
            }
        }
    }
     
    $mainImgUrl = uploadImage($_FILES["main-blog-image"]["name"], "main-blog-image", "main");
    $altImgUrl = uploadImage($_FILES["alt-blog-image"]["name"], "alt-blog-image", "alt");


    $sqlAddBlog = "INSERT INTO blog_post (category_id, post_title, post_meta_title, post_path, post_sumary, 
    post_content, main_image_url, alt_image_url, home_page_placement, post_status, date_created, time_created) VALUES ('$blogCategoryId', 
    '$title', '$metaTitle', '$blogPath', '$blogSummary', '$blogContent', '$mainImgUrl', '$altImgUrl', '$homePagePlacement', '1', '$date', '$time')";

    if (mysqli_query($connection, $sqlAddBlog)) {
        
        $blogPostId = mysqli_insert_id($connection);
        $sqlAddTags = "INSERT INTO blog_tags (blog_post_id, tag) VALUES ('$blogPostId', '$blogTags')";

        if (mysqli_query($connection, $sqlAddTags)) {
            
            mysqli_close($connection);

            unset($_SESSION['blogTitle']);
            unset($_SESSION['blogMetaTitle']);
            unset($_SESSION['blogCategoryId']);
            unset($_SESSION['blogSummary']);
            unset($_SESSION['blogContent']);
            unset($_SESSION['blogTags']);
            unset($_SESSION['blogPath']);
            unset($_SESSION['blogHomePagePlacement']);
    
    
            header("Location: ../blogs.php?addblog=success");
            exit();
        }
    
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

    require "dbh.php";

    $_SESSION['blogTitle'] = $_POST['blog-title'];
    $_SESSION['blogMetaTitle'] = $_POST['blog-meta-title'];
    $_SESSION['blogCategoryId'] = $_POST['blog-category'];
    $_SESSION['blogSummary'] = $_POST['blog-sumary'];
    $_SESSION['blogContent'] = $_POST['blog-content'];
    $_SESSION['blogTags'] = $_POST['blog-tags'];
    $_SESSION['blogPath'] = $_POST['blog-path'];
    $_SESSION['blogHomePagePlacement'] = $_POST['blog-home-page-placement'];

    mysqli_close($connection);
    header("Location: ../write-a-blog.php?addblog=".$errorCode);
    exit();
}

function uploadImage($img, $imgName, $imgType) {

    $imgUrl = "";

    $validExtension = array("jpg", "png", "jpeg", "bmp", "gif");

    if ($img == "") {
        formError("empty".$imgType."image");
    }
    else if ($_FILES[$imgName]["size"] <= 0) {
        formError($imgType."imageerror");
    }
    else {

        $extension = strtolower(end(explode(".", $img)));
        if (!in_array($extension, $validExtension)) {
            formError("invalidtype".$imgType."image");
        }

        $folder = "../images/blog-images/";
        $imgNewName = rand(10000, 990000).'_'.time().'.'.$extension;
        $imgPath = $folder.$imgNewName;

        if (move_uploaded_file($_FILES[$imgName]['tmp_name'], $imgPath)) {
            $imgUrl = "http://localhost/blog/admin/images/blog-images/".$imgNewName;
        }
        else {
            formError("erroruploading".$imgType."image");
        }
    }

    return $imgUrl;

}