<?php

require_once ROOT . "/src/views/inc/start.php";



//variables

$product = $data["product"];

$similar_products = $data["similar_products"];

$product_id = $product["id"];

$coupon_reduction = $product["coupon_reduction"];

$name = $product["name"];

$video_src = $product["video_src"];

$category = $product["category"];

$rating = $product["rating"];

$quantity = $product["quantity"];

$total_reviews = $product["total_reviews"];

$price = explode(".", $product['price']);

$price_int = $price[0];

$price_dec = $price[1];

$original_price = $product['original_price'];

$promotion = $product['promotion'];

$guarantee = $product['guarantee'];

$reviews = $data["reviews"];

$banner_ads = $data["banner_ads"];

$vertical_ads = $data["vertical_ads"];



//get image sources

$images = ["image_1", "image_2", "image_3", "image_4", "image_5"];

$sources = [];

foreach ($images as $image) {

    if ($product[$image]) {

        array_push($sources, "img/products/" . $product[$image]);
    }
}

?>



<main>



    <!-- section details -->

    <section class="d-flex p-2 flex-wrap">

        <!-- section 1 -->

        <section class="pr-5">



            <!-- guarantee -->

            <div class="pt-2">

                <?php

                if ($guarantee) {

                    $guarantee_src = 'img/icons/guarantee-' . $guarantee . '.png';

                    echo '<img src="' . $guarantee_src . '" class="h-7">';
                }

                ?>

            </div>



            <!-- image -->

            <div class="d-flex pt-4">

                <!-- select images -->

                <div>

                    <?php

                    foreach ($sources as $image_src) {

                        echo '

                        <img src="' . $image_src . '" alt="" title="' . translator("selectione", "select") . '" class="d-block w-3 b-gray my-1 js-small-image js-open-window h-pointer">

                        ';
                    }

                    ?>

                </div>



                <!-- selected image -->

                <div class="d-flex-center w-25 h-25 pl-2">

                    <?php

                    echo '<img src="' . $sources[0] . '" alt="" title="zoom in" class=" img-fluid js-medium-image js-open-window h-pointer">';

                    ?>

                </div>

            </div>



            <!-- add to favourites -->

            <div class="d-flex-center pt-4">

                <?php

                if (isset($_SESSION["user_favourites"])) {

                    if (!in_array($product_id, $_SESSION["user_favourites"])) {

                        echo '

            <a href="users/add_to_favourites?product_id=' . $product_id . '" class="btn-medium btn-secondary">

                    <i class="far fa-heart pr-1 t-3"></i>';

                        echo translator("rajouter aux favoris", "add to favourites");

                        echo '</a>';
                    }
                } else {

                    echo '

                    <a href="auth/sign_in_form" class="btn-medium btn-secondary">

                    <i class="far fa-heart pr-1 t-3"></i>';

                    echo translator("rajouter aux favoris", "add to favourites");

                    echo '</a>';
                }

                ?>

            </div>

        </section>







        <!-- section 2 -->

        <div class="flex-1">

            <!-- name -->

            <div>

                <span class="t-5 t-bold t-capitalize">

                    <?php

                    echo $name;

                    ?>

                </span>

            </div>



            <!-- link to parent site -->

            <div class="pt-1 ">

                <?php

                echo '<a href="#" class="t-link">' . translator("visiter le site du produit pour en savoir plus", "visit product site for more") . '</a>'

                ?>



            </div>



            <!-- rating -->

            <?php

            if ($rating) {

                echo '

                    <div class="pt-1">

                    <a href="' . $_SERVER['REQUEST_URI'] . '#reviews" class="t-warning" title="' . translator("voir les evaluations", "see reviews") . '">';

                render_stars($rating);

                echo '

                    </a>

                    <span class="pl-1 t-warning">' . $rating . '</span>

                <span class="pl-1">(' . translator("de la part de", "from") . ' ' . $total_reviews . ' ' . translator("evaluateurs", "reviewers") . ')</span>

                </div>';
            }

            ?>







            <!-- stock situation -->

            <div class="t-capitalize pt-1 ">

                <?php

                if ($quantity == 0) {

                    echo '<span class="t-alert">' . translator("indisponible", "out of stock") . '</span>';
                } elseif ($quantity <= 10) {

                    echo '<span class="t-warning">' . translator("seulement", "only") . ' ' . $quantity . ' ' . translator("restant", "left") . ' !</span>';
                } else {

                    echo '<span class="t-gray">' . translator("en stock", "in stock") . '</span>';
                }

                ?>

            </div>



            <!-- guarantee -->

            <?php

            if ($guarantee) {

                echo '

                <div class="pt-1 t-capitalize t-gray">

                <span>' . $guarantee . ' ' . translator("mois de guarantie", "months guarantee") . ' !!</span>

                </div>

                ';
            }

            ?>



            <!-- coupon -->

            <?php

            if ($coupon_reduction) {

                echo '

                <div class="pt-1 t-capitalize">

                    <span class="t-green">' . translator("avec coupon pour", "with coupon for") . ' <span class="t-warning">' . $coupon_reduction . '%</span> reduction</span>

                </div>

                ';
            }

            ?>



            <hr class="mt-2">



            <!-- price -->

            <div class="d-flex a-center j-between pt-2">

                <div>

                    <?php

                    echo '<span class="t-6 t-warning t-bold">' . $price_int . '</span>

                        <span class=" t-warning">.' . $price_dec . ' Dhs</span>';

                    ?>

                    <?php

                    if ($promotion) {

                        echo '<span class="t-gray t-through pl-1">' . $original_price . ' Dhs</span>

                        <span class="ml-2 px-2 t-capitalize bg-secondary">' . translator("economisez", "save") . ' ' . $promotion . ' %</span>

                        ';
                    }

                    ?>

                </div>



                <!-- add to cart -->

                <div class="pr-2">

                    <?php

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

                    ?>

                </div>



            </div>

            <hr class="mt-2">



            <!-- description -->

            <div class="pt-1  w-p-60">

                <div class="pb-2 t-3">

                    <span class="t-capitalize">

                        <?php

                        echo translator("description du produit", "product description");

                        ?> :</span>

                </div>

                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eaque, optio? Debitis quod voluptate

                    adipisci ipsa quisquam fugit accusamus, accusantium dolor id omnis unde assumenda. Delectus numquam

                </p>

                <p class="pt-1">

                    molestias, asperiores dolores corporis, totam temporibus autem neque, eos dolor debitis nisi ducimus

                    odio molestiae similique consectetur dignissimos veniam quae distinctio quia sint consequatur?</p>

                <p class="pt-1">



                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea commodi aut aliquam quae voluptatibus

                    quas, voluptatum, nihil assumenda esse eaque placeat accusantium inventore rerum excepturi nostrum,</p>

                <p class="pt-1">

                    quidem iste quaerat tempore! Dolorum, temporibus vero? Nisi sunt illo molestias quibusdam voluptatem

                    iste, distinctio autem unde alias suscipit dolore assumenda cupiditate aut saepe quae amet aperiam

                    odit illum iusto exercitationem repudiandae eos nesciunt! Voluptatibus excepturi numquam qui</p>

                <p class="pt-1">

                    dignissimos, temporibus aliquid. At quam et voluptatem illo veritatis cupiditate itaque ipsa,

                    voluptate ullam, atque labore!</p>

            </div>



            <!-- video -->

            <?php

            if ($video_src) {

                echo '

                <div class="pt-2">

                    <iframe class="youtube-video" src="' . $video_src . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen autoplay></iframe>

                </div>

                ';
            }

            ?>





            <!-- admin link -->

            <?php

            if (isset($_SESSION["user_id"]) && $_SESSION["user_type"] === "admin") {

                echo '

                <div class="pt-2 d-flex">

                <a href="admin/edit_product_form?id=' . $product_id . '" class="btn-primary btn-medium">modifier le produit</a>

                </div>

                ';
            }



            ?>

        </div>

    </section>







    <!-- section user review -->

    <?php

    if (isset($_SESSION["user_orders"]) && in_array($product_id, $_SESSION["user_orders"])) {

        echo '<div class="my-4"></div>';

        if (!in_array($product_id,  $_SESSION["user_reviews"])) {

            echo '

                <hr class="my-1">

                <form class="p-2 w-p-60 m-auto" action="reviews/add_review" method="post">

                <div class="t-4 t-center t-capitalize">

                    <span>' . translator("evaluer le produit", "rate the product") . '</span>

                </div>

                <input class="d-none" name="product_id" value="' . $product_id . '">

                <div class="pt-2 d-flex-center t-6 t-warning js-rating">';



            //stars

            $stars = [

                ["value" => 1, "class" => "js-rating-1"],

                ["value" => 2, "class" => "js-rating-2"],

                ["value" => 3, "class" => "js-rating-3"],

                ["value" => 4, "class" => "js-rating-4"],

                ["value" => 5, "class" => "js-rating-5"]

            ];



            foreach ($stars as $star) {

                echo '

                <label class="mx-2 h-pointer">

                    <input type="radio" name="rating" value=' . $star["value"] . ' class="d-none" required>

                    <i class="far fa-star ' . $star["class"] . ' t-4"></i>

                </label>';
            }

            echo '</div>';



            //comment and submit

            echo '<div class="d-flex-center pt-4">

                <textarea class="p-1" name="comment" placeholder="' . translator("laissez un commentaire", "leave us a comment about the product") . '" cols="60" rows="1"></textarea>

                </div> 

                

                <div class="d-flex-center pt-4">

                <button class="btn-large btn-primary " name="submit" type="submit">' . translator("confirmer votre evaluation", "confirm your review") . '</button>

                </div>

                </form>';
        }

        //edit review

        else {

            $user_review = $data["user_review"];

            $old_rating = $user_review["rating"];

            $old_comment = $user_review["comment"];



            echo '

                <hr class="my-1">

                <form class="p-2 w-p-60 m-auto" action="reviews/edit_review" method="post">

                <div class="t-capitalize t-4 t-center">

                    <span>' . translator("modifier votre evaluation", "edit your review") . '</span>

                </div>

                <input class="d-none" name="product_id" value="' . $product_id . '">

                <input class="d-none" name="old_rating" value="' . $old_rating . '">

                <div class="pt-2 d-flex-center t-5 t-warning js-rating">';



            $models = [

                [

                    ["class" => "js-rating-1 fas", "attribute" => "checked"],

                    ["class" => "js-rating-2 far", "attribute" => ""],

                    ["class" => "js-rating-3 far", "attribute" => ""],

                    ["class" => "js-rating-4 far", "attribute" => ""],

                    ["class" => "js-rating-5 far", "attribute" => ""],

                ], [

                    ["class" => "js-rating-1 fas", "attribute" => ""],

                    ["class" => "js-rating-2 fas", "attribute" => "checked"],

                    ["class" => "js-rating-3 far", "attribute" => ""],

                    ["class" => "js-rating-4 far", "attribute" => ""],

                    ["class" => "js-rating-5 far", "attribute" => ""],

                ],

                [

                    ["class" => "js-rating-1 fas", "attribute" => ""],

                    ["class" => "js-rating-2 fas", "attribute" => ""],

                    ["class" => "js-rating-3 fas", "attribute" => "checked"],

                    ["class" => "js-rating-4 far", "attribute" => ""],

                    ["class" => "js-rating-5 far", "attribute" => ""],

                ],

                [

                    ["class" => "js-rating-1 fas", "attribute" => ""],

                    ["class" => "js-rating-2 fas", "attribute" => ""],

                    ["class" => "js-rating-3 fas", "attribute" => ""],

                    ["class" => "js-rating-4 fas", "attribute" => "checked"],

                    ["class" => "js-rating-5 far", "attribute" => ""],

                ],

                [

                    ["class" => "js-rating-1 fas", "attribute" => ""],

                    ["class" => "js-rating-2 fas", "attribute" => ""],

                    ["class" => "js-rating-3 fas", "attribute" => ""],

                    ["class" => "js-rating-4 fas", "attribute" => ""],

                    ["class" => "js-rating-5 fas", "attribute" => "checked"],

                ]



            ];

            $stars = $models[$old_rating - 1];

            for ($i = 0; $i < 5; $i++) {

                echo '

                    <label class="mx-2 h-pointer">

                    <input type="radio" name="rating" value=' . ($i + 1) . ' class="d-none" ' . $stars[$i]["attribute"] . ' >

                    <i class="' . $stars[$i]["class"] . ' fa-star t-6"></i>

                    </label>

                    ';
            }



            echo '</div>

                <div class="d-flex-center pt-4">

                <textarea class="p-1 t-2" name="comment" placeholder="' . translator("laissez un commentaire", "leave us a comment about the product") . '" cols="100" rows="5">' . $old_comment . '</textarea>

                </div> 

                

                <div class="d-flex-center pt-4">

                <button class="btn-large  btn-primary" name="submit" type="submit">' . translator("sauvegarder", "save") . '</button>

                </div>

                </form>

                </section>';
        }
    }

    ?>



    <!-- section reviews -->

    <section id="reviews" class="p-1">

        <!-- header -->

        <div class="d-flex j-between bg-lightgray p-1">

            <!-- title -->

            <span class="pl-1 t-capitalize t-4">

                <?php

                echo translator("commentaires", "comments");

                ?>

            </span>

            <!-- ranking -->

            <div class="d-flex a-center t-bold t-capitalize">

                <span class="pr-2">

                    <?php

                    echo translator("classer par", "sort by");

                    ?>

                    :</span>

                <?php

                echo '<input form="default-form" type="text" name="id" class="d-none" value="' . $product_id . '">'

                ?>

                <select form="default-form" name="reviews_ranking" class="h-pointer js-default-target">

                    <?php

                    $options = [

                        ["value" => "most_helpful", "span" => translator("plus utile", "most helpful")],

                        ["value" => "best_reviews", "span" => translator("meilleures evaluations", "best reviews")],

                        ["value" => "worst_reviews", "span" => translator("pire evaluations", "worst reviews")]

                    ];



                    foreach ($options as $option) {

                        //variables

                        $value = $option["value"];

                        $span = $option["span"];



                        echo '<option value="' . $value . '"';

                        echo isset($_GET["reviews_ranking"]) && $_GET["reviews_ranking"] == $value ? ' selected>' : '>';

                        echo $span . '</option>';
                    }

                    ?>

                </select>

            </div>

        </div>



        <!-- reviews & ad -->

        <?php

        if (count($reviews)) {

            echo '

                    <div class="px-2 pt-4 d-flex">

                    <div class="flex-1 js-comments pl-4">';

            foreach ($reviews as $review) {

                //variables

                $reviewer_first_name = $review["first_name"];

                $reviewer_last_name = $review["last_name"];

                $reviewer_image = $review["image_name"];

                $reviewer_rating = $review["rating"];

                $comment = $review["comment"];

                $comment_date = $review["comment_date"];

                $comment_id =  $review["id"];

                $helpful = $review["helpful"];



                //comment

                echo '

                    <div class="pt-5">

                        <div class="d-flex a-center ">

                            <div style="background-image: url(img/profiles/' . $reviewer_image . ')" class="b-radius-circle h-2 w-2 bg-img bg-center"></div>

                            <span class="pl-2 t-capitalize t-blue">' . $reviewer_first_name . ' ' . $reviewer_last_name . '</span></div>

                        <div class="pl-5 t-warning">';

                //render stars

                render_stars($reviewer_rating);

                echo '

                            <span class="pl-2 t-gray ">' . translator("posté le", "posted the") . ' ' . $comment_date . '</span>

                            <span class="t-warning pl-2">' . translator("achat verifié", "verified purchase") . '</span>

                        </div>

                        <div class="pl-5 pt-1">

                            <p>' . $comment . '</p>

                        </div>

                        <div class="pl-5 pt-2 d-flex a-center">';

                if (isset($_SESSION["user_reactions"])) {

                    echo '<div class="js-reaction-group">';

                    if (in_array($comment_id, $_SESSION["user_reactions"])) {

                        echo '

                            <button data-comment_id=' . $comment_id . ' class=" btn-secondary btn-small js-remove-reaction">' . translator("enlever utile", "remove helpful") . '</button>

                            <button data-comment_id=' . $comment_id . ' class=" btn-secondary btn-small js-add-reaction d-none">' . translator("utile", "helpful") . '</button>

                            ';
                    } else {

                        echo '

                            <button data-comment_id=' . $comment_id . ' class=" btn-secondary btn-small js-add-reaction">' . translator("utile", "helpful") . '</button>

                            <button data-comment_id=' . $comment_id . ' class=" btn-secondary btn-small js-remove-reaction d-none">' . translator("enlever utile", "remove helpful") . '</button>

                            ';
                    }

                    echo '</div>';
                } else {

                    echo '

                    <div>

                        <a href="auth/sign_in_form" class="btn-secondary btn-small">' . translator("utile", "helpful") . '</a>

                    </div>

                    ';
                }

                if ($helpful > 1) {

                    echo '

                            <span class="pl-3 t-blue">' . $helpful . ' ' . translator("utilisateurs on trouvé ce commentaire utile", "users found this comment helpful") . '</span>';
                }

                echo '

                        </div>

                    </div>

                    ';
            }

            echo '</div>';



            // section ad

            echo '<div class="flex-1 d-flex j-end">';

            vertical_ad($vertical_ads[1]);

            echo '</div>';





            echo '</div>';

            //check show more

            if (isset($_SESSION["show_more"]) && $_SESSION["show_more"]) {

                echo '

                    <div class="pt-4 d-flex-center">

                        <img class="js-loading d-none h-5 ml-1" src="img/gifs/loading.gif">

                        <button data-displayed_comments="5" data-total_comments="' . $data["total_comments"] . '" data-product_id="' . $product_id . '" data-ranking="' . get("reviews_ranking") . '" class="btn-large btn-primary js-show-more-comments">' . translator("plus de commentaires", "more comments") . '</button>

                    </div>

                     ';

                unset($_SESSION["show_more"]);
            }
        } else {

            echo '<span class="t-3 t-center d-block py-5 t-capitalize t-gray">' . translator("pas de commentaires", "no comments") . ' . . .</span>';
        }

        ?>





    </section>



    <!-- section banner ad -->

    <section class="mt-2">

        <?php

        banner_ad($banner_ads[1]);

        ?>

    </section>



    <!-- section same category -->

    <?php

    render_items_carousel(translator("meme categorie", "same category"),  "products/filter_products?category=" . $category, $data["similar_products"]);

    ?>



    <!-- carousel -->

    <div class="p-fixed t-0 b-0 l-0 r-0 bg-semi-transparent d-flex-center p-relative js-window d-none">

        <div class="bg-white w-p-70 h-p-80 d-flex py-5 t-darkgray p-relative">

            <!-- prev btn -->

            <div class="d-flex-center px-4">

                <i class="fas fa-angle-left t-8 js-zoom-prev h-opacity h-pointer"></i>

            </div>

            <div class="flex-1 d-flex-center">

                <?php

                echo '<img src="" class="img-fluid js-large-image">';

                ?>

            </div>

            <!-- next btn -->

            <div class="d-flex-center px-4">

                <i class="fas fa-angle-right t-8 js-zoom-next h-opacity h-pointer"></i>

            </div>

            <!-- close btn -->

            <div class=" p-1 p-absolute t-0 r-0">

                <img src="img/icons/close.png" alt="" class="h-1 w-1 h-opacity h-pointer  js-close-window">

            </div>



        </div>

    </div>



    <!-- back to top -->

    <?php

    back_to_top();

    ?>



</main>

<?php

require_once ROOT . "/src/views/inc/end.php";

?>