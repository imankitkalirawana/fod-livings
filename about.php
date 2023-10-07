<?php
include("config.php");


$stmp_website = $link->prepare("SELECT * FROM website where id = 1");
$stmp_website->execute();
$result_website = $stmp_website->get_result();
$row_website = $result_website->fetch_assoc();
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
</head>

<body>

	<?php include("header.php") ?>

	<div class="container">
		<main>
			<div class="about">
				<h2 class="heading">About</h2>
				<p><?php echo $row_website['detailed_description']; ?></p>
			</div>
		</main> <!-- Main Area -->
	</div>

	<?php include("footer.php") ?>


</body>

</html>