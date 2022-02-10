<?php
require_once ROOT . "/src/views/inc/start.php";
?>

<main class="pb-10">

    <!-- title -->
    <div class="py-4 t-center">
        <span class="t-capitalize t-6">
            <?php
            echo translator("vos commandes", "your orders");
            ?>
        </span>
    </div>

    <!-- section orders -->
    <section>
        <!-- orders table -->
        <?php
        if (count($data['user_orders_details']) > 0) {
            echo '
        <section class="w-p-90 m-auto b-left-gray b-right-gray">
            <hr>
            <div class="d-flex a-center t-capitalize bg-lightgray">
                <div class="flex-1 p-2 t-center b-right-gray">
                    image
                </div>
                <div class="flex-3 p-2 t-center b-right-gray">
                    ' . translator("nom", "name") . '
                </div>
                <div class="flex-1 p-2 t-center b-right-gray">
                ' . translator("quantité", "quantity") . '
                </div>
                <div class="flex-1 p-2 t-center b-right-gray">
                ' . translator("prix total", "total price") . ' (dhs)
                </div>
                <div class="flex-1 t-center p-2">
                    date
                </div>
            </div>
            <hr>';

            foreach ($data['user_orders_details'] as $key => $order) {
                //variables
                $image_src = 'img/products/' . $order['image_1'];
                $product_name = $order['name'];
                $product_id = $order['product_id'];
                $quantity = $order['quantity'];
                $total_price = $order['total_price'];
                $order_date = $order['order_date'];

                echo '<div class="d-flex">
                <div class="flex-1 p-2 d-flex-center b-right-gray">
                    <img class="img-fluid h-max-3" src="' . $image_src . '">
                </div>
                <div class="flex-3 d-flex-center p-2 b-right-gray">
                    <a href="products/product_details?id=' . $product_id . '" class="h-t-warning">' . $product_name . '</a>
                </div>
                <div class="flex-1 p-2 d-flex-center b-right-gray">
                    ' . $quantity . '
                </div>
                <div class="flex-1 p-2 d-flex-center b-right-gray">
                    ' . $total_price . '
                </div>
                <div class="flex-1 p-2 d-flex-center">
                    ' . $order_date . '
                </div>
            </div>
            <hr>
            ';
            }
            echo '</section>';
        }

        //no orders
        else {
            echo '
        <div class="t-center t-4 t-capitalize pt-5">
            <span>you didn\'t order anything yet ...</span>
        </div>
        ';
        }

        ?>
    </section>

</main>

<?php
require_once ROOT . "/src/views/inc/end.php";
?>