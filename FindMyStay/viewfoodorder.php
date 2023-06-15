<?php
include("header.php");
if(isset($_GET[delid]))
{
	$sql = "DELETE FROM food_order WHERE food_order_id='$_GET[delid]'";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('Food Order record deleted successfully...');</script>";
	}
}
?>
<!--start main -->
<div class="main_bg">
<div class="wrap">
	<div class="main">
		<div class="res_online">
			<h4>View Food Order</h4>
		</div>			
			<div class="span_of_2">
			
<?php
	$sql = "SELECT * FROM room_booking LEFT JOIN hotel ON room_booking.hotel_id=hotel.hotel_id LEFT JOIN room_type ON room_booking.room_typeid=room_type.room_typeid LEFT JOIN customer ON room_booking.customer_id=customer.customer_id LEFT JOIN payment ON payment.room_booking_id=room_booking.room_booking_id WHERE room_booking.status='Active' AND payment.spa_service_bookingid='0' AND payment.food_order_id='0' AND payment.cab_bookingid='0'";
	if(isset($_SESSION[customer_id]))
	{
	$sql = $sql . " AND room_booking.customer_id='$_SESSION[customer_id]'";
	}
	$sql = $sql . " ORDER BY room_booking.room_booking_id desc";
	$qsql = mysqli_query($con,$sql);
	while($rs = mysqli_fetch_array($qsql))
	{
?>		
	<table id="dataTables" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Room Booking</th>
				<th>Item</th>
				<th>Customer</th>
				<th>Item Cost</th>
				<th>Quantity</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$sql = "SELECT * FROM food_order LEFT JOIN room_booking ON food_order.room_booking_id=room_booking.room_booking_id LEFT JOIN item ON food_order.item_id=item.item_id LEFT JOIN customer ON food_order.customer_id=customer.customer_id";
		$qsql = mysqli_query($con,$sql);
		while($rs = mysqli_fetch_array($qsql))
		{
			echo "<tr>
				<td>$rs[room_booking_id]</td>
				<td>$rs[item_name]</td>
				<td>$rs[customer_name]</td>
				<td>$rs[item_cost]</td>
				<td>$rs[qty]</td>
				<td>$rs[status]</td>
				<td> <a href='foodorder.php?editid=$rs[food_order_id]'>Edit</a> | <a href='viewfoodorder.php?delid=$rs[food_order_id]' onclick='return confirmdelete()'>Delete</a></td>
			</tr>";
		}
		?>	
		</tbody>
	</table>
<?php
	}
?>
				
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