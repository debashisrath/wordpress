<?php
/**
 * The main template file. Includes the loop.
 *
 *
 * @package Customizr
 * @since Customizr 1.0
 */
if ( apply_filters( 'czr_four_do', false ) ) {
  do_action( 'czr_four_template' );
  return;
}
?>
<?php do_action( '__before_main_wrapper' ); ##hook of the header with get_header ?>


<div id="main-wrapper" class="<?php echo implode(' ', apply_filters( 'tc_main_wrapper_classes' , array('container') ) ) ?>">
    <?php if ( is_front_page() ) { ?>
    <div class="">
       <h2 class="scom-h2-home-tag">We provide solutions for your problems</h2>
    </div>
<?php } ?>
    <?php do_action( '__before_main_container' ); ##hook of the featured page (priority 10) and breadcrumb (priority 20)...and whatever you need! ?>

    <div class="container" role="main">
<?php if ( is_front_page() ) { ?>
    <div class="">
       <h3 class="scom-h2-home-tag">Our Products</h2>
    </div>
<?php } ?>

        <div class="<?php echo implode(' ', apply_filters( 'tc_column_content_wrapper_classes' , array('row' ,'column-content-wrapper') ) ) ?>">

            <?php do_action( '__before_article_container'); ##hook of left sidebar?>

                <div id="content" class="<?php echo implode(' ', apply_filters( 'tc_article_container_class' , array( CZR_utils::czr_fn_get_layout( CZR_utils::czr_fn_id() , 'class' ) , 'article-container' ) ) ) ?>">

                    <?php do_action ('__before_loop');##hooks the heading of the list of post : archive, search... ?>

                        <?php if ( czr_fn__f('__is_no_results') || is_404() ) : ##no search results or 404 cases ?>

                            <article <?php czr_fn__f('__article_selectors') ?>>
                                <?php do_action( '__loop' ); ?>
                            </article>

                        <?php endif; ?>

                        <?php if ( have_posts() && ! is_404() ) : ?>
                            <?php while ( have_posts() ) : ##all other cases for single and lists: post, custom post type, page, archives, search, 404 ?>
                                <?php the_post(); ?>

                                <?php do_action ('__before_article') ?>
                                    <article <?php czr_fn__f('__article_selectors') ?>>
                                        <?php do_action( '__loop' ); ?>
                                    </article>
                                <?php do_action ('__after_article') ?>

                            <?php endwhile; ?>

                        <?php endif; ##end if have posts ?>

                    <?php do_action ('__after_loop');##hook of the comments and the posts navigation with priorities 10 and 20 ?>

           <?php do_action( '__after_article_container'); ##hook of left sidebar ?>
        </div><!--.row -->
    </div><!-- .container role: main -->
</div>

  <?php do_action( '__after_main_container' ); ?>

<?php if ( is_front_page() ) { ?>
<a href="videos"><h3 class="scom-h2-home-tag" style="">Our Videos</h3></a>
<div class="row">
  <div class="span12">
    <div class="row">
        <div class="span4">
            <iframe width="504" height="306" src="https://www.youtube.com/embed/rAkhFkrF_yc?feature=oembed" frameborder="0" allowfullscreen="" style="width: 100%;"></iframe>
        </div>
        <div class="span4"> 
             <iframe width="504" height="306" src="https://www.youtube.com/embed/Kc5iWa-Ky30?feature=oembed" frameborder="0" allowfullscreen="" style="width: 100%;"></iframe>
        </div>
        <div class="span4">
             <iframe width="504" height="306" src="https://www.youtube.com/embed/MbDndJdRi1o?feature=oembed" frameborder="0" allowfullscreen=""></iframe>
        </div>
    </div>
    <p class="home_view_more"><a href="videos">View More...</a></p>
  </div>
</div>
<div class="row main-testimonial">
 <h4 class="peopleabout scom-h2-home-tag">What people say about us</h4>
    <div class="span12">
        <div class="mySlides">
             <img src="wp-content/themes/customizr-pro/assets/front/img/male.png" alt="male" width="80px" height="80px"> 
             <p class="testimonial-description"><i class="fa fa-quote-left" aria-hidden="true"></i> Hypnosis under clinical conditions, is a great wonderful tool to deal with trauma, behavioral issues,hes,lack of motivation, examination phobia, fear of rejection <i class="fa fa-quote-right" aria-hidden="true"></i> <br>
             <span class="persionname">Ishan,Bangalore</span></p>  
        </div>
        <div class="mySlides"> 
             <img src="wp-content/themes/customizr-pro/assets/front/img/male.png" alt="male" width="80px" height="80px">
             <p class="testimonial-description"><i class="fa fa-quote-left" aria-hidden="true"></i>  is a great wonderful tool to deal with trauma, behavioral issues, relationship issues, anxiety, depression, insomnia, skin rashes,lack of motivation, examination phobia, fear of rejection <i class="fa fa-quote-right" aria-hidden="true"></i><br>
             <span class="persionname">Ishan,Bangalore</span></p>  
        </div>  
        <div class="mySlides"> 
            <img src="wp-content/themes/customizr-pro/assets/front/img/male.png" alt="male" width="80px" height="80px"> 
            <p class="testimonial-description"><i class="fa fa-quote-left" aria-hidden="true"></i> Hypnosis under , is a great wonderful tool to deal with trauma, behavioral issues, relationship issues, anxiety, depression, insomnia, skin rashes,lack of motivation, examination phobia, fear of rejection <i class="fa fa-quote-right" aria-hidden="true"></i><br>
            <span class="persionname">Ishan,Bangalore</span></p>  
        </div>
     </div>
</div>
  

<style type="text/css">  </style>
<script>
var myIndex = 0;
carousel();
function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";  
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}    
    x[myIndex-1].style.display = "block";  
    setTimeout(carousel, 7000); // Change image every 2 seconds
}
</script>

<?php } ?>

</div><!-- //#main-wrapper -->

<?php do_action( '__after_main_wrapper' );##hook of the footer with get_footer ?>
