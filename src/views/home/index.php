<?php

require_once ROOT . "/src/views/inc/start.php";



//variables

$carousel_ads = $data["carousel_ads"];

$banner_ads = $data["banner_ads"];

$vertical_ads = $data["vertical_ads"];

?>



<main class="bg-lightgray">



    <!-- carousel ads -->

    <?php

    if ($carousel_ads) {

        echo '

            <section class="d-flex-center">

                <div class="js-carousel-pages p-relative h-30 w-p-100 ov-x-hidden">

                    <div class="js-slider d-flex flex-no-wrap">

            ';

        foreach ($carousel_ads as $ad) {

            //variables

            $product_id = $ad["product_id"];

            $image_src = "img/ads/" . $ad['image_name'];



            //render

            echo '<a href="products/product_details?id=' . $product_id . '" class="js-item bg-img bg-bottom h-30 w-p-100" style="background-image : url(' . $image_src . ')"></a>';
        }



        //render last ad

        $last_ad = $carousel_ads[0];

        $product_id = $last_ad["product_id"];

        $image_src = "img/ads/" . $last_ad['image_name'];

        echo '<a href="products/product_details?id=' . $product_id . '" class="js-item bg-img bg-bottom h-30 w-p-100" style="background-image : url(' . $image_src . ')"></a>';



        //close slider

        echo '</div>';



        //carousel buttons

        echo '

        <div class="js-pagination-container p-absolute b-0 l-0 r-0 pb-2 d-flex-center">';

        for ($i = 0; $i < count($carousel_ads); $i++) {

            echo '<div data-index=' . $i . ' class="js-pagination mx-2 h-1 b-gray b-radius-small w-3 h-pointer"></div>';
        }

        echo '</div>';



        //close section

        echo '

                </div>

            </section>

            ';
    }

    ?>



    <!-- section categories -->

    <section class="d-flex-vertical m-auto w-p-70">

        <!-- first row -->

        <div class="d-flex">

            <?php

            $categories = [

                ["span" => translator("jeux et consoles", "games & consoles"), "value" => "games"],

                ["span" => translator("telephones et tablettes", "phones & tablets"), "value" => "phones"],

                ["span" => translator("ordinateurs", "computers"), "value" => "computers"],

            ];

            foreach ($categories as $category) {

                $span = $category["span"];

                $value = $category["value"];

                echo '

                <a href="products/filter_products?category=' . $value . '" class="d-block flex-1 d-flex-vertical m-1 bg-white">

                    <div class="t-center py-2 t-3  t-capitalize">' . $span . '</div>

                     <div class="bg-' . $value . ' bg-img h-20"></div>

                     <div class="t-link p-2">' . translator("decouvrir", "see more") . '</div>

                </a>

                ';
            }

            ?>

        </div>



        <!-- second row -->

        <div class="d-flex">

            <?php

            $categories = [

                ["span" => translator("materiel informatique", "hardwares"), "value" => "hardwares"],

                ["span" => translator("ecrans", "monitors"), "value" => "monitors"],

                ["span" => translator("autres gadgets", "other gadgets"), "value" => "others"],

            ];

            foreach ($categories as $category) {

                $span = $category["span"];

                $value = $category["value"];

                echo '

                <a href="products/filter_products?category=' . $value . '" class="d-block flex-1 d-flex-vertical m-1 bg-white">

                    <div class="t-center py-2 t-3  t-capitalize">' . $span . '</div>

                     <div class="bg-' . $value . ' bg-img h-20"></div>

                     <div class="t-link p-2">' . translator("decouvrir", "see more") . '</div>

                </a>

                ';
            }

            ?>

        </div>

    </section>



    <!-- section about us -->

    <section class="mt-2 m-auto w-p-90 d-flex">

        <?php

        $infos = [

            ["link" => "about_us#delivery", "span" => translator("livraison gratuite a partir de 1000 dhs", "free delivery starting from 1000 dhs"), "image_src" => "img/icons/delivery.jpg"],

            ["link" => "about_us#payment", "span" => translator("paiement a la livraison", "pay on delivery"), "image_src" => "img/icons/cash.jpg"],

            ["link" => "about_us#refund", "span" => translator("satisfait ou remboursé", "satisfied or refunded"), "image_src" => "img/icons/satisfied.jpg"],

        ];



        foreach ($infos as $info) {

            //variables

            $link = $info["link"];

            $span = $info["span"];

            $image_src = $info["image_src"];

            echo '

            <a href="' . $link . '" class="flex-1 d-flex p-2 h-pointer mx-2 bg-white">

                    <div class="flex-1 d-flex-center">

                            <img src="' . $image_src . '" class="h-10" />

                    </div>

                    <div class="flex-1 p-3 t-center">

                        <div>

                            <span class="t-3 t-capitalize">' . $span . '</span>

                        </div>

                        <div class="pt-1">

                            <span class="t-gray t-1">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Asperiores earum incidunt deleniti!</span>

                        </div>    

                    </div>

            </a>

            ';
        }

        ?>

    </section>



    <!-- section best deals -->

    <section class="w-p-90 m-auto mt-2">

        <?php

        render_items_carousel(translator("nos meilleures offres", "our best deals of the week"), "products/filter_products?ranking=promotion", $data["best_deals"])

        ?>

    </section>



    <!-- section banner ad -->

    <section class="mt-2 w-p-90 m-auto">

        <?php

        banner_ad($banner_ads[2])

        ?>

    </section>



    <!-- section video games -->

    <section class="mt-2 m-auto w-p-90">

        <?php

        render_items_carousel(translator("jeux et consoles", "games & consoles"), "products/filter_products?category=games&ranking=rating", $data["best_games"])

        ?>

    </section>



    <!-- section banner ad -->

    <section class="mt-2 w-p-90 m-auto">

        <?php

        banner_ad($banner_ads[0]);

        ?>

    </section>



    <!-- section cheap -->

    <div class="w-p-90 m-auto mt-2">

        <?php

        render_items_carousel(translator("moins cher", "cheapest"), "products/filter_products?ranking=low_price", $data["cheapest"])

        ?>

    </div>



    <!-- section sign in -->

    <?php

    if (!isset($_SESSION["user_id"])) {

        echo '

        <div class="pt-4">

            <div class="t-4 t-center t-capitalize">

                <span>' . translator("connectez vous pour une meilleur experience", "sign in for better user experience") . ' !!!</span>

            </div>

            <div class="d-flex-center pt-2">

                <a href="auth/sign_in_form" class="btn-large btn-primary">' . translator("se connecter", "sign in") . '</a>

            </div>

            <div class="t-center  t-capitalize py-2">

                <a href="auth/sign_up_form" class="t-link">' . translator("je n'ai pas de compte", "i don't have an account") . '</a>

            </div>

        </div>

        ';
    }

    ?>



    <!-- section newsletter -->

    <section class="m-auto w-p-90 my-2">

        <form action="users/register_to_news" class="d-flex bg-white d-flex a-center p-4 b-radius-small">

            <span class="t-capitalize pr-2">

                <?php

                echo translator("abonnez vous a notre newsletter", "subscribe to our newsletter")

                ?>

                :</span>



            <?php

            echo '<input type="email" name="email" class="p-1 flex-1" placeholder="' . translator("entrez votre email", "enter your email") . '">'

            ?>



            <button type="submit" class="btn-primary btn-small">

                <?php

                echo translator("s'abonner", "subscribe")

                ?>

            </button>

        </form>

    </section>



    <!-- back to top -->

    <?php

    back_to_top();

    ?>

</main>

<?php

require_once ROOT . "/src/views/inc/end.php";

?>