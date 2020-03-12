<?php include 'header.php'; ?>
			<!--Header End-->
			<!--Inner Home Banner Start-->
			<div class="wt-haslayout wt-innerbannerholder">
				<div class="container">
					<div class="row justify-content-md-center">
						<div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
							<div class="wt-innerbannercontent">
							<div class="wt-title"><h2>A Brief Intro</h2></div>
							<ol class="wt-breadcrumb">
								<li><a href="index-2.html">Home</a></li>
								<li class="wt-active">About</li>
							</ol>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--Inner Home End-->
			<!--Main Start-->
			<main id="wt-main" class="wt-main wt-haslayout wt-innerbgcolor">
			<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'conn.php';
// Check connection
if (!$link) {
  die("Connection failed: " . mysqli_connect_error());
}
if(isset($_POST['save'])){
 $name = $_POST['term'];
 if (empty($name)) {
  echo "<div class='alert alert-danger'>
  <strong>Failed!</strong> Tracking Id Cannot Be Empty.
  </div>";
}else{

  $sql = "SELECT * FROM escrow where track_id LIKE '%$name%'";
  $result = mysqli_query($link, $sql);

  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {?> 
      <div class="container">
       <div class="alert alert-success" align="center">
        <strong>Success!</strong> Your escrow has been created successfully!
      </div>
    </div>
    <div class="container">
     <div class="jumbotron jumbotron-fluid bg-dark text-white">
      <div class="container text-center">
        <h1 class="display-4" style="color: #fff"><i class="fa fa-lock"></i><?php echo $row["transname"] ?></h1>
        <p class="lead">  <span class="badge badge-primary">YOUR TRACK CODE : <?php echo $row["track_id"] ?> </span> <span class="badge badge-info">PRICE: $<?php echo $row["price"] ?></span>
          <span class="badge badge-secondary">BALANCE:  <i class="fa fa-btc" aria-hidden="true"></i>  0 - Pending funds from customer</span>   </p><br>
          <p class="lead add-funds"><i class="fa fa-plus-circle" aria-hidden="true"></i> ADD FUNDS : <button class="btn btn-primary btn-lg">1CGU4v6S6cKEgWFtoUis9Tjj9uUCNiWK73</button>  </p> <br>Current bitcoin balance : 0.00000000<p class="text-warning" style="margin-top:10px;"><small>You must to send an total of $<?php echo $row["price"] ?> = <?php $url = "https://blockchain.info/stats?format=json";
          $stats = json_decode(file_get_contents($url), true);
          $btcValue = $stats['market_price_usd'];
          $usdCost =   $row["price"];

          $convertedCost = $usdCost / $btcValue;

          echo number_format($convertedCost, 8). " BTC"; ?><i class="fa fa-btc"></i> BTC</small> </p>
          <div class="row">
            <div class="col-md-5 refund-wrapper">
              <p>Refund Bitcoin Wallet Address: <br>
                <small>If something goes wrong all funds will be refunded in the follow bitcoin wallet address</small> <br>
                <span class="refund-wallet"><i class="fa fa-btc" aria-hidden="true"></i> <button class="btn btn-info btn-lg"><?php echo $row["refund_wallet"] ?></button> </span>
              </p>
            </div>
            <div class="col-md-2 exchange-wrapper">
              <span style="font-size:30px;"><i class="fa fa-exchange" aria-hidden="true"></i></span> <br>
              <a href="new-dispute.php" class="btn btn-sm btn-danger btn-disabled" disabled><i class="fa fa-frown-o" aria-hidden="true"></i>
              Open dispute</a>
            </div>
            <div class="col-md-5 success-wrapper">
              <p>Success Bitcoin Wallet Address: <br>
                <small>If the transaction goes well all funds will be send in the follow bitcoin wallet address</small> <br>
                <span class="success-wallet"><i class="fa fa-btc" aria-hidden="true"></i> <button class="btn btn-info btn-lg"><?php echo $row["success_wallet"] ?></button> </span>
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <h4><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Escrow Description</h4>

            <p><?php echo $row["description"] ?></p>
          </div>
          <div class="col-md-4">
            <h4> <i class="fa fa-calendar" aria-hidden="true"></i> Job should be completed in  :</h4>
            <hr>
            <p style="font-weight:bolder; color: #000">
              <?php echo $row["completion_time"] ?></p><br>

              <h4> <i class="fa fa-user" aria-hidden="true"></i> Escrow created by  :</h4>
              <hr>
              <p style="font-weight:bolder; color: #000">
                Customer</p><br>
                <h4> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                If not completed  :</h4>
                <hr>
                <p style="font-weight:bolder; color: #000">
                  <?php echo $row["if_not_completed"] ?></p><br>
                  <h4> <i class="fa fa-money" aria-hidden="true"></i>
                  Fees will be paid by :</h4>
                  <hr>
                  <p style="font-weight:bolder; color: #000">
                    <?php echo $row["fee"] ?></p><br>
                  </div>
                </div>
              </div>
            </div>
            <?php       
          }
        } else {
          echo "<div class='alert alert-danger'>
          <strong>Failed!</strong> No Search Done Yet Or Tracking Id Doesnt Exist.
          </div>";
        }
      }
    }

    ?>
			</main>
			<!--Main End-->
			<!--Footer Start-->
			<?php include 'footer.php'; ?>