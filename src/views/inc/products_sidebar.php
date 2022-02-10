<section class="t-capitalize bg-lightgray b-right-gray">
    <!-- section filter -->
    <section class="p-2">
        <!-- categories -->
        <div>
            <span class="t-bold">categories</span>
        </div>
        <div class="pt-2">
            <?php
            $categories = [
                ["value" => null, "span" => translator("tous", "all")],
                ["value" => "games", "span" => translator("jeux et consoles", "games & consoles")],
                ["value" => "phones", "span" => translator("telephones et tablettes", "phones & tablets")],
                ["value" => "computers", "span" => translator("ordinateurs", "computers")],
                ["value" => "hardwares", "span" => translator("materiel informatique", "hardwares")],
                ["value" => "monitors", "span" => translator("ecrans", "monitors")],
                ["value" => "others", "span" => translator("autres gadgets", "other gadgets")],
            ];
            foreach ($categories as $category) {
                //variables
                $value = $category["value"];
                $span = $category["span"];

                echo '
            <label class="d-block pt-1">
            <input form="default-form" type="radio" name="category" value="' . $value . '" class="mr-1 js-default-target"';
                echo (isset($_GET['category']) && $_GET['category'] == $value) ? 'checked>' : '>';
                echo '<span class="h-pointer h-t-warning">' . $span . '</span>
            </label>';
            }
            ?>
        </div>
        <hr class="mt-2">

        <!-- rating -->
        <div class="pt-2">
            <span class="t-bold">
                <?php
                echo translator("evaluations", "rating")
                ?>
            </span>
        </div>
        <div class="pt-2">
            <?php
            $values = [4, 3, 2, 1];
            foreach ($values as $value) {
                echo '<label class="d-flex pt-1 a-center h-pointer h-t-warning">
            <input form="default-form" type="radio" name="rating" value="' . $value . '" class="mr-1 js-default-target"';
                echo (isset($_GET['rating']) && $_GET['rating'] == $value) ? ' checked>' : '>';
                echo '<span class="t-warning">';
                render_stars($value);
                echo '</span>';
                echo  '<span class="pl-1 t-capitalize">' . translator("et plus", "& up") . '</span>
               </label>';
            }
            ?>
        </div>
        <hr class="mt-2">

        <!-- price -->
        <div class="pt-2">
            <span class="t-bold">
                <?php
                echo translator("prix maximal", "max price")
                ?>
            </span>
        </div>
        <div class="pt-2">
            <?php
            $limits = [
                ["value" => 3000, "span" => translator("moins de 3000", "under 3000")],
                ["value" => 2000, "span" => translator("moins de 2000", "under 2000")],
                ["value" => 1000, "span" => translator("moins de 1000", "under 1000")],
                ["value" => 500, "span" => translator("moins de 500", "under 500")],
            ];

            foreach ($limits as $limit) {
                //variables
                $value = $limit["value"];
                $span = $limit["span"];

                echo '
        <label class="d-block pt-1">
        <input form="default-form" type="radio" name="max_price" value=' . $value . ' class="mr-1 js-default-target"';
                echo (isset($_GET['max_price']) && $_GET['max_price'] == $value) ?
                    ' checked>' : '>';
                echo '<span class="h-pointer h-t-warning">' . $span . ' Dhs</span>
        </label>';
            }
            ?>
        </div>
        <hr class="my-2">
    </section>



    <!-- section ad -->
    <div class="d-flex-center">
        <?php
        vertical_ad($vertical_ads[0]);
        ?>
    </div>
</section>