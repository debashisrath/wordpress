<?php
/**
* Fires the plugin
* @package      PC_pro_bundle
* @author Nicolas GUILLAUME - Rocco ALIBERTI
* @since 1.0
*/
if ( ! class_exists( 'TC_pro_slider' ) ) :
class TC_pro_slider {
  static $instance;

  function __construct() {
    self::$instance =& $this;

    $this -> load();

    //safe hook to let the query filter called in admin, e.g. wp action hook isn't fired on save_post
    add_action( 'after_setup_theme'                  , array( $this , 'tc_set_pro_slider_hooks'), 500 );
  }//end __construct


  private function load() {
    $plug_classes = array(
      'TC_utils_pro_slider'          => array('/utils/classes/class_utils_slider.php'),
      'TC_plugins_compat_pro_slider' => array('/utils/classes/class-fire-plugins_compat.php'),
      'TC_back_pro_slider'           => array('/back/classes/class_back_slider.php'),
      'TC_front_pro_slider'          => array('/front/classes/class_front_slider.php')
    );//end of plug_classes array

    //loads and instanciates the plugin classes
    foreach ( $plug_classes as $name => $params ) {
        //don't load admin classes if not admin && not customizing
        if ( is_admin() && ! PC_pro_bundle::$instance -> is_customizing ) {
          if ( false != strpos($params[0], 'front') )
            continue;
        }

        if ( ! is_admin() && ! PC_pro_bundle::$instance -> is_customizing ) {
          if ( false != strpos($params[0], 'back') )
            continue;
        }

        if( ! class_exists( $name ) )
            require_once ( dirname( __FILE__ ) . $params[0] );

        $args = isset( $params[1] ) ? $params[1] : null;

        new $name( $args );
    }//end for
  }//fn


  /**
  * hook : after_setup_theme
  */
  function tc_set_pro_slider_hooks() {
    //alter the posts slider query
    add_filter( 'tc_query_posts_slider_join'           , array( $this, 'tc_pro_slider_filter_posts_by_cat'), 10, 2 );
    add_filter( 'tc_query_posts_slider_join_where'     , array( $this, 'tc_pro_slider_filter_posts_by_cat'), 10, 2 );
  }


  /**
  * Filter the posts slider query SQL join clause
  * @param join , the JOIN string
  * @param args , params passed throughout the caller, it might contain info on the slider to show e.g. the transient name
  *
  *
  * hook : tc_query_posts_slider_join
  * hook : tc_query_posts_slider_join_where
  */
  function tc_pro_slider_filter_posts_by_cat( $join, $args ) {
    global $wpdb;
    $cats = $this -> tc_get_slider_categories( $args );

    if ( is_array( $cats ) && ! empty( $cats ) ) {
      switch ( current_filter() ){
        case 'tc_query_posts_slider_join'        : $join .= " INNER JOIN $wpdb->term_relationships AS _wp_term";
                                                   break;
        case 'tc_query_posts_slider_join_where'  : $join .= sprintf('%1$s _wp_term.term_taxonomy_id IN ( %2$s ) AND posts.ID = _wp_term.object_ID',
                                                                      $join ? 'AND' : 'WHERE',
                                                                      implode(',', $cats )
                                                   );
                                                   break;
      }
    }
    return $join;
  }

  /*
  * Helper
  * Get the categories which will filter the slider of posts
  *
  * @param args    : the array which stores the slider's configuration
  * @return array : the array of categories
  *
  * we cache them 'cause the array of cats is retrieved twice by two subsequent filter callbacks 'tc_query_posts_slider_join' , 'tc_query_posts_slider_join_where'
  * in order to avoid re-run filters on tc_posts_slider_cat_filter (used by lang plugins)
  *
  */
  function tc_get_slider_categories( $args ) {

    $_cats = ( ! empty( $args ) && isset( $args['categories'] ) ) ? $args['categories'] : array();
    // when a transient_name wich doesn't contain "tc_posts_slider_"{ID} is set we know we're displaying the home slider, so we have to refer to the theme option
    $_context = ( ! empty( $args ) && isset( $args['transient_name'] ) && strstr( $args['transient_name'], 'tc_posts_slides_' ) ) ? $args['transient_name'] : 'home';

    //get cached cats
    $cats = wp_cache_get( $_context );
    if ( ! $cats ) {
      $cats = 'home' == $_context ? CZR_utils::$inst->czr_fn_opt( 'tc_posts_slider_restrict_by_cat') : $_cats;

      $cats = (array)apply_filters( 'tc_posts_slider_cat_filter', $cats);
      $cats = array_filter( $cats, array( CZR_utils::$inst , 'czr_fn_category_id_exists' ) );
      //store cached cats
      wp_cache_set( $_context, $cats );
    }
    return $cats;
  }


  /*
  * Get the current context slider option when in posts/pages
  *
  * used on front to filter the pre post slides args ( in a callback of tc_get_pre_posts_slides_args )
  * used on back when building the posts slider post/page transients
  *
  * @return array of options
  */
  function tc_pro_slider_get_post_slider_options( $post_id = null ) {
    if ( czr_fn__f('__is_home') )
      return array();

    if ( is_null( $post_id ) )
      $post_id = get_queried_object_id() ? get_queried_object_id() : get_the_ID() ;

    if ( ! $post_id )
      return array();

    $saved_meta  = get_post_meta( $post_id, 'post_slider_posts_key', true );

    if ( empty( $saved_meta ) ) return array();

    $saved_meta['transient_name']  = 'tc_posts_slides_'. $post_id;

    return $saved_meta;
  }
}//end class
endif;
