<?php
require_once ROOT . "/src/views/inc/start.php";
//variables
$products = $data["products"];
$vertical_ads = $data["ads"];
$cart = $data["cart"];
?>

<main class="d-flex">
    <!-- section side bar -->
    <?php
    require_once ROOT . "/src/views/inc/products_sidebar.php";
    ?>

    <!-- section products -->
    <section class="flex-1 bg-white">
        <?php
        //found products
        if (count($products)) {
            //section ranking
            echo '<section class="d-flex a-center j-between p-2 t-capitalize">';
            // results
            require ROOT . "/src/views/inc/pagination_results.php";
            //ranking options
            echo '<div>
        <span class="pr-2">' . translator("classer par", "sort by") . '</span>
        <select form="default-form" name="ranking" class="js-default-target">';
            $rankings = [
                ["value" => "rating", "span" => translator("évaluation", "rating")],
                ["value" => "low_price", "span" => translator("prix croissant", "low price to hight")],
                ["value" => "high_price", "span" => translator("prix decroissant", "hight price to low")],
                ["value" => "name", "span" => translator("nom", "name")],
                ["value" => "promotion", "span" => translator("meilleur offres", "best deals")],
                ["value" => "total_sells", "span" => translator("nombre de ventes", "highest sells")]
            ];
            foreach ($rankings as $ranking) {
                //variables
                $value = $ranking["value"];
                $span = $ranking["span"];

                echo '<option class="p-1" value="' . $value . '"';
                echo isset($_GET['ranking']) &&  $_GET['ranking'] == $value ?
                    ' selected>' : '>';
                echo $span . '</option>';
            }
            echo '
                </select>
            </div>
        </section>
        <hr>
        ';

            //products
            foreach ($products as $product) {

                // variables
                $product_id = $product['id'];
                $product_name = $product['name'];
                $promotion = $product['promotion'];
                $price = explode(".", $product['price']);
                $price_int = $price[0];
                $price_dec = $price[1];
                $original_price = $product['original_price'];
                $rating = $product['rating'];
                $total_reviews = $product['total_reviews'];
                $quantity = $product['quantity'];
                $image_src = "img/products/" . $product['image_1'];

                echo '<div class="d-flex">
                    <div class="d-flex-center h-15 w-25">
                        <a href="products/product_details?id=' . $product_id . '">
                        <img src="' . $image_src . '" alt="" title="' . $product_name . '" class="w-max-20 h-max-10">
                        </a>
                    </div>
                    <div class="pl-5 p-2">
                    <a href="products/product_details?id=' . $product_id . '" class="h-t-warning t-3 d-block t-capitalize" title="see more">' . $product_name . '</a>';
                //check rating
                if ($rating) {
                    echo '<div class="pt-1">
                            <a href="products/product_details?id=' . $product_id . '#reviews" class="t-warning" title="' . translator("voir plus", "see more") . '">';
                    render_stars($rating);
                    echo '
                            </a>
                            <span class="pl-1 t-small t-warning">' . $rating . '</span>
                            <span class="pl-1 t-small">(' . $total_reviews . ' ' . translator("evaluations", "reviews") . ')</span>
                            </div>';
                }

                //stock
                echo '<div class="pt-1">';
                if ($quantity == 0) {
                    echo '<span class="t-alert">' . translator("indisponible", "out of stock") . '</span>';
                } elseif ($quantity <= 10) {
                    echo '<span class="t-warning">' . translator("seulement", "only") . ' ' . $quantity . ' ' . translator("restant", "left") . ' !</span>';
                } else {
                    echo '<span class="t-gray t-capitalize">' . translator("en stock", "in stock") . '</span>';
                }
                echo '</div>';

                //price
                echo ' <div class="pt-3">
                        <span class="t-4 t-bold">' . $price_int . '</span>
                        <span>.' . $price_dec . ' Dhs</span>';
                //promotion
                if ($promotion) {
                    echo '<span class="t-gray t-1 t-through pl-1">' . $original_price . ' Dhs</span>
                            <span class="ml-2 px-2 t-capitalize bg-secondary">' . translator("economisez", "save") . ' ' . $promotion . ' %</span>
                            ';
                }
                echo '</div>';

                //resume
                echo '   
                    </div>
                    </div>
                    <hr>';
            }
        }

        //no products found
        else {
            echo '
                    <div class="d-flex-center pt-10">
                        <img src="img/others/empty-box.png" class="w-20">
                    </div>
                    <div class="t-center pt-2">
                        <span class="t-5 t-capitalize">' . translator("pas de produit trouvé", "sorry, no products found") . ' ...</span>
                    </div>
                    ';
        }
        ?>


        <!-- section pagination -->
        <?php
        require ROOT . "/src/views/inc/pagination.php";
        ?>

    </section>

    <!-- section cart carousel -->
    <section>
        <?php
        if ($cart) {
            render_items_carousel_vertical(translator("votre panier", "your cart"), "cart", $cart);
        }
        ?>
    </section>



</main>

<?php
back_to_top();
?>

<?php
require_once ROOT . "/src/views/inc/end.php";
?>