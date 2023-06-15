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
			<th style="width:50%">Bill No. <?php echo $rspayment[payment_id]; ?></th>
		</tr>
		<tr>
			<th style="width:50%">
			Address:<br>  <?php echo $rspayment[address]; ?>, <?php echo $rspayment[city]; ?>, <?php echo $rspayment[pincode]; ?><br>
			Contact No.   <?php echo $rspayment[contact_no]; ?><br>
			Email ID.   <?php echo $rspayment[email_id]; ?>
			</th>
			<th style="width:50%;">
			Bill Date: <?php echo date("d-M-Y",strtotime($rspayment[payment_date])); ?><br>&nbsp;
			</th>
		</tr>
	</tbody>
</table>



<table class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Spa Service</th>
				<th>Booking Date</th>
				<th>Booking Time</th>
				<th>Message</th>
				<th>Cost</th>
			</tr>
		</thead>
		
		<tbody>
		<?php
		$totcost =0;
		$sql = "SELECT * FROM spa_service_booking LEFT JOIN spa_service ON spa_service_booking.spa_serviceid=spa_service.spa_serviceid LEFT JOIN customer ON spa_service_booking.customer_id=customer.customer_id WHERE  spa_service_booking.status='Active' AND spa_service_booking.payment_id='$_GET[paymentid]' ";
		$qsql = mysqli_query($con,$sql);
		while($rs = mysqli_fetch_array($qsql))
		{
			echo "<tr>
				<td>$rs[service_type]</td>
				<td>" . date("d-M-Y",strtotime($rs[booking_date])) . "</td>
				<td>" . date("h:i A",strtotime($rs[booking_time])) . "</td>
				<td>$rs[message]</td>
				<td>₹$rs[cost]</td>
			</tr>";
			$totcost = $totcost + $rs[cost] ;
		}
		?>	
		</tbody>
		<tfoot>
			<tr>
				<th></th>
				<th></th>
				<th></th>
				<th>Total</th>
				<th>₹<?php echo $totcost; ?></th>
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