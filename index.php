<?php

require "admin/includes/dbh.php";

?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>

    <!--- basic page needs
    ================================================== -->
    <meta charset="utf-8">
    <title>Bujare</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- mobile specific metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="css/vendor.css">
    <link rel="stylesheet" href="css/styles.css">

    <!-- script
    ================================================== -->
    <script src="js/modernizr.js"></script>
    <script defer src="js/fontawesome/all.min.js"></script>

    <!-- favicons
    ================================================== -->
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">

</head>

<body id="top">


    <!-- preloader
    ================================================== -->
    <div id="preloader"> 
    	<div id="loader"></div>
    </div>

    <?php include "header.php"; ?>

    <!-- hero
    ================================================== -->
    <section id="hero" class="s-hero">

        <div class="s-hero__slider">

            <?php
            
            $sqlGetFirstBlog = "SELECT * FROM blog_post INNER JOIN blog_category ON blog_post.category_id = blog_category.category_id WHERE home_page_placement = '1' AND post_status != '2' LIMIT 1";            
            $queryGetFirstBlog = mysqli_query($connection, $sqlGetFirstBlog);

            if ($rowGetFirstBlog = mysqli_fetch_assoc($queryGetFirstBlog)) {

                $firstBlogCategory = $rowGetFirstBlog['category_title'];
                $firstBlogCategoryPath = $rowGetFirstBlog['category_path'];
                $firstBlogTitle = $rowGetFirstBlog['post_title'];
                $firstBlogPath = $rowGetFirstBlog['post_path'];
                $firstBlogMainImageUrl = $rowGetFirstBlog['main_image_url'];
            ?>

            <div class="s-hero__slide">
                <div class="s-hero__slide-bg" style="background-image: url('<?php echo $firstBlogMainImageUrl ?>');"></div>
                <div class="row s-hero__slide-content animate-this">
                    <div class="column">
                        <div class="s-hero__slide-meta">
                            <span class="cat-links">
                                <a href="categories.php?group=<?php echo $firstBlogCategoryPath ?>"><?php echo $firstBlogCategory; ?></a>
                            </span>
                            <span class="byline"> 
                                Posted by 
                                <span class="author">
                                    <a href="#">Bujare Ndrecaj</a>
                                </span>
                            </span>
                        </div>
                        <h1 class="s-hero__slide-text">
                            <a href="single-blog.php?blog=<?php echo $firstBlogPath; ?>"><?php echo $firstBlogTitle; ?></a>
                        </h1>
                    </div>
                </div>
            </div> 

            <?php
            }

            $sqlGetSecondBlog = "SELECT * FROM blog_post INNER JOIN blog_category ON blog_post.category_id = blog_category.category_id WHERE home_page_placement = '2' AND post_status != '2' LIMIT 1";            
            $queryGetSecondBlog = mysqli_query($connection, $sqlGetSecondBlog);

            if ($rowGetSecondBlog = mysqli_fetch_assoc($queryGetSecondBlog)) {

                $secondBlogCategory = $rowGetSecondBlog['category_title'];
                $secondBlogCategoryPath = $rowGetSecondBlog['category_path'];
                $secondBlogTitle = $rowGetSecondBlog['post_title'];
                $secondBlogPath = $rowGetSecondBlog['post_path'];
                $secondBlogMainImageUrl = $rowGetSecondBlog['main_image_url'];

            ?>

            <div class="s-hero__slide">
                <div class="s-hero__slide-bg" style="background-image: url('<?php echo $secondBlogMainImageUrl ?>');"></div>
                <div class="row s-hero__slide-content animate-this">
                    <div class="column">
                        <div class="s-hero__slide-meta">
                            <span class="cat-links">
                                <a href="categories.php?group=<?php echo $secondBlogCategoryPath; ?>"><?php echo $secondBlogCategory; ?></a>
                            </span>
                            <span class="byline"> 
                                Posted by 
                                <span class="author">
                                    <a href="#">Test Test</a>
                                </span>
                            </span>
                        </div>
                        <h1 class="s-hero__slide-text">
                            <a href="single-blog.php?blog=<?php echo $secondBlogPath; ?>"><?php echo $secondBlogTitle; ?></a>
                        </h1>
                    </div>
                </div>
            </div> 

            <?php 
            }

            $sqlGetThirdBlog = "SELECT * FROM blog_post INNER JOIN blog_category ON blog_post.category_id = blog_category.category_id WHERE home_page_placement = '3' AND post_status != '2' LIMIT 1";            
            $queryGetThirdBlog = mysqli_query($connection, $sqlGetThirdBlog);

            if ($rowGetThirdBlog = mysqli_fetch_assoc($queryGetThirdBlog)) {

                $thirdBlogCategory = $rowGetThirdBlog['category_title'];
                $thirdBlogCategoryPath = $rowGetThirdBlog['category_path'];
                $thirdBlogTitle = $rowGetThirdBlog['post_title'];
                $thirdBlogPath = $rowGetThirdBlog['post_path'];
                $thirdBlogMainImageUrl = $rowGetThirdBlog['main_image_url'];
            
            ?>

            <div class="s-hero__slide"">
                <div class="s-hero__slide-bg" style="background-image: url('<?php echo $thirdBlogMainImageUrl ?>');"></div>
                <div class="row s-hero__slide-content animate-this">
                    <div class="column">
                        <div class="s-hero__slide-meta">
                            <span class="cat-links">
                                <a href="categories.php?group=<?php echo $thirdBlogCategoryPath; ?>"><?php echo $thirdBlogCategory; ?></a>
                            </span>
                            <span class="byline"> 
                                Posted by 
                                <span class="author">
                                    <a href="#0">Test Test</a>
                                </span>
                            </span>
                        </div>
                        <h1 class="s-hero__slide-text">
                            <a href="single-blog.php?blog=<?php echo $thirdBlogPath; ?>"><?php echo $thirdBlogTitle; ?></a>
                        </h1>
                    </div>
                </div>
            </div> 

            <?php } ?>

        </div> 

        <div class="s-hero__social hide-on-mobile-small">
            <p>Follow</p>
            <span></span>
            <ul class="s-hero__social-icons">
                <li><a href="https://facebook.com"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
                <li><a href="https://twitter.com"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                <li><a href="https://instagram.com"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
                <li><a href="https://youtube.com"><i class="fab fa-dribbble" aria-hidden="true"></i></a></li>
            </ul>
        </div>

        <div class="nav-arrows s-hero__nav-arrows">
            <button class="s-hero__arrow-prev">
                <svg viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg" width="15" height="15"><path d="M1.5 7.5l4-4m-4 4l4 4m-4-4H14" stroke="currentColor"></path></svg>
            </button>
            <button class="s-hero__arrow-next">
               <svg viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg" width="15" height="15"><path d="M13.5 7.5l-4-4m4 4l-4 4m4-4H1" stroke="currentColor"></path></svg>
            </button>
        </div>
    </section> 


    <!-- content
    ================================================== -->
    <section class="s-content s-content--no-top-padding">


        <!-- masonry
        ================================================== -->
        <div class="s-bricks">

            <div class="masonry">
                <div class="bricks-wrapper h-group">

                    <div class="grid-sizer"></div>

                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>

                    <?php 
                    
                    $sqlGetAllBlogs = "SELECT * FROM blog_post WHERE post_status = '1' ORDER BY blog_post_id DESC";
                    $queryGetAllBlogs = mysqli_query($connection, $sqlGetAllBlogs);

                    while ($rowGetAllBlogs = mysqli_fetch_assoc($queryGetAllBlogs)) {

                        $blogTitle = $rowGetAllBlogs['post_title'];
                        $blogPath = $rowGetAllBlogs['post_path'];
                        $blogSummary = $rowGetAllBlogs['post_sumary'];                        
                        $blogAltImageUrl = $rowGetAllBlogs['alt_image_url'];

                        
                    
                    
                    ?>

                    <article class="brick entry" data-aos="fade-up">
    
                        <div class="entry__thumb">
                            <a href="single-blog.php?blog=<?php echo $blogPath; ?>" class="thumb-link">
                                <img src="<?php echo $blogAltImageUrl; ?>" 
                                     srcset="<?php echo $blogAltImageUrl; ?> 1x, <?php echo $blogAltImageUrl; ?> 2x" alt="">
                            </a>
                        </div> <!-- end entry__thumb -->
    
                        <div class="entry__text">
                            <div class="entry__header">
                                <h1 class="entry__title"><a href="single-blog.php?blog=<?php echo $blogPath; ?>"><?php echo $blogTitle; ?></a></h1>
                                
                                <div class="entry__meta">
                                    <span class="byline">By:
                                        <span class='author'>
                                            <a href="#">Bujare Ndrecaj</a>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="entry__excerpt">
                                <p><?php echo $blogSummary; ?></p>
                            </div>
                            <a class="entry__more-link" href="single-blog.php?blog=<?php echo $blogPath; ?>">Read Blog</a>
                        </div> <!-- end entry__text -->
                    
                    </article> <!-- end article -->

                    <?php } ?>

                </div> <!-- end brick-wrapper -->

            </div> <!-- end masonry -->

            <div class="row">
                <div class="column large-12">
                    <nav class="pgn">
                        <ul>
                            <li>
                                <span class="pgn__prev" href="#0">
                                    Prev
                                </span>
                            </li>
                            <li><a class="pgn__num" href="#0">1</a></li>
                            <li><span class="pgn__num current">2</span></li>
                            <li><a class="pgn__num" href="#0">3</a></li>
                            <li><a class="pgn__num" href="#0">4</a></li>
                            <li><a class="pgn__num" href="#0">5</a></li>
                            <li><span class="pgn__num dots">…</span></li>
                            <li><a class="pgn__num" href="#0">8</a></li>
                            <li>
                                <span class="pgn__next" href="#0">
                                    Next
                                </span>
                            </li>
                        </ul>
                    </nav> <!-- end pgn -->
                </div> <!-- end column -->
            </div> <!-- end row -->

        </div> <!-- end s-bricks -->

    </section> <!-- end s-content -->

    <?php include "footer.php"; ?>

    <!-- Java Script
    ================================================== -->
    <script src="js/jquery-3.5.0.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>

</body>

</html>