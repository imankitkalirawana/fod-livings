<?php
// require_once "config.php";
include_once "common.php";

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
	header("location: login.php");
	exit;
}
$param_id = $_SESSION["id"];
$param_username = $_SESSION["username"];
$stmp = $link->prepare("SELECT * from users where id = ?");
$stmp->bind_param("i", $param_id);
$stmp->execute();
$result = $stmp->get_result();
$row = $result->fetch_assoc();

if (isset($_POST['update'])) {
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$address = $_POST['address'];
	$mobile = $_POST['mobile'];

	$stmp_update = $link->prepare("UPDATE users SET first_name = ?, last_name = ?, address = ?, mobile_number = ? WHERE id = ?");
	$stmp_update->bind_param("ssssi", $fname, $lname, $address, $mobile, $param_id);
	$stmp_update->execute();
	$stmp_update->close();

	$profilePicture = $_FILES['profile_picture'];
	$profilePictureName = $profilePicture['name'];

	if (!empty($profilePictureName)) {
		$targetDirectory = '/img/users/';
		$targetFilePath = $targetDirectory . basename($profilePictureName);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

		// Check if the image file is a actual image or fake image
		$check = getimagesize($profilePicture['tmp_name']);
		if ($check !== false) {
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}

		// Check file size
		if ($profilePicture['size'] > 500000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}

		// Allow certain file formats
		$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
		if (!in_array($imageFileType, $allowedExtensions)) {
			echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
			$uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		} else {
			// If everything is ok, try to upload file
			if (move_uploaded_file($profilePicture['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $targetFilePath)) {
				$profilePicturePath = $targetFilePath;
				// Update the image path in the database
				$stmp_update = $link->prepare("UPDATE users SET image = ? WHERE id = ?");
				$stmp_update->bind_param("si", $profilePicturePath, $param_id);
				$stmp_update->execute();
				$stmp_update->close();
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
	}

	$stmp->execute();
	$result = $stmp->get_result();
	$row = $result->fetch_assoc();
}

$stmp->close();


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
	<?php include("header.php") ?>


	<div class="container">
		<main>
			<div class="breadcrumb">
				<ul>
					<li><a href="index.php">Home</a></li>
					<li> / </li>
					<li>Account</li>
				</ul>
			</div> <!-- End of Breadcrumb-->

			<div class="account-page">
				<div class="profile">
					<div class="profile-img">
						<img src="<?php echo $row['image']; ?>">
						<h2><?php echo $row['first_name'] . " " . $row['last_name']; ?></h2>
						<p><?php echo $param_email; ?></p>
					</div>
					<ul>
						<li><a href="account.php" class="active">Account <span>></span></a></li>
						<li><a href="orders.php">My Orders <span>></span></a></li>
						<li><a href="change-password.php">Change Password <span>></span></a></li>
						<li><a href="/logout.php">Logout <span>></span></a></li>
					</ul>
				</div>
				<div class="account-detail">
					<h2>Account</h2>
					<div class="billing-detail">
						<form class="checkout-form" method="POST" enctype="multipart/form-data">
							<div class="form-inline">
								<div class="form-group">
									<label>First Name</label>
									<input type="text" id="fname" name="fname" value="<?php echo $row['first_name']; ?>">
								</div>
								<div class="form-group">
									<label>Last Name</label>
									<input type="text" id="lname" name="lname" value="<?php echo $row['last_name']; ?>">
								</div>
							</div>
							<div class="form-group">
								<label>Profile Picture</label>
								<input type="file" id="profile_picture" name="profile_picture">
							</div>
							<div class="form-group">
								<label>Address</label>
								<textarea style="resize:none" id="address" name="address" rows="3"><?php echo $row['address']; ?></textarea>
							</div>
							<div class="form-inline">
								<div class="form-group">
									<label>Mobile</label>
									<input type="text" id="mobile" name="mobile" minlength="10" maxlength="12" value="<?php echo $row['mobile_number']; ?>">
								</div>
							</div>
							<div class="form-group">
								<label></label>
								<input type="submit" id="update" name="update" value="Update">
							</div>
						</form>
					</div>
				</div>
			</div>
		</main> <!-- Main Area -->
	</div>

	<?php include("footer.php") ?>


</body>

</html>