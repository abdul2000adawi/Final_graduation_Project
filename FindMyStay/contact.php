<?php
include("header.php");

if(isset($_POST[submit]))
{
	//message Subject mobno  $_POST[email]
	
	$msg= "<b>Subject:</b> $_POST[subject] <br>";
	$msg= $msg. "<b>Email ID:</b> $_POST[email] <br>";
	$msg= $msg."<b>Mobile No. : </b>$_POST[mobno] <br>";
	$msg= $msg."<b>Message: </b> $_POST[message] <br>";
	
	include("phpmailer.php");
	sendmail($_POST[name],'writetoiftrath@gmail.com', $_POST[subject], $msg);
}
?>

<!--start main -->
<div class="main_bg">
<div class="wrap">
	<div class="main">
		<div class="contact">				
				<div class="contact_left">
					<div class="contact_info">
			    	 	<h3>Find Us Here</h3>
      				</div>
      			<div class="company_address">
				     	<h3>Company Information :</h3>
						<p>FindMyStay,</p>
						<p>3rd floor, 3rd block,</p>
						<p>Mahaveera cross</p>
						<p>Bangalore</p>
				   		<p>Phone:99855665454</p>
				 	 	<p>Email: <a href="mailto:contact@findmystay.com">contact@findmystay.com</a></p>
				   </div>
				</div>				
				<div class="contact_right">
				  <div class="contact-form">
				  	<h3>Contact Us</h3>
<form method="post" action="">
	<div>
		<span><label>Name</label></span>
		<span><input name="name" type="text" class="form-control" required></span>
	</div>
	
	<div>
		<span><label>Email </label></span>
		<span><input name="email" type="text" class="form-control" required></span>
	</div>
		
	<div>
		<span><label>Mobile No. </label></span>
		<span><input name="mobno" type="text" class="form-control" required></span>
	</div>
	
	<div>
		<span><label>Subject</label></span>
		<span><input name="subject" type="text" class="form-control" required></span>
	</div>
   
	<div>
		<span><label>Message</label></span>
		<span>
		<textarea name="message" required ></textarea>
		</span>
	</div>
	
   <div>
		<span><input type="submit" name="submit" value="Contact us"></span>
  </div>
</form>
				    </div>
  				</div>		
  				<div class="clear"></div>		
		  </div>
	</div>
</div>
</div>		
<!--start main -->
<?php
include("footer.php");
?>