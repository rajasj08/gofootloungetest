    <?php

 /*$username=$_POST['Nname'];
      $comment=$_POST['NComments'];
        $emailid=$_POST['Nemail'];
        $productname=$_POST['Nproductname'];
        $phoneno=$_POST['Nmobileno'];
        $to='rselakki@gmail.com'; */
       
        /* $subject='Product Enquiry';
        $message="Dear Admin,<br/><p>You have received an enquiry for the below product.</p><br/>Name:&nbsp; ".$username."<br/>Product:&nbsp; ".$productname."<br/>Phone Number: &nbsp; ".$phoneno."<br/>Comment:&nbsp; ".$comment."<br/>Email : &nbsp; ".$emailid."<br/><br/>Thank you."; 

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();  
        // More headers
        $headers .= 'From: <"order@footlounge.in">' . "\r\n";  

        if(mail($to,$subject,$message,$headers)) echo 1; else echo 0; */
  
  
require 'vendor/autoload.php';
       
        use Mailgun\Mailgun;
       
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
        



         $subject='Out of Stock Product Enquiry';
        $message="Dear Footlounge Admin,<br/><br/>You've received a Out of Stock product enquiry and here is the details.<br/>Product Name:&nbsp; ".$productname."<br/>Phone Number: &nbsp; ".$phoneno."<br/>Email ID: &nbsp; ".$emailid."<br/>Product Link: &nbsp; ".$prohref."<br/><br/> Thank you";

$domain1 = strstr($emailid, '@',true);
$changename= ucfirst($domain1);

            //$test=$this->load->model('vendor/autoload.php'); 

            //print_r($test); 
            
               $mg = new Mailgun("key-2ac5fe6af0f22ee15e4d22ce8d7996f0");
            $domain = "sandboxf0a68cc146e8491da440bb50e4fe0267.mailgun.org";
            
            $message1= htmlentities(file_get_contents("mailmessage.html"));   
             $str=str_replace('changeproductlink',$prohref,$message1);
             $strn=str_replace('changeproducthighlight',$prohightlight,$str);
              $strnn=str_replace('changeproductname',$proname,$strn);  
		$strnn1=str_replace('changecustomername',$changename,$strnn);   
	  
             $strnew=str_replace('changeproductimage',$proimage,$strnn1);
              $strnew1=str_replace('&lt;tr&gt;','<tr class="borbot borcolor" style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;border-bottom: 1px solid #ddd;background: #f9f9f9;">',$strnew);
              
             $strnew2=str_replace('&lt;th&gt;','<td class="padd" style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;padding: 9px;position: relative;left: -7px;">',$strnew1);
            $strnew3=str_replace('&lt;th&gt;','<td class="padd" style="font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;padding: 9px;position: relative;left: -7px;">',$strnew2);

             //$strnew1=str_replace('<table class="table table-hover table-striped">',$proimage,$strnew);
             $str1=html_entity_decode($strnew3);    
               

        if($emailid)
        {      
        $result = $mg->sendMessage($domain, array(  
        "from" => 'order@footlounge.in', 
        "to" =>  'rselakki@gmail.com',   
       // "to" =>  $emailid,   
         //"to" => 'rajesh@tech-bee.com',
         "subject" => 'Email Notification Request Received', 
         "html"    => $str1, 
         "h:Reply-To"  =>'order@footlounge.in'
         
        ));
        }    
           
            
                if($mg->sendMessage($domain, array(
                                    'from'=>$emailid,  
                                    'to'=> 'rselakki@gmail.com',
                                  // 'to'=> 'order@footlounge.in',  
				  // 'cc'=>'rajesh@tech-bee.com',	
                                    'subject' => $subject, 
                                    'html' => $message,
                                    'h:Reply-To' =>'info@gmail.com'   
                                        )
                                    ))
            echo 1; 
                           else echo 0;  
                           



?> 