<?php
require_once ROOT . "/src/views/inc/start.php";
recover_post();
//variables
$ad_details = $data["ad_details"];
$product_id = $ad_details["product_id"];
$ad_id = $ad_details["id"];
$image_src = "img/ads/" . $ad_details["image_name"];
?>
<main class="pb-10">

    <!-- section title -->
    <div class="py-4 t-center">
        <span class="t-capitalize t-6">modifier cette pub</span>
    </div>

    <!-- section edit ad -->
    <section>
        <form action="admin/edit_ad" method="post" enctype="multipart/form-data" class="w-p-50 m-auto">

            <!-- needed info -->
            <?php
            echo '
        <input class="d-none" type="text" name="ad_id" value="' . $ad_id . '">
        <input class="d-none" type="text" name="old_image_name" value="' . $ad_details["image_name"] . '">
        ';
            ?>

            <!-- old ad image -->
            <?php
            echo '
        <div class="d-flex-center">
            <img src="' . $image_src . '" class="img-fluid">
        </div>
        ';
            ?>

            <!-- image -->
            <div class="d-flex pt-4 a-center">
                <div class="flex-2">
                    <span class="t-capitalize">nouvelle image</span>
                    <strong class="t-3 t-alert">*</strong>
                </div>
                <input class="p-1 flex-5" type="file" name="image">
            </div>

            <!-- product id -->
            <?php
            echo '
        <div class="d-flex pt-2 a-center">
            <div class="flex-2">
            <span class="t-capitalize">id du produit</span>
            <strong class="t-3 t-alert">*</strong>
            </div>
            <div class="flex-5">';
            $value = isset($_POST["product_id"]) ? $_POST["product_id"] : $product_id;
            echo '
                <input class="p-1" type="text" name="product_id" value="' . $value . '">
            </div>
        </div>   
        ';
            ?>

            <!-- error msg -->
            <div class="t-center pt-2">
                <?php
                input_err("global");
                ?>
            </div>

            <!-- edit ad -->
            <div class="d-flex-center pt-4">
                <button type="submit" class="btn-large btn-primary mr-5" name="submit">sauvegarder</button>
                <div class="btn-alert btn-medium js-open-confirm-delete">supprimer !!</div>

                <!-- confirm delete -->
                <div class="js-confirm-delete p-fixed t-0 b-0 l-0 r-0 bg-semi-transparent d-flex-vertical j-center d-none">
                    <div class="t-center">
                        <span class="t-white t-capitalize t-4 t-shadow t-bold">etes vous sur de vouloir supprimer cette pub de la base de données ?</span>
                    </div>
                    <div class="pt-4 d-flex-center">
                        <?php
                        echo ' <a href="admin/delete_ad?id=' . $ad_id . '" class="btn-medium btn-alert mr-5">oui</a>';
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