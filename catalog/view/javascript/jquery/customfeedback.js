 $(document).ready(function() {
          
           $("#phoneno").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
            
        } );


	function feedback()//feedback form
	{
		$("#myModal").modal('show');
	}

	function feedbacksubmit()
	{
    var regex = /(<([^>]+)>)/ig;

		var comment=$("#comment").val().replace(/\\/g, '').trim().replace(regex, "");
		var emailid=$("#emailid").val().replace(/\\/g, '').trim().replace(regex, "");
		var productname=$("#productname").val().replace(/\\/g, '').trim().replace(regex, "");
		var phoneno=$("#phoneno").val().replace(/\\/g, '').trim().replace(regex, "");
    var username=$("#username").val().replace(/\\/g, '').trim().replace(regex, "");
     
    
    	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/igm;
		var flag=1;
		if(username==''){$("#username").css('border','1px solid #F00');flag=0;}
    else{$("#username").css('border','1px solid #ccc');}
		if(emailid==''){$("#emailid").css('border','1px solid #F00'); flag=0;}
		else{$("#emailid").css('border','1px solid #ccc');}
		if(emailid!='') { if (re.test(emailid) == false)  { $("#emailid_error").html('Invalid Mail Id');
         flag=0; } else { $("#emailid_error").html('');}}
        if(productname==''){$("#productname").css('border','1px solid #F00');flag=0;}
		else{$("#productname").css('border','1px solid #ccc');} 
    if(comment==''){$("#comment").css('border','1px solid #F00');flag=0;}
    else{$("#comment").css('border','1px solid #ccc');}
		if(flag==1){
        //url: 'index.php?route=common/home/emailus/',  
      $("#loadingspan").show();     

			 $.ajax({
              type: "POST",
             
              url: 'index.php?route=common/home/emailus/', 
              contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                headers: { Accept : "text/plain; charset=utf-8","Content-Type": "application/x-www-form-urlencoded; charset=UTF-8; charset=utf-8"},
              data:
              {username:username,
                comment:comment,
              	emailid:emailid,
              	productname:productname, 
              	phoneno:phoneno
               
              },
              success: function(resp){    
              //alert(resp);
                //resp=0; 
               if(resp==1)
                { 
                 
                 // alert('sadfsdfdsf');
                  $("#successcls1").addClass('label label-success');
                   $("#loadingspan").hide();  
                   $("#successcls1").html('Thank you for your Feedback. We will get back to you shortly!');
                  $("#successcls1").css('display','inline');    
                   $("#successcls1").css('margin-right','3px');    
                     $("#successcls1").css('padding','8px');    
                    setTimeout(function() { $("#myModal").modal('hide'); document.getElementById("feedbackform").reset(); $("#successcls1").css('display','none'); }, 4000);
                   // 
                 // $("#myModal").delay("slow").modal('hide');                // alert('Send Successfully!');
                    // document.getElementById("feedbackform").reset();
                   // $("#myModal").modal('hide');

                    //window.location.href=base_url+'index.php/Admin/ManageUser';
                }
                else
                {
                    $("#loadingspan").hide(); 
                  $("#successcls1").addClass('label label-danger');
                   $("#successcls1").html('Sending Failed');
                  $("#successcls1").css('display','inline');    
                   $("#successcls1").css('margin-right','3px');    
                     $("#successcls1").css('padding','8px');    
                  
                }
            }
                });

		}
		
	}
	
	function showcod()
  {
    $("#CODModal").modal('show');
  }

  function closecodmodal()//close cod model
  {
    $("#zipcode").css('border','1px solid #ccc'); 
     $("#CODModal").modal('hide'); 
  }

  function codstatus() //cash on delivery status
  {
    
    var zipcode=$("#zipcode").val();
    var flag=1;
    if(zipcode=='')
    {
      $("#zipcode").css('border','1px solid #F00');
      flag=0;

    }else{$("#zipcode").css('border','1px solid #ccc');
      }
      if(flag==1)
      {
        $.ajax({
              type: "POST",
             
              url: 'index.php?route=common/home/codstatus/', 
              data:
              {zipcode:zipcode,
                               
              },
              success: function(resp){    
              //alert(resp);
                //resp=0; 

              $("#dzipcode").html($("#zipcode").val());
              $("#dzipcode1").html($("#zipcode").val()); 
              $("#dzipcode2").html($("#zipcode").val()); 
              
                if(resp ==1)
                  {  $("#success_msg").show();
                              //alert('Mail Send Successfully');

                            setTimeout(function() { 
                          $('#CODModal').modal('hide');
                           $("#success_msg").hide();
                      }, 5000);
                      
                      $(".product-availability").html('<div id="codupdate"><span class="cds_style"> COD Available for Pincode '+zipcode+'</span> <input type="button" class="cds_style cds_style1" onclick="showcod();" value="EDIT"></div>');
                     
                  }
                  else if(resp==2)
                  {

                     $("#failure_msg").show();
                    setTimeout(function() { 
                         $('#CODModal').modal('hide');
                           $("#failure_msg").hide();
                      }, 5000); 
          
                   $(".product-availability").html('<div id="codupdate"><span class="cds_style"> Prepaid Delivery Only for Pincode '+zipcode+'</span> <input type="button" class="cds_style cds_style1" onclick="showcod();" value="EDIT"></div>'); 
                   } 

                   else
                   {

                     $("#failure_msg2").show();
                    setTimeout(function() { 
                         $('#CODModal').modal('hide');
                           $("#failure_msg2").hide();
                      }, 5000); 
          
                    $(".product-availability").html('<div id="codupdate"><span class="cds_style"> Invalid Pincode '+zipcode+'</span> <input type="button" class="cds_style cds_style1" onclick="showcod();" value="EDIT"></div>'); 
                  
                   }
               /*if(resp==1) 
                { 
                 
                 // alert('sadfsdfdsf');
                  $("#successcls1").addClass('label label-success');
                   $("#loadingspan").hide();  
                   $("#successcls1").html('Thank you for your Feedback. We will get back to you shortly!');
                  $("#successcls1").css('display','inline');    
                   $("#successcls1").css('margin-right','3px');    
                     $("#successcls1").css('padding','8px');    
                    setTimeout(function() { $("#myModal").modal('hide'); document.getElementById("feedbackform").reset(); $("#successcls1").css('display','none'); }, 4000);
                   // 
                 // $("#myModal").delay("slow").modal('hide');                // alert('Send Successfully!');
                    // document.getElementById("feedbackform").reset();
                   // $("#myModal").modal('hide');

                    //window.location.href=base_url+'index.php/Admin/ManageUser';
                }
                else
                {
                    $("#loadingspan").hide(); 
                  $("#successcls1").addClass('label label-danger');
                   $("#successcls1").html('Sending Failed');
                  $("#successcls1").css('display','inline');    
                   $("#successcls1").css('margin-right','3px');    
                     $("#successcls1").css('padding','8px');    
                  
                }*/
            }
                });

      }
  }
  