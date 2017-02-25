<?php
/**
* This class is instantiated both in front end
*
*
* @package      Pro Slider
* @subpackage   classes
* @since        3.0
* @author       Nicolas GUILLAUME <nicolas@themesandco.com>, Rocco ALIBERTI <rocco@themesandco.com>
* @copyright    Copyright (c) 2015, Nicolas GUILLAUME - Rocco ALIBERTI
* @link         http://presscustomizr.com
* @license      http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/
if ( ! class_exists( 'TC_front_pro_slider' ) ) :
  class TC_front_pro_slider {
    //Access any method or var of the class with classname::$instance -> var or method():
    static $instance;

    function __construct () {
      self::$instance =& $this;
      add_action( 'after_setup_theme'                  , array( $this , 'tc_set_pro_slider_hooks'), 500 );
    }



    /***************************************
    * HOOKS SETTINGS ***********************
    ****************************************/
    /**
    * hook : after_setup_theme
    */
    function tc_set_pro_slider_hooks() {
      // filter the pre_posts_slider_args to render the current post/page slider of posts
      add_filter( 'tc_get_pre_posts_slides_args'   , array( $this, 'tc_pro_slider_force_post_slider_options') );
    }




    /**
    * Filter the pre_posts_slider_args to render the current post/page slider of posts
    *
    * @param args array of post slider params
    * @return update array of post slider params
    *
    * hook: tc_get_pre_posts_slides_args
    */
    function tc_pro_slider_force_post_slider_options( $args ) {
      if ( czr_fn__f( '__is_home' ) )
        return $args;

      return array_merge( $args, TC_pro_slider::$instance -> tc_pro_slider_get_post_slider_options() );
    }

  }//end of class
endif;
