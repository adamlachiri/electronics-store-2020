<?php
require_once ROOT . "/src/views/inc/start.php";
?>

<main>

    <!-- user name -->
    <div class="py-4 t-center">
        <?php
        echo '<span class="t-capitalize t-6">' . $_SESSION["first_name"] . ' ' . $_SESSION["last_name"] . '</span>';
        ?>
    </div>

    <!-- section links -->
    <section class="flex-wrap d-flex a-center j-around">
        <?php
        $items = [
            ["link" => "users/edit_profile_form", "span" => translator("modifier profile", "edit profile"), "image_src" => "img/icons/profile.png"],
            ["link" => "users/change_password_form", "span" => translator("changer mot de passe", "change password"), "image_src" => "img/icons/security.png"],
            ["link" => "users/orders", "span" => translator("vos commandes", "your orders"), "image_src" => "img/icons/orders.png"],
            ["link" => "users/favourites", "span" => translator("favoris", "favourites"), "image_src" => "img/icons/favourite.png"]
        ];

        if ($_SESSION["user_type"] == "admin") {
            array_push(
                $items,
                ["link" => "admin/add_product_form", "span" => "rajouter un produit", "image_src" => "img/icons/add.png"],
                ["link" => "admin/search_product", "span" => "chercher et modifer un produit", "image_src" => "img/icons/search.png"],
                ["link" => "admin/advertising", "span" => "publicité", "image_src" => "img/icons/advertising.png"],
                ["link" => "admin/reports", "span" => "rapports", "image_src" => "img/icons/reports.png"]
            );
        }

        array_push(
            $items,
            ["link" => "auth/sign_out", "span" => translator("deconnection", "sign out"), "image_src" => "img/icons/logout.png"]
        );

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