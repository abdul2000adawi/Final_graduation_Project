<?php
include("header.php");
$sqlpayment = "SELECT * FROM payment LEFT JOIN customer ON payment.customer_id=customer.customer_id LEFT JOIN room_booking ON room_booking.room_booking_id = payment.room_booking_id  WHERE payment_id='$_GET[paymentid]'";
$qsqlpayment = mysqli_query($con,$sqlpayment);
$rspayment = mysqli_fetch_array($qsqlpayment);
?>
<!--start main -->
<div class="main_bg">
<div class="wrap">
	<div class="main">			
			<div>				

<div >
	<div >
		
        <div class="col-md-12" id="divprintarea">
         
		
			
            <div>
			
<table class="table table-bordered">
	<thead>
		<tr>
			<th colspan="2">
				<center>
				<img src="images/findmystay.png" alt="" width="250px;" style="height:150px;"><br>
				FindMyStay<br>
				3rd floor, city light building<br>
				Mangalore
				</center>
			</th>
		</tr>
		<tr>
			<th style="width:50%">Name : <?php echo $rspayment[customer_name]; ?></td>
			<th style="width:50%;color:red;">Bill No. <?php echo $rspayment[payment_id]; ?></th>
		</tr>
		<tr>
			<th style="width:50%">
			Address:<br>  <?php echo $rspayment[address]; ?>, <?php echo $rspayment[city]; ?>, <?php echo $rspayment[pincode]; ?><br>
			Contact No.   <?php echo $rspayment[contact_no]; ?><br>
			Email ID.   <?php echo $rspayment[email_id]; ?>
			</th>
			<th style="width:50%;">
			Bill Date: <?php echo date("d-M-Y",strtotime($rspayment[payment_date])); ?>
			<hr>
			Note: <br>
			<?php echo $rspayment[note]; ?>
			</th>
		</tr>
		<tr>
			<th style="width:50%;">
		<?php
		$checkin = date("d-M-Y",strtotime($rspayment[name]));
		$checkout = date("h:i A",strtotime($rspayment[mobileno]));
		?>
			Food Order date : <?php echo $checkin; ?>
			</th>
			<th style="width:50%;">
			Food Order time : <?php echo $checkout; ?>
			</th>
		</tr>
	</tbody>
</table>



<table class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Item</th>
			<th>Item Cost</th>
			<th>Quantity</th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql = "SELECT * FROM food_order LEFT JOIN room_booking ON food_order.room_booking_id=room_booking.room_booking_id LEFT JOIN item ON food_order.item_id=item.item_id LEFT JOIN customer ON food_order.customer_id=customer.customer_id WHERE food_order.payment_id='$_GET[paymentid]'";
	$qsql = mysqli_query($con,$sql);
	while($rs = mysqli_fetch_array($qsql))
	{
		echo "<tr>
			<td>$rs[item_name]</td>
			<td>₹$rs[item_cost]</td>
			<td>$rs[qty]</td>
			<td> ₹" . $rs[item_cost]*$rs[qty] . "</td>
		</tr>";
	}
	?>	
<tfoot>
	<tr>
		<th></th>
		<th></th>
		<th class="text-right"><h2><strong>Total: </strong></h2></th>
		<th class="text-left text-danger">
		<h2>Rs. <?php echo $rspayment[total_amt]; ?></strong></h2>
		</th>
	</tr>
</tfoot>
                </table>
				<hr>
<center><input type="button" class="form-control" value="Print" style="width:500px;" onclick="PrintElem('divprintarea')"></center>
				
            </div>
			
			
        </div>    
	</div>
</div>
				
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
function PrintElem(elem)
{
    var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById(elem).innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
}
</script>