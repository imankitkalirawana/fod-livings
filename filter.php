<?php
// filter.php

include_once("config.php");

$minPrice = $_POST['minPrice'];
$maxPrice = $_POST['maxPrice'];

// Prepare and execute the filtered query
$stmp_filtered = $link->prepare("SELECT * FROM products WHERE discount_price BETWEEN ? AND ?");
$stmp_filtered->bind_param("ii", $minPrice, $maxPrice);
$stmp_filtered->execute();
$result_filtered = $stmp_filtered->get_result();

// Generate the filtered result HTML
$output = '';
while ($row = $result_filtered->fetch_assoc()) {
    $originalPrice = $row['original_price'];
    $discountPrice = $row['discount_price'];
    $discountPercentage = round(($originalPrice - $discountPrice) / $originalPrice * 100);
    // Build the HTML for each filtered product
    $output .= '<a href="product.php?id=' . $row['p_id'] . '" class="row-item">
    <div class="row-img">
        <img src="/img/p_images/' . $row['p_id'] . '/' . $row['image'] . '" alt="">
        <div class="row-wishlist">
            <i class="fa-regular fa-heart"></i>
        </div>
    </div>
    <div class="row-details">
        <div class="row-details-heading">
            <h3>' . $row['p_name'] . '</h3>
        </div>
        <div class="row-price">
            <div class="row-price-left">
                <span class="discount-price">₹' . $row['discount_price'] . '</span>
                <span class="original-price">₹' . $row['original_price'] . '</span>
            </div>
            <div class="row-price-right">
                <span class="discount-percent">' . $discountPercentage . '% Off</span>
            </div>
        </div>
    </div>
</a>';
}

echo $output;


?>

<!-- <a href="product.php?id=<?php echo $row['p_id']; ?>" class="row-item">
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
                        </a> -->