<?php
include("header.php");
if(isset($_POST['submit']))
{
	$food_category = mysqli_real_escape_string($con,$_POST['food_category']);
	$note = mysqli_real_escape_string($con,$_POST['note']);
	//4. Update the record
	if(isset($_GET['editid']))
	{
		$sql = "UPDATE food_category SET food_category='$food_category', note='$note', status='$_POST[status]' WHERE food_category_id='$_GET[editid]'";
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		if(mysqli_affected_rows($con) ==1 )
		{
			echo "<SCRIPT>alert('Food Category record updated successfully..');</SCRIPT>";
		}
	}
	else
	{
	
	$sql = "INSERT INTO food_category(food_category,note,status) VALUES('$food_category','$note','$_POST[status]')";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	if(mysqli_affected_rows($con) ==1 )
	{
		echo "<SCRIPT>alert('Food category record inserted successfully..');</SCRIPT>";
	}
	}
}
//2. Update - select record starts here
if(isset($_GET['editid']))
{
	$sqledit= "SELECT * FROM food_category WHERE food_category_id='$_GET[editid]'";
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
				<div class="contact_right">
				  <div class="contact-form">
				  	<h3>Food Category</h3>
					    <form method="post" action="" onsubmit="return validateform()">
					    	<div>
						    	<span><label>Food Category</label></span>
						    	<span><input name="food_category" id="food_category" type="text" class="form-control" value="<?php echo $rsedit['food_category']; ?>"></span>
						    </div>
							<div>
						    	<span><label>Note</label></span>
						    	<span><textarea name="note"  class="form-control"><?php echo $rsedit['note']; ?></textarea></span>
						    </div>
						    <div>
						     	<span><label>Status</label></span>
						    	<span>
								<select name="status" class="form-control" id="status">
				<option value="">Select Status</option>
				<?php
				$arr = array("Active","Inactive");
				foreach($arr as $val)
				{
					if($val == $rsedit['status'])
					{
					echo "<option value='$val' selected >$val</option>";
					}
					else
					{
					echo "<option value='$val'>$val</option>";
					}
				}
				?>
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
	var onlycharacter = /^[a-zA-Z\s]*$/;
	
	if(document.getElementById("food_category").value == "")
	{
		alert("Kindly enter the Food Category..");
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