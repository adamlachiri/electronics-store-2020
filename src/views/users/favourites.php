<?php
require_once ROOT . "/src/views/inc/start.php";
?>

<main class="pb-10">

    <!-- title -->
    <div class="py-4 t-center">
        <span class="t-capitalize t-6">
            <?php
            echo translator("vos produits favoris", "your favourite products");
            ?>
        </span>
    </div>

    <!-- section favourites -->
    <section class="m-auto w-p-80">
        <?php
        if (count($data["products"]) == 0) {
            echo '
            <div class="d-flex-center pt-5">
                <img src="img/icons/empty.png">
            </div>
            <div class="t-center pt-5">
                <span class="t-capitalize t-4">' . translator("vous n'avez pas de produit favoris, rajoutez en !!", "you have no favourite products, add some !!") . '</span>
            </div>    
            ';
        } else {
            foreach ($data["products"] as $product) {
                //variables
                $image_src = "img/products/" . $product["image_1"];
                $name = $product["name"];
                $price = $product["price"];
                $quantity = $product["quantity"];
                $rating = $product["rating"];
                $product_id = $product["id"];

                echo '
                <section class="d-flex pt-4">
                    <div class="w-15 d-flex-center p-2">
                        <img src="' . $image_src . '" class="img-fluid h-max-15">
                    </div>
                    <div class="flex-1 pl-4 d-flex-vertical j-center">

                        <div>
                            <a href="products/product_details?id=' . $product_id . '" class="t-3 t-capitalize h-t-warning">' . $name . '</a>
                        </div>';

                // rating
                if ($rating) {
                    echo '<div class="t-warning pt-2">';
                    echo render_stars($rating) . '<span class="pl-1">' . $rating . '</span>';
                    echo '</div>';
                }

                // stock situation
                echo '<div class="pt-2 t-capitalize">';
                if ($quantity == 0) {
                    echo '<span class="t-gray">' . translator("indisponible en stock", "out of stock") . '</span>';
                } elseif ($quantity <= 10) {
                    echo '<span class="t-warning">' . translator("seulement", "only") . ' ' . $quantity . ' ' . translator("restant", "left") . ' !</span>';
                } else {
                    echo '<span class="t-gray">' . translator("en stock", "in stock") . '</span>';
                }
                echo '</div>';

                echo '  <div class="pt-2">
                            <span class="t-bold t-3">' . $price . ' Dhs</span>
                        </div>  
                    </div>';

                //buttons
                echo ' 
                    <div class="flex-1 p-2 d-flex-vertical j-center">
 
                            <div class="d-flex-center">';
                //add to cart
                if ($quantity > 0) {
                    $found = false;
                    if (isset($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $item) {
                            if ($item["product_id"] === $product_id) {
                                $found = true;
                                break;
                            }
                        }
                    }

                    //display button
                    echo $found ? '
                    <a href="cart/remove_from_cart?product_id=' . $product_id . '" class="btn-large btn-secondary">' . translator("enlever du panier", "remove from cart") . '</a>'
                        :
                        '<a href="cart/add_to_cart?product_id=' . $product_id . '" class="btn-large btn-primary">' . translator("rajouter au panier", "add to cart") . '<i class="pl-1 fas fa-cart-plus"></i></a>';
                }
                echo '            </div>';

                // remove from favourite
                echo '
                <div class="pt-2 d-flex-center">
                    <a href="users/remove_from_favourites?product_id=' . $product_id . '" class="btn-medium btn-secondary">
                    <i class="far fa-heart pr-1 t-3"></i>';
                echo translator("suprimer des favoris", "remove from favourites");
                echo '</a>
                </div>
                ';

                echo '  
                    </div>
                </section>
                <hr class="mt-2">
                ';
            }
        }
        ?>

    </section>

</main>

<?php
require_once ROOT . "/src/views/inc/end.php";
?>