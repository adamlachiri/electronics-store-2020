<?php





//render stars





function render_stars($rating)


{





    switch (true) {


        case $rating == 5:


            $class = "js-star-5";


            break;


        case $rating >= 4.5:


            $class = "js-star-4-half";


            break;


        case $rating >= 4:


            $class = "js-star-4";


            break;


        case $rating >= 3.5:


            $class = "js-star-3-half";


            break;


        case $rating >= 3:


            $class = "js-star-3";


            break;


        case $rating >= 2.5:


            $class = "js-star-2-half";


            break;


        case $rating >= 2:


            $class = "js-star-2";


            break;


        case $rating >= 1.5:


            $class = "js-star-1-half";


            break;


        case $rating >= 1:


            $class = "js-star-1";


            break;
    }





    echo '<span class="' . $class . '"></span>';
}





//error message





function input_err($str)


{


    if (isset($_SESSION["error"]) && $_SESSION["error"]["type"] === $str) {


        echo '


        <div class="pt-2 t-alert">


            <i class="fas fa-exclamation-circle pr-1"></i>


            <span>' . $_SESSION["error"]["span"] . '</span>


        </div>';


        unset($_SESSION["error"]);
    }
}





function input_err_class($type)


{


    return (isset($_SESSION["error"]) && $_SESSION["error"]["type"] === $type) ? " b-alert " : "";
}








//items carousel





function render_items_carousel($title, $link, $products)


{


    //carousel


    echo '


    <section class="p-2 bg-white mt-2">


        <div class="d-flex a-center"> 


            <span class="t-4 t-capitalize">' . $title . '</span>


            <a href="' . $link . '"class="t-link pl-2">' . translator("decouvrir", "see more") . '</a>


        </div>


        <div class="js-carousel-items mt-5">


            <div class="js-slider-container ov-x-hidden p-relative">


                <div class="js-slider d-inline-flex a-ease-out-fast">


    ';


    foreach ($products as $product) {


        // variables


        $product_id = $product['id'];


        $name = $product['name'];


        $image_src = "img/products/" . $product['image_1'];


        $product_link = "products/product_details?id=" . $product_id;





        //card design


        echo '


            <a href="' . $product_link . '">


                <img src="' . $image_src . '" alt="" title="' . $name . '"class="h-10 mr-5">


            </a>';
    }


    //close slider


    echo ' </div>';





    //buttons


    echo '


    <div class="js-next-container p-absolute t-0 b-0 r-0 d-flex-center">


        <button class="js-next h-opacity d-flex-center h-pointer t-7 t-darkgray h-p-80 w-3 bg-white b-gray mr-3"><i class="fas fa-angle-right"></i></button>


    </div>


    <div class="js-prev-container p-absolute t-0 b-0 l-0 d-flex-center">


        <button class="js-prev h-opacity d-flex-center h-pointer t-7 t-darkgray h-p-80 w-3 bg-white b-gray ml-3"><i class="fas fa-angle-left"></i></button>


    </div>';





    //close slider container


    echo '</div>';





    //scrollbar


    echo '<div class="js-scrollbar-container mt-2 h-mini p-relative">


            <div class="js-scrollbar a-ease-out-fast h-hand a-grab p-absolute t-0 b-0 bg-gray a-bg-black b-radius-small"></div>


        </div>';





    //close


    echo '


            </div>


            </section>


            ';
}





//items carousel vertical





function render_items_carousel_vertical($title, $link, $products)


{


    //carousel


    echo '


    <section class="p-1 bg-white b-left-gray d-flex-vertical p-sticky t-0 r-0 h-vh">


        <div class="t-center"> 


            <a href="' . $link . '"class="t-link t-capitalize">' . $title . '</a>


        </div>


        <hr class="mt-2">


        <div class="js-carousel-items-vertical d-flex flex-1 mt-2">';





    //scrollbar


    echo '<div class="js-scrollbar-container mr-2 w-mini b-radius-small p-relative">


    <div class="js-scrollbar p-absolute l-0 r-0 bg-gray b-radius-small a-ease-out-fast h-hand a-grab a-bg-black"></div>


    </div>';





    //slider container


    echo '


    <div class="js-slider-container ov-y-hidden p-relative h-30">


    <div class="js-slider d-flex-vertical a-ease-out-fast">


    ';


    foreach ($products as $product) {





        // variables


        $product_id = $product['id'];


        $name = $product['name'];


        $quantity = $product['quantity'];


        $image_src = "img/products/" . $product['image_1'];


        $product_link = "products/product_details?id=" . $product_id;





        //card design


        if ($quantity > 0) {


            echo '


            <a href="' . $product_link . '" class="d-block">


                <img src="' . $image_src . '" alt="" title="' . $name . '"class="w-5 mb-5">


            </a>';
        }
    }


    //close slider


    echo ' </div>';





    //buttons


    echo '


    <div class="js-prev-container p-absolute l-0 r-0 t-0 d-flex-center mt-1">


        <button class="js-prev d-flex-center h-pointer t-5 bg-white t-darkgray b-gray h-opacity w-p-80"><i class="fas fa-angle-up"></i></button>


    </div>


    <div class="js-next-container p-absolute l-0 r-0 b-0 d-flex-center mb-1">


        <button class="js-next d-flex-center h-pointer t-5 bg-white t-darkgray b-gray h-opacity w-p-80"><i class="fas fa-angle-down"></i></button>


    </div>';








    //close slider container


    echo '</div>';





    //close


    echo '


            </div>


            </section>


            ';
}





// back to top





function back_to_top()


{


    echo '


        <a href="' . $_SERVER["REQUEST_URI"] . '#" class="d-block t-center btn-primary py-2">' . translator("retourner en haut de la page", "back to top of the page") . '</a>


    ';
}





//banner ad


function banner_ad($ad)


{


    if (isset($ad)) {


        //variables


        $product_id = $ad["product_id"];


        $image_src = "img/ads/" . $ad['image_name'];





        echo '


        <a href="products/product_details?id=' . $product_id . '" class="d-block p-relative">


            <img src="' . $image_src . '" class="w-p-100">


            <div class="p-absolute t-0 l-0 r-0 p-1">


                <span class="t-gray t-1"><i class="fas fa-exclamation-circle"></i> ' . translator("sponsorisé", "sponsored") . '</span>


            </div>


        </a>


        ';
    }
}








//vertical ad


function vertical_ad($ad)


{


    if (isset($ad)) {


        //variables


        $product_id = $ad["product_id"];


        $image_src = "img/ads/" . $ad['image_name'];





        //render


        echo '


        <a href="products/product_details?id=' . $product_id . '" class="d-block p-relative">


            <img src="' . $image_src . '" class="w-max-20" >


            <div class="p-absolute t-0 l-0 r-0 p-1">


                <span class="t-gray t-1"><i class="fas fa-exclamation-circle"></i> ' . translator("sponsorisé", "sponsored") . '</span>


            </div>


        </a>    


    ';
    }
}
