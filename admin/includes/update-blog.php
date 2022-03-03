<?php

require "dbh.php";
session_start();

if (isset($_POST['submit-edit-blog'])) {

    $blogId = $_POST['blog-id'];
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

   

    $sqlCheckBlogTitle = "SELECT post_title FROM blog_post WHERE post_title = '$title' AND post_title != '$title' AND post_status != '2'";
    $queryCheckBlogTitle = mysqli_query($connection, $sqlCheckBlogTitle);

    $sqlCheckBlogPath = "SELECT post_path FROM blog_post WHERE post_path = '$blogPath' AND post_path != '$blogPath' AND post_status != '2'";
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
     
    $mainImgUrl = uploadImage($_FILES["main-blog-image"]["name"], "main-blog-image", "main", "main_image_url");
    $altImgUrl = uploadImage($_FILES["alt-blog-image"]["name"], "alt-blog-image", "alt", "alt_image_url");


    if ($mainImgUrl == "noupdate") {
        if ($altImgUrl == "noupdate") {
            $sqlUpdateBlog = "UPDATE blog_post SET category_id = '$blogCategoryId', post_title = '$title', post_meta_title = '$metaTitle', 
            post_path = '$blogPath', post_sumary = '$blogSummary', post_content = '$blogContent', home_page_placement = '$homePagePlacement', 
            date_updated = '$date', time_updated = '$time' WHERE blog_post_id = '$blogId'";
        }
        else {
            $sqlUpdateBlog = "UPDATE blog_post SET category_id = '$blogCategoryId', post_title = '$title', post_meta_title = '$metaTitle', 
            post_path = '$blogPath', post_sumary = '$blogSummary', post_content = '$blogContent', alt_image_url = '$altImgUrl', 
            home_page_placement = '$homePagePlacement', date_updated = '$date', time_updated = '$time' WHERE blog_post_id = '$blogId'";
        }

    }
    else if ($altImgUrl == "noupdate") {
        if ($mainImgUrl != "noupdate") {
            $sqlUpdateBlog = "UPDATE blog_post SET category_id = '$blogCategoryId', post_title = '$title', post_meta_title = '$metaTitle', 
            post_path = '$blogPath', post_sumary = '$blogSummary', post_content = '$blogContent', main_image_url = '$mainImgUrl', 
            home_page_placement = '$homePagePlacement', date_updated = '$date', time_updated = '$time' WHERE blog_post_id = '$blogId'";
        }
    }
    else {
        $sqlUpdateBlog = "UPDATE blog_post SET category_id = '$blogCategoryId', post_title = '$title', post_meta_title = '$metaTitle', 
        post_path = '$blogPath', post_sumary = '$blogSummary', post_content = '$blogContent', main_image_url = '$mainImgUrl', 
        alt_image_url = '$altImgUrl', home_page_placement = '$homePagePlacement', date_updated = '$date', time_updated = '$time' WHERE blog_post_id = '$blogId'";
    }

    $sqlUpdateTags = "UPDATE blog_tags SET tag = '$blogTags' WHERE blog_post_id = '$blogId'";

    if (mysqli_query($connection, $sqlUpdateBlog) && mysqli_query($connection, $sqlUpdateTags)) {
        formSuccess();
    }
    else {
        formError("sqlerror");
    }

}
else {
    header("Location: ../index.php");
    exit();
}

function formSuccess() {

    require "dbh.php"; 
    mysqli_close($connection);

        unset($_SESSION['editBlogId']);
        unset($_SESSION['editTitle']);
        unset($_SESSION['editMetaTitle']);
        unset($_SESSION['editCategoryId']);
        unset($_SESSION['editSummary']);
        unset($_SESSION['editContent']);
        unset($_SESSION['editPath']);
        unset($_SESSION['editTags']);
        unset($_SESSION['editHomePagePlacement']);

        header("Location: ../blogs.php?updateblog=success");
        exit();
}

function formError($errorCode) {

    require "dbh.php";
    

    $_SESSION['editTitle'] = $_POST['blog-title'];
    $_SESSION['editMetaTitle'] = $_POST['blog-meta-title'];
    $_SESSION['editCategoryId'] = $_POST['blog-category'];
    $_SESSION['editSummary'] = $_POST['blog-sumary'];
    $_SESSION['editContent'] = $_POST['blog-content'];
    $_SESSION['editTags'] = $_POST['blog-tags'];
    $_SESSION['editPath'] = $_POST['blog-path'];
    $_SESSION['editHomePagePlacement'] = $_POST['blog-home-page-placement'];

    mysqli_close($connection);
    header("Location: ../edit-blog.php?updateblog=".$errorCode);
    exit();
}

function uploadImage($img, $imgName, $imgType, $imgDbColumn) {

    require "dbh.php";

    $imgUrl = "";

    $validExtension = array("jpg", "png", "jpeg", "bmp", "gif");

    if ($img == "") {
        return "noupdate";
    }
    else {

        if ($_FILES[$imgName]["size"] <= 0) {
            formError($imgType."imageerror");
        }
        else {
    
            $extension = strtolower(end(explode(".", $img)));
            if (!in_array($extension, $validExtension)) {
                formError("invalidtype".$imgType."image");
            }

            //delete old image
            $blogId = $_POST['blog-id'];

            $sqlGetOldImage = "SELECT ".$imgDbColumn." FROM blog_post WHERE blog_post_id = '$blogId'";
            $queryGetOldImage = mysqli_query($connection, $sqlGetOldImage);

            if ($rowGetOldImage = mysqli_fetch_assoc($queryGetOldImage)) {
                $oldImgURL = $rowGetOldImage[$imgDbColumn];
            }

            if (!empty($oldImgURL)) {
                $oldImgURLArray = explode("/", $oldImgURL);
                $oldImgName = end($oldImgURLArray);
                $oldImgPath = "../images/blog-images/".$oldImgName;
                unlink($oldImgPath);
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


}