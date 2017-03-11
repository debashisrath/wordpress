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
       <h2 class="scom-h2-home-tag" style="text-align: center;font-size: 28px;color: #eb1d1f;font-weight: 700;">We provide solutions for your problems</h2>
    </div>
<?php } ?>
    <?php do_action( '__before_main_container' ); ##hook of the featured page (priority 10) and breadcrumb (priority 20)...and whatever you need! ?>

    <div class="container" role="main">
<?php if ( is_front_page() ) { ?>
    <div class="">
       <h3 class="scom-h2-home-tag" style="text-align: center;font-size: 28px;color: #eb1d1f;font-weight: 700;">
       Our Products </h2>
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
    <div class="">
       <h3 class="scom-h2-home-tag" style="text-align: center;font-size: 28px;color: #eb1d1f;font-weight: 700;">Our Videos</h2>
    </div>

<div class="row">
  <div class="span12">
    Level 1 column
    <div class="row">
      <div class="span4">
            <iframe width="504" height="306" src="https://www.youtube.com/embed/rAkhFkrF_yc?feature=oembed" frameborder="0" allowfullscreen="" style="width: 100%;"></iframe>
        </div>
      <div class="span4"> 
      <iframe width="504" height="306" src="https://www.youtube.com/embed/Kc5iWa-Ky30?feature=oembed" frameborder="0" allowfullscreen="" style="width: 100%;"></iframe>
      </div>
      <div class="span4"><iframe width="504" height="306" src="https://www.youtube.com/embed/MbDndJdRi1o?feature=oembed" frameborder="0" allowfullscreen=""></iframe></div>
    </div>
    <p><a href="">View More</a></p>
  </div>
</div>
<?php } ?>

</div><!-- //#main-wrapper -->

<?php do_action( '__after_main_wrapper' );##hook of the footer with get_footer ?>
