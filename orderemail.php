    <?php


//require 'vendor/autoload.php';
       
       // use Mailgun\Mailgun;
        
      
        $orderid=$_POST['orderid'];
        $timestamp=$_POST['timestamp']; 
        $emailid=$_POST['emailid']; 

      //  $link='https://gofootlounge.in/cart/'.$orderid;  
        $subject='View Your Order'; 
        $message="Dear Customer,<br/><br/>You've received a order details and here is the code to view your order<br/><br/><b>".$timestamp."</b><br/><br/> Thank you";    

	  /*  $mg = new Mailgun("key-2ac5fe6af0f22ee15e4d22ce8d7996f0"); 
        $domain = "sandboxf0a68cc146e8491da440bb50e4fe0267.mailgun.org";    
             
                if($mg->sendMessage($domain, array(
                                    'from'=>'order@footlounge.in',  
                                    'to'=>$emailid,     
				                    //'cc'=>'rajesh@tech-bee.com',	
                                    'subject' => $subject, 
                                    'html' => $message, 
                                     //'h:Reply-To' =>'info@gmail.com'    
                                        )
                                    ))  
            echo 1; 
                           else echo 0;  */ 
                            

 $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";  
    $headers .= 'From: order@footlounge.in'."\r\n".
           // 'Reply-To: '.$emailid."\r\n" .
            'X-Mailer: PHP/' . phpversion();

        // Sending email
if(mail($emailid, $subject, $message, $headers)){
    echo 1;
} else{ 
    echo 0; 
}   
 
?> 
