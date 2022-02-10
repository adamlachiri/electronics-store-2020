<?php
require_once ROOT . "/src/views/inc/start.php";
recover_post();
?>
<main class="pb-10">

    <!-- section title -->
    <div class="py-4 t-center">
        <span class="t-capitalize t-6">rajouter un produit</span>
    </div>

    <!-- form -->
    <form action="admin/add_product" method="post" enctype="multipart/form-data" class="w-p-80 m-auto">

        <!-- section inputs -->
        <section>
            <!-- name -->
            <div class="d-flex pt-2 a-center">
                <div class="flex-3 t-end t-blue pr-4">
                    <span>nom du produit </span><span class="t-alert t-3">*</span>
                </div>
                <input class="p-1 flex-5" type="text" name="name">
            </div>
            <!-- error msg -->
            <div class="t-center">
                <?php
                input_err("name");
                ?>
            </div>


            <!-- images -->
            <?php
            $images = ["image_1", "image_2", "image_3", "image_4", "image_5"];
            foreach ($images as $key => $image) {
                echo '
                <div class="d-flex pt-2 a-center">
                    <div class="flex-3 t-end t-blue pr-4">
                        <span>' . $image . '</span>';
                echo $key == 0 ? '<span class="t-alert t-3">*</span>' : '';
                echo '        
                    </div>
                    <input class="p-1 flex-5" type="file" name="' . $image . '">
                </div>
                ';
            }
            ?>

            <!-- video -->
            <div class="d-flex pt-2 a-center">
                <div class="flex-3 t-end t-blue pr-4">
                    <span>source de la video </span>
                </div>
                <input class="p-1 flex-5" type="text" name="video_src">
            </div>


            <!-- category -->
            <div class="d-flex pt-2 a-center">
                <div class="flex-3 t-end t-blue pr-4">
                    <span>categorie </span><span class="t-alert t-3">*</span>
                </div>
                <select name="category" class="t-capitalize p-1 flex-5">
                    <option hidden disabled selected value> ... </option>
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
                        <option class="p-1" value="' . $value . '">' . $span . '</option>';
                    }
                    ?>
                </select>
            </div>

            <!-- original price -->
            <div class="d-flex pt-2 a-center">
                <div class="flex-3 t-end t-blue pr-4">
                    <span>prix de base </span><span class="t-alert t-3">*</span>
                </div>
                <input class="p-1 flex-5" type="number" step="0.01" name="original_price">
            </div>

            <!-- quantity -->
            <div class="d-flex pt-2 a-center">
                <div class="flex-3 t-end t-blue pr-4">
                    <span>quantité </span><span class="t-alert t-3">*</span>
                </div>
                <input class="p-1 flex-5" type="number" name="quantity">
            </div>

            <!-- promotion -->
            <div class="d-flex pt-2 a-center">
                <div class="flex-3 t-end t-blue pr-4">
                    <span>promotion </span>
                </div>
                <input class="p-1 flex-5" type="number" step=1 min=1 max=90 name="promotion">
            </div>

            <!-- coupon code -->
            <div class="d-flex pt-2 a-center">
                <div class="flex-3 t-end t-blue pr-4">
                    <span>code du coupon </span>
                </div>
                <input class="p-1 flex-5" type="text" name="coupon_code">
            </div>

            <!-- coupon reduction -->
            <div class="d-flex pt-2 a-center">
                <div class="flex-3 t-end t-blue pr-4">
                    <span>reduction du coupon </span>
                </div>
                <input class="p-1 flex-5" type="number" step=1 min=1 max=90 name="coupon_reduction">
            </div>
            <!-- error msg -->
            <div class="t-center">
                <?php
                input_err("global");
                ?>
            </div>


            <!-- guarantee -->
            <div class="d-flex pt-2 a-center">
                <div class="flex-3 t-end t-blue pr-4">
                    <span>guarantie </span><span class="t-alert t-3">*</span>
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
                        <option class="p-1" value="' . $value . '">' . $span . '</option>';
                    }
                    ?>
                </select>
            </div>


        </section>



        <!-- section submit product -->
        <div class="d-flex-center pt-4">
            <button type="submit" class="btn-large btn-primary" name="submit">rajouter le produit</button>
        </div>

    </form>
</main>
<?php
require_once ROOT . "/src/views/inc/end.php";
?>