<?php
include("header.php");
$spa_serviceid  = $_POST["spa_serviceid"];
$bookingdate  = $_POST["bookingdate"];
$bookingtime  = $_POST["bookingtime"];
$note = $_POST["note"];
for($i=0; $i < count($spa_serviceid); $i++)
{
	$sql = "UPDATE spa_service_booking SET booking_date='$bookingdate[$i]',booking_time='$bookingtime[$i]', message='$note[$i]' WHERE spa_sevice_bookingid='$spa_serviceid[$i]'";
	$qsql = mysqli_query($con,$sql);
}
?>
<div class="main_bg">
<div class="wrap">
	<div class="main">
		<div class="res_online">
<center><h4 style="font-size:25px;font-weight: bold; color:red;">Spa Service Payment Gateway</h4></center>
		</div>			
			<div>
			
<div class="col-md-12">


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
	$sql = "SELECT * FROM room_booking LEFT JOIN hotel ON room_booking.hotel_id=hotel.hotel_id LEFT JOIN room_type ON room_booking.room_typeid=room_type.room_typeid LEFT JOIN customer ON room_booking.customer_id=customer.customer_id LEFT JOIN payment ON payment.room_booking_id=room_booking.room_booking_id WHERE room_booking.status='Active' AND payment.payment_id='$_POST[paymentid]'   ";
	$qsql = mysqli_query($con,$sql);
	while($rs = mysqli_fetch_array($qsql))
	{
		$hotelid=  $rs[hotel_id];
		$_GET[hotel_id] = $hotelid;
		echo "<input type='hidden' name='room_booking_id' id='room_booking_id' value='$rs[room_booking_id]' >";
		$checkin = date("d-M-Y",strtotime($rs[check_in]));
		$checkout = date("d-M-Y",strtotime($rs[check_out]));
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
					$sql = "SELECT * FROM spa_service_booking LEFT JOIN spa_service ON spa_service_booking.spa_serviceid=spa_service.spa_serviceid LEFT JOIN customer ON spa_service_booking.customer_id=customer.customer_id WHERE  spa_service_booking.status='Pending' AND customer.customer_id='$_SESSION[customer_id]'";
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
			<input type='hidden' name="totcost" id='totcost' value="<?php echo $totcost; ?>"
				
<hr>

	<table class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th colspan="2">Enter payment detail... </th>
			</tr>
			
			<tr>
				<th style="width:25%;">Payment Type</th>
				<th style="width:75%;"><select name="payment_type" id="payment_type" class="form-control" style="height:40px;">
						<option value=''>Select payment type</option>
						<option value='VISA'>VISA</option>
						<option value='MASTER CARD'>MASTER CARD</option>
						<option value='CREDIT CARD'>CREDIT CARD</option>
						<option value='DEBIT CARD'>DEBIT CARD</option>
					</select></th>
			</tr>
			
			<tr>
				<th style="width:25%;">Card holder</th>
				<th style="width:75%;"><input name="card_holder" id="card_holder" type="text" class="form-control" ></th>
			</tr>			
			 
			<tr>
				<th style="width:25%;">Card No</th>
				<th style="width:75%;"><input name="card_no" id="card_no" type="text" class="form-control" value="<?php echo $rsedit[card_no]; ?>"></th>
			</tr>
			
			<tr>
				<th style="width:25%;">Expiry Date</th>
				<th style="width:75%;"><input name="exp_date" id="exp_date" type="month" class="form-control" min="<?php echo $minmonth; ?>" value="<?php echo $rsedit[exp_date]; ?>"></th>
			</tr>
			
			<tr>
				<th style="width:25%;">CVV No</th>
				<th style="width:75%;"><input name="cvv_no" id="cvv_no" type="text" class="form-control" value="<?php echo $rsedit[cvv_no]; ?>"></th>
			</tr>
			
			<tr>
				<th style="width:25%;"></th>
				<th style="width:75%;"><input type="button" id="btnpayment" name="btnpayment" class="form-control" value="Make payment" ></th>
			</tr>
			
			
		</thead>
	</table>
			
	</div>

</div>
</div>
</div>
</div>
</div>


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
function validateform()
{
	if(document.getElementById("room_booking_id").value == "")
	{
		alert("Kindly select the Room Booking Id..");
		return false;
	}
	else if(document.getElementById("spa_serviceid").value == "")
	{
		alert("Kindly select the Spa Service Id..");
		return false;
	}
	else if(document.getElementById("customer_id").value == "")
	{
		alert("Kindly select the Customer Name..");
		return false;
	}
	else if(document.getElementById("booking_date").value == "")
	{
		alert("Kindly enter Booking Date..");
		return false;
	}
	else if(document.getElementById("booking_time").value == "")
	{
		alert("Kindly enter Booking Time....");
		return false;
	}
	else if(document.getElementById("cost").value == "")
	{
		alert("Cost should not be empty....");
		return false;
	}
	else if(document.getElementById("message").value == "")
	{
		alert("Message Should not be empty....");
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
	xmlhttp.open("GET","ajaxspaservicebooking.php?spaid="+spaid+"&cost="+cost+"&submit=submit",true);
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
<script>
$('#btnpayment').bind('click', function(e) {
	
	var onlycharacter = /^[a-zA-Z\s]*$/;
	
	if(document.getElementById("payment_type").value == "")
	{
		alert("Kindly select the Payment type..");
		return false;
	}
	else if(document.getElementById("card_holder").value == "")
	{
		alert("Kindly enter Cardholde name..");
		return false;
	}
	else if(!document.getElementById("card_holder").value.match(onlycharacter))
	{
		alert("Cardholder Name should contain only Character..");
		return false;
	}
	else if(document.getElementById("card_no").value == "")
	{
		alert("Kindly enter Card no ..");
		return false;
	}	
	else if(document.getElementById("card_no").value.length != 16)
	{
		alert("Card No should contain only 16 digits...");
		return false;
	}	
	else if(document.getElementById("exp_date").value == "")
	{
		alert("Kindly enter expiration date..");
		return false;
	}
	else if(document.getElementById("cvv_no").value == "")
	{
		alert("Kindly enter CVV no ..");
		return false;
	}	
	else if(document.getElementById("cvv_no").value.length != 3)
	{
		alert("CVV No should contain only 3 digits...");
		return false;
	}
	else
	{
	
		var payment_type = $('#payment_type').val();
		var card_holder = $('#card_holder').val();
		var card_no = $('#card_no').val();
		var cvv_no = $('#cvv_no').val();
		var exp_date = $('#exp_date').val();
		var room_booking_id = $('#room_booking_id').val(); 
		var totcost = $('#totcost').val(); 	
		
			$.post("payment.php",
			{
				'payment_type': payment_type,
				'card_holder': card_holder,
				'card_no': card_no,
				'cvv_no': cvv_no,
				'exp_date': exp_date,
				'totcost':totcost,
				'room_booking_id':room_booking_id,
                'btnspaservice': "btnspaservice"
			},
			function(data, status){
				alert("Spa Service payment done successfully...");
				window.location='spaservicereceipt.php?paymentid='+data;
			});
	}
});
</script>