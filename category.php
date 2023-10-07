<?php
include_once("config.php");

$get_cat_id = $_GET['id'];


$stmp = $link->prepare("SELECT * FROM products where cat_id = ? and status = 1");
$stmp->bind_param("i", $get_cat_id);
$stmp->execute();
$result = $stmp->get_result();

$stmp_category = $link->prepare("SELECT * FROM pg_category where cat_id = ?");
$stmp_category->bind_param("i", $get_cat_id);
$stmp_category->execute();
$result_category = $stmp_category->get_result();
$row_cat = $result_category->fetch_assoc();



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta name="author" content="imankitkalirawana">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title>Category - FOD Livings</title>
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
        <main>


            <div class="row-container">
                <div class="row-heading">
                    <h3><?php echo $row_cat['cat_name']; ?> Rooms</h3>
                </div>
                <div class="row">
                    <?php
                    if ($result->num_rows > 0) {

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
                    <?php
                        }
                    } else {
                        echo "No " . $row_cat['cat_name'] . " room found";
                    }
                    ?>
                </div>
            </div>
        </main> <!-- Main Area -->
    </div>

</body>

</html>