<?php
/**
* Defines filters and actions used in several templates/classes
*
*
* @package      Pro Slider
* @subpackage   classes
* @since        3.0
* @author       Nicolas GUILLAUME <nicolas@presscustomizr.com>, Rocco ALIBERTI <rocco@presscustomizr.com>
* @copyright    Copyright (c) 2015, Nicolas GUILLAUME - Rocco ALIBERTI
* @link         http://presscustomizr.com
* @license      http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/
if ( ! class_exists( 'TC_utils_pro_slider' ) ) :
  class TC_utils_pro_slider {
    //Access any method or var of the class with classname::$instance -> var or method():
    static $instance;
    public $plug_lang;
    public $addon_opt_prefix;

    function __construct () {
      self::$instance =& $this;

      $this -> plug_lang          = PC_pro_bundle::$instance -> plug_lang;
      $this -> addon_opt_prefix   = PC_pro_bundle::$instance -> addon_opt_prefix;//=>tc_theme_options since only used as an addon for now

      //add new settings
      add_filter ( 'czr_fn_front_page_option_map'  , array( $this ,  'tc_pro_slider_update_setting_control_map'), 50 );
      //allow array type settings
      add_filter( 'tc_get_ctx_excluded_options', array( $this,   'tc_pro_slider_allow_array_settings') );
    }


    /**
    * Defines sections, settings and function of customizer and return and array
    * hook : tc_add_setting_control_map
    */
    function tc_pro_slider_update_setting_control_map( $_map ) {
      $addon_opt_prefix     = $this -> addon_opt_prefix;
      $_new_settings = array(
        //page for posts
        'tc_posts_slider_restrict_by_cat'  => array(
                'default'     => array(),
                'label'       =>  __( 'Apply a category filter to your posts slider' , 'customizr'  ),
                'section'     => 'frontpage_sec',
                'control'     => 'CZR_Customize_Multipicker_Categories_Control',
                'type'        => 'czr_multiple_picker',
                'priority'    => 23,
                'notice'      => sprintf( '%1$s <a href="%2$s" target="_blank">%3$s<span style="font-size: 17px;" class="dashicons dashicons-external"></span></a>' ,
                                __( "Click inside the above field and pick post categories you want to display. No filter will be applied if empty.", 'customizr'),
                                esc_url('codex.wordpress.org/Posts_Categories_SubPanel'),
                                __('Learn more about post categories in WordPress' , 'customizr')
                              )
        )
      );
      return array_merge($_map , $_new_settings );
    }


    function tc_pro_slider_allow_array_settings( $settings ) {
      $settings[] = 'tc_posts_slider_restrict_by_cat';
      return $settings;
    }
  }//end of class
endif;
