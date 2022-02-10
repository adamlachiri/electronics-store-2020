<?php
require_once ROOT . "/src/views/inc/start.php";
$products = isset($data["products"]) ? $data["products"] : null;
?>
<main>
    <!-- section title -->
    <div class="py-4 t-center">
        <span class="t-capitalize t-6">chercher un produit</span>
    </div>

    <!-- section search -->
    <section>

        <!-- search form -->
        <form class="d-flex w-p-60 m-auto b-bottom-gray" action="" method="GET">
            <button type="submit" name="submit" class="b-none h-opacity t-3 h-3 px-2 " title="search"><i class="fas fa-search"></i></button>
            <?php
            $value = isset($_GET["edit_name"]) ? $_GET["edit_name"] : "";
            echo '
            <input type="text" name="edit_name" value="' . $value . '" class="b-none px-2 h-3 b-none flex-1 t-lato" placeholder="Entrez le nom du produit">
            ';
            ?>
        </form>

        <!-- search results -->
        <?php
        if ($products !== null) {
            if (count($products) > 0) {
                echo '
            <div class="w-p-80 pt-5 m-auto">
            ';
                foreach ($products as $product) {
                    //variables
                    $id = $product['id'];
                    $name = $product['name'];
                    $image_src = "img/products/" . $product['image_1'];

                    echo '
            <div class="d-flex a-center">
                <div class="w-15 h-10 d-flex-center">
                    <img class="h-max-5 w-max-5" src="' . $image_src . '">
                </div>
                <div class="flex-1 pl-2">
                    <div class="pt-1">
                        <a href="admin/edit_product_form?id=' . $id . '" class="h-t-warning t-3">' . $name . '</a>
                    </div>
                </div>
            </div>
            <hr>
            ';
                }
                echo '</div>';
            }
            //no products found
            else {
                echo '
                <div class="d-flex-center pt-5">
                    <img src="img/others/empty-box.png" class="w-20">
                </div>
                <div class="t-center pt-2">
                    <span class="t-capitalize t-5">pas de produit trouvé ...</span>
                </div>
                ';
            }
        }
        ?>
    </section>

</main>
<?php

require_once ROOT . "/src/views/inc/end.php";
?>