<?php
include_once("config.php");

$stmp_all = $link->prepare("SELECT * FROM products limit 2");
$stmp_all->execute();
$result = $stmp_all->get_result();

$stmp_featured = $link->prepare("SELECT * FROM products where status = 1 limit 6");
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
    <title>FOD Livings</title>
    <!-- Style Sheet -->
    <link rel="stylesheet" type="text/css" href="/css/theme.css" />
    <link rel="stylesheet" type="text/css" href="/css/common.css" />
    <link rel="stylesheet" type="text/css" href="/css/style.css" />

    <script src="js/script.js" defer></script>

    <!-- Javascript -->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" href="https://pro.Fontawesome.com/releases/v6.0.0-beta3/css/all.css">
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.11/typed.min.js"></script>
</head>

<body>

    <?php include("header.php") ?>



    <div class="container">
        <div class="search-container">
            <form action="" class="search">
                <div class="input">
                    <label class="label">
                        <i class="fa-regular fa-magnifying-glass"></i>
                        <input type="text" name="search" placeholder="Search">
                    </label>
                </div>
            </form>
        </div>
        <main>
            <div class="row-container row-offers">
                <div class="row-heading">
                    <h3>Special Offers</h3>
                    <a href="#">See All</a>
                </div>
                <div class="row">
                    <div class="row-item">
                        <div class="row-text">
                            <h1 class="row-text-1">30% OFF</h1>
                            <h3 class="row-text-2">on your first order</h3>
                            <a href="#" class="row-btn">Explore</a>
                        </div>
                    </div>
                    <div class="row-item">
                        <div class="row-text">
                            <h1 class="row-text-1">10% OFF</h1>
                            <h3 class="row-text-2">using hdfc credit card</h3>
                            <a href="#" class="row-btn">Explore</a>
                        </div>
                    </div>
                    <div class="row-item">
                        <div class="row-text">
                            <h1 class="row-text-1">20% OFF</h1>
                            <h3 class="row-text-2">for first 50 bookings</h3>
                            <a href="#" class="row-btn">Explore</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-container row-featured">
                <div class="row-heading">
                    <h3>Featured Rooms</h3>
                    <a href="/shop.php">See All</a>
                </div>
                <div class="row">
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
            </div>
            <div class="row-container row-category">
                <div class="row-heading">
                    <h3>View By Category</h3>
                </div>
                <div class="row">
                    <?php
                    while ($row_category = $result_category->fetch_assoc()) { ?>
                        <div class="row-item">
                            <div class="row-text">
                                <h1 class="row-text-1"><?php echo $row_category['cat_name']; ?></h1>
                                <a href="category.php?id=<?php echo $row_category['cat_id']; ?>" class="row-btn">Explore</a>
                            </div>
                        </div>
                    <?php }
                    ?>
                </div>
            </div>
        </main>


        <!-- <main>
        

            <div class=" new-product-section">
                        <div class="product-section-heading">
                            <h2>Available Rooms<img src="img/icons/increase.png"></h2>
                            <h3>Location: Law Gate</h3>
                        </div>
                        <div class="product-content">

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
                        </div>
                    </div>

                    <div class="collection">
                        <a href="/category.php?id=2" class="men-collection">
                            <h2>Budget <br>Rooms</h2>
                        </a>
                        <a href="/category.php?id=1" class="women-collection">
                            <h2>Luxurious <br>Rooms</h2>
                        </a>
                    </div>

                    <div class="new-product-section">
                        <div class="product-section-heading">
                            <h2>Categories <img src="img/icons/good_quality.png"></h2>
                            <h3>OUR BEST PRODUCTS RECOMMENDED FOR YOU</h3>
                        </div>
                        <div class="product-content">

                            <?php while ($row_category = $result_category->fetch_assoc()) { ?>
                                <div class="product">
                                    <a href="category.php?id=<?php echo $row_category['cat_id']; ?>">
                                        <img src="img/category/<?php echo $row_category['cat_image']; ?>">
                                    </a>
                                    <div class="product-detail">
                                        <h2><?php echo $row_category['cat_name']; ?></h2>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
        </main> -->
    </div>

</body>

</html>