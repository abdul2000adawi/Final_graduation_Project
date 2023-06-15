<?php
include("header.php");
if(isset($_POST[submit]))
{
	//4. Update the record
	if(isset($_GET[editid]))
	{
		$sql = "UPDATE food_order SET room_booking_id='$_POST[room_booking_id]', item_id='$_POST[item_id]', customer_id='$_POST[customer_id]',item_cost='$_POST[item_cost]',qty='$_POST[qty]',status='$_POST[status]' WHERE food_order_id='$_GET[editid]'";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) ==1 )
		{
			echo "<SCRIPT>alert('Food Order record updated successfully..');</SCRIPT>";
		}
	}
	else
	{
	$sql = "INSERT INTO food_order(room_booking_id,item_id,customer_id,item_cost,qty,status) VALUES('$_POST[room_booking_id]','$_POST[item_id]','$_POST[customer_id]','$_POST[item_cost]','$_POST[qty]','$_POST[status]')";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	if(mysqli_affected_rows($con) ==1 )
	{
		echo "<SCRIPT>alert('Food Order record inserted successfully..');</SCRIPT>";
	}
	}
}
//2. Update - select record starts here
if(isset($_GET[editid]))
{
	$sqledit= "SELECT * FROM food_order WHERE food_order_id='$_GET[editid]'";
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
<?php
include("leftsidebar.php");
?>				
				<div class="contact_right">
				  <div class="contact-form">
				  	<h3>Food Order</h3>
					    <form method="post" action="" onsubmit="return validateform()">
					    	<div>
						    	<span><label>Room Booking</label></span>
						    	<span><select name="room_booking_id" id="room_booking_id" class="form-control">
								<option value="">Select</option>
								<?php
	//This program links primary key to foreign key
	//Select record from room_booking
	$sqlroombooking = "SELECT * FROM room_booking WHERE status='Active'";
	$qsqlroombooking = mysqli_query($con,$sqlroombooking);
	while($rsroombooking = mysqli_fetch_array($qsqlroombooking))
	{
		//if statement executes in the update statement
		if($rsroombooking[room_booking_id] == $rsedit[room_booking_id])
		{
			echo "<OPTION selected value='$rsroombooking[room_booking_id]'>$rsroombooking[room_booking_id]</option>";
		}
		//else statement executes in the else statement
		else
		{
			echo "<OPTION value='$rsroombooking[room_booking_id]'>$rsroombooking[room_booking_id]</option>";
		}
	}
	?>
								</select></span>
						    </div>
							<div>
						    	<span><label>Item</label></span>
						    	<span><select name="item_id" id="item_id" class="form-control">
								<option value="">Select</option>
								<?php
	//This program links primary key to foreign key
	//Select record from item
	$sqlitem = "SELECT * FROM item WHERE status='Active'";
	$qsqlitem= mysqli_query($con,$sqlitem);
	while($rsitem = mysqli_fetch_array($qsqlitem))
	{
		//if statement executes in the update statement
		if($rsitem[item_id] == $rsedit[item_id])
		{
			echo "<OPTION selected value='$rsitem[item_id]'>$rsitem[item_name]</option>";
		}
		//else statement executes in the else statement
		else
		{
			echo "<OPTION value='$rsitem[item_id]'>$rsitem[item_name]</option>";
		}
	}
	?>
								</select></span>
						    </div>
							<div>
						    	<span><label>Customer</label></span>
						    	<span><select name="customer_id" id="customer_id" class="form-control">
								<option value="">Select</option>
								<?php
	//This program links primary key to foreign key
	//Select record from customer
	$sqlcustomer = "SELECT * FROM customer WHERE status='Active'";
	$qsqlcustomer = mysqli_query($con,$sqlcustomer);
	while($rscustomer = mysqli_fetch_array($qsqlcustomer))
	{
		//if statement executes in the update statement
		if($rscustomer[customer_id] == $rsedit[customer_id])
		{
			echo "<OPTION selected value='$rscustomer[customer_id]'>$rscustomer[customer_name]</option>";
		}
		//else statement executes in the else statement
		else
		{
			echo "<OPTION value='$rscustomer[customer_id]'>$rscustomer[customer_name]</option>";
		}
	}
	?>
								</select></span>
						    </div>
						    <div>
						    	<span><label>Item Cost</label></span>
						    	<span><input name="item_cost" id="item_cost" type="text" class="form-control" value="<?php echo $rsedit[item_cost]; ?>"></span>
						    </div>
						    <div>
						     	<span><label>Quantity</label></span>
						    	<span><input name="qty" id="qty" type="text" class="form-control" value="<?php echo $rsedit[qty]; ?>"></span>
						    </div>
						    <div>
						     	<span><label>Status</label></span>
						    	<span>
								<select name="status" id="status" class="form-control">
								<option value="">Select</option>
								<option value="Active">Active</option>
								<option value="Inactive">Inactive</option>
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
<script>
function validateform()
{
	if(document.getElementById("room_booking_id").value == "")
	{
		alert("Kindly select the Room Booking Id..");
		return false;
	}
	else if(document.getElementById("item_id").value == "")
	{
		alert("Kindly select the Item Name..");
		return false;
	}
	else if(document.getElementById("customer_id").value == "")
	{
		alert("Kindly enter customer Name..");
		return false;
	}
	else if(document.getElementById("item_cost").value == "")
	{
		alert("Item Cost should not be empty..");
		return false;
	}
	else if(document.getElementById("qty").value == "")
	{
		alert("Kindly enter the Item Quantity....");
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