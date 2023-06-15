<?php
include("header.php");
if(isset($_GET[delid]))
{
	$sql = "DELETE FROM spa_service WHERE spa_serviceid='$_GET[delid]'";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('Spa Service record deleted successfully...');</script>";
	}
}
?>
<!--start main -->
<div class="main_bg">
<div class="wrap">
	<div class="main">
		<div class="res_online">
			<h4>View Spa Service</h4>
		</div>			
			<div class="span_of_2">
				
				<table id="dataTables" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Service Image</th>
							<th>Hotel</th>
							<th>Service Type</th>
							<th>Gender</th>
							<th>Service Description</th>
							<th>Service Cost</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$sql = "SELECT * FROM spa_service LEFT JOIN hotel ON spa_service.hotel_id=hotel.hotel_id";
					$qsql = mysqli_query($con,$sql);
					while($rs = mysqli_fetch_array($qsql))
					{
						if($rs[service_images] == "")
						{
							$imgname = "images/noimage.png";
						}
						else
						{
							if(file_exists("imgspa/".$rs[service_images]))
							{
								$imgname=  "imgspa/".$rs[service_images];
							}
							else
							{
								$imgname = "images/noimage.png";
							}
						}
						echo "<tr>
							<td><img src='$imgname' width='100' height='100'></td>
							<td>$rs[hotel_name]</td>
							<td>$rs[service_type]</td>
							<td>$rs[gender]</td>
							<td>$rs[service_description]</td>
							<td>₹$rs[service_cost]</td>
							<td>$rs[status]</td>
							<td> <a href='spaservice.php?editid=$rs[spa_serviceid]'>Edit</a> | <a href='viewspaservice.php?delid=$rs[spa_serviceid]' onclick='return confirmdelete()'>Delete</a></td>
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