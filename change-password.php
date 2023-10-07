<?php
// Initialize the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
	header("location: login.php");
	exit;
}

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// Validate new password
	if (empty(trim($_POST["new_password"]))) {
		$new_password_err = "Please enter the new password.";
	} elseif (strlen(trim($_POST["new_password"])) < 6) {
		$new_password_err = "Password must have atleast 6 characters.";
	} else {
		$new_password = trim($_POST["new_password"]);
	}

	// Validate confirm password
	if (empty(trim($_POST["confirm_password"]))) {
		$confirm_password_err = "Please confirm the password.";
	} else {
		$confirm_password = trim($_POST["confirm_password"]);
		if (empty($new_password_err) && ($new_password != $confirm_password)) {
			$confirm_password_err = "Password did not match.";
		}
	}

	// Check input errors before updating the database
	if (empty($new_password_err) && empty($confirm_password_err)) {
		// Prepare an update statement
		$sql = "UPDATE users SET password = ? WHERE id = ?";

		if ($stmt = mysqli_prepare($link, $sql)) {
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

			// Set parameters
			$param_password = password_hash($new_password, PASSWORD_DEFAULT);
			$param_id = $_SESSION["id"];

			// Attempt to execute the prepared statement
			if (mysqli_stmt_execute($stmt)) {
				// Password updated successfully. Destroy the session, and redirect to login page
				session_destroy();
				header("location: login.php");
				exit();
			} else {
				echo "Oops! Something went wrong. Please try again later.";
			}

			// Close statement
			mysqli_stmt_close($stmt);
		}
	}

	// Close connection
	mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Meta Tags -->
	<meta charset="UTF-8">
	<meta name="author" content="imankitkalirawana">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Title -->
	<title>E-Commerce Online Shop</title>
	<!-- Style Sheet -->
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<!-- Javascript -->
	<script type="text/javascript" src="js/jquery.min.js"></script>
</head>

<body>

	<header>
		<div class="container">
			<div class="brand">
				<div class="logo">
					<a href="index.php">
						<img src="img/icons/online_shopping.png">
						<div class="logo-text">
							<p class="big-logo">Ecommerce</p>
							<p class="small-logo">online shop</p>
						</div>
					</a>
				</div> <!-- logo -->
				<div class="shop-icon">
					<div class="dropdown">
						<img src="img/icons/account.png">
						<div class="dropdown-menu">
							<ul>
								<li><a href="account.php">My Account</a></li>
								<li><a href="orders.php">My Orders</a></li>
							</ul>
						</div>
					</div>
					<div class="dropdown">
						<img src="img/icons/heart.png">
						<div class="dropdown-menu wishlist-item">
							<table border="1">
								<thead>
									<tr>
										<th>Image</th>
										<th>Product Name</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><img src="img/product/img1.jpg"></td>
										<td>product name</td>
									</tr>
									<tr>
										<td><img src="img/product/img2.jpg"></td>
										<td>product name</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="dropdown">
						<img src="img/icons/shopping_cart.png">
						<div class="dropdown-menu cart-item">
							<table border="1">
								<thead>
									<tr>
										<th>Image</th>
										<th>Product Name</th>
										<th class="center">Price</th>
										<th class="center">Qty.</th>
										<th class="center">Amount</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><img src="img/product/img1.jpg"></td>
										<td>product name</td>
										<td class="center">1200</td>
										<td class="center">2</td>
										<td class="center">2400</td>
									</tr>
									<tr>
										<td><img src="img/product/img2.jpg"></td>
										<td>product name</td>
										<td class="center">1500</td>
										<td class="center">2</td>
										<td class="center">3000</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div> <!-- shop icons -->
			</div> <!-- brand -->

			<div class="menu-bar">
				<div class="menu">
					<ul>
						<li><a href="index.php">Home</a></li>
						<li><a href="shop.php">Shop</a></li>
						<li><a href="about.php">About</a></li>
						<li><a href="contact.php">Contact</a></li>
					</ul>
				</div>
				<div class="search-bar">
					<form>
						<div class="form-group">
							<input type="text" class="form-control" name="search" placeholder="Search">
							<img src="img/icons/search.png">
						</div>
					</form>
				</div>
			</div> <!-- menu -->
		</div> <!-- container -->
	</header> <!-- header -->

	<div class="container">
		<main>
			<div class="breadcrumb">
				<ul>
					<li><a href="index.php">Home</a></li>
					<li> / </li>
					<li><a href="account.php">Account</a></li>
					<li> / </li>
					<li>Change Password</li>
				</ul>
			</div> <!-- End of Breadcrumb-->


			<div class="account-page">
				<div class="profile">
					<div class="profile-img">
						<img src="img/product/img5.jpg">
						<h2>John Doe</h2>
						<p>user@mail.com</p>
					</div>
					<ul>
						<li><a href="account.php" class="active">Account <span>></span></a></li>
						<li><a href="orders.php">My Orders <span>></span></a></li>
						<li><a href="change-password.php">Change Password <span>></span></a></li>
						<li><a href="/logout.php">Logout <span>></span></a></li>
					</ul>
				</div>
				<div class="account-detail">
					<h2>Change Password</h2>
					<div class="billing-detail">
						<form class="checkout-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
							<div class="form-group">
								<label>Old Password</label>
								<input type="password" id="old_password" name="old_password">
							</div>
							<div class="form-inline">
								<div class="form-group">
									<label>New Password</label>
									<input type="password" id="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" name="new_password" value="<?php echo $new_password; ?>">
								</div>
								<div class="form-group">
									<label>Confirm Password</label>
									<input type="password" id="confirm_password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
								</div>
							</div>
							<div class="form-group">
								<label></label>
								<input type="submit" class="btn btn-primary" value="Submit">
							</div>
						</form>
					</div>
				</div>
			</div>
		</main> <!-- Main Area -->
	</div>

	<footer>
		<div class="container">
			<div class="footer-widget">
				<div class="widget">
					<div class="widget-heading">
						<h3>Important Link</h3>
					</div>
					<div class="widget-content">
						<ul>
							<li><a href="about.php">About</a></li>
							<li><a href="contact.php">Contact</a></li>
							<li><a href="refund.php">Refund Policy</a></li>
							<li><a href="terms.php">Terms & Conditions</a></li>
						</ul>
					</div>
				</div>
				<div class="widget">
					<div class="widget-heading">
						<h3>Information</h3>
					</div>
					<div class="widget-content">
						<ul>
							<li><a href="account.php">My Account</a></li>
							<li><a href="orders.php">My Orders</a></li>
							<li><a href="cart.php">Cart</a></li>
							<li><a href="checkout.php">Checkout</a></li>
						</ul>
					</div>
				</div>
				<div class="widget">
					<div class="widget-heading">
						<h3>Follow us</h3>
					</div>
					<div class="widget-content">
						<div class="follow">
							<ul>
								<li><a href="#"><img src="img/icons/facebook.png"></a></li>
								<li><a href="#"><img src="img/icons/twitter.png"></a></li>
								<li><a href="#"><img src="img/icons/instagram.png"></a></li>
							</ul>
						</div>
					</div>
					<div class="widget-heading">
						<h3>Subscribe for Newsletter</h3>
					</div>
					<div class="widget-content">
						<div class="subscribe">
							<form>
								<div class="form-group">
									<input type="text" class="form-control" name="subscribe" placeholder="Email">
									<img src="img/icons/paper_plane.png">
								</div>
							</form>
						</div>
					</div>
				</div>
			</div> <!-- Footer Widget -->
			<div class="footer-bar">
				<div class="copyright-text">
					<p>Copyright 2021 - All Rights Reserved</p>
				</div>
				<div class="payment-mode">
					<img src="img/icons/paper_money.png">
					<img src="img/icons/visa.png">
					<img src="img/icons/mastercard.png">
				</div>
			</div> <!-- Footer Bar -->
		</div>
	</footer> <!-- Footer Area -->

</body>

</html>