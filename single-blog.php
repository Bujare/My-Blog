<?php 

require "admin/includes/dbh.php";

if (isset($_REQUEST['blog'])) {

    $blogPath = $_REQUEST['blog'];

    $sqlGetBlog = "SELECT * FROM blog_post WHERE post_path = '$blogPath' AND post_status = '1'";
    $queryGetBlog = mysqli_query($connection, $sqlGetBlog);

    if ($rowGetBlog = mysqli_fetch_assoc($queryGetBlog)) {
        $blogPostId = $rowGetBlog['blog_post_id'];
        $blogCategoryId = $rowGetBlog['category_id'];
        $blogTitle = $rowGetBlog['post_title'];
        $blogMetaTitle = $rowGetBlog['post_meta_title'];
        $blogContent = $rowGetBlog['post_content'];
        $blogMainImgUrl = $rowGetBlog['main_image_url'];
        $blogCreationDate = $rowGetBlog['date_created'];
    }
    else {
        header("Location: index.php");
        exit();
    }

    $sqlGetCategory = "SELECT * FROM blog_category WHERE category_id = '$blogCategoryId'";
    $queryGetCategory = mysqli_query($connection, $sqlGetCategory);

    if ($rowGetCategory = mysqli_fetch_assoc($queryGetCategory)) {
        $categoryTitle = $rowGetCategory['category_title'];
        $blogCategoryPath = $rowGetCategory['category_path'];
    }

    $sqlGetTags = "SELECT * FROM blog_tags WHERE blog_post_id = '$blogPostId'";
    $queryGetTags = mysqli_query($connection, $sqlGetTags);

    if ($rowGetTags = mysqli_fetch_assoc($queryGetTags)) {
        $blogTags = $rowGetTags['tag'];
        $blogTagsArr = explode(",", $blogTags);
    }

    

}

?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>

    <!--- basic page needs
    ================================================== -->
    <meta charset="utf-8">
    <title>Bujare's Blog | <?php echo $blogMetaTitle; ?></title>
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


    <?php include "header-opaque.php"; ?>



    <!-- content
    ================================================== -->
    <section class="s-content">

        <div class="row">
            <div class="column large-12">

                <article class="s-content__entry format-standard">

                    <div class="s-content__media">
                        <div class="s-content__post-thumb">
                            <img src="<?php echo $blogMainImgUrl; ?>" 
                                 srcset="<?php echo $blogMainImgUrl; ?> 2100w, 
                                 <?php echo $blogMainImgUrl; ?> 1050w, 
                                 <?php echo $blogMainImgUrl; ?> 525w" sizes="(max-width: 2100px) 100vw, 2100px" alt="">
                        </div>
                    </div> <!-- end s-content__media -->

                    <div class="s-content__entry-header">
                        <h1 class="s-content__title s-content__title--post"><?php echo $blogTitle; ?></h1>
                    </div> <!-- end s-content__entry-header -->

                    <div class="s-content__primary">

                        <div class="s-content__entry-content">

                            <?php echo $blogContent; ?>

                        </div> <!-- end s-entry__entry-content -->

                        <div class="s-content__entry-meta">

                            <div class="entry-author meta-blk">
                                <div class="author-avatar">
                                    <img class="avatar" src="images/profile.jpg" alt="">
                                </div>
                                <div class="byline">
                                    <span class="bytext">Posted By</span>
                                    <a href="#">Bujare Ndrecaj</a>
                                </div>
                            </div>

                            <div class="meta-bottom">
                                
                                <div class="entry-cat-links meta-blk">
                                    <div class="cat-links">
                                        <span>In</span> 
                                        <a href="categories.php?group=<?php echo $blogCategoryPath; ?>"><?php echo $categoryTitle; ?></a>
                                    </div>

                                    <span>On</span>
                                    <?php echo date("M j, Y", strtotime($blogCreationDate)); ?>
                                </div>

                                <div class="entry-tags meta-blk">
                                    <span class="tagtext">Tags</span>
                                    <?php 
                                    
                                    for ($i = 0; $i < count($blogTagsArr); $i++) {
                                        if (!empty($blogTagsArr[$i])) {
                                            echo "<a href='search.php?query=".$blogTagsArr[$i]."'>".$blogTagsArr[$i]."</a>";
                                        }
                                    }
                                    
                                    ?>
                                </div>

                            </div>

                        </div> <!-- s-content__entry-meta -->

                        <div class="s-content__pagenav">


                            <?php
                            //'".$blogPostId."'
                            $sqlGetPreviousBlog = "SELECT * FROM blog_post WHERE blog_post_id = (SELECT max(blog_post_id) FROM blog_post WHERE blog_post_id < '".$blogPostId."') AND post_status = '1'";
                            $queryGetPreviousBlog = mysqli_query($connection, $sqlGetPreviousBlog);

                            $sqlGetNextBlog = "SELECT * FROM blog_post WHERE blog_post_id = (SELECT min(blog_post_id) FROM blog_post WHERE blog_post_id > '".$blogPostId."') AND post_status = '1'";
                            $queryGetNextBlog = mysqli_query($connection, $sqlGetNextBlog);

                            if ($rowGetPreviousBlog = mysqli_fetch_assoc($queryGetPreviousBlog)) {
                                $previousBlogName = $rowGetPreviousBlog['post_title'];
                                $previousBlogPath = $rowGetPreviousBlog['post_path'];

                                echo "<div class='prev-nav'>
                                        <a href='single-blog.php?blog=".$previousBlogPath."' rel='prev'>
                                            <span>Previous</span>
                                            ".$previousBlogName."
                                        </a>
                                    </div>";
                            }

                            if ($rowGetNextBlog = mysqli_fetch_assoc($queryGetNextBlog)) {
                                $nextBlogName = $rowGetNextBlog['post_title'];
                                $nextBlogPath = $rowGetNextBlog['post_path'];

                                echo "<div class='prev-nav'>
                                        <a href='single-blog.php?blog=".$nextBlogPath."' rel='prev'>
                                            <span>Next</span>
                                            ".$nextBlogName."
                                        </a>
                                    </div>";
                            }
                         
                            ?>                           
                         </div> <!-- end s-content__pagenav -->

                    </div> <!-- end s-content__primary -->
                </article> <!-- end entry -->

            </div> <!-- end column -->
        </div> <!-- end row -->

        <?php 
        
        $sqlGetAllComments = "SELECT * FROM blog_comments WHERE blog_post_id = '$blogPostId'";
        $queryGetAllComments = mysqli_query($connection, $sqlGetAllComments);
        $numComments = mysqli_num_rows($queryGetAllComments);
        
        ?>


        <!-- comments
        ================================================== -->
        <div class="comments-wrap">

            <div id="comments" class="row">
                <div class="column large-12">

                    <h3><?php echo $numComments; ?> Comments</h3>

                    <!-- START commentlist -->
                    <ol class="commentlist" id="commentlist">

                        <?php 
                        
                        $sqlGetComments = "SELECT * FROM blog_comments WHERE blog_post_id = '$blogPostId' AND blog_comment_parent_id = '0' ORDER BY date_created ASC";
                        $queryGetComments = mysqli_query($connection, $sqlGetComments);

                        while ($rowComments = mysqli_fetch_assoc($queryGetComments)) {

                            $commentId = $rowComments['blog_comment_id'];
                            $commentAuthor = $rowComments['comment_author'];
                            $comment = $rowComments['comment'];
                            $commentDate = $rowComments['date_created'];

                            $sqlCheckCommentChildren = "SELECT * FROM blog_comments WHERE blog_comment_parent_id = '$commentId' ORDER BY date_created ASC";
                            $queryCheckCommentChildren = mysqli_query($connection, $sqlCheckCommentChildren);
                            $numCommentChildren = mysqli_num_rows($queryCheckCommentChildren);

                            if ($numCommentChildren == 0) {
                            
                            ?>

                            <li class="depth-1 comment">
                                <div class="comment__content">
                                    <div class="comment__info">
                                        <input type="hidden" id="comment-author-<?php echo $commentId; ?>" value="<?php echo $commentAuthor; ?>">
                                        <div class="comment__author"><?php echo $commentAuthor; ?></div>
                                        <div class="comment__meta">
                                            <div class="comment__time"><?php echo date("M j, Y", strtotime($commentDate)); ?></div>
                                            <div class="comment__reply">
                                                <a class="comment-reply-link" href="#reply-comment-section" onclick="prepareReply('<?php echo $commentId; ?>');">Reply</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="comment__text">
                                    <p><?php echo $comment; ?></p>
                                    </div>
                                </div>
                            </li> 

                            
                            <?php

                            }
                            else {

                            ?>
                                <li class="thread-alt depth-1 comment">
                                    <div class="comment__content">
                                        <div class="comment__info">
                                            <input type="hidden" id="comment-author-<?php echo $commentId; ?>" value="<?php echo $commentAuthor; ?>">
                                            <div class="comment__author"><?php echo $commentAuthor; ?></div>
                                            <div class="comment__meta">
                                                <div class="comment__time"><?php echo date("M j, Y", strtotime($commentDate)); ?></div>
                                                <div class="comment__reply">
                                                    <a class="comment-reply-link" href="#reply-comment-section" onclick="prepareReply('<?php echo $commentId; ?>');">Reply</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="comment__text">
                                        <p><?php echo $comment; ?></p>
                                        </div>
                                    </div>

                                <?php

                                while ($rowCommentChildren = mysqli_fetch_assoc($queryCheckCommentChildren)) {

                                    $commentIdChild = $rowCommentChildren['blog_comment_id'];
                                    $commentAuthorChild = $rowCommentChildren['comment_author'];
                                    $commentChild = $rowCommentChildren['comment'];
                                    $commentDateChild = $rowCommentChildren['date_created'];

                                    echo "<ul class='children'>
                                            <li class='depth-2 comment'>
                                                <div class='comment__content'>
                                                    <div class='comment__info'>
                                                        <div class='comment__author'>".$commentAuthorChild."</div>
                                                        <div class='comment__meta'>
                                                            <div class='comment__time'>".date("M j, Y", strtotime($commentDateChild))."</div>
                                                        </div>
                                                    </div>
                                                        <div class='comment__text'>
                                                            <p>".$commentChild."</p>
                                                        </div>
                                                </div>
                                            </li>
                                        </ul>";

                                }

                            }

                        }
                        
                        ?>

                    </ol>
                    <!-- END commentlist -->

                </div> <!-- end col-full -->
            </div> <!-- end comments -->

            <div class="row comment-respond" id="reply-comment-section">

            <!-- START respond -->
            <div id="respond" class="column">

                <h3 id="reply-h3"></h3>

                <p style="color:green;display:none;" id="reply-success">Your reply was added successfully. Refresh your page to view it.</p>
                <p style="color:red;display:none;" id="reply-error"></p>


                <form name="replyForm" id="replyForm">
                    <fieldset>
                        <input type="hidden" name="replyBlogPostId" id="replyBlogPostId" value="<?php echo $blogPostId; ?>">
                        <div class="form-field">
                        <input type="hidden" name="commentParentId" id="commentParentId" value="">
                        <div class="form-field">
                            <input name="replyCName" id="replyCName" class="h-full-width h-remove-bottom" placeholder="Your Name" value="" type="text">
                        </div>
                        <div class="form-field">
                            <input name="replyCEmail" id="replyCEmail" class="h-full-width h-remove-bottom" placeholder="Your Email" value="" type="text">
                        </div>
                        <div class="message form-field">
                            <textarea name="replyCMessage" id="replyCMessage" class="h-full-width" placeholder="Your Message"></textarea>
                        </div>
                        <br>
                        <input name="submit" id="submitReplyForm" class="btn btn--primary btn-wide btn--large h-full-width" value="Reply" type="submit">
                        <input name="submit" id="addComment" class="btn btn--primary btn-wide btn--large h-full-width" value="Add Comment" onclick="prepareComment();">
                    </fieldset>
                </form> <!-- end form -->
            </div>
            <!-- END respond-->

            </div> <!-- end comment-respond -->

            <div class="row comment-respond" id="add-comment-section">

                <!-- START respond -->
                <div id="respond" class="column">

                    <h3>
                    Add Comment 
                    <span>Your email address will not be published.</span>
                    </h3>

                    <p style="color:green;display:none;" id="comment-success">Your comment was added successfully.</p>
                    <p style="color:red;display:none;" id="comment-error"></p>


                    <form name="commentForm" id="commentForm">
                        <fieldset>
                            <input type="hidden" name="blogPostId" id="blogPostId" value="<?php echo $blogPostId; ?>">
                            <div class="form-field">
                                <input name="cName" id="cName" class="h-full-width h-remove-bottom" placeholder="Your Name" value="" type="text">
                            </div>
                            <div class="form-field">
                                <input name="cEmail" id="cEmail" class="h-full-width h-remove-bottom" placeholder="Your Email" value="" type="text">
                            </div>
                            <div class="message form-field">
                                <textarea name="cMessage" id="cMessage" class="h-full-width" placeholder="Your Message"></textarea>
                            </div>
                            <br>
                            <input name="submit" id="submitCommentForm" class="btn btn--primary btn-wide btn--large h-full-width" value="Add Comment" type="submit">
                        </fieldset>
                    </form> <!-- end form -->
                </div>
                <!-- END respond-->

            </div> <!-- end comment-respond -->

        </div> <!-- end comments-wrap -->


    </section> <!-- end s-content -->


    <?php include "footer.php";?>


    <!-- Java Script
    ================================================== -->
    <script src="js/jquery-3.5.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>

    <script>

        $(document).ready(function() {
            prepareComment();
        });

        function checkEmail(email) {
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!regex.test(email)) {
                return false;
            }
            else {
                return true;
            }
        }

        function prepareReply(commentId) {
            $("#comment-success").css("display", "none");
            $("#comment-error").css("display", "none");
            $("#reply-comment-section").show();
            $("#add-comment-section").hide();
            var authorName = $("#comment-author-" + commentId).val();
            $("#reply-h3").html("Reply to: " + authorName);
            $("#commentParentId").val(commentId);
        }

        function prepareComment() {
            $("#comment-success").css("display", "none");
            $("#comment-error").css("display", "none");
            $("#reply-comment-section").hide();
            $("#add-comment-section").show();
        }

        $(document).on('submit', '#commentForm', function(e) {

            e.preventDefault();

            $("#comment-success").css("display", "none");
            $("#comment-error").css("display", "none");

            var name = $("#cName").val();
            var email = $("#cEmail").val();
            var comment = $("#cMessage").val();

            if (!name || !email || !comment) {
                $("#comment-error").css("display", "block");
                $("#comment-error").html("Please fill all fields.");
            } else if (name.length > 50) {
                $("#comment-error").css("display", "block");
                $("#comment-error").html("The name input field can only be a max of 50 characters.");
            } else if (email.length > 50) {
                $("#comment-error").css("display", "block");
                $("#comment-error").html("The email input field can only be a max of 50 characters.");
            } else if (comment.length > 500) {
                $("#comment-error").css("display", "block");
                $("#comment-error").html("The comment input field can only be a max of 500 characters.");
            } else if (checkEmail(email) == false) {
                $("#comment-error").css("display", "block");
                $("#comment-error").html("Please enter a valid email address.");
            } else {

                var date = new Date();
                var months = ["JAN", "FEB", "MAR", "APR", "MAY", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
                var dateFormatted = months[date.getMonth()] + " " + date.getDate() + ", " + date.getFullYear();

                $.ajax({
                    method: "POST",
                    url: "includes/add-comment.php",
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data == "success") {
                            var newComment = "<li class='depth-1 comment><div class='comment__content'><div class='comment__info'><div class='comment__author'>" + name + "</div><div class='comment__meta'><div class='comment__time'>" + dateFormatted + "</div></div></div><div class='comment__text'><p>" + comment + "</p></div></div></li>";
                            $("#comment-success").css("display", "block");
                            $("#commentlist").append(newComment);
                            $("#commentForm").hide();
                        }
                        else {
                            $("#comment-error").css("display", "block");
                            $("#comment-error").html("There was an error while adding your comment. Please try again later.");
                        }
                    }
                });
            }
        });

        $(document).on('submit', '#replyForm', function(e) {

            e.preventDefault();

            $("#reply-success").css("display", "none");
            $("#reply-error").css("display", "none");

            var name = $("#replyCName").val();
            var email = $("#replyCEmail").val();
            var reply = $("#replyCMessage").val();
            var parentId = $("#commentParentId").val();

            if (!name || !email || !reply) {
                $("#reply-error").css("display", "block");
                $("#reply-error").html("Please fill all fields.");
            } else if (name.length > 50) {
                $("#reply-error").css("display", "block");
                $("#reply-error").html("The name input field can only be a max of 50 characters.");
            } else if (email.length > 50) {
                $("#reply-error").css("display", "block");
                $("#reply-error").html("The email input field can only be a max of 50 characters.");
            } else if (reply.length > 500) {
                $("#reply-error").css("display", "block");
                $("#reply-error").html("The message input field can only be a max of 500 characters.");
            } else if (checkEmail(email) == false) {
                $("#reply-error").css("display", "block");
                $("#reply-error").html("Please enter a valid email address.");
            } else if (!parentId) {
                $("#reply-error").css("display", "block");
                $("#reply-error").html("There was an unexpected error. Try refreshing the page.");
            } else {

                var date = new Date();
                var months = ["JAN", "FEB", "MAR", "APR", "MAY", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
                var dateFormatted = months[date.getMonth()] + " " + date.getDate() + ", " + date.getFullYear();

                $.ajax({
                    method: "POST",
                    url: "includes/add-reply.php",
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data == "success") {
                            $("#reply-success").css("display", "block");
                            $("#replyForm").hide();
                        }
                        else {
                            $("#reply-error").css("display", "block");
                            $("#reply-error").html("There was an error while adding your reply. Please try again later.");
                        }
                    }
                });
            }
        });

    </script>

</body>

</html>