<?php
require_once ROOT . "/src/views/inc/start.php";
?>

<main class="pb-5">
    <!-- section title -->
    <div class="py-4 t-center">
        <span class="t-capitalize t-6">liste des pubs</span>
    </div>


    <!-- section edit ads -->
    <section>
        <?php
        if (count($data['ads']) > 0) {
            echo '
        <div class="w-p-90 m-auto t-capitalize">
        <div class="d-flex">
            <div class="flex-3 t-center bg-lightgray b-gray py-2">
                image de la pub
            </div>
            <div class="flex-1 t-center bg-lightgray b-gray py-2">
                id du produit concerné
            </div>
            <div class="flex-1 t-center bg-lightgray b-gray py-2">
                type de la pub
            </div>
            <div class="flex-1 b-bottom-gray">
            </div>
        </div>';
            foreach ($data['ads'] as $key => $ad) {
                //variables
                $image_src = 'img/ads/' . $ad['image_name'];
                $ad_id = $ad['id'];
                $product_id = $ad['product_id'];
                $type = $ad['type'];
                $class = $key % 2 == 0 ? '' : 'bg-lightgray';

                echo '<div class="d-flex b-left-gray ' . $class . '">
                <div class="flex-3 d-flex-center b-right-gray">
                    <img class="img-fluid h-max-20" src="' . $image_src . '">
                </div>
                <div class="flex-1 d-flex-center b-right-gray">
                    <span>' . $product_id . '</span>
                </div>
                <div class="flex-1 d-flex-center b-right-gray">
                    ' . $type . '
                </div>
                <div class="flex-1 d-flex-center b-right-gray">
                    <a href="admin/edit_ad_form?id=' . $ad_id . '" class="btn-primary btn-medium">modifer</a>
                </div>
            </div>
            <hr>
            ';
            }
            echo '</div>';
        }

        //no orders
        else {
            echo '
        <div class="t-center t-4 t-gray t-capitalize pt-4">
            <span>pas de pubs pour le moment ...</span>
        </div>
        ';
        }
        ?>

    </section>
</main>

<?php
require_once ROOT . "/src/views/inc/end.php";
?>