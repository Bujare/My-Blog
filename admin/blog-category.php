<?php

require "includes/dbh.php";

$sqlCategories = "SELECT * FROM blog_category";
$queryCategories = mysqli_query($connection, $sqlCategories);
$numCategories = mysqli_num_rows($queryCategories);

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
                            Blog Categories
                        </h1>
                    </div>

                    <?php 

                    if (asset($_REQUEST['addcategory'])) {
                        if ($_REQUEST['addcategory'] == "success") {
                            echo "div class='alert alert-success'>
                                <strong>Success!</strong> Category added.
                            </div>";
                        }
                        else if ($_REQUEST['addcategory'] == "error") {
                            echo "div class='alert alert-danger'>
                                <strong>Error!</strong> Category was not added, there was an unexpected error.
                            </div>";
                        }
                    }

                    ?>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Add A Category
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <form role="form" method="POST" action="includes/add-category.php">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input class="form-control" name="category-name">
                                                </div>
                                                <div class="form-group">
                                                    <label>Meta Title</label>
                                                    <input class="form-control" name="category-meta-title">
                                                </div>
                                                <div class="form-group">
                                                    <label>Category Path(lower case, no spaces)</label>
                                                    <input class="form-control" name="category-path">
                                                </div>                                        
                                                <button type="submit" class="btn btn-default" name="add-category-btn">Add Category</button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.row (nested) -->
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    All Categories
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Name</th>
                                                    <th>Meta Title</th>
                                                    <th>Category Path</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                $counter = 0;
                                                
                                                while ($rowCategories = mysqli_fetch_assoc($queryCategories)) {
                                                
                                                    $counter++;

                                                    $id = $rowCategories['category_id'];
                                                    $name = $rowCategories['category_title'];
                                                    $metaTitle = $rowCategories['category_meta_title'];
                                                    $categoryPath = $rowCategories['category_path'];


                                                ?>

                                                <tr>
                                                    <td><?php echo $counter; ?></td>
                                                    <td><?php echo $name; ?></td>
                                                    <td><?php echo $metaTitle; ?></td>
                                                    <td><?php echo $categoryPath; ?></td>
                                                    <td>
                                                        <button>View</button>
                                                        <button>Edit</button>
                                                        <button>Delete</button>
                                                    </td>
                                                </tr>

                                                <?php
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <!-- /.col-lg-12 -->
                    </div>

                </div> 
                 <!-- /. ROW  -->
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
      <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
    
   
</body>
</html>
