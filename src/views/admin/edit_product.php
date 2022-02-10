<?php
require_once ROOT . "/src/views/inc/start.php";
recover_post();
$product = $data["product"];
$id = $product["id"];
$name = $product["name"];
$quantity = $product["quantity"];
$product_category = $product["category"];
$original_price = $product["original_price"];
$promotion = $product["promotion"];
$image_src_1 = "img/products/" . $product['image_1'];
$video_src = $product["video_src"];
$coupon_code = $product["coupon_code"];
$coupon_reduction = $product["coupon_reduction"];
$product_guarantee = $product["guarantee"];
?>
<main class="pb-10">
    <!-- section title -->
    <div class="py-4 t-center">
        <span class="t-capitalize t-6">modifier le produit</span>
        <?php
        echo '<span class="pl-1 t-5">(Id : ' . $id . ')</span>';
        ?>
    </div>

    <!-- section edit product -->
    <section class="w-p-80 m-auto">
        <form action="admin/edit_product" method="post" enctype="multipart/form-data">

            <!-- hidden infos -->
            <?php
            echo '
            <input type="text" value="' . $id . '" name="id" class="d-none">
            <input type="text" value="' . $quantity . '" name="quantity" class="d-none">
            ';
            $images = [
                ["name" => "old_image_1", "value" => "image_1"],
                ["name" => "old_image_2", "value" => "image_2"],
                ["name" => "old_image_3", "value" => "image_3"],
                ["name" => "old_image_4", "value" => "image_4"],
                ["name" => "old_image_5", "value" => "image_5"]
            ];
            foreach ($images as $image) {
                echo '<input type="text" value="' .  $product[$image["value"]] . '" name="' . $image["name"] . '" class="d-none">';
            }
            ?>

            <!-- section image & inputs -->
            <section class="d-flex">
                <!-- image -->
                <div class="p-5 j-center">
                    <div>
                        <?php
                        echo '<img src="' . $image_src_1 . '" class="w-max-15">';
                        ?>
                    </div>
                </div>

                <!-- inputs -->
                <div class="flex-1">
                    <!-- name -->
                    <div class="pt-4 d-flex a-center j-end">
                        <div class="flex-2 pr-3 t-end">
                            <span>nom</span>
                            <strong class="t-alert">*</strong>
                        </div>
                        <?php
                        echo '<input value="' . $name . '" type="text" name="name" class="flex-5 p-1">';
                        ?>
                    </div>

                    <!-- category -->
                    <div class="d-flex pt-2 a-center">
                        <div class="flex-2 pr-3 t-end">
                            <span>categorie</span>
                            <strong class="t-alert">*</strong>
                        </div>
                        <select name="category" class="t-capitalize p-1 flex-5">
                            <?php
                            $categories = [
                                ["value" => "games", "span" => "jeux et consoles"],
                                ["value" => "phones", "span" => "telephones et tablettes"],
                                ["value" => "computers", "span" => "ordinateurs"],
                                ["value" => "hardwares", "span" => "materiel informatique"],
                                ["value" => "monitors", "span" => "ecrans"],
                                ["value" => "others", "span" => "autres gadgets"],
                            ];
                            foreach ($categories as $category) {
                                $value = $category["value"];
                                $span = $category["span"];
                                echo '
                        <option class="p-1" value="' . $value . '"';
                                echo $product_category == $value ? ' selected ' : '';
                                echo '>' . $span . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <!-- original price -->
                    <div class="pt-2 d-flex a-center j-end">
                        <div class="flex-2 pr-3 t-end">
                            <span>prix de base</span>
                            <strong class="t-alert">*</strong>
                        </div>
                        <?php
                        echo '<input value="' . $original_price . '" type="number" step="any" name="original_price" class="flex-5 p-1">';
                        ?>
                    </div>

                    <!-- promotion -->
                    <div class="pt-2 d-flex a-center j-end">
                        <div class="flex-2 pr-3 t-end">
                            <span>promotion</span>
                        </div>
                        <?php
                        echo '<input value="' . $promotion . '" type="number" name="promotion" class="flex-5 p-1" step=1 max=90 min=1>';
                        ?>
                    </div>

                    <!-- add to stock -->
                    <div class="pt-2 d-flex a-center j-end">
                        <div class="flex-2 pr-3 t-end">
                            <span>rajouter au stock</span>
                        </div>
                        <input type="number" name="add_to_stock" class="flex-5 p-1" step=1>
                    </div>

                    <!-- images -->
                    <?php
                    $images = ["image_1", "image_2", "image_3", "image_4", "image_5"];
                    foreach ($images as $image) {
                        $image_src = "img/products/" . $product[$image];
                        echo '
                <div class="pt-2 d-flex a-center j-end">
                <div class="flex-2 pr-3 t-end">
                    <span>' . $image . '</span>';
                        echo $image == "image_1" ? '<strong class="t-alert">*</strong>' : '';
                        echo '</div>
                <div class="p-1 flex-5 d-flex">
                    <input type="file" name="' . $image . '" class="h-pointer mr-5">
                    <img src="' . $image_src . '" class="h-3">
                </div>
            </div>
                ';
                    }
                    ?>

                    <!-- video source -->
                    <div class="pt-4 d-flex a-center j-end">
                        <div class="flex-2 pr-3 t-end">
                            <span>source de la video</span>
                        </div>
                        <?php
                        echo '<input value="' . $video_src . '" type="text" name="video_src" class="flex-5 p-1">';
                        ?>
                    </div>

                    <!-- coupon code -->
                    <div class="pt-4 d-flex a-center j-end">
                        <div class="flex-2 pr-3 t-end">
                            <span>code coupon</span>
                        </div>
                        <?php
                        echo '<input value="' . $coupon_code . '" type="text" name="coupon_code" class="flex-5 p-1">';
                        ?>
                    </div>

                    <!-- coupon reduction -->
                    <div class="pt-4 d-flex a-center j-end">
                        <div class="flex-2 pr-3 t-end">
                            <span>reduction du coupon</span>
                        </div>
                        <?php
                        echo '<input value="' . $coupon_reduction . '" type="number" name="coupon_reduction" class="flex-5 p-1" step=1 max=90 min=1>';
                        ?>
                    </div>

                    <!-- guarantee -->
                    <div class="d-flex pt-2 a-center">
                        <div class="flex-2 pr-3 t-end">
                            <span>guarantie</span>
                            <strong class="t-alert">*</strong>
                        </div>
                        <select name="guarantee" class="t-capitalize p-1 flex-5">
                            <?php
                            $guarantees = [
                                ["value" => null, "span" => "pas de guarantie"],
                                ["value" => "6", "span" => "6 mois"],
                                ["value" => "12", "span" => "12 mois"],
                                ["value" => "24", "span" => "24 mois"]
                            ];
                            foreach ($guarantees as $guarantee) {
                                $value = $guarantee["value"];
                                $span = $guarantee["span"];
                                echo '
                        <option class="p-1" value="' . $value . '"';
                                echo $product_guarantee == $value ? ' selected ' : '';
                                echo '>' . $span . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                </div>
            </section>

            <!-- section global error -->
            <div class="t-center">
                <?php
                input_err("global");
                ?>
            </div>

            <!-- section submit -->
            <div class="pt-5 d-flex-center">
                <button type="submit" name="submit" class="btn-medium btn-primary mx-2">sauvegarder</button>
                <?php
                echo '<a href="admin/edit_product_form?id=' . $id . '" class="btn-medium btn-secondary mx-2">reset</a>';
                ?>

                <div class="btn-alert btn-medium js-open-confirm-delete">supprimer !!</div>

                <!-- confirm delete -->
                <div class="js-confirm-delete p-fixed t-0 b-0 l-0 r-0 bg-semi-transparent d-flex-vertical j-center d-none">
                    <div class="t-center">
                        <span class="t-white t-capitalize t-4 t-shadow t-bold">etes vous sur de vouloir supprimer ce produit de la base de données ?</span>
                    </div>
                    <div class="pt-4 d-flex-center">
                        <?php
                        echo ' <a href="admin/delete_product?id=' . $id . '" class="btn-medium btn-alert mr-5">oui</a>';
                        ?>
                        <div class="btn-secondary btn-medium js-close-confirm-delete">annuler</div>
                    </div>

                </div>
            </div>


        </form>
    </section>
</main>
<?php
require_once ROOT . "/src/views/inc/end.php";
?>