<?php
include_once("config.php");

// Get the sort option selected by the user
$sortOption = isset($_POST['sort']) ? $_POST['sort'] : 'default';

// Set the sort order for the SQL query
$sortOrder = '';
switch ($sortOption) {
	case 'low_high':
		$sortOrder = 'ORDER BY discount_price ASC';
		break;
	case 'high_low':
		$sortOrder = 'ORDER BY discount_price DESC';
		break;
	default:
		$sortOrder = ''; // No sorting
		break;
}

// Fetch all products with the selected sorting order
$stmp_all = $link->prepare("SELECT * FROM products $sortOrder");
$stmp_all->execute();
$result = $stmp_all->get_result();

$stmp_featured = $link->prepare("SELECT * FROM products WHERE status = 1 $sortOrder");
$stmp_featured->execute();
$result = $stmp_featured->get_result();

$stmp_category = $link->prepare("SELECT * FROM pg_category");
$stmp_category->execute();
$result_category = $stmp_category->get_result();
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
	<link rel="stylesheet" type="text/css" href="/css/theme.css" />
	<link rel="stylesheet" type="text/css" href="/css/common.css" />
	<link rel="stylesheet" type="text/css" href="/css/style.css" />
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<!-- Javascript -->
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
		$(function() {
			$("#slider-range").slider({
				range: true,
				min: 5000,
				max: 20000,
				values: [7000, 10000],
				slide: function(event, ui) {
					$("#amount").val("Rs." + ui.values[0] + " - Rs." + ui.values[1]);
				}
			});
			$("#amount").val("Rs." + $("#slider-range").slider("values", 0) +
				" - Rs." + $("#slider-range").slider("values", 1));
		});

		$(document).on("submit", "form", function(event) {
			event.preventDefault(); // Prevent form submission

			var minPrice = $("#slider-range").slider("values", 0);
			var maxPrice = $("#slider-range").slider("values", 1);

			// Send the minPrice and maxPrice values to the server using AJAX
			$.ajax({
				url: "filter.php",
				type: "POST",
				data: {
					minPrice: minPrice,
					maxPrice: maxPrice
				},
				success: function(response) {
					// Handle the response from the server (e.g., update the displayed results)
					$("#result").html(response);
				}
			});
		});
	</script>
</head>

<body>

	<?php include("header.php"); ?>

	<div class="container">
		<div class="sidebar-widget">
			<h3>Sort by Price</h3>
			<form method="post" id="filter-form">
				<select name="sort" id="sort-select">
					<option value="default" <?php echo ($sortOption === 'default') ? 'selected' : ''; ?>>Default</option>
					<option value="low_high" <?php echo ($sortOption === 'low_high') ? 'selected' : ''; ?>>Price: Low to High</option>
					<option value="high_low" <?php echo ($sortOption === 'high_low') ? 'selected' : ''; ?>>Price: High to Low</option>
				</select>
				<button type="submit">Apply</button>
			</form>
		</div>
		<main>
			<div class="breadcrumb">
				<ul>
					<li><a href="index.php">Home</a></li>
					<li> / </li>
					<li>Shop</li>
				</ul>
			</div> <!-- End of Breadcrumb-->

			<div class="new-product-section shop">
				<div class="sidebar">
					<div class="sidebar-widget">
						<h3>Category</h3>
						<ul>
							<?php while ($row_category = $result_category->fetch_assoc()) { ?>
								<li><a href="/category.php?id=<?php echo $row_category['cat_id']; ?>"><?php echo $row_category['cat_name']; ?></a></li>
							<?php } ?>

						</ul>
					</div>
					<div class="sidebar-widget">
						<h3>Range Filter</h3>
						<p>
							<label for="amount"></label>
							<input type="text" id="amount" readonly style="border:0; color:#F0E68C;  margin-bottom: 5px;">
						</p>
						<form method="post" id="filter-form">
							<div id="slider-range"></div>
							<button type="submit">Apply</button>
						</form>


					</div>
				</div>
				<div class="row" id="result">
					<?php
					while ($row = $result->fetch_assoc()) {
						$originalPrice = $row['original_price'];
						$discountPrice = $row['discount_price'];
						$discountPercentage = round(($originalPrice - $discountPrice) / $originalPrice * 100);
					?>
						<a href="product.php?id=<?php echo $row['p_id']; ?>" class="row-item">
							<div class="row-img">
								<img src="/img/p_images/<?php echo $row['p_id'] . "/" . $row['image']; ?>" alt="">
								<div class="row-wishlist">
									<i class="fa-regular fa-heart"></i>
								</div>
							</div>
							<div class="row-details">
								<div class="row-details-heading">
									<h3><?php echo $row['p_name']; ?></h3>
								</div>
								<div class="row-price">
									<div class="row-price-left">
										<span class="discount-price">₹<?php echo $row['discount_price']; ?></span>
										<span class="original-price">₹<?php echo $row['original_price']; ?></span>
									</div>
									<div class="row-price-right">
										<span class="discount-percent"><?php echo $discountPercentage; ?>%Off</span>
									</div>
								</div>
							</div>
						</a>
					<?php } ?>

				</div>

				<!-- <div class="product-content" id="result">
					<?php
					while ($row = $result->fetch_assoc()) {
					?>
						<div class="product">
							<a href="product.php?id=<?php echo $row['p_id']; ?>">
								<img src="img/p_images/<?php echo $row['p_id'] . "/" . $row['image']; ?>">
							</a>
							<div class="product-detail">
								<h3><?php echo $row['size']; ?></h3>
								<h2><?php echo $row['p_name']; ?></h2>
								<a href="product.php?id=<?php echo $row['p_id']; ?>">View</a>
								<p>Rs.<?php echo $row['p_price']; ?>/-</p>
							</div>
						</div>
					<?php } ?>
				</div> -->
			</div> <!-- New Product Section -->

		</main> <!-- Main Area -->
	</div>

	<?php include("footer.php") ?>

</body>

</html>