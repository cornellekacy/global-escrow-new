<?php include 'header.php'; ?>
<section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_1.jpg');">
	<div class="overlay"></div>
	<div class="container">
		<div class="row no-gutters slider-text align-items-center justify-content-center">
			<div class="col-md-9 ftco-animate text-center">
				<h1 class="mb-2 bread">Start A Transaction</h1>
				<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Start A Transaction<i class="ion-ios-arrow-forward"></i></span></p>
			</div>
		</div>
	</div>
</section>


<div class="container">
	<div class="row">
		<div class="col-md-2">
		</div>
		<div class="col-md-8">
			<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
include 'conn.php';

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
if(isset($_POST['save'])){
 $transname = mysqli_real_escape_string($link,$_POST['transname']);
 $price = mysqli_real_escape_string($link,$_POST['price']);
 $transtype = mysqli_real_escape_string($link,$_POST['transtype']);
 $fee = mysqli_real_escape_string($link,$_POST['fee']);
 $completion_time = mysqli_real_escape_string($link,$_POST['completion_time']);
 $if_not_completed = mysqli_real_escape_string($link,$_POST['if_not_completed']);
 $refund_wallet = mysqli_real_escape_string($link,$_POST['refund_wallet']);
 $success_wallet = mysqli_real_escape_string($link,$_POST['success_wallet']);
 $secret_code = mysqli_real_escape_string($link,$_POST['secret_code']);
 $description = mysqli_real_escape_string($link,$_POST['description']);
 

 if (empty($transname)) {
    echo "<div class='alert alert-danger'>
    <strong>Failed!</strong>Transaction Name Cannot Be Empty.
    </div>";
}

elseif (empty($price)) {
    echo "<div class='alert alert-danger'>
    <strong>Failed!</strong>Price in USD Cannot Be Empty.
    </div>";
}
elseif (empty($refund_wallet)) {
    echo "<div class='alert alert-danger'>
    <strong>Failed!</strong> Refund Bitcoin Wallet Address (Customer): Cannot Be Empty.
    </div>";
}
elseif (empty($success_wallet)) {
    echo "<div class='alert alert-danger'>
    <strong>Failed!</strong> Success Bitcoin Wallet Address (Vendor): Cannot Be Empty.
    </div>";
}
elseif (empty($secret_code)) {
    echo "<div class='alert alert-danger'>
    <strong>Failed!</strong>  Secret Code Cannot Be Empty.
    </div>";
}
elseif (empty($description)) {
    echo "<div class='alert alert-danger'>
    <strong>Failed!</strong> Description and address Cannot Be Empty.
    </div>";
}

else{
    $me = substr(md5(time()), 0, 16);


 

// Attempt insert query execution
    $sql = "INSERT INTO escrow (transname,
price,
transtype,
fee,
completion_time,
if_not_completed,
refund_wallet,
success_wallet,
secret_code,
description, track_id) 
    VALUES ('$transname',
'$price',
'$transtype',
'$fee',
'$completion_time',
'$if_not_completed',
'$refund_wallet',
'$success_wallet',
'$secret_code',
'$description', '$me')";
    if(mysqli_query($link, $sql)){
    	$last_id = mysqli_insert_id($link);
    	 echo "New record created successfully. Last inserted ID is: " . $last_id;
        echo "<div class='alert alert-success'>
        <strong>Success!</strong> Tracking Successfully Created.
        </div>";
        echo "<script>window.location.replace('success.php?order=$last_id');</script>";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
}
}
// Close connection
mysqli_close($link);

?>
	
			<div class="alert alert-info">
				<strong>!</strong> THE ESCROW MUST BE CREATED BY CUSTOMER .
			</div>


			<form action="#" method="post">

				<div class="form-group">
					<label>Transaction Name:</label>
					<input class="form-control" type="text" name="transname" placeholder="Example i want to buy credit cards"
					required="">
				</div>
				<div class="form-group">
					<label>Price in USD (automatically converted in bitcoin by the system):</label>
					<input class="form-control" type="text" name="price" placeholder="price in USD"
					required="">
				</div>
				<div class="form-group">
					<label for="transtype"> I am</label>
					<select class="form-control" name="transtype">
						<option>Customer - I will buy something</option>
						<option>Vendor - I will sell something</option>
					</select>
				</div>
				<div class="form-group">
					<label for="fee"> Tranasction fees ( 1% ) will be paid by:</label>
					<select class="form-control" name="fee">
						<option>Customer</option>
						<option>Vendor</option>
						<option>Both 50% - 50%</option>
					</select>
				</div>
				<div class="form-group">
					<label for="completion_time"> Job should be completed in :</label>
					<select class="form-control" name="completion_time">
						<option>1 Day</option>
						<option>2 Days</option>
						<option>3 Days</option>
						<option>4 Days</option>
						<option>5 Days</option>
						<option>1 Week</option>
						<option>2 Weeks</option>
						<option>1 Month</option>
					</select>
				</div>
				<div class="form-group">
					<label for="if_not_completed">  If not completed :</label>
					<select class="form-control" name="if_not_completed">
						<option>Open Despute</option>
						<option>Extend for 10 Days</option>
						<option>Extend for 1 Week</option>
						<option>Extend for 2 Weeks</option>
						<option>Extend for 30 Days</option>

					</select>
				</div>
				<div class="form-group">
					<label>Refund Bitcoin Wallet Address (Customer):</label>
					<input class="form-control" type="text" name="refund_wallet" placeholder="Bitcoin Wallet to receive fund when task is not completed"
					required="">
				</div>
				<div class="form-group">
					<label>Success Bitcoin Wallet Address (Vendor):</label>
					<input class="form-control" type="text" name="success_wallet" placeholder="Bitcoin Wallet to receive fund when task is completed"
					required="">
				</div>
				<div class="form-group">
					<label>Secret Code (<a href="secret-code.php" target="blank">About secret code</a>  ):</label>
					<input class="form-control" type="text" name="secret_code" placeholder="Your Secret code"
					required="">
				</div>
				<div class="form-group">
					<label for="description">Description and address</label>
					<textarea class="form-control" rows="5" name="description"></textarea>
				</div>
				<br><hr>
				<div class="input-group1 ">
					<button class="wt-btn btn-primary" name="save" type="submit">CONTINUE</button>
				</div>
				<br>
			</form>
		</div>
	</div>

</div>
<div class="col-md-2">
</div>
</div>
<?php include 'footer.php'; ?>