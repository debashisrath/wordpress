<?php
/**
 * Plugin Name: Footer Customizer
 * Plugin URI: http://presscustomizr.com/extension/footer-customizer
 * Description: Customize the footer credits of the Customizr WordPress theme.
 * Version: 1.0.3
 * Author: presscustomizr
 * Author URI: http://presscustomizr.com
 * License: GPL2+
 */

/**
* Fires the plugin
* @author Nicolas GUILLAUME
* @since 1.0
*/
if ( ! class_exists( 'TC_fc' ) ) :
class TC_fc {
      //Access any method or var of the class with classname::$instance -> var or method():
      static $instance;
      public $default_options;
      private $fc_fire_plugin_active_notice;
      public $plug_lang;

      function __construct () {
            self::$instance =& $this;
            $this -> plug_lang = PC_pro_bundle::$instance -> plug_lang;

            //USEFUL CONSTANTS
            if ( ! defined( 'TC_FC_DIR_NAME' ) ) { define( 'TC_FC_DIR_NAME' , basename( dirname( __FILE__ ) ) ); }
            if ( ! defined( 'TC_FC_BASE_URL' ) ) { define( 'TC_FC_BASE_URL' , sprintf('%s/%s', TC_PRO_BUNDLE_BASE_URL, TC_FC_DIR_NAME ) ); }

            //setup the plugin hooks : setup hook is different in plugin / addon context
            /*
            * Fired before most of the theme setup hooks
            * e.g. CZR_Utils::czr_fn_init_properties where tc_options_prefixes filter hook is fired
            * allowing us to let the Customizr theme manage this plugin options
            */
            add_action( 'after_setup_theme'                        , array( $this , 'fc_plugin_setup'), 5 );

            $this -> default_options = array(
              'fc_show_footer_credits'    => 1,
              'fc_copyright_text'         => sprintf( '&copy; %1$s', esc_attr( date( 'Y' ) ) ),
              'fc_site_name'              => esc_attr( get_bloginfo() ),
              'fc_site_link'              => esc_url( home_url() ),
              'fc_site_link_target'       => 0, // 0 = _self, 1 = _blank
              'fc_show_designer_credits'  => 1,
              'fc_credit_text'            => __( 'Designed by' , $this -> plug_lang ),
              'fc_designer_name'          => 'Press Customizr',
              'fc_designer_link'          => 'http://presscustomizr.com',
              'fc_designer_link_target'   => false, // 0 = _self, 1 = _blank
              'fc_show_wp_powered'        => 0,
            );
      }//end of construct



      function fc_plugin_setup() {
        //add option prefix to let fc options be handled by Customizr famework
        add_filter ( 'tc_options_prefixes'                  , array( $this ,  'fc_options_prefix') );
        //update section map, since 3.2.0
        add_filter ( 'tc_add_section_map'                   , array( $this ,  'fc_update_section_map'), 20 );
        //update setting_control_map
        add_filter ( 'tc_add_setting_control_map'           , array( $this ,  'fc_update_setting_control_map'), 200 );
        add_filter ( 'tc_credits_display'                   , array( $this ,  'fc_custom_credits') );

        //visibility elements
        foreach ( array( 'fc_wp_powered_class', 'fc_designer_class' ) as $filter )
          add_filter ( $filter,             array( $this , 'fc_set_elements_visibility' ), 10, 2 );

        //js assets for the customizer
        add_action ( 'customize_controls_enqueue_scripts'   , array( $this , 'fc_customize_controls_js_css' ), 100);
        add_action ( 'customize_preview_init'               , array( $this , 'fc_customize_preview_js' ));

        //plugins compatibility
        add_action( 'after_setup_theme'                     , array( $this , 'fc_plugins_compatibility'), 20 );
      }



      function fc_update_section_map( $sections ) {
        $_new_footer_section = array(
                        'footer_customizer_sec'          => array(
                                            'title'       =>  __( 'Footer credits' , 'customizr' ),
                                            'priority'    =>  20,
                                            'description' =>  __( 'Customize the footer credits' , 'customizr' ),
                                            'panel'       => 'tc-footer-panel'
                        ),
        );
        return array_merge($sections , $_new_footer_section);
      }



      function fc_custom_credits() {
        $_options = array();
        //get saved options and apply $_opt filter to them
        //this way we have two filters we can act on
        //a) tc_opt_{$_opt} to globally filter the options
        //b) $_opt to filter only the displayed option value ( used by q-translateX )
        foreach ( $this -> default_options as $_opt => $_default_value )
          $_options[$_opt] = apply_filters( $_opt, CZR_utils::$inst -> czr_fn_opt($_opt) );

        if ( 1 != $_options['fc_show_footer_credits'] )
          return '';

        //copyright
        $_html = sprintf('<span class="%1$s"><span class="fc-copyright-text">%2$s</span> <a class="fc-copyright-link" href="%3$s" title="%4$s" rel="bookmark" target="%5$s">%4$s</a></span>',
              implode( ' ', apply_filters('fc_copyright_block', array( 'fc-copyright' ) ) ),
              html_entity_decode( esc_attr( $_options['fc_copyright_text'] ) ),
              esc_url( $_options['fc_site_link'] ),
              esc_attr( $_options['fc_site_name'] ),
              0 == esc_attr( $_options['fc_site_link_target']) ? '_self' : '_blank'
        );
        //designer
        if ( 1 == $_options['fc_show_designer_credits'] || PC_pro_bundle::$instance -> is_customizing ) {
          $_html .= sprintf( '<span class="%1$s"> &middot; <span class="fc-credits-text">%2$s</span> <a class="fc-credits-link" href="%3$s" title="%4$s" target="%5$s">%4$s</a></span>',
                implode( ' ', apply_filters('fc_designer_class', array( 'fc-designer' ), $_options['fc_show_designer_credits'] ) ),
                html_entity_decode( esc_attr( $_options['fc_credit_text'] ) ),
                esc_url( $_options['fc_designer_link'] ),
                esc_attr( $_options['fc_designer_name'] ),
                0 == esc_attr( $_options['fc_designer_link_target']) ? '_self' : '_blank'
          );
        }
        //powered by wordpress
        if ( 1 == $_options['fc_show_wp_powered'] || PC_pro_bundle::$instance -> is_customizing ) {
          $_html .= sprintf( '<span class="%1$s"> &middot; <span class="fc-wp-powered-text">%2$s</span> <a class="fc-wp-powered-link icon-wordpress" href="%3$s" title="%4$s" target="_blank"></a></span>',
                implode( ' ', apply_filters('fc_wp_powered_class', array( 'fc-wp-powered' ), $_options['fc_show_wp_powered'] ) ),
                __( 'Powered by', 'customizr' ),
                'https://www.wordpress.org',
                __( 'Powered by WordPress', 'customizr' )
          );
        }

        return sprintf('<div class="%1$s"><p>&middot; %2$s &middot;</p></div>',
            implode( ' ', apply_filters( 'tc_colophon_center_block_class', array( 'span6', 'credits' ) ) ),
            $_html
        );
      }


      function fc_update_setting_control_map($_map) {
        $_new_settings = $this -> fc_get_setting_control_map();
        return array_merge($_map , $_new_settings );
      }


      function fc_get_setting_control_map() {
        $_defaults = $this -> default_options;
        $_settings = array(
          "fc_show_footer_credits" =>  array(
                    'default'       => isset( $_defaults['fc_show_footer_credits'] ) ? $_defaults['fc_show_footer_credits'] : false,
                    'control'       => 'CZR_controls' ,
                    'label'         => __( "Enable the footer copyrights and credits" , "customizr" ),
                    'section'       => 'footer_customizer_sec' ,
                    'type'          => 'checkbox',
                    'priority'      => 1
          ),
          "fc_copyright_text" =>  array(
                    'default'       => isset( $_defaults['fc_copyright_text'] ) ? $_defaults['fc_copyright_text'] : false,
                    'control'       => 'CZR_controls' ,
                    'label'         => __( "Copyright text" , "customizr" ),
                    'title'         => __( "Copyright"),
                    'section'       => 'footer_customizer_sec' ,
                    'type'          => 'text',
                    'priority'      => 5,
                    'transport'   =>  'postMessage',
          ),
          "fc_site_name" =>  array(
                    'default'       => isset( $_defaults['fc_site_name'] ) ? $_defaults['fc_site_name'] : false,
                    'control'       => 'CZR_controls' ,
                    'label'         => __( "Site name" , "customizr" ),
                    'section'       => 'footer_customizer_sec' ,
                    'type'          => 'text',
                    'priority'      => 10,
                    'transport'   =>  'postMessage',
          ),
          "fc_site_link" =>  array(
                    'default'       => isset( $_defaults['fc_site_link'] ) ? $_defaults['fc_site_link'] : false,
                    'control'       => 'CZR_controls' ,
                    'label'         => __( "Site link" , "customizr" ),
                    'section'       => 'footer_customizer_sec' ,
                    'type'          => 'url',
                    'priority'      => 20,
                    'transport'   =>  'postMessage',
          ),
          "fc_site_link_target" =>  array(
                    'default'       => isset( $_defaults['fc_site_link_target'] ) ? $_defaults['fc_site_link_target'] : false,
                    'control'       => 'CZR_controls' ,
                    'label'         => __( "Open in a new window/tab" , "customizr" ),
                    'section'       => 'footer_customizer_sec' ,
                    'type'          => 'checkbox',
                    'priority'      => 21,
                    'transport'   =>  'postMessage',
          ),
          "fc_show_designer_credits" =>  array(
                    'default'       => isset( $_defaults['fc_show_designer_credits'] ) ? $_defaults['fc_show_designer_credits'] : false,
                    'control'       => 'CZR_controls' ,
                    'label'         => __( "Display the designer's credits" , "customizr" ),
                    'title'         => __( "Credits"),
                    'section'       => 'footer_customizer_sec' ,
                    'type'          => 'checkbox',
                    'priority'      => 30,
                    'transport'   =>  'postMessage',
          ),
          "fc_credit_text" =>  array(
                    'default'       => isset( $_defaults['fc_credit_text'] ) ? $_defaults['fc_credit_text'] : false,
                    'control'       => 'CZR_controls' ,
                    'label'         => __( "Credit text" , "customizr" ),
                    'section'       => 'footer_customizer_sec' ,
                    'type'          => 'text',
                    'priority'      => 40,
                    'transport'   =>  'postMessage',
          ),
          "fc_designer_name" =>  array(
                    'default'       => isset( $_defaults['fc_designer_name'] ) ? $_defaults['fc_designer_name'] : false,
                    'control'       => 'CZR_controls' ,
                    'label'         => __( "Designer name" , "customizr" ),
                    'section'       => 'footer_customizer_sec' ,
                    'type'          => 'text',
                    'priority'      => 50,
                    'transport'   =>  'postMessage',
          ),
          "fc_designer_link" =>  array(
                    'default'       => isset( $_defaults['fc_designer_link'] ) ? $_defaults['fc_designer_link'] : false,
                    'control'       => 'CZR_controls' ,
                    'label'         => __( "Designer link" , "customizr" ),
                    'section'       => 'footer_customizer_sec' ,
                    'type'          => 'url',
                    'priority'      => 60,
                    'transport'   =>  'postMessage',
          ),
          "fc_designer_link_target" =>  array(
                    'default'       => isset( $_defaults['fc_designer_link_target'] ) ? $_defaults['fc_designer_link_target'] : false,
                    'control'       => 'CZR_controls' ,
                    'label'         => __( "Open in a new window/tab" , "customizr" ),
                    'section'       => 'footer_customizer_sec' ,
                    'type'          => 'checkbox',
                    'priority'      => 61,
                    'transport'   =>  'postMessage',
          ),
          "fc_show_wp_powered" =>  array(
                    'default'       => isset( $_defaults['fc_show_wp_powered'] ) ? $_defaults['fc_show_wp_powered'] : false,
                    'control'       => 'CZR_controls' ,
                    'title'         => __( "Powered by WordPress", "customizr" ),
                    'label'         => __( "Display 'Powered by WordPress'" , "customizr" ),
                    'section'       => 'footer_customizer_sec' ,
                    'type'          => 'checkbox',
                    'priority'      => 62,
                    'transport'   =>  'postMessage',
          ),
        );
        return $_settings;
      }

      /**
      * This function handles the following plugins compatibility : Qtranslate-X, Polylang
      *
      * @package FC
      *
      * @since FC 1.0.3
      */
      function fc_plugins_compatibility() {
        //we always can rely on CZR_plugins_compat since this addon will run only in Customizr/Customizr-Pro
        /*
        * QTranslatex
        */
        if ( current_theme_supports( 'qtranslate-x' ) && CZR_plugins_compat::$instance -> czr_fn_is_plugin_active('qtranslate-x/qtranslate.php') )
          $this -> fc_set_qtranslatex_compat();
        /*
        * Polylang
        */
        if ( current_theme_supports( 'polylang' ) && CZR_plugins_compat::$instance -> czr_fn_is_plugin_active('polylang/polylang.php') )
          $this -> fc_set_polylang_compat();
        /*
        * WPML
        */
        if ( current_theme_supports( 'wpml' ) && CZR_plugins_compat::$instance -> czr_fn_is_plugin_active('sitepress-multilingual-cms/sitepress.php') )
          $this -> fc_set_wpml_compat();
      }

      /**
      * QtranslateX compat hooks
      *
      * @package FC
      * @since FC 1.0.3
      */
      function fc_set_qtranslatex_compat() {
        function fc_apply_qtranslate ($text) {
          return call_user_func(  '__' , $text );
        }

        foreach ( array_keys( $this -> fc_get_translatable_settings() ) as $option ){
          add_filter( $option, 'fc_apply_qtranslate');
        }
      }// end Qtranslate-X

      /**
      * Polylang compat hooks
      *
      * @package FC
      * @since FC 1.0.3
      */
      function fc_set_polylang_compat() {
        add_filter( 'tc_get_string_options_to_translate', 'fc_pll_string_options_to_translate' );
        function fc_pll_string_options_to_translate( $string_options ) {
          return array_merge( $string_options, array_keys( TC_fc::$instance -> fc_get_translatable_settings() ) );
        }
      }

      /**
      * WPML compat hooks
      *
      * @package FC
      * @since FC 1.0.3
      */
      function fc_set_wpml_compat() {
        //add string options to translate to Customizr
        add_filter( 'tc_get_string_options_to_translate', 'fc_wpml_string_options_to_translate' );
        function fc_wpml_string_options_to_translate( $string_options ) {
          return array_merge( $string_options, array_keys( TC_fc::$instance -> fc_get_translatable_settings() ) );
        }
        //add wpml config to Customizr
        add_filter( 'tc_wpml_options_names_config', 'fc_wpml_options_names_config' );
        function fc_wpml_options_names_config( $string_options ) {
          return array_merge( $string_options, array(
            'fc_copyright_text' => 'Footer Copyright text',
            'fc_site_name'      => 'Footer Site name',
            'fc_site_link'      => 'Footer Site link',
            'fc_credit_text'    => 'Footer Credit text',
            'fc_designer_name'  => 'Footer Designer name',
            'fc_designer_link'  => 'Footer Designer link'
          ) );
        }
      }

      /*
      * Helper
      * returns an array of settings ( key => array(label, type) ) of the translatable options
      * we return the type too 'cause technically we might want to distinguish between normal text
      * and urls
      *
      * @return array
      */
      function fc_get_translatable_settings() {
        $settings = $this -> fc_get_setting_control_map();
        $translatable = array();
        foreach ( $settings as $key => $value ) {
          // add string just for text and url type fields
          if ( ! in_array( $value['type'], array('text', 'url') )  )
            continue;
          $translatable[$key]= array( 'label' => $value['label'], 'type' => $value['type'] );
        }
        return $translatable;
      }



      function fc_set_elements_visibility( $element_classes, $element_state ) {
        if ( PC_pro_bundle::$instance -> is_customizing && ! $element_state )
          $element_classes[] = 'hidden';

        return $element_classes;
      }


      /**
      *
      * Appends fc_ to the array of Customizr option prefixes
      *
      */
      function fc_options_prefix( $_prefixes ) {
        $_prefixes[] = 'fc_';
        return $_prefixes;
      }




      function fc_customize_preview_js() {
        wp_enqueue_script(
          'tc-fc-preview' ,
          sprintf('%1$s/back/assets/js/fc-customizer-preview.js' , TC_FC_BASE_URL ),
          array( 'customize-preview' ),
          PC_pro_bundle::$instance -> plug_version,
          true
        );
      }


      function fc_customize_controls_js_css() {
        wp_enqueue_script(
          'tc-fc-controls' ,
          sprintf('%1$s/back/assets/js/fc-customizer-control.js' , TC_FC_BASE_URL ),
          array( 'customize-controls' ),
          PC_pro_bundle::$instance -> plug_version,
          true
        );
      }

}//end of class
endif;
