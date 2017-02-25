<?php
/**
* Handles various plugins compatibilty ( Polylang, WPML, WP Ultimate Recipe )
*
* @package      Pro Slider
* @subpackage   classes
* @author       Nicolas GUILLAUME <nicolas@presscustomizr.com>, Rocco Aliberti <rocco@presscustomizr.com>
* @copyright    Copyright (c) 2013-2015, Nicolas GUILLAUME - Rocco Aliberti
* @link         http://presscustomizr.com/
* @license      http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/
if ( ! class_exists( 'TC_plugins_compat_pro_slider' ) ) :
  class TC_plugins_compat_pro_slider {
    //Access any method or var of the class with classname::$instance -> var or method():
    static $instance;
    //credits @Srdjan
    public $default_language, $current_language;

    function __construct () {

      self::$instance =& $this;
      // Call this after the main theme has set up its supported plugins so we can check it
      add_action ('after_setup_theme'          , array( $this , 'tc_set_plugins_supported'), 22 );
      // Call this before the main theme has executed the actually plugin compatibility code, so we can hook to its action/filter hooks
      add_action ('after_setup_theme'          , array( $this , 'tc_plugins_compatibility'), 25 );
    }//end of constructor



    /**
    * Set plugins supported ( before the plugin compat function is fired )
    * => allows to easily remove support by firing remove_theme_support() (with a priority < tc_plugins_compatibility) on hook 'after_setup_theme'
    * hook : after_setup_theme
    *
    * @package Pro Slider
    */
    function tc_set_plugins_supported() {
      add_theme_support( 'wp-ultimate-recipe' );
      add_theme_support( 'lifter-lms' );
    }



    /**
    * This function handles the following plugins compatibility : Polylang, WPML, WP Ultimate Recipe
    *
    * @package Pro Slider
    */
    function tc_plugins_compatibility() {
      /*
      * Back Plugin Compatiblity
      */
      /* WP Ultimate Recipe */
      // This plugin loads a more recent version of select2. Our (older) conflicts with it breaking its shortocode's GUI..
      if ( current_theme_supports( 'wp-ultimate-recipe' ) && method_exists( 'CZR_plugins_compat', 'czr_fn_is_plugin_active' ) &&
          CZR_plugins_compat::$instance -> czr_fn_is_plugin_active('wp-ultimate-recipe/wp-ultimate-recipe.php') )
        add_filter( 'tc_pro_slider_enqueue_select2_res', '__return_false' );

      // This plugin loads a more recent version of select2. Our (older) conflicts with it breaking its settings gui in the Membership post_type editing
      if ( current_theme_supports( 'lifter-lms' ) && method_exists( 'CZR_plugins_compat', 'czr_fn_is_plugin_active' ) &&
          CZR_plugins_compat::$instance -> czr_fn_is_plugin_active('lifterlms/lifterlms.php') )
        $this -> tc_lifter_lms_compat();

      /* Lifter LMS */
      /* Lang compatiblity codes use functions which are defined in the core theme with priority 30 */
      /* I think we need some hook in the core code like __before_core_plugins_compatibility_code __after_core_plugins_compatibility_code*/
      add_action ('after_setup_theme'          , array( $this , 'tc_lang_plugins_compatibility'), 30 );
    }

    /**
    * This function handles the Lifter LMS plugin compatibility
    *
    * @package Pro Slider
    */
    function tc_lifter_lms_compat() {
      add_filter( 'tc_pro_slider_enqueue_select2_res', 'tc_lms_maybe_enqueue_select2_res' );
      function tc_lms_maybe_enqueue_select2_res( $bool ) {
        global $pagenow, $post_type;
        $llms_s2_post_types = apply_filters( 'tc_llms_s2_post_types', array( 'llms_membership', 'course', 'llms_quiz' ) );

        return $bool && ! ( ( 'post-new.php' == $pagenow || 'post.php' == $pagenow ) && in_array( $post_type, $llms_s2_post_types) );
      }
    }


    /**
    * This function handles the following plugins compatibility : Polylang, WPML
    *
    * @package Pro Slider
    */
    function tc_lang_plugins_compatibility() {
      /*
      * Front Plugin Compatibility
      */
      /* Callbacks defined in the Customizr theme */
      /* Polylang */
      //Translate category ids for the filtered slider of posts by cat
      if ( function_exists( 'czr_fn_pll_translate_tax' ) )
        add_filter( 'tc_posts_slider_cat_filter', 'czr_fn_pll_translate_tax' );
      /* WPML */
      //Translate category ids for the filtered slider of posts by cat
      // in this case we remove the polylang posts filter and translate only the category
      if ( function_exists( 'czr_fn_wpml_translate_cat' ) )
        add_filter( 'tc_posts_slider_cat_filter', 'czr_fn_wpml_translate_cat' );
    }
  }//end of class
endif;
