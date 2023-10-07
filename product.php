<?php
include_once("config.php");

$get_p_id = $_GET['id'];

$stmp = $link->prepare("SELECT * FROM products WHERE p_id = ?");
$stmp->bind_param("i", $get_p_id);
$stmp->execute();
$result = $stmp->get_result();
$row = $result->fetch_assoc();


$stmp_featured = $link->prepare("SELECT * FROM products WHERE featured = 1 and p_id != ?");
$stmp_featured->bind_param("i", $get_p_id);
$stmp_featured->execute();
$result_featured = $stmp_featured->get_result();

$stmp_p_img = $link->prepare("SELECT * FROM images WHERE image_p_id = ?");
$stmp_p_img->bind_param("i", $get_p_id);
$stmp_p_img->execute();
$result_p_img = $stmp_p_img->get_result();

$first_p_img = $link->prepare("SELECT * FROM images WHERE image_p_id = ? LIMIT 1");
$first_p_img->bind_param("i", $get_p_id);
$first_p_img->execute();
$result_first_p_img = $first_p_img->get_result();
$firstImageRow = mysqli_fetch_assoc($result_first_p_img);
$firstImage = $firstImageRow['image_name'];

$stmp_category = $link->prepare("SELECT * from pg_category where cat_id = ?");
$stmp_category->bind_param("i", $row['cat_id']);
$stmp_category->execute();
$result_category = $stmp_category->get_result();
$row_category = $result_category->fetch_assoc();


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
	<!-- FancyBox -->
	<link rel="stylesheet" href="fancybox/source/jquery.fancybox.css" type="text/css" media="screen" />
	<script type="text/javascript" src="fancybox/source/jquery.fancybox.pack.js"></script>

	<!-- Optionally add helpers - button, thumbnail and/or media -->
	<link rel="stylesheet" href="fancybox/source/helpers/jquery.fancybox-buttons.css" type="text/css" media="screen" />
	<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-buttons.js"></script>
	<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-media.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="https://pro.Fontawesome.com/releases/v6.0.0-beta3/css/all.css">


	<link rel="stylesheet" href="fancybox/source/helpers/jquery.fancybox-thumbs.css" type="text/css" media="screen" />
	<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-thumbs.js"></script>
	<script>
		$(document).ready(function() {
			$('.fancybox').fancybox({
				openEffect: 'none',
				closeEffect: 'none',

				prevEffect: 'none',
				nextEffect: 'none',

				closeBtn: false,

				helpers: {
					title: {
						type: 'inside'
					},
					buttons: {}
				},

				afterLoad: function() {
					this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
				}
			});
		});
	</script>
</head>

<body>

	<header>
		<div class="container">
			<div class="brand">
				<div class="logo">
					<a href="/">
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
						<li><a href="/">Home</a></li>
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
					<li><a href="/">Home</a></li>
					<li> / </li>
					<li><a href="">Shop</a></li>
					<li> / </li>
					<li><a href="">Product</a></li>
				</ul>
			</div> <!-- End of Breadcrumb-->

			<div class="single-product">
				<div class="images-section">
					<div class="larg-img">
						<img src="img/p_images/<?php echo $get_p_id . "/" . $firstImage; ?>">
					</div>
					<div class="small-img">

						<?php while ($row_p_img = $result_p_img->fetch_assoc()) { ?>
							<a class="fancybox" rel="group" href="img/p_images/<?php echo $get_p_id . "/" . $row_p_img['image_name']; ?>">
								<img src="img/p_images/<?php echo $get_p_id . "/" . $row_p_img['image_name']; ?>">
							</a>

						<?php } ?>
					</div>
				</div> <!-- End of Images Section-->

				<div class="product-detail">
					<div class="product-name">
						<h2><?php echo $row['p_name']; ?></h2>
					</div>
					<div class="product-price">
						<h3>₹<?php echo $row['p_price']; ?>/month</h3>
					</div>
					<hr>
					<div class="product-meta">
						<p><b>Category: </b> <?php echo $row_category['cat_name']; ?></p>
					</div>
					<div class="product-meta">
						<p><b>Size: </b> <?php echo $row['size']; ?></p>
					</div>
					<div class="product-meta">
						<p><b>AC: </b> <?php echo ($row['ac']) ? "Available" : "Not available"; ?></p>
					</div>
					<div class="product-meta">
						<p><b>Status: </b> <?php echo ($row['status']) ? "Available" : "Not available"; ?></p>
					</div>
				</div> <!-- End of Product Detail-->
			</div>
			<hr>
			<div class="product-long-description">
				<h3>Product Description</h3>
				<p><?php echo $row['description']; ?></p>
			</div>
			<hr>
			<div class="new-product-section">
				<div class="product-section-heading">
					<h2>Recommend Products <img src="img/icons/good_quality.png"></h2>
					<h3>OUR BEST PRODUCTS RECOMMENDED FOR YOU</h3>
				</div>
				<div class="product-content">
					<?php
					if ($result_featured->num_rows > 0) {
						while ($row_featured = $result_featured->fetch_assoc()) {
					?>
							<div class="product">
								<a href="product.php?id=<?php echo $row_featured['p_id']; ?>">
									<img src="img/p_images/<?php echo $row_featured['p_id'] . "/" . $row_featured['image']; ?>">
								</a>
								<div class="product-detail">
									<h3><?php echo $row_featured['p_id']; ?></h3>
									<h2><?php echo $row_featured['p_name']; ?></h2>
									<a href="product.php?id=<?php echo $row_featured['p_id']; ?>">View</a>
									<p>₹<?php echo $row_featured['p_price']; ?>/-</p>
								</div>
							</div>
					<?php }
					} else {
						echo "No Recommended Products";
					} ?>
				</div>
			</div> <!-- Recommend Product Section -->
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


	<script>
		$(".carousel1").owlCarousel({
			margin: 20,
			loop: true,
			autoplay: true,
			autoplayTimeout: 3000,
			autoplayHoverPause: true,
			responsive: {
				0: {
					items: 1,
					nav: false
				}
			}
		});
	</script>
</body>

</html>