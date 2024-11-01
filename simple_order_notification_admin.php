<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$twilio_sid = "smsTwilioSID";
$twilio_auth = "smsTwilioauth";
$twilio_name = "smsltltwilioname";
//set show price variable for show price checkbox
$showprice = "smsshowprice";
$productlist = "smsproductlist";
$yournumber = "smsyournumber";
$twilionumber = "smstwilionumber";


//adding sanitization function
function prefix_sanitize_checkbox( $input, $expected_value=1 ) {
    if ( $expected_value == $input ) {
        return $expected_value;
    } else {
        return '0';
    }
}

 //if the form is submitted
if(isset($_POST["submit"])){ 

    if (!isset($_POST['sms_update_setting'])) die('<div id="message" class="updated fade"><p>Not allowed</p></div>');

    if (!wp_verify_nonce($_POST['sms_update_setting'],'sms-update-setting')) die( '<div id="message" class="updated fade"><p>Not allowed</p></div>');



    //GRAB ALL THE INPUTS//////////////////

    //Grab if twilio SID and sanitize
    $twilio_show = sanitize_text_field( $_POST[$twilio_sid] );

    //Grab the number, sanitize 
    $yournumber_show = sanitize_text_field($_POST[$yournumber]);

     //Grab the twilio number, sanitize 
    $twilionumber_show = sanitize_text_field($_POST[$twilionumber]);

    //Grab twilio AUTH and saitize
    $auth_show = sanitize_text_field($_POST[$twilio_auth]);
      //Grab name and sanitize
    $twilio_name_show = sanitize_text_field($_POST[$twilio_name]);
     //Grab the price option
    //$price_show =  isset($_POST[$showprice]);

    $productlist_show =  isset( $_POST[$productlist]);

    //$price_show = filter_var( $_POST[$showprice], FILTER_SANITIZE_NUMBER_INT );

    //Grad the product list
    //$productlist_show =  filter_var( $_POST[$productlist], FILTER_SANITIZE_NUMBER_INT );

  
    $price_show = !empty($_POST[$showprice]) ? prefix_sanitize_checkbox($_POST[$showprice], '1') : ''; // this will return the value only if the checkbox contains the value "submit_doors", otherwise, it will return empty string.

     $productlist_show = !empty($_POST[$productlist]) ? prefix_sanitize_checkbox($_POST[$productlist], '1') : '';

    ///////VALIDATE ALL INPUTS///////////////////////////
   
       //$price_show = isset($_POST[$showprice]) ? esc_html(trim(implode(",", $_POST[$showprice]))) : ''; // My Edit

   



    if($twilio_show =="") 
    {

    $errorMsg=  "error : You did not enter a SID.";
    
    } elseif (!ctype_alpha($twilio_name_show))
     
    {

    $twilio_name_show = "";
    $errorMsg=  "error : Letters only please in Name";

    } else 

    {
    


     
    update_option($twilio_sid, $twilio_show);
    update_option($twilio_name, $twilio_name_show);
    update_option($twilio_auth, $auth_show);
     //Add option in DB
    update_option($showprice, $price_show);
     //Add option in DB
    update_option($productlist, $productlist_show);
    //Add the option in the DB
    update_option($twilionumber, $twilionumber_show);

    //echo ($productlist_show);
     //Success message
    echo '<div id="message" class="updated fade"><p>Options Updated</p></div>';
}
}
else{
    //If post not submitted, echo out the current status
    $twilio_show = get_option($twilio_sid);
   // esc_attr( string $twilio_show );
    $auth_show = get_option($twilio_auth);
    $twilio_name_show = get_option($twilio_name);
    $price_show = get_option($showprice);
    $productlist_show =  get_option($productlist);
    $yournumber_show = get_option($yournumber);
    $twilionumber_show = get_option($twilionumber);


}
?>
<div class="wrap">
    <?php screen_icon(); ?>
    <h2>Welcome Simple SMS order notification page</h2>
    <br />
    <br />
   <?php if (isset($errorMsg)) { echo "<div id='message' class='updated fade'>" .$errorMsg. "</div>" ;} ?>
    <div class="">
        <fieldset>
            <legend>Twilio Settings</legend>
            <form method="post" action=""> 
             <input name="sms_update_setting" type="hidden" value="<?php echo wp_create_nonce('sms-update-setting'); ?>" />

             <table class="form-table" width="100%" cellpadding="10">
                <tbody>
                    <tr>
                        <td scope="row" align="left">

                            <label>Add your Twilio SID token</label>
                            <input type="text" name="<?php echo $twilio_sid; ?>" value="<?php echo esc_attr ($twilio_show) ?>" /></input>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row" align="left">

                            <label>Add your Twilio Auth Token</label>
                            <input type="text" name="<?php echo $twilio_auth; ?>" value="<?php echo esc_attr ($auth_show) ?>" /></input>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row" align="left">

                            <label>Add your name to the SMS</label>
                            <input type="text" name="<?php echo $twilio_name; ?>" value="<?php echo esc_attr($twilio_name_show) ?>" /></input>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row" align="left">

                            <label>Put your number in</label>
                            <input type="text" pattern=".{9,13}" name="<?php echo $yournumber; ?>" value="<?php echo esc_attr( $yournumber_show) ?>" /></input>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row" align="left">

                            <label>Enter your Twilio Number example +44203889997</label>
                            <input type="text" name="<?php echo $twilionumber; ?>" value="<?php echo esc_attr( $twilionumber_show )?>" /></input>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row" align="left">

                            <label>Do you want the total price on the SMS?</label>
                            <input type="checkbox" name="<?php echo $showprice; ?>" value="1"  
                            <?php echo $price_show?"checked='checked'":""; ?> />
                        </td>
                    </tr>
                    <tr>
                        <td scope="row" align="left">

                            <label>Do you want a product list show?</label>
                            <input type="checkbox" name="<?php echo $productlist; ?>" value="1" 
                            <?php echo $productlist_show?"checked='checked'":""; ?> />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" value="Save" class="button button-primary" name="submit" />
                        </br >

                    </td>
                </tr>
                <tr>
                    <td>
                        <h3>Please Double check all data saved</h3>
                    </td>
                </tr>
            </tbody>
        </table>                
    </form>
</fieldset>        
</div>  

<?php


?>


