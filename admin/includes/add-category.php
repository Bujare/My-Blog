<?php

require "dbh.php";

if (isset($_POST['add-category-btn'])) {

    $name = $_POST['category-name'];
    $metaTitle = $_POST['category-meta-title'];
    $categoryPath = $_POST['category-path'];

    $date = date("Y-m-d");
    $time = date("H:i:s");

    $sqlAddCategory = "INSERT INTO blog_category (category_title, category_meta_title, category_path, date_created, time_created) VALUES ('$name', '$metaTitle', '$categoryPath', '$date', '$time')";

    if (mysqli_query($connection, $sqlAddCategory)) {
        mysqli_close($connection);
        header("Location: ../blog-category.php?addcategory=success");
        exit();
    }
    else {
        mysqli_close($connection);
        header("Location: ../blog-category.php?addcategory=error");
        exit();
    }

}
else {
    header("Location: ../index.php");
    exit();
}