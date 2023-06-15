<?php
include("header.php");
?>
<!--start main -->
<div class="main_bg">
<div class="wrap">

	<!--start grids_of_3 -->
	<div class="grids_of_3">
		
		
		<div class="grid1_of_3">
			<div class="grid1_of_3_img">
				<a href="displayitem.php?paymentid=<?php echo $_GET[paymentid]; ?>">
					<img src="images/Online-Ordering-Feature.jpg" alt=""  style="width:480;height:340px;" />
				</a>
			</div>
			<h4><a href="displayitem.php?paymentid=<?php echo $_GET[paymentid]; ?>">Online Food Order</a></h4>
			<p>Order foods through online...</p>
		</div>
		
		
		<div class="grid1_of_3">
			<div class="grid1_of_3_img">
				<a href="rentacar.php?paymentid=<?php echo $_GET[paymentid]; ?>">
					<img src="images/Rent A Car.png" alt="" style="width:480;height:340px;" />
				</a>
			</div>
			<h4><a href="rentacar.php?paymentid=<?php echo $_GET[paymentid]; ?>">Rent a car</a></h4>
			<p>Rent or Book vehicles through online</p>
		</div>
		
		
		<div class="grid1_of_3">
			<div class="grid1_of_3_img">
				<a href="spaservicebooking.php?paymentid=<?php echo $_GET[paymentid]; ?>">
					<img src="images/spabeauty.jpg" alt="" style="width:480;height:340px;" />
				</a>
			</div>
			<h4><a href="spaservicebooking.php?paymentid=<?php echo $_GET[paymentid]; ?>">Spa & Beauty Parlor</a></h4>
			<p>We provide all the services for your hair salon and day spa..</p>
		</div>
		
		
		<div class="clear"></div>
	</div>	
</div>
</div>		
<!--start main -->
<?php
include("footer.php");
?>