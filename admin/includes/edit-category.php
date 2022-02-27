<?php

require "dbh.php";

if (isset(($_POST['edit-category-btn']))) {

    $id = $_POST['category-id'];
    $name = $_POST['edit-category-name'];
    $metaTitle = $_POST['edit-category-meta-title'];
    $categoryPath = $_POST['edit-category-path'];

    $sqlEditCategory = "UPDATE blog_category SET category_title = '$name', category_meta_title = '$metaTitle', 
    category_path = '$categoryPath' WHERE category_id = '$id'";

    if (mysqli_query($connection, $sqlEditCategory)) {
        mysqli_close($connection);
        header("Location: ../blog-category.php?editcategory=success");
        exit();
    }
    else {
        mysqli_close($connection);
        header("Location: ../blog-category.php?editcategory=error");
        exit();
    }

}
else {
    header("Location: ../index.php");
    exit();
}