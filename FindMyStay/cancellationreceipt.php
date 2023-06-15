<?php
include("header.php");
$sqlhotelcancel = "SELECT * FROM payment WHERE status='Cancelled' AND payment_id='$_GET[paymentid]'";
$qsqlhotelcancel = mysqli_query($con,$sqlhotelcancel);
$rshotelcancel = mysqli_fetch_array($qsqlhotelcancel);

$totalamt = 0;
?>
<!--start main -->
<div class="main_bg">
<div class="wrap">
	<div class="main">
		<div class="res_online">
			<center><h4>Cancellation Receipt</h4></center>
		</div>
		
			<div class="span_of_2">			
<center><b style="font-size:25px;color:red;">Room Booking records</b></center>
<table  class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Bill No.</th>
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
			<th>Booked for</th>
			<th>Booking date</th>
			<th>Cost</th>
			<th>Cancellation charge</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql = "SELECT * FROM room_booking LEFT JOIN hotel ON room_booking.hotel_id=hotel.hotel_id LEFT JOIN room_type ON room_booking.room_typeid=room_type.room_typeid LEFT JOIN customer ON room_booking.customer_id=customer.customer_id LEFT JOIN payment ON payment.room_booking_id=room_booking.room_booking_id WHERE payment.status='Cancel' AND payment.spa_service_bookingid='0' AND payment.food_order_id='0' AND payment.cab_bookingid='0' AND payment.room_booking_id='$rshotelcancel[name]' ";
	if(isset($_SESSION[customer_id]))
	{
	$sql = $sql . " AND room_booking.customer_id='$_SESSION[customer_id]'";
	}
	$sql = $sql . " ORDER BY room_booking.room_booking_id desc";
	$qsql = mysqli_query($con,$sql);
	while($rs = mysqli_fetch_array($qsql))
	{
		$room_booking_id = $rs[room_booking_id];
		$sqlhotel_image = "SELECT * FROM hotel_image WHERE hotel_id='$rs[1]' AND room_typeid='0'";
		$qsqlhotel_image = mysqli_query($con,$sqlhotel_image);
		$rshotel_image = mysqli_fetch_array($qsqlhotel_image);		
		
		$checkin = date("d-M-Y",strtotime($rs[check_in]));
		$checkout = date("d-M-Y",strtotime($rs[check_out]));
		echo "<tr>
			<th>
			<center>
			<p style='color:red;font-size:25px;'>
			$rs[payment_id]</p>
			</center>
			</th>
			<td>$rs[hotel_image] $rs[hotel_name]</td>
			<td>$rs[room_type]<br>(₹$rs[cost] / day)</td>";
			if(!isset($_SESSION[customer_id]))
			{
		echo "<td>$rs[customer_name]</td>";
			}
		echo "<td>Adults : $rs[no_ofadults]<br>Children: $rs[no_ofchildren]</td>
			<td>
			CheckIn : $checkin<br>Checkout : $checkout <br><b style='color:green;'>";
$checkin = strtotime($rs[check_in]);
$checkout = strtotime($rs[check_out]);
$datediff = $checkout - $checkin;
$nodays = round($datediff / (60 * 60 * 24));
$nodays = $nodays +1;
if($nodays == 1 )
{
	echo $nodays . " Day"; 
}
else
{
	echo $nodays . " Days"; 
}
		echo "</b></td>
			<td>₹". $rs[cost]*$nodays . "</td>
			<td>₹";
			echo $rs[cost]*$nodays/2;
		echo "</td></tr>";
		$totalamt = $totalamt + ($rs[cost]*$nodays);
	}
	?>	
	</tbody>
</table>
			<hr>
			
			<?php
	$sql = "SELECT * FROM room_booking LEFT JOIN hotel ON room_booking.hotel_id=hotel.hotel_id LEFT JOIN room_type ON room_booking.room_typeid=room_type.room_typeid LEFT JOIN customer ON room_booking.customer_id=customer.customer_id LEFT JOIN payment ON payment.room_booking_id=room_booking.room_booking_id WHERE payment.status='Cancel' AND payment.spa_service_bookingid='0' AND payment.food_order_id='$room_booking_id' AND payment.cab_bookingid='0' ";
	if(isset($_SESSION[customer_id]))
	{
	$sql = $sql . " AND room_booking.customer_id='$_SESSION[customer_id]'";
	}
	$sql = $sql . " ORDER BY room_booking.room_booking_id desc";
	$qsql = mysqli_query($con,$sql);
	if(mysqli_num_rows($qsql) > 1)
	{
	?>

<center><b style="font-size:25px;color:red;">Food Order</b></center>
				
<table class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Bill No.</th>
			<th>Hotel</th>
			<?php
			if(!isset($_SESSION[customer_id]))
			{
			?>
			<th>Customer</th>
			<?php
			}
			?>
			<th>Food Order date</th>
			<th>No. of <br>Items ordered</th>
			<th>Cost</th>
			<th>Cancellation charge</th>
		</tr>
	</thead>
	<tbody>
	<?php

	while($rs = mysqli_fetch_array($qsql))
	{
		$sqlnoitem = "SELECT * FROM food_order WHERE payment_id='$rs[payment_id]'";
		$qsqlnoitem = mysqli_query($con,$sqlnoitem);
		
		$sqlhotel_image = "SELECT * FROM hotel_image WHERE hotel_id='$rs[1]' AND room_typeid='0'";
		$qsqlhotel_image = mysqli_query($con,$sqlhotel_image);
		$rshotel_image = mysqli_fetch_array($qsqlhotel_image);		
		
		if(mysqli_num_rows($qsqlhotel_image) == 0)
		{
			$imgname = "images/noimage.png";
		}
		else
		{
			if(file_exists("imghotel/$rshotel_image[hotel_image]"))
			{
				$imgname = "imghotel/$rshotel_image[hotel_image]";				
			}
			else
			{
				$imgname = "images/noimage.png";
			}
		}

		$checkin = date("d-M-Y",strtotime($rs[name]));
		$checkout = date("h:i A",strtotime($rs[mobileno]));
		echo "<tr>
			<th><p style='color:red;'>Bill No. $rs[payment_id]</p></th>
			<td>$rs[hotel_name]<br>$rs[room_type]</td>";
			if(!isset($_SESSION[customer_id]))
			{
		echo "<td>$rs[customer_name]</td>";
			}
		echo "
			<td>
			Date : $checkin<br>Time : $checkout <br>";
		echo "</td>
			<td>". mysqli_num_rows($qsqlnoitem) . "</td>
			<td>₹". $rs[total_amt] . "</td>
			<td>₹". $rs[total_amt]/2 . "</td>
		</tr>";
		$totalamt = $totalamt + $rs[total_amt];
	}
	?>	
	</tbody>
</table>
	<hr>
	<?php
	}
	?>
	
	
<?php
$sql = "SELECT * FROM cab_booking LEFT JOIN payment  ON payment.payment_id=cab_booking.payment_id LEFT JOIN room_booking ON payment.room_booking_id=room_booking.room_booking_id LEFT JOIN vehicle_type ON cab_booking.vehicle_typeid=vehicle_type.vehicle_typeid LEFT JOIN customer ON cab_booking.customer_id=customer.customer_id  ";
$sql = $sql . " WHERE cab_booking.cab_bookingid!='0' AND payment.room_booking_id='$room_booking_id' ";
if(isset($_SESSION[customer_id]))
{
$sql = $sql . " AND cab_booking.customer_id='$_SESSION[customer_id]'";
}
	$qsql = mysqli_query($con,$sql);
	if(mysqli_num_rows($qsql) > 1)
	{
	?>
	
	<center><b style="font-size:25px;color:red;">Cab Bookings</b></center>
	<table class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Bill No.</th>
			<th>Room Booking</th>
			<th>Customer</th>
			<th>Vehicle Type</th>
			<th>Booking Date & Time</th>
			<th>From Location</th>
			<th>To Location</th>
			<th>Cost/KM</th>
			<th>Total K.M</th>
			<th>Total Amount</th>
			<th>Cancellation charge</th>
		</tr>
	</thead>
	<tbody>
	<?php

	while($rs = mysqli_fetch_array($qsql))
	{
$sqlhotel = "select * from hotel WHERE hotel_id='$rs[hotel_id]'";
$qsqlhotel = mysqli_query($con,$sqlhotel);
$rshotel = mysqli_fetch_array($qsqlhotel);
		
$bookdttime = date("d-M-Y",strtotime($rs[booking_date])). " " . date("h:i A",strtotime($rs[booking_time]));
		echo "<tr>
			<td><p style='color:red;'>$rs[payment_id]</p></td>
			<td>$rshotel[hotel_name]</td>
			<td>$rs[customer_name]</td>
			<td>$rs[vehicle_type]</td>
			<td>$bookdttime</td>
			<td>$rs[flocation]</td>
			<td>$rs[tlocation]</td>
			<td>₹$rs[9]</td>
			<td>$rs[total_km]</td>
			<td>₹" . $rs[total_km] * $rs[9]  . "</td>
			<td>" . $rs[total_km] * $rs[9]/2 ."</td>
		</tr>";
		$totalamt = $totalamt + ($rs[total_km] * $rs[9]);
	}
	?>	
	</tbody>
</table>
<hr>
<?php
	}
?>

<?php
	$sql = "SELECT * FROM room_booking LEFT JOIN hotel ON room_booking.hotel_id=hotel.hotel_id LEFT JOIN room_type ON room_booking.room_typeid=room_type.room_typeid LEFT JOIN customer ON room_booking.customer_id=customer.customer_id LEFT JOIN payment ON payment.room_booking_id=room_booking.room_booking_id WHERE room_booking.status='Active' AND payment.spa_service_bookingid='$room_booking_id' AND payment.food_order_id='0' AND payment.cab_bookingid='0'";
	if(isset($_SESSION[customer_id]))
	{
	$sql = $sql . " AND room_booking.customer_id='$_SESSION[customer_id]'";
	}
	$sql = $sql . " ORDER BY room_booking.room_booking_id desc";
	$qsql = mysqli_query($con,$sql);
	if(mysqli_num_rows($qsql) > 1)
	{
?>
	<center><b style="font-size:25px;color:red;">Spa Service</b></center>
<table class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Bill No.</th>
			<th>Hotel</th>
			<?php
			if(!isset($_SESSION[customer_id]))
			{
			?>
			<th>Customer</th>
			<?php
			}
			?>
			<th>Booked on</th>
			<th>No. of <br>services booked </th>
			<th>Cost</th>
			<th>Cancellation charge</th>
		</tr>
	</thead>
	<tbody>
	<?php

	while($rs = mysqli_fetch_array($qsql))
	{
		$sqlnoitem = "SELECT * FROM spa_service_booking WHERE payment_id='$rs[payment_id]'";
		$qsqlnoitem = mysqli_query($con,$sqlnoitem);

		$checkin = date("d-M-Y",strtotime($rs[name]));
		$checkout = date("h:i A",strtotime($rs[mobileno]));
		echo "<tr>
			<th><p style='color:red;'>Bill No. $rs[payment_id]</p></th>
			<td>$rs[hotel_name]<br><span style='color:red;'>$rs[room_type]</span></td>";
			if(!isset($_SESSION[customer_id]))
			{
		echo "<td>$rs[customer_name]</td>";
			}
		echo "
			<td>". $rs[payment_date] . "</td><td>". mysqli_num_rows($qsqlnoitem) . "</td>
			<td>₹". $rs[total_amt] . "</td>
			<td>₹". $rs[total_amt]/2 . "</td>
		</tr>";
		$totalamt = $totalamt + $rs[total_amt];
	}
	?>	
	</tbody>
</table>
<?php
	}
?>	
			<hr>
<input type="hidden" name="room_booking_id" id="room_booking_id" value="<?php echo $room_booking_id; ?>">
<input type="hidden" name="totalamt" id="totalamt" value="<?php echo $totalamt; ?>">
	<center><b style="font-size:25px;color:red;">Cancellation details</b></center>
<table class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
		<th>Total Amount</th>
		<td>₹<?php echo $totalamt; ?></td>
		</tr>
		<tr>
		<th>Total cancellation charge(50%)</th>
		<td>₹<?php echo $totalamt/2; ?></td>
		</tr>
		<tr>
		<th>Refundable amount</th>
		<td>₹<?php echo $totalamt/2; ?></td>
		</tr>
		<tr>
				<th colspan="2" style='color:red;'>Accout detail... </th>
			</tr>
			
			<tr>
				<th style="width:25%;">Payment Type</th>
				<th style="width:75%;"><?php echo $rshotelcancel[payment_type]; ?></th>
			</tr>
			
			<tr>
				<th style="width:25%;">Card holder</th>
				<th style="width:75%;"><?php echo $rshotelcancel[card_holder]; ?></th>
			</tr>			
			 
			<tr>
				<th style="width:25%;">Card No</th>
				<th style="width:75%;"><?php echo $rshotelcancel[card_no]; ?></th>
			</tr>
			
			
		
	</thead>
</table>
			
			
				
				<div class="clear"></div>
			</div>
	
	
	
	
	</div>
</div>
</div>		
<!--start main -->
<?php
include("datatable.php");
include("footer.php");
?>
