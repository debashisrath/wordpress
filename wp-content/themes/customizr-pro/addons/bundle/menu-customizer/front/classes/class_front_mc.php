<?php
/**
* FRONT END CLASS
* @package  MC
* @author Nicolas GUILLAUME, Rocco ALIBERTI
* @since 1.0
*/
class PC_front_mc {

    //Access any method or var of the class with classname::$instance -> var or method():
    static $instance;

    function __construct () {
        self::$instance     =& $this;

        add_action( 'template_redirect'                  , array( $this , 'pc_set_mc_hooks') );
        //before Customizr-Pro theme resources
        add_action( 'wp_enqueue_scripts'       , array( $this , 'pc_enqueue_plug_resources'), 9 );

    }//end of construct


    /***************************************
    * HOOKS SETTINGS ***********************
    ****************************************/
    /**
    * hook : wp_head
    */
    function pc_set_mc_hooks() {
      add_filter( 'tc_sidenav_body_class'             , array( $this, 'pc_mc_body_class') );
    }

    /**
    * hook : tc_sidenav_body_class filter
    *
    * @package Customizr
    * @since Customizr 3.3+
    */
    function pc_mc_body_class( $_class ){
      $effect = apply_filters( 'tc_sidenav_slide_mobile', wp_is_mobile() ) ? 'mc_slide_top' : $this -> pc_mc_open_effect();
      return $_class .= '-' . $effect;
    }


    /******************************
    HELPERS
    *******************************/

    /******************************************
    * SETTERS / GETTTERS / CALLBACKS
    ******************************************/

    /**
    * @return string
    */
    private function pc_mc_open_effect() {
      return apply_filters( 'pc_mc_open_effect', esc_attr( CZR_utils::$inst->czr_fn_opt( 'tc_mc_effect') ) );
    }



    /******************************
    * ASSETS
    *******************************/
    /* Enqueue Plugin resources */
    function pc_enqueue_plug_resources() {
      if ( ! method_exists( 'CZR_menu', 'czr_fn_is_sidenav_enabled') )
        return;

      /*
      * enqueue resources only if NOT
      * 1) sidenav enabled
      * and
      * 2) not slide in mobiles (handled in Customizr free)
      */
      
      if ( ! ( CZR_menu::$instance->czr_fn_is_sidenav_enabled() && ( ! apply_filters( 'tc_sidenav_slide_mobile', wp_is_mobile() ) ) ) )
        return;

      $_script_suffix = ( defined('WP_DEBUG') && true === WP_DEBUG ) ? '' : '.min'; /* prod */

      wp_enqueue_style(
        'mc-front-style' ,
        sprintf('%1$s/front/assets/css/mc-front%2$s.css' , PC_MC_BASE_URL, $_script_suffix),
        null,
        PC_pro_bundle::$instance -> plug_version,
        $media = 'all'
      );
    }
} //end of class
