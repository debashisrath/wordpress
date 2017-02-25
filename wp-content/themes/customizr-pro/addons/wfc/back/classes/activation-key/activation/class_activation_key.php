<?php
/**
* Manages activation keys in admin
* @author Nicolas GUILLAUME
* @since 1.0
*/
class TC_activation_key {
  static $instance;
  public $plug_name;
  public $plug_version;
  public $plug_prefix;
  protected $string;
  public $transients;

  function __construct ( $args ) {

        self::$instance =& $this;

        //extract properties from args
          list( $this -> plug_name , $this -> plug_prefix , $this -> plug_version  ) = $args;

         //this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
          if( ! defined( 'TC_PLUG_URL' ) ) {
              //adds the menu if no other plugins has already defined it
              add_action('admin_menu'                     , array( $this , 'tc_licenses_menu') );
              //adds the admin notices if no other plugins has already defined it
              add_action( 'admin_notices'                     , array( $this , 'edd_sample_admin_notices' ) );

              define( 'TC_PLUG_URL' , 'http://presscustomizr.com' );
          }

          //creates our settings in the options table
          add_action('admin_init'                         , array( $this ,'tc_plug_register_option') );
          add_action('admin_init'                         , array( $this ,'tc_plug_activate_license') );
          add_action('admin_init'                         , array( $this ,'tc_plug_desactivate_license') );



          //print the key form
          add_action('__license_page'           , array( $this , 'tc_plug_license_page_content' ) );

          $this -> strings = array(
              'enter-key' => __( 'Enter your Activation Key and press "Save Changes"', 'edd-theme-updater' ),
              'license-key' => __( 'Activation Key', 'edd-theme-updater' ),
              'license-action' => __( 'Key Action', 'edd-theme-updater' ),
              'deactivate-license' => __( 'Deactivate Key', 'edd-theme-updater' ),
              'activate-license' => __( 'Activate Key', 'edd-theme-updater' ),
              'status-unknown' => __( 'Key status is unknown.', 'edd-theme-updater' ),
              'renew' => __( 'Renew?', 'edd-theme-updater' ),
              'unlimited' => __( 'unlimited', 'edd-theme-updater' ),
              'license-key-is-valid' => __( 'Key is valid.', 'edd-theme-updater' ),
              'expires%s' => __( 'Expires %s.', 'edd-theme-updater' ),
              'expires-never'             => __( 'Lifetime Activation Key.', 'edd-theme-updater' ),
              '%1$s/%2$-sites' => __( 'You have %1$s / %2$s sites activated.', 'edd-theme-updater' ),
              'license-key-expired-%s' => __( 'Key expired %s.', 'edd-theme-updater' ),
              'license-key-expired' => __( 'Key has expired.', 'edd-theme-updater' ),
              'license-key-lifetime' => __( 'Lifetime duration.', 'edd-theme-updater' ),
              'license-keys-do-not-match' => __( 'Keys do not match.', 'edd-theme-updater' ),
              'license-is-inactive' => __( 'Activation key is inactive.', 'edd-theme-updater' ),
              'license-key-is-disabled' => __( 'Activation key is disabled.', 'edd-theme-updater' ),
              'site-is-inactive' => __( 'Site is inactive.', 'edd-theme-updater' ),
              'license-status-unknown' => __( 'Activation key status is unknown.', 'edd-theme-updater' ),
              'update-notice' => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'edd-theme-updater' ),
              'update-available' => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'edd-theme-updater' )
          );

          $this -> transients = array(
              'no-key-yet'        => $this->plug_prefix . '_no_key_yet',
              'dismiss-key-notice'=> $this->plug_prefix. '_dismiss_key_notice',
              'no-api-answer'     => $this->plug_prefix. '_no_api_answer',
              'upgrade-package'   => $this->plug_prefix. '_upgrade_package',
              'license-message'   => 'tc_' . $this->plug_prefix . '_license_message'
          );
    }//end of construct

    //hook : admin_menu
    //Fired only once if several plugins are activated
    function tc_licenses_menu() {
        add_plugins_page( 'Press Customizr keys', 'Press Customizr keys', 'manage_options', 'tc-licenses', array( $this , 'tc_plug_license_page' ) );
    }

    //cb of add_plugins_page
    function tc_plug_license_page() {
        ?>
        <div class="wrap">
            <?php
              //do_action( 'tc_before_key_form' );
              do_action( '__license_page' );
            ?>
        </div> <!-- .wrap -->
        <?php
    }



    //hook : __license_page
    function tc_plug_license_page_content() {
        $license    = get_option( 'tc_' . $this->plug_prefix . '_license_key' );
        $status     = get_option( 'tc_' . $this->plug_prefix . '_license_status' );
        $strings    = $this -> strings;
        $transients = $this -> transients;

        // Checks license status to display under license key
        if ( ! $license ) {
            //the message next to the activation key field
            $message    = $strings['enter-key'];
        } else {
            // delete_transient( $this->theme_slug . '_license_message' );
            if ( ! get_transient( $transients['license-message'], false ) ) {
              set_transient( $transients['license-message'], $this->tc_check_license( $license ), ( 60 * 60 * 24 ) );
            }
            $message = get_transient( $transients['license-message'] );
            //CHECK IF THE KEY IS ACTIVE : STATUS MUST BE VALID
            // if ( 'valid' != $status && ! get_transient( $transients['no-key-yet'] ) )
            //   set_transient(  $transients['no-key-yet'] , $this -> _create_no_key_message() , ( 60 * 60 * 24 ) );

            // if ( 'valid' == $status ) {
            //   //delete the $no_keytransient if any
            //   delete_transient( $transients['no-key-yet'] );
            // }
        }//end else
        ?>
        <form method="post" action="options.php">

            <?php wp_nonce_field( 'tc_plug_licenses_nonce', 'tc_plug_licenses_nonce' ); ?>

            <h2><?php printf( __('%1$s Key') , $this -> plug_name ) ; ?></h2>
            <?php settings_fields('tc_' . $this->plug_prefix . '_license'); ?>

            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row" valign="top">
                            <?php _e('Activation key'); ?>
                        </th>
                        <td>
                            <input id="tc_<?php echo $this->plug_prefix ?>_license_key" name="tc_<?php echo $this->plug_prefix ?>_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
                            <label class="description" for="tc_<?php echo $this->plug_prefix ?>_license_key"><?php echo $message; ?></label>
                        </td>
                    </tr>
                    <?php if( $license ) { ?>
                        <tr valign="top">
                            <th scope="row" valign="top">
                                <?php _e('Activate key'); ?>
                            </th>
                            <td>
                                <?php if( $status !== false && $status == 'valid' )  : ?>
                                    <span style="color:green;line-height: 27px;font-weight: bold;"><?php _e('active'); ?></span>
                                    <input type="submit" class="button-secondary" name="tc_<?php echo $this->plug_prefix ?>_license_desactivate" value="<?php _e('Deactivate Key'); ?>"/>
                                <?php else : ?>
                                    <input type="submit" class="button-secondary" name="tc_<?php echo $this->plug_prefix ?>_license_activate" value="<?php _e('Activate Key'); ?>"/>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php submit_button(); ?>
            </form>

        <?php
    }



    //hook : admin_init
    function tc_plug_register_option() {
        // creates our settings in the options table
        register_setting('tc_' . $this->plug_prefix . '_license', 'tc_' . $this->plug_prefix . '_license_key', array( $this , 'tc_sanitize_license' ) );
    }




    function tc_sanitize_license( $new ) {
        $old = get_option( 'tc_' . $this->plug_prefix . '_license_key' );
        if( $old && $old != $new ) {
            delete_option( 'tc_' . $this->plug_prefix . '_license_status' ); // new license has been entered, so must reactivate
        }
        return $new;
    }




    //hook : admin_init
    function tc_plug_activate_license() {

        // listen for our activate button to be clicked
        if( isset( $_POST['tc_' . $this->plug_prefix . '_license_activate'] ) ) {

            // run a quick security check
            if( ! check_admin_referer( 'tc_plug_licenses_nonce', 'tc_plug_licenses_nonce' ) )
                return; // get out if we didn't click the Activate button

            // retrieve the license from the database
            $license = trim( get_option( 'tc_' . $this->plug_prefix . '_license_key' ) );


            // data to send in our API request
            $api_params = array(
                'edd_action'=> 'activate_license',
                'license'   => $license,
                'item_name' => urlencode( $this -> plug_name ), // the name of our product in EDD
                'url'        => home_url()
            );

            // Call the custom API.
            $response = wp_remote_post( TC_PLUG_URL , array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

            // make sure the response came back okay
            if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
              $error_message = $response->get_error_message();
              $message =  ( is_wp_error( $response ) && ! empty( $error_message ) ) ? $error_message : __( 'An error occurred, please try again.' );

            } else {

              $license_data = json_decode( wp_remote_retrieve_body( $response ) );

              if ( false === $license_data->success ) {
                $message = $this -> tc_get_license_error_message( $license_data );
              }

            }


            //always delete the licence message transient
            $transients = $this -> transients;
            delete_transient( $transients['license-message'] );

            // Check if anything passed on a message constituting a failure
            if ( ! empty( $message ) ) {
                $base_url = admin_url( 'plugins.php?page=tc-licenses' );
                $redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );

                wp_redirect( $redirect );
                exit();
            }

            // $license_data->license will be either "active" or "inactive"

            update_option( 'tc_' . $this->plug_prefix . '_license_status', $license_data->license );

            // wp_redirect( admin_url( 'plugins.php?page=tc-licenses' );
            // exit();
        }
    }


    //@param $license_data = object
    //@return string message
    function tc_get_license_error_message( $license_data ) {
        switch( $license_data->error ) {

            case 'expired' :

              $message = sprintf(
                __( 'Your activation key expired on %s.' ),
                date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
              );
              break;

            case 'revoked' :

              $message = __( 'Your activation key has been disabled.' );
              break;

            case 'missing' :

              $message = __( 'Invalid activation key.' );
              break;

            case 'invalid' :
            case 'site_inactive' :

              $message = __( 'Your activation key is not active for this URL.' );
              break;

            case 'item_name_mismatch' :

              $message = sprintf( __( 'This appears to be an invalid activation key for %s.' ), $this -> plug_name );
              break;

            case 'no_activations_left':

              $message = sprintf( '%1$s <a href="http://docs.presscustomizr.com/search?query=upgrade+key" target="_blank">%2$s</a>', __( 'Your key has reached its activation limit.' ), __('Upgrade to unlock new activations.') );
              break;

            default :

              $message = __( 'An error occurred, please try again.' );
              break;
          }
        return $message;
    }




    //hook : admin_init
    function tc_plug_desactivate_license() {

        // listen for our activate button to be clicked
        if( isset( $_POST['tc_' . $this->plug_prefix . '_license_desactivate'] ) ) {

            // run a quick security check
            if( ! check_admin_referer( 'tc_plug_licenses_nonce', 'tc_plug_licenses_nonce' ) )
                return; // get out if we didn't click the Activate button

            // retrieve the license from the database
            $license = trim( get_option( 'tc_' . $this->plug_prefix . '_license_key' ) );


            // data to send in our API request
            $api_params = array(
                'edd_action'=> 'deactivate_license',
                'license'   => $license,
                'item_name' => urlencode( $this -> plug_name ), // the name of our product in EDD
                'url'        => home_url()
            );

            // Call the custom API.
            $response = wp_remote_post( TC_PLUG_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

            // make sure the response came back okay
            if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
              $error_message = $response->get_error_message();
              $message =  ( is_wp_error( $response ) && ! empty( $error_message ) ) ? $error_message : __( 'An error occurred, please try again.' );

              $base_url = admin_url( 'plugins.php?page=tc-licenses' );
              $redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );

              wp_redirect( $redirect );
              exit();
            }

            // decode the license data
            $license_data = json_decode( wp_remote_retrieve_body( $response ) );

            // $license_data->license will be either "deactivated" or "failed"
            if( $license_data->license == 'deactivated' )
                delete_option( 'tc_' . $this->plug_prefix . '_license_status' );

            //always delete the licence message transient
            $transients = $this -> transients;
            delete_transient( $transients['license-message'] );

        }
    }





    /**
     * Checks if license is valid and gets expire date.
     * Generates the message transient string
     * fired in tc_plug_license_page()
     *
     * @since 1.0.0
     *
     * @return string $message License status message.
     */
    function tc_check_license( $license ) {
      $strings = $this->strings;

      $api_params = array(
        'edd_action' => 'check_license',
        'license'    => $license,
        'item_name'  => urlencode( $this -> plug_name ),
        'url'        => home_url()
      );

      //NEW
      $response = wp_remote_post( TC_PLUG_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

      // make sure the response came back okay
      if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
          $error_message = $response->get_error_message();
          $message =  ( is_wp_error( $response ) && ! empty( $error_message ) ) ? $error_message : $strings['license-status-unknown'];

      } else {
          $license_data = json_decode( wp_remote_retrieve_body( $response ) );
          //Check if user has activated the key for the current website
          $current_site_activation_status     = get_option( 'tc_' . $this->plug_prefix . '_license_status' );

          // If response doesn't include license data, return
          if ( !isset( $license_data->license ) ) {
            $message = $strings['license-status-unknown'];
            return $message;
          }

          //We need to update the license status at the same time the message is updated
          if ( $license_data && isset( $license_data->license ) ) {
            update_option( 'tc_' . $this->theme_prefix . '_license_status', $license_data->license );
          }

          // Get expire date
          $expires = false;
          if ( isset( $license_data->expires ) && 'lifetime' != $license_data->expires ) {
              $expires = date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires ) );
              $renew_link = '<a href="http://presscustomizr.com/account" target="_blank">' . $strings['renew'] . '</a>';
          } elseif ( isset( $license_data->expires ) && 'lifetime' == $license_data->expires ) {
              $expires = 'lifetime';
          }

          // Get site counts
          $site_count = $license_data->site_count;
          $license_limit = $license_data->license_limit;

          // If unlimited
          if ( 0 == $license_limit ) {
            $license_limit = $strings['unlimited'];
          }

          //check if the server sent an error. Print the error.
          if ( false === $license_data->success ) {
              $message = $this -> tc_get_license_error_message( $license_data );
          } else if ( 0 === $license_data->activations_left && ( $current_site_activation_status === false || $current_site_activation_status  != 'valid' ) ) {
              $message = sprintf( '<span style="color:#f57717;line-height: 27px">%1$s <a style="color:#f57717;line-height: 27px;font-weight: bold;" href="http://docs.presscustomizr.com/search?query=upgrade+key" target="_blank">%2$s</a></span>', __( 'Your key has reached its activation limit.' ), __('Upgrade to unlock new activations.') );
          } else if ( $license_data->license == 'valid' ) {



              if( $current_site_activation_status === false || $current_site_activation_status  != 'valid' ) {
                  $message = sprintf( '<span style="color:#f57717;line-height: 27px;font-weight: bold;">%1$s </span>', __('Key is not activated for this website yet. Enter your key and press "Activate Key".') );
              } else {
                  $message = sprintf( '<span style="color:green;line-height: 27px;font-weight: bold;">%1$s </span>', __('Key is activated for this website.') );
                  $message .= $strings['license-key-is-valid'] . ' ';
                  if ( isset( $expires ) && 'lifetime' != $expires ) {
                    $message .= sprintf( $strings['expires%s'], $expires ) . ' ';
                  }
                  if ( isset( $expires ) && 'lifetime' == $expires ) {
                    $message .= $strings['expires-never'];
                  }
                  if ( $site_count && $license_limit ) {
                    $message .= ' ' . sprintf( $strings['%1$s/%2$-sites'], $site_count, $license_limit );
                  }
              }

          } else if ( $license_data->license == 'expired' ) {
              if ( $expires ) {
                $message = sprintf( $strings['license-key-expired-%s'], $expires );
              } else {
                $message = $strings['license-key-expired'];
              }
              if ( $renew_link ) {
                $message .= ' ' . $renew_link;
              }
          } else if ( $license_data->license == 'invalid' ) {
              $message = $strings['license-keys-do-not-match'];
          } else if ( $license_data->license == 'inactive' ) {
              $message = $strings['license-is-inactive'];
          } else if ( $license_data->license == 'disabled' ) {
              $message = $strings['license-key-is-disabled'];
          } else if ( $license_data->license == 'site_inactive' ) {
              // Site is inactive
              $message = $strings['site-is-inactive'];
          } else {
              $message = $strings['license-status-unknown'];
          }
      }
      return $message;
    }




    /**
     * This is a means of catching errors from the activation method above and displaying it to the customer
     */
    function edd_sample_admin_notices() {
      if ( isset( $_GET['sl_activation'] ) && ! empty( $_GET['message'] ) ) {

        switch( $_GET['sl_activation'] ) {

          case 'false':
            $message = urldecode( $_GET['message'] );
            ?>
            <div class="error">
              <p><?php echo $message; ?></p>
            </div>
            <?php
            break;

          case 'true':
          default:
            // Developers can put a custom success message here for when activation is successful if they way.
            break;

        }
      }
    }


}//end of class