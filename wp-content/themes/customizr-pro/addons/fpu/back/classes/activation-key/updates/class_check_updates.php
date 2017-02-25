<?php
/**
* Check for plugin updates
* @author Nicolas GUILLAUME
* @since 1.0
*/
class TC_check_updates {
    static $instance;

    public $plug_name;
    public $plug_version;
    public $plug_prefix;
    public $plug_lang;
    public $plug_file;

    function __construct ( $args ) {

        self::$instance =& $this;

        //extract properties from args
        list( $this -> plug_name , $this -> plug_prefix , $this -> plug_version, $this -> plug_file  ) = $args;

        // this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
        if( ! defined( 'TC_PLUG_URL' ) ) { define( 'TC_PLUG_URL' , 'http://presscustomizr.com' ); }

        //loads the updater
        add_action( 'admin_init'                       , array( $this , 'tc_plug_update_check' ) );

    }//end of construct

    function tc_plug_update_check() {
        // retrieve our license key from the DB
        $license_key = trim( get_option( 'tc_' . $this->plug_prefix . '_license_key' ) );
        // setup the updater
        $edd_updater = new TC_plug_updater( TC_PLUG_URL, $this -> plug_file , array(
                'version'   => $this -> plug_version,               // current version number
                'license'   => $license_key,        // license key (used get_option above to retrieve from DB)
                'item_name' => $this -> plug_name,    // name of this plugin
                'author'    => 'Press Customizr'  // author of this plugin
            )
        );

    }

}//end of class