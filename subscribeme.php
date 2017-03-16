<?php

header('Access-Control-Allow-Origin: *');

/*$api_key = "eaf7754f78c23497fc4f6e6e85883ab9-us13" e5e81bb20cd318481c47f3287bbed7ac-us12;
$list_id = "45f0df28e2"; 8a1b232ca9.*/
/*
$api_key = "27e7dd598991864130d3e89adabd977c-us15";
$list_id = "a0c96a3796";
*/

$api_key = "e5e81bb20cd318481c47f3287bbed7ac-us12";
$list_id = "8a1b232ca9"; 

require 'Mailchimp.php'; 
   
$Mailchimp = new Mailchimp( $api_key );
$Mailchimp_Lists = new Mailchimp_Lists( $Mailchimp );
 try{
$subscriber = $Mailchimp_Lists->subscribe( $list_id, array( 'email' => htmlentities($_POST['Nemail']) ) ); 

} 
catch (Exception $e) 
{ 
	
   echo 2;
}  


if ( ! empty( $subscriber['leid'] ) ) {
   echo 1;
} 

?>       