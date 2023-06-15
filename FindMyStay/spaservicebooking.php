<?php
include("header.php");
$sql = "DELETE FROM spa_service_booking WHERE status='Pending'";
$qsql = mysqli_query($con,$sql);
echo mysqli_error($con);
?>

<div class="col-md-12">

<center><h3 style="font-size:35px;">Spa Service Booking</h3></center>

<table class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Hotel</th>
			<th>Room Type</th>
			<?php
			if(!isset($_SESSION[customer_id]))
			{
			?>
			<th>Customer</th>
			<?php
			}
			?>
			<th>Adult</th>
			<th>Children</th>
			<th>Check-in date</th>
			<th>Check-out date</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql = "SELECT * FROM room_booking LEFT JOIN hotel ON room_booking.hotel_id=hotel.hotel_id LEFT JOIN room_type ON room_booking.room_typeid=room_type.room_typeid LEFT JOIN customer ON room_booking.customer_id=customer.customer_id LEFT JOIN payment ON payment.room_booking_id=room_booking.room_booking_id WHERE room_booking.status='Active' AND payment.payment_id='$_GET[paymentid]'";
	$qsql = mysqli_query($con,$sql);
	while($rs = mysqli_fetch_array($qsql))
	{
		$room_booking_id = $rs[room_booking_id];
		$hotelid=  $rs[hotel_id];
		$_GET[hotel_id] = $hotelid;
		echo "<input type='hidden' name='room_booking_id' value='$rs[room_booking_id]' >";
		$checkin = date("d-M-Y",strtotime($rs[check_in]));
		$checkout = date("d-M-Y",strtotime($rs[check_out]));
		$checkindt = date("Y-m-d",strtotime($rs[check_in]));
		$checkoutdt = date("Y-m-d",strtotime($rs[check_out]));
		echo "<tr>
			<td>$rs[hotel_name]</td>
			<td>$rs[room_type]</td>";
			if(!isset($_SESSION[customer_id]))
			{
		echo "<td>$rs[customer_name]</td>";
			}
		echo "<td>$rs[no_ofadults]</td>
			<td>$rs[no_ofchildren]</td>
			<td>$checkin</td>
			<td>$checkout</td>
		</tr>";
	}
	?>	
	</tbody>
</table>
<hr>
<form method="post" action="spaservicepayment.php" >
<input type="hidden" name="paymentid" id="paymentid" value="<?php echo $_GET[paymentid]; ?>" >
<input type="hidden" name="room_booking_id" id="room_booking_id" value="<?php echo $room_booking_id; ?>" >
<input type="hidden" name="checkindt" id="checkindt" value="<?php echo $checkindt; ?>" >
<input type="hidden" name="checkoutdt" id="checkoutdt" value="<?php echo $checkoutdt; ?>" >

	<div class="col-md-8">
	
		<div class="col-md-6">
			Select Gender
			<select name="gender" id="gender" class="form-control">
				<option value=''>All</option>
				<?php
					$arr = array("Male","Female");
					foreach($arr as $val)
					{
						echo "<option value='$val'>$val</option>";
					}
				?>
			</select>
		</div>
		<div class="col-md-6">
		<br>
			<input type="button" name="button" class="form-control" value="select"  onclick="loadspaservice(gender.value,'<?php echo $hotelid; ?>')">
		</div>
		<div class="col-md-12" id="divspaservice">
<?php
include("ajaxspaservice.php");
?>
		</div>
	</div>

	<div class="col-md-4" id="divload">
			
	</div>

</div>

</form>

<!--start main -->
<div class="main_bg">
<div class="wrap">
	<div class="main">
		<div class="contact">								
				<div class="contact_right">
				 
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
function loadspaservice(gender,hotelid)
{
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("divspaservice").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET","ajaxspaservice.php?gender="+gender+"&hotel_id="+hotelid,true);
	xmlhttp.send();
}
function insertspaservice(spaid,cost)
{
	//checkindt checkoutdt
	var checkin = document.getElementById("checkindt").value;
	var checkout = document.getElementById("checkoutdt").value;
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("divload").innerHTML = this.responseText;
		}
	}; 
	xmlhttp.open("GET","ajaxspaservicebooking.php?spaid="+spaid+"&cost="+cost+"&submit=submit&checkin="+checkin+"&checkout="+checkout,true);
	xmlhttp.send();
}
function deletespaservice(spa_sevice_bookingid)
{
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("divload").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET","ajaxspaservicebooking.php?spa_sevice_bookingid="+spa_sevice_bookingid+"&delete=delete",true);
	xmlhttp.send();
}
</script>