<?php
include("header.php");
?>
<!--start main -->
<div class="main_bg">
<div class="wrap">
	<div class="main">
		<div class="res_online">
			<h4>SPA AND SERVICE BOOKING REPORT</h4>
		</div>			
			<div class="span_of_2">
				
<table id="dataTables" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql = "SELECT * FROM room_booking LEFT JOIN hotel ON room_booking.hotel_id=hotel.hotel_id LEFT JOIN room_type ON room_booking.room_typeid=room_type.room_typeid LEFT JOIN customer ON room_booking.customer_id=customer.customer_id LEFT JOIN payment ON payment.room_booking_id=room_booking.room_booking_id WHERE room_booking.status='Active' AND payment.spa_service_bookingid!='0' AND payment.food_order_id='0' AND payment.cab_bookingid='0'";
	if(isset($_SESSION[customer_id]))
	{
	$sql = $sql . " AND room_booking.customer_id='$_SESSION[customer_id]'";
	}
	$sql = $sql . " ORDER BY room_booking.room_booking_id desc";
	$qsql = mysqli_query($con,$sql);
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
			<td><a href='spaservicereceipt.php?paymentid=$rs[payment_id]'>Receipt</a></td>
		</tr>";
	}
	?>	
	</tbody>
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
<script>
function confirmdelete()
{
	if(confirm("Are you sure you want to delete this record??") == true)
	{
		return true;
	}
	else
	{
		return false;
	}
}
</script>