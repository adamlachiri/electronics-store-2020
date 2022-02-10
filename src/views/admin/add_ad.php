<?php
require_once ROOT . "/src/views/inc/start.php";
recover_post();
?>
<main>
    <!-- section title -->
    <div class="py-4 t-center">
        <span class="t-capitalize t-6">rajouter une pub</span>
    </div>

    <!-- section add ad -->
    <section>
        <form action="admin/add_ad" method="post" enctype="multipart/form-data" class="w-p-50 m-auto">

            <!-- image -->
            <div class="d-flex pt-2 a-center">
                <div class="flex-2">
                    <span class="t-capitalize">image de la pub</span>
                    <strong class="t-alert t-3">*</strong>
                </div>
                <input class="p-1 flex-5 b-none" type="file" name="image">
            </div>

            <!-- ad type -->
            <div class="d-flex pt-2 a-center">
                <div class="flex-2">
                    <span class="t-capitalize">type</span>
                    <strong class="t-alert t-3">*</strong>
                </div>
                <div class="flex-5">
                    <select name="type" class="t-capitalize p-1">
                        <?php
                        $value = isset($_POST["type"]) ? $_POST["type"] : "";
                        echo '<option disabled';
                        echo $value ? '>' : 'selected>';
                        echo '. . . </option>';
                        $types = ["carousel", "banner", "vertical"];

                        foreach ($types as $type) {
                            echo '<option value="' . $type . '"';
                            echo $value === $type ? ' selected ' : '';
                            echo '>' . $type . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- product id -->
            <div class="d-flex pt-2 a-center">
                <div class="flex-2">
                    <span class="t-capitalize">id du produit</span>
                    <strong class="t-alert t-3">*</strong>
                </div>
                <?php
                $value = isset($_POST["product_id"]) ? $_POST["product_id"] : "";
                echo '<input class="p-1 flex-5" type="text" name="product_id" value="' . $value . '">';
                ?>
            </div>

            <!-- error msg -->
            <div class="t-center">
                <?php
                input_err("global");
                ?>
            </div>


            <!-- add ad -->
            <div class="d-flex-center pt-3">
                <button type="submit" class="btn-large btn-primary" name="submit">rajouter la pub</button>
            </div>

        </form>
    </section>
</main>
<?php
require_once ROOT . "/src/views/inc/end.php";
?>