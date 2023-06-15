<?php
include("header.php");
if(isset($_POST['submit']))
{
	
	$filename = rand().$_FILES["service_images"]["name"];
	move_uploaded_file($_FILES["service_images"]["tmp_name"],"imgspa/".$filename);
	$service_type = mysqli_real_escape_string($con,$_POST['service_type']);
	$service_description = mysqli_real_escape_string($con,$_POST['service_description']);
	//4. Update the record
	if(isset($_GET[editid]))
	{
		$sql = "UPDATE spa_service SET service_type='$service_type', gender='$_POST[gender]', service_description='$service_description'";
		if($_FILES["service_images"]["name"] != "")
		{
		$sql = $sql . ",service_images='$filename'";
		}
		$sql = $sql . ",service_cost='$_POST[service_cost]', status='$_POST[status]',hotel_id='$_POST[hotel_id]' WHERE spa_serviceid='$_GET[editid]'";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) ==1 )
		{
			echo "<SCRIPT>alert('Spa Service record updated successfully..');</SCRIPT>";
		}
	}
	else
	{
	$sql = "INSERT INTO spa_service(hotel_id,service_type,gender,service_description,service_images,service_cost,status) VALUES('$_POST[hotel_id]','$service_type','$_POST[gender]','$service_description','$filename','$_POST[service_cost]','$_POST[status]')";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	if(mysqli_affected_rows($con) ==1 )
	{
		echo "<SCRIPT>alert('Spa Service record inserted successfully..');</SCRIPT>";
	}
	}
}
//2. Update - select record starts here
if(isset($_GET[editid]))
{
	$sqledit= "SELECT * FROM spa_service WHERE spa_serviceid='$_GET[editid]'";
	$qsqledit = mysqli_query($con,$sqledit);
	$rsedit = mysqli_fetch_array($qsqledit);
}
//2. Update - select record ends here

?>

<!--start main -->
<div class="main_bg">
<div class="wrap">
	<div class="main">
		<div class="contact">
				<div class="contact_right">
				  <div class="contact-form">
				  	<h3>Spa Service</h3>
					    <form method="post" action="" onsubmit="return validateform()"  enctype="multipart/form-data">
						
						<div>
						    	<span><label>Hotel</label></span>
						    	<span>
	<select name="hotel_id" id="hotel_id" class="form-control">
		<option value="">Select</option>
		<?php
		//This program links primary key to foreign key
		//Select record from hotel
		$sqlhotel = "SELECT * FROM hotel WHERE status='Active'";
		$qsqlhotel = mysqli_query($con,$sqlhotel);
		while($rshotel = mysqli_fetch_array($qsqlhotel))
		{
			//if statement executes in the update statement
			if($rshotel[hotel_id] == $rsedit[hotel_id])
			{
				echo "<OPTION selected value='$rshotel[hotel_id]'>$rshotel[hotel_name]</option>";
			}
			//else statement executes in the else statement
			else
			{
				echo "<OPTION value='$rshotel[hotel_id]'>$rshotel[hotel_name]</option>";
			}
		}
		?>
	</select>
								</span>
						    </div>
						
					    	<div>
						    	<span><label>Service Type</label></span>
						    	<span><input name="service_type" id="service_type" type="text" class="form-control" value="<?php echo $rsedit[service_type]; ?>"></span>
						    </div>
							<div>
						    	<span><label>Gender</label></span>
						    	<span>
<select  name="gender" id="gender">
	<option value=''>Select gender</option>
	<?php
	$arr  = array("Male","Female");
	foreach($arr as $val)
	{
		if($val == $rsedit[gender])
		{
		echo "<option value='$val' selected>$val</option>";
		}
		else
		{
		echo "<option value='$val'>$val</option>";
		}
	}
	?>
</select>
								</span>
						    </div>
							<div> 
						     	<span><label>Service Description</label></span>
						    	<span><textarea name="service_description" id="service_description" class="form-control"><?php echo $rsedit[service_description]; ?></textarea></span>
						    </div>
							<div> 
						     	<span><label>Service Image</label></span>
						    	<span>
								<input type='file' name="service_images" id="service_images" class="form-control">
								</span>
<?php
if(isset($_GET['editid']))
{
	echo "<img src='imgspa/$rsedit[service_images]' style='width: 100px;height: 125px;'>";
}
?>								
						    </div>
							
							<div> 
						     	<span><label>Service Cost</label></span>
						    	<span><input name="service_cost" id="service_cost" type="text" class="form-control" value="<?php echo $rsedit[service_cost]; ?>"></span>
						    </div>
					     	<div>
						     	<span><label>Status</label></span>
						    	<span>
<select name="status" id="status" class="form-control">
	<option value="">Select</option>
	<?php
	$arr = array("Active","Inactive");
	foreach($arr as $val)
	{
		if($val == $rsedit[status])
		{
		echo "<option value='$val' selected>$val</option>";
		}
		else
		{
		echo "<option value='$val'>$val</option>";
		}
	}
	?>
</select>
								</span>
						    </div>
							
						   <div>
						   		<span><input type="submit" value="submit" name="submit" ></span>
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
<?php
if(isset($_GET[editid]))
{
?>
<script>
function validateform()
{
	var onlynumbers = /^[0-9]*$/;
	var onlycharacter = /^[a-zA-Z\s]*$/;
	var isDecimal = /^(\d+\.?\d{0,9}|\.\d{1,9})$/;
	
	if(document.getElementById("hotel_id").value == "")
	{
		alert("Kindly select the Hotel..");
		return false;
	}
	else if(document.getElementById("service_type").value == "")
	{
		alert("Kindly enter Service type..");
		return false;
	}
	else if(document.getElementById("gender").value == "")
	{
		alert("Kindly select the Gender..");
		return false;
	}
	else if(document.getElementById("service_description").value == "")
	{
		alert("Kindly enter Service Description..");
		return false;
	}
	else if(document.getElementById("service_cost").value == "")
	{
		alert("Service Cost should not be empty....");
		return false;
	}
	else if (!document.getElementById("service_cost").value.match(isDecimal))
	{
		alert("Kindly enter valid Cost..");
		return false;
	}
	
	else if(document.getElementById("status").value == "")
	{
		alert("Kindly select the status....");
		return false;
	}
	else
	{
		return true;
	}
}
</script>
<?php
}
else
{
?>
<script>
function validateform()
{
	var onlynumbers = /^[0-9]*$/;
	var onlycharacter = /^[a-zA-Z\s]*$/;
	var isDecimal = /^(\d+\.?\d{0,9}|\.\d{1,9})$/;
	
	if(document.getElementById("hotel_id").value == "")
	{
		alert("Kindly select the Hotel..");
		return false;
	}
	else if(document.getElementById("service_type").value == "")
	{
		alert("Kindly enter Service type..");
		return false;
	}
	else if(document.getElementById("gender").value == "")
	{
		alert("Kindly select the Gender..");
		return false;
	}
	else if(document.getElementById("service_description").value == "")
	{
		alert("Kindly enter Service Description..");
		return false;
	}
	else if(document.getElementById("service_images").value == "")
	{
		alert("Kindly select the Service Image..");
		return false;
	}
	else if(document.getElementById("service_cost").value == "")
	{
		alert("Service Cost should not be empty....");
		return false;
	}
	else if (!document.getElementById("service_cost").value.match(isDecimal))
	{
		alert("Kindly enter valid Cost..");
		return false;
	}
	
	else if(document.getElementById("status").value == "")
	{
		alert("Kindly select the status....");
		return false;
	}
	else
	{
		return true;
	}
}
</script>
<?php
}
?>