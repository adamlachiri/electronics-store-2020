<?php
require_once ROOT . "/src/views/inc/start.php";
?>

<main class="p-2">
    <!-- title -->
    <div>
        <span class="t-capitalize t-4">
            <?php
            echo translator("a propos", "about us")
            ?>
        </span>
    </div>
    <hr class="mt-2">

    <!-- conditions of use -->
    <div class="pt-2">
        <a href="about_us/terms_of_service" class="t-link t-capitalize">
            <?php
            echo translator("nos termes de services", "our terms of service")
            ?>
        </a>
    </div>

    <!-- section conditions -->
    <?php
    $sections = [
        ["icon" => "fas fa-dolly-flatbed", "title" => translator("livraison", "delivery"), "class" => "bg-delivery", "id" => "delivery"],
        ["icon" => "fas fa-tools", "title" => translator("conditions de retour et remboursement", "return & refurbish policy"), "class" => "bg-return", "id" => "refund"],
        ["icon" => "fas fa-money-bill-wave", "title" => translator("methodes de paiement", "payment methods"), "class" => "bg-payment", "id" => "payment"],
    ];

    foreach ($sections as $key => $section) {
        //variables
        $icon = $section["icon"];
        $class = $section["class"];
        $title = $section["title"];
        $id = $section["id"];
        $margin_class = $key % 2 == 0 ? "mr-auto" : "ml-auto";

        //render
        echo '
        <div id="' . $id . '" class="p-2 ' . $class . ' mt-2 bg-img bg-center d-flex">
            <div class="w-p-30 ' . $margin_class . ' t-white">
                <div class="t-4 t-warning">
                    <i class="' . $icon . ' pr-2"></i>
                    <span class="t-capitalize">' . $title . '</span>
                </div>
                <div class="pt-2">
                    <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio, vel eos! Eum totam vitae molestias nihil dolorum beatae minus, ab dolore non nobis mollitia doloribus repellat odit. Perferendis, pariatur voluptatum?
                    </p>
                    <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio, vel eos! Eum totam vitae molestias nihil dolorum beatae minus, ab dolore non nobis mollitia doloribus repellat odit. Perferendis, pariatur voluptatum?
                    </p>
                    <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio, vel eos! Eum totam vitae molestias nihil dolorum beatae minus, ab dolore non nobis mollitia doloribus repellat odit. Perferendis, pariatur voluptatum?
                    </p>
                </div>
            </div>   
        </div>
        ';
    }
    ?>

</main>

<?php
require_once ROOT . "/src/views/inc/end.php";
?>