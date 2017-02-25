<?php
/**
 * Plugin Name: Grid Customizr
 * Plugin URI: http://www.themesandco.com/extension/grid-customizer/
 * Description: Add beautiful effects to your blog post grid.
 * Version: 1.0.0
 * Author: ThemesandCo
 * Author URI: http://www.themesandco.com
 * License: GPLv2 or later
 */


/**
* Fires the plugin
* @package      GC
* @author Nicolas GUILLAUME - Rocco ALIBERTI
* @since 1.0
*/
if ( ! class_exists( 'TC_gc' ) ) :
class TC_gc {
    //Access any method or var of the class with classname::$instance -> var or method():
    static $instance;

    function __construct() {

        self::$instance =& $this;

        //USEFUL CONSTANTS
        if ( ! defined( 'TC_GC_DIR_NAME' ) ) { define( 'TC_GC_DIR_NAME' , basename( dirname( __FILE__ ) ) ); }
        if ( ! defined( 'TC_GC_BASE_URL' ) ) { define( 'TC_GC_BASE_URL' , sprintf('%s/%s', TC_PRO_BUNDLE_BASE_URL, TC_GC_DIR_NAME ) ); }

        $this -> load();
    }//end of construct

    private function load() {
      $plug_classes = array(
        'TC_utils_gc'              => array('/utils/classes/class_utils_gc.php'),
        'TC_back_gc'               => array('/back/classes/class_back_gc.php'),
        'TC_front_gc'              => array('/front/classes/class_front_gc.php')
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
          if ( $name !=  'TC_plug_updater' )
              new $name( $args );
      }
    }

} //end of class
endif;
