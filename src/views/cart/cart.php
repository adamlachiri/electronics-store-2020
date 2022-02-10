<?php
require_once ROOT . "/src/views/inc/start.php";
//variables
$cart = $data["cart"];
?>

<main class="p-2">

    <?php
    if (count($cart) > 0) {
        echo '
        <span class="t-5 t-capitalize">' . translator("votre pannier", "your shopping cart") . '</span>
        <hr class="my-3">
        <div class="d-flex">
        ';

        echo '<form action="cart/confirm_cart" class="w-p-100" method="post">';

        foreach ($cart as $key => $product) {
            //variables
            $name = $product["name"];
            $coupon_code = $product["coupon_code"];
            $coupon_reduction = $product["coupon_reduction"];
            $image_src = "img/products/" . $product["image_1"];
            $product_id = $product["id"];
            $promotion = $product["promotion"];
            $price = explode(".", $product["price"]);
            $price_int = $price[0];
            $price_dec = $price[1];
            $original_price = $product["original_price"];
            $limit = $product["quantity"] <= 10 ? $product["quantity"] : 10;

            //session variables
            foreach ($_SESSION["cart"] as $item) {
                if ($product_id == $item["product_id"]) {
                    $order_quantity = $item["quantity"];
                    $user_coupon_code = $item["coupon_code"];
                    break;
                }
            }


            //cart item design
            echo '
            <div class="js-cart-item d-flex" data-id="' . $product_id . '" data-price="' . $product['price'] . '" data-reduction="' . $coupon_reduction . '">

                <div class="w-15 h-10 d-flex-center mr-3">
                    <img src="' . $image_src . '" class="h-max-10 w-max-15 pr-2">
                </div>
                
                <div class="p-1 flex-1 d-flex-vertical">
                    <div class="t-capitalize d-flex j-between">
                        <a href="products/product_details?id=' . $product_id . '" class="h-pointer h-t-warning t-3"  title="' . translator("voir details", "see details") . '">' . $name . '</a>
                        <div class="t-nowrap pl-4">
                            <span class="t-bold t-capitalize pr-1">' . translator("sous total", "sub total") . ' : </span>
                            <span class="js-sub-total t-4 t-bold"></span>
                            <span> Dhs</span>
                        </div> 
                    </div>
                    <div class="pt-1">
                        <span class="t-darkgray">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Assumenda, voluptatibus!</span>
                    </div>
                    <div class="pt-1">
                        <span class="t-bold t-capitalize pr-1">' . translator("prix unité", "unit price") . ' : </span>
                        <span class="t-3 js-unit-price">' . $product['price'] . '</span>
                        <span> Dhs</span>
                    </div>
                    ';

            //stock almost empty sign
            if ($product["quantity"] <= 10) {
                echo '<div class="t-warning py-1">
                    <span>' . translator("seulement", "only") . ' ' . $product["quantity"] . ' ' . translator("restant", "left") . '</span>
                    </div>';
            }

            //quantity
            echo '
                        <div class="pt-2 d-flex a-center j-between">
                            <div>
                                <span class="t-bold t-capitalize pr-1">' . translator("quantité", "quantity") . ' : </span>
                                <select class="js-quantity h-pointer px-1 mr-2 bg-lightgray t-2 b-radius-small w-4 b-black" name="quantity_' . $product_id . '">';
            for ($i = 1; $i <= $limit; $i++) {
                echo '<option value="' . $i . '"';
                echo $order_quantity == $i ? ' selected ' : '';
                echo '>' . $i . '</option>';
            }
            echo '
                                </select>
                                </div>';
            //remove btn
            echo '                
                            <div>
                                <a href="cart/remove_from_cart?product_id=' . $product_id . '" class="btn-small btn-secondary">' . translator("supprimer", "remove") . '</a>
                            </div>
                        </div>';
            //coupon
            if ($coupon_code) {
                echo '
                <div class="pt-1">
                    <span class="t-bold t-capitalize pr-1">' . translator("entrez le code du coupon pour ", "enter coupon code for ") . ' <span class="t-success">' . $coupon_reduction . '%</span> reduction :</span>';
                echo isset($_SESSION["user_id"]) ?
                    '<input type="text" name="coupon_code_' . $product_id . '" value="' . $user_coupon_code . '" class="p-1 js-coupon">' :
                    '<span class="t-warning">' . translator("connectez vous pour entrer le code", "sign in to enter the code") . '</span>';

                echo '<i class="fas fa-check-circle t-success t-3 ml-1 t-4 js-coupon-validation d-none"></i>
                    <img class="js-coupon-loading d-none h-1 ml-1" src="img/gifs/loading.gif">
                </div>';
            }
            //closing
            echo '
                </div>
                </div>
                <hr class="my-2">
                ';
        }

        //total price
        echo '
        <div class="t-center pt-5 t-2">
            <div class="t-darkgray pt-1">
                <span>price HT :</span>
                <span class="js-HT"></span>
                <span>DH</span>
            </div>
            <div class="t-darkgray pt-1">
                <span>tax : 20%</span>
            </div>
            <div class="pt-1">
                total : 
                <span class="js-total t-4 t-warning t-bold"></span>
                <span class="t-warning">DH</span>
            </div>
            <div class="pt-1 t-darkgray">
            ' . translator("les frais de transport seront ajoutés aprés avoir completé vos informations personnelles", "transport fees will be added after you give us your delivery address") . '
                
            </div>
        </div>
        <div class="pt-5">';

        //check if logged
        echo  isset($_SESSION["user_id"]) ?
            '<div class="d-flex-center">
           <button class="t-capitalize btn-primary btn-large" type="submit">' . translator("suivant", "next") . ' >></button>
           <div>'
            :
            '<div class="d-flex-center">
            <a href="auth/sign_in_form" class="btn-large btn-primary t-capitalize">' . translator("connectez vous pour achetez", "sign in to buy") . '</a>
            </div>
            <div class="d-flex-center pt-2"><a href="auth/sign_up_form" class=" t-center t-link t-capitalize" title="register account">' . translator("je n'ai pas de compte", "i don't have an account") . '</a></div>';
        echo '</div></form>';
    }
    //cart is empty
    else {
        echo '
        <div class="d-flex-center pt-5">
            <img src="img/others/empty-cart.png">
        </div>
        <div class="t-5 t-center t-capitalize pt-5 pb-3">
            <span>' . translator("votre pannier est vide, essayez de rajoutez des produits", "your cart is empty, try adding some products") . '</span>
        </div>
        ';
    }
    ?>
</main>

<?php
require_once ROOT . "/src/views/inc/end.php";
?>