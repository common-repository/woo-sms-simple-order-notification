<?php
/**
* Plugin Name: Woocommerce SMS Simple Order Notification
* Plugin URI: http://getjuicy.co.uk/plugins/woocommerce-simple-order-notification
* Description: Simple order notification via SMS twilio client when a new order is placed. This is an add-on for woocommerce
* Version: 1.0 
* Author: getJuicy
* Author URI: http://getjuicy.co.uk
*/

//Don't call the file directly
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

//--REMOVED AS THE PLUGIN NOW USE THE WP OPTIONS TABLE -->
//Install tables on activation
/*register_activation_hook( __FILE__, 'simple_order_notification_table_install' );


//Creates the table in the DB to store settings
function simple_order_notification_table_install() {
	global $wpdb;

	$table_name = $wpdb->prefix . 'simple_order_notification';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id int(11) NOT NULL AUTO_INCREMENT,
		sid varchar(100) NOT NULL,
		authtoken varchar(100) NOT NULL,
		name varchar(100) NOT NULL,
		price int(11) NOT NULL,
		productlist int(11) NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

} */

//Call the action for when an order is completed 
add_action( 'woocommerce_thankyou', 'ltl_custom_woocommerce_complete_order_sms' );
//Function to run when an order is completed
function ltl_custom_woocommerce_complete_order_sms( $order_id ) {
		global $woocommerce;
        //DEFINE WP OPTIONS NAMES
            $twilio_sid = "smsTwilioSID";
            $twilio_auth = "smsTwilioauth";
            $twilio_name = "smsltltwilioname";
            //set show price variable for show price checkbox
            $showprice = "smsshowprice";
            $productlist = "smsproductlist";
            $yournumber = "smsyournumber";
            $twilionumber = "smstwilionumber";


	    if ( !$order_id )
	    return;
		$order = new WC_Order( $order_id );

		//Empty product list
        $product_list = '';
        //Get Order Items
        $order_item = $order->get_items();

        //Get the product name and Quantity for each item ordered
        foreach( $order_item as $product ) {
            $prodct_name[] = $product['name']."x".$product['qty'];
            
        }

        //Add items to the product list
        $product_list = implode( ',', $prodct_name );
        //Get the total order amount
        $order_amount = get_post_meta( $order_id, '_order_total', true );

         //get showprice option
         $showpriceoption = get_option($showprice);
        //get show product list option
        $showproductlistoption = get_option($productlist);

         if ($showpriceoption === '1'){
                $po = "Order amount is"." ".$order_amount.".";
            }
        if ($showproductlistoption === '1'){
                $pl = "Order items are"." ".$product_list.".";
            }


    
    // Include the twilio php library
    require "twilio-php-master/Services/Twilio.php";
 
    // Step 2: Include Account SID and Auth Token
    $AccountSid = get_option($twilio_sid);
    $AuthToken = get_option($twilio_auth);
 
    // Step 3: instantiate a new Twilio Rest Client
    $client = new Services_Twilio($AccountSid, $AuthToken);
 
   	//Add your name and number
   	 
     //get name
    $name = get_option($twilio_name);
    //get number
    $number = get_option($yournumber);
    //get twilio number
    $twilionum =  get_option($twilionumber);
   
   
 		//Send the message with the twilio Client
        $sms = $client->account->messages->sendMessage(
 
        // Add your twilio number
            $twilionum, 
 
            // Add your number
            $number,
            
           
            // What the order will say
            "Hey $name, there is a new order. $po $pl"
        );
 
        
    }

//Hook into admin menu and run the function to add a new page
add_action('admin_menu', 'ltl_simple_order_notification_admin_actions');    

//Include the admin php file
function ltl_simple_order_notification_admin() {
    include('simple_order_notification_admin.php');
}


//Here is where we add the menu page and the menu item entry. The first option ‘Simple Order Notification’ is the title of our options page. The second parameter ‘Simple Order Notification’ is the label for our admin panel. The third parameter determines which users can see the option by limiting access to certain users with certain capabilities. ‘Simple Order Notification’ is the slug which is used to identify the menu. The final parameter ‘simple_order_notification_admin’ is the name of the function we want to call when the option is selected, this allows us to add code to output HTML to our page. In this case we just include the admin php file
function ltl_simple_order_notification_admin_actions() {
	add_menu_page("Simple Order Notification Admin", "Simple Order Notification Admin",'administrator', "Simple-Order-Notification-Admin", "ltl_simple_order_notification_admin");

 
}
 




