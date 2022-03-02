<?php

require "includes/dbh.php";

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Free Bootstrap Admin Template : Dream</title>
	<!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
     <!-- Google Fonts-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id="wrapper">

        <?php include "header.php"; include "sidebar.php"; ?>

        <div id="page-wrapper" >
            <div id="page-inner">
			 <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Write A Blog
                        </h1>
                    </div>
                </div> 
                 <!-- /. ROW  -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Write A Blog
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form" method="POST" action="includes/add-blog.php" enctype="multipart/
                                    form-data">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input class="form-control" name="blog-title">
                                        </div>
                                        <div class="form-group">
                                            <label>Meta Title</label>
                                            <input class="form-control" name="blog-meta-title">
                                        </div>
                                        <div class="form-group">
                                            <label>Blog Category</label>
                                            <select class="form-control" name="blog-category">
                                                <option value="">Select a category</option>
                                                <?php

                                                $sqlCategories = "SELECT * FROM blog_category";
                                                $queryCategories = mysqli_query($connection, $sqlCategories);

                                                while ($rowCategories = mysqli_fetch_assoc($queryCategories)) {

                                                    $categoryId = $rowCategories['category_id'];
                                                    $categoryName = $rowCategories['category_title'];

                                                    echo "<option value='".$categoryId."'>".$categoryName."</option>";

                                                }

                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Main Image</label>
                                            <input type="file" name="main-blog-image" id="main-blog-image">
                                        </div>
                                        <div class="form-group">
                                            <label>Alternate Image</label>
                                            <input type="file" name="alt-blog-image" id="alt-blog-image">
                                        </div>
                                        <div class="form-group">
                                            <label>Summary</label>
                                            <textarea class="form-control" rows="3" name="blog-sumary"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Blog Content</label>
                                            <textarea class="form-control" rows="3" name="blog-content"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Blog Tags (seperated by comma)</label>
                                            <input class="form-control" name="blog-tags">
                                        </div> 
                                        <div class="form-group">
                                            <label>Blog Path</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">www.bujare's blog.com/</span>
                                                <input type="text" class="form-control" placeholder="Username" name="blog-path">
                                            </div>
                                        </div>                                   
                                        <div class="form-group">
                                            <label>Home Page Placement</label>
                                            <label class="radio-inline">
                                                <input type="radio" name="blog-home-page-placement" id="optionsRadiosInline1" value="option1" checked="">1
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="blog-home-page-placement" id="optionsRadiosInline2" value="option2">2
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="blog-home-page-placement" id="optionsRadiosInline3" value="option3">3
                                            </label>
                                        </div>
                                        <button type="submit" class="btn btn-default" name="submit-blog">Add Blog</button>
                                    </form>
                                </div>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <?php include "footer.php"; ?>
			</div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
      <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>

    <script>
        function validateImage() {

            var main_img = $("#main-blog-image").val();
            var alt_img = $("#alt-blog-image").val();

            var extension = ['jpg', 'jpeg', 'jpeg', 'gif', 'bmp'];

            var get_ext_main_img = main_img.split('.');
            var get_ext_alt_img = alt_img.split('.');

            get_ext_main_img = get_ext_main_img.reverse();
            get_ext_alt_img = get_ext_alt_img.reverse();

            main_image_check = false;
            alt_image_check = false;

            if (main_img.length > 0) {
                if ($.inArray(get_ext_main_img[0].toLowerCase(), extension) >= -1) {
                    main_image_check = true;
                }
                else {
                    alert("Error -> Main Image. Upload only jpg, jpeg, png, gif, bmp images.");
                    main_img_check = true;
                }
            }    
            else {
                alert("Please updload a main image.");
                main_img_check = false;
            }

            if (alt_img.length > 0) {
                if ($.inArray(get_ext_alt_img[0].toLowerCase(), extension) >= -1) {
                    alt_image_check = true;
                }
                else {
                    alert("Error -> Alternate Image. Upload only jpg, jpeg, png, gif, bmp images.");
                    alt_image_check = true;
                }
            }    
            else {
                alert("Please updload a alternate image.");
                alt_image_check = false;
            }

            if (main_image_check == true && alt_image_check == true) {
                return true;
            }
            else {
                return false;
            }

        }
    </script>
    
   
</body>
</html>
