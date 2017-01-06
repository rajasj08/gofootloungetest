<?php

// $username=$_POST['Nname'];
      //$comment=$_POST['NComments'];
        $emailid=$_POST['Nemail'];
        $productname=$_POST['Nproductname'];
        $phoneno=$_POST['Nmobileno'];
        $proname=$_POST['proname'];
        $prohref=$_POST['prohref'];
        $proimage=$_POST['proimage'];
        $prohightlight=$_POST['prohightlight'];
        $prodesc=$_POST['prodesc'];      
        $selectsize=trim($_POST['selectsize']);     


         $subject='Out of Stock Product Enquiry';
         $message="Dear Footlounge Admin,<br/><br/>You've received a Out of Stock product enquiry and here is the details.<br/>Product Name:&nbsp; ".$productname."";
       
        if($selectsize != '-1' && $selectsize != '0')
        {
       		
           $message.=" <br/>Required Product Size:&nbsp; ".$selectsize.""; 
        }
       
        $message.="<br/>Phone Number: &nbsp; ".$phoneno."<br/>Email ID: &nbsp; ".$emailid."<br/>Product Link: &nbsp; <a href='".$prohref."' target='_blank'>".$prohref."</a><br/><br/> Thank you";
        
$domain1 = strstr($emailid, '@',true);

	$changename= ucfirst($domain1);
	
        $message1= htmlentities(file_get_contents("mailmessage.html"));   
             $str=str_replace('changeproductlink',$prohref,$message1);
             $strn=str_replace('changeproducthighlight',$prohightlight,$str);
              $strnn=str_replace('changeproductname',$proname,$strn);  
		$strnn1=str_replace('changecustomername',$changename,$strnn);   
	  
             $strnew=str_replace('changeproductimage',$proimage,$strnn1);
              $strnew1=str_replace('&lt;tr&gt;','<tr class="borbot borcolor" style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;border-bottom: 1px solid #ddd;background: #f9f9f9;">',$strnew);
              
             $strnew2=str_replace('&lt;th&gt;','<td class="padd" style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;padding: 9px;position: relative;left: -7px;">',$strnew1);
            $strnew3=str_replace('&lt;th&gt;','<td class="padd" style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;padding: 9px;position: relative;left: -7px;">',$strnew2);
          
if($selectsize != '-1' && $selectsize != '0') {
            $selectoption='Required Product Size:&nbsp;'.$selectsize;
            $strnn4=str_replace('reqproductsize',$selectoption,$strnew3);  
        }
            else
                 $strnn4=str_replace('reqproductsize',' ',$strnew3); 
                 
              
 
// To send HTML mail, the Content-type header must be set
   $str1=html_entity_decode($strnn4);     

 

 

if($emailid) 
        { 
         $fromemailid='order@footlounge.in';

        	$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        	$headers .= 'From: '.$fromemailid."\r\n".
    		'Reply-To: '.$fromemailid."\r\n" .
    		'X-Mailer: PHP/' . phpversion(); 

        	// Create email headers
			
	   if( mail($emailid, 'Email Notification Request Received', $str1, $headers))
	      
	     {}

        }  
        $headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";  
	$headers .= 'From: '.$emailid."\r\n".
    		'Reply-To: '.$emailid."\r\n" .
    		'X-Mailer: PHP/' . phpversion();

        // Sending email
if(mail('order@footlounge.in', $subject, $message, $headers)){

    echo 1;
} else{  
    echo 0; 
}  

/******** Origional online

$to = 'rselakki@gmail.com';
$subject = 'Welcome';   
$from = 'info@mailinator.com';
 
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// Create email headers
$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
 
// Compose a simple HTML email message
$message = '<html><body>';
$message .= '<h1 style="color:#f40;">Hi Jane!</h1>';
$message .= '<p style="color:#080;font-size:18px;">Have a great day?</p>';
$message .= '</body></html>';
    
// Sending email
if(mail($to, $subject, $message, $headers)){
    echo 'Your mail has been sent successfully.';
} else{ 
    echo 'Unable to send email. Please try again.';
}
*******/
?>