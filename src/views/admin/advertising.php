<?php
require_once ROOT . "/src/views/inc/start.php";
?>
<main class="pb-10">
    <!-- section title -->
    <div class="py-4 t-center">
        <span class="t-capitalize t-6">publicité</span>
    </div>

    <!-- section choices -->
    <section class="pt-5 flex-wrap d-flex a-center j-around">
        <?php
        $items = [
            ["link" => "admin/add_ad_form", "span" => "rajouter une pub", "image_src" => "img/icons/add.png"],
            ["link" => "admin/ads_list", "span" => "modifier une pub", "image_src" => "img/icons/advertising.png"]
        ];
        foreach ($items as $item) {
            $link = $item["link"];
            $span = $item["span"];
            $image_src = $item["image_src"];
            echo '
        <a href="' . $link . '" class="h-bg-lightgray p-2 w-25 b-gray m-4 d-flex b-radius-small">
            <div class="flex-1 d-flex-center">
                <img src="' . $image_src . '" class="h-max-5">
            </div>
            <div class="flex-2 d-flex-center px-2">
                    <span class="t-capitalize">' . $span . '</span>
            </div>
        </a>';
        }
        ?>
    </section>
</main>
<?php
require_once ROOT . "/src/views/inc/end.php";
?>