<!-- navigation -->
<section class="b-bottom-gray">

    <!-- info bar -->
    <div id="search-bar" class="d-flex a-center p-1 bg-white">
        <!-- logo -->
        <div class="d-flex-center px-5">
            <a href="">
                <img src="img/icons/logo.png" width=32 alt="">
            </a>
        </div>

        <!-- search -->
        <form action="products" class="d-flex a-center flex-1 b-gray b-radius-small bs-content" method="GET">
            <!-- search btn -->
            <button type="submit" class="py-1 px-2 t-3 btn-primary b-none" title="search"><i class="fas fa-search"></i></button>

            <!-- search options -->
            <select name="category" class="py-1 w-5 b-right-black btn-secondary">
                <?php
                $options = [
                    ["value" => null, "span" => translator("tous", "all")],
                    ["value" => "games", "span" => translator("jeux et consoles", "games & consoles")],
                    ["value" => "phones", "span" => translator("telephones et tablettes", "phones & tablets")],
                    ["value" => "computers", "span" => translator("ordinateurs", "computers")],
                    ["value" => "hardwares", "span" => translator("materiel informatique", "hardwares")],
                    ["value" => "monitors", "span" => translator("ecrans", "monitors")],
                    ["value" => "others", "span" => translator("autres gadgets", "other gadgets")],
                ];

                foreach ($options as $option) {
                    //variables
                    $value = $option["value"];
                    $span = $option["span"];
                    $selected = isset($_GET["category"]) && $value == $_GET["category"] ? ' selected ' : '';

                    //render
                    echo '
                        <option class="p-1" value="' . $value . '" ' . $selected . '>' . $span . '</option>';
                }
                ?>
            </select>
            <!-- search input -->
            <?php
            $value = isset($_GET["name"]) ? $_GET["name"] : '';
            echo '<input type="text" name="name" class="py-1 px-2 b-none flex-1" placeholder="' . translator("Entrez le nom du produit", "Enter product name") . '. . ." value="' . $value . '">';
            ?>
        </form>

        <!-- language options -->
        <div class="ml-2 b-gray d-flex b-radius-small">
            <div class="d-flex-vertical p-relative w-3">
                <?php
                $languages = [
                    ["link" => "Config/select_language?language=french", "icon_src" => "img/icons/french.png"],
                    ["link" => "Config/select_language?language=english", "icon_src" => "img/icons/english.png"]
                ];

                if (isset($_SESSION["language"]) && $_SESSION["language"] == "english") {
                    $option_1 = $languages[1];
                    $option_2 = $languages[0];
                } else {
                    $option_1 = $languages[0];
                    $option_2 = $languages[1];
                }

                //option 1
                $link = $option_1["link"];
                $icon_src = $option_1["icon_src"];

                echo '
                    <a href="' . $link . '" class="d-flex a-center p-1">
                        <img src="' . $icon_src . '" class="h-1">
                    </a>
                    ';

                //option 2
                $link = $option_2["link"];
                $icon_src = $option_2["icon_src"];

                echo '
                    <a href="' . $link . '" class="js-dropdown-window d-none btn-secondary p-absolute p-1 l-0 r-0 t-100 b-gray d-flex a-center">
                            <img src="' . $icon_src . '" class="h-1">
                    </a>
                    ';
                ?>
            </div>
            <div class="btn-primary js-dropdown-toggler px-1 h-pointer d-flex-center">
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>

        <!-- cart -->
        <div class="pl-2">
            <a href="cart" class="btn-primary btn-small b-radius-small" title="your cart">
                <i class="fas fa-cart-plus"></i>
                <span class="pl-1">
                    <?php
                    echo translator("pannier", "cart")
                    ?>
                </span>
                <span class="pl-1">
                    <?php echo isset($_SESSION["cart"]) ? count($_SESSION["cart"]) : 0; ?>
                </span>
            </a>
        </div>

    </div>

    <!-- navigation bar -->
    <div id="nav-bar" class="d-flex a-center j-between bg-lightgray t-black t-capitalize">
        <!-- links -->
        <div class="d-flex">
            <?php
            $links = [
                ["link" => "", "span" => "<i class='fas fa-home'></i>"],
                ["link" => "products?category=games", "span" => translator("jeux et consoles", "games & consoles")],
                ["link" => "products?category=phones", "span" => translator("telephones et tablettes", "phones & tablets")],
                ["link" => "products?category=computers", "span" => translator("ordinateurs", "computers")],
                ["link" => "products?category=hardwares", "span" => translator("matériel informatique", "hardwares")],
                ["link" => "products?category=monitors", "span" => translator("ecrans", "monitors")],
                ["link" => "products?category=others", "span" => translator("autres gadgets", "other gadgets")],
                ["link" => "about_us", "span" => translator("a propos", "about us")]
            ];

            foreach ($links as $key => $link) {
                $class = $key != 0 ? "js-link" : "";
                echo '
                <a href="' . $link["link"] . '" class="px-2 py-1 ' . $class . ' h-bg-primary h-t-white">' . $link["span"] . '</a>
                ';
            }
            ?>
            <!-- test link -->
            <?php
            if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "admin") {
                echo '
                    <a href="admin/test_form" class="px-2 py-1 js-link h-bg-primary">test</a>
                    ';
            }
            ?>
        </div>

        <!-- auth -->
        <div class="d-flex-center p-relative h-2">
            <?php
            if (isset($_SESSION["user_id"])) {
                echo '<a href="users/profile" class="px-2 py-1 js-link h-bg-primary h-t-white d-flex a-center">
                <div style="background-image: url(img/profiles/' . $_SESSION["user_image"] . ')" class="b-radius-circle h-1 w-1 bg-img bg-center"></div>
                <span class="pl-1 t-capitalize">' . $_SESSION["first_name"] . '</span>
            </a>';
            }
            //sign in
            else {
                echo '<a href="auth/sign_in_form" class="px-2 py-1 js-link h-bg-primary h-t-white" title="sign in">' . translator("se connecter", "sign in") . '</a>';
            }
            ?>
        </div>
    </div>

    <!-- success message -->
    <?php
    if (isset($_SESSION["success"])) {
        echo '<div class="js-popup d-flex a-center j-between bg-success t-white t-2 t-bold p-1">
        <div>
            <i class="fas fa-check-circle pr-1"></i>
            <span>' . $_SESSION["success"] . '</span>
        </div>
        <i class="js-close-popup h-pointer h-opacity t-3 far fa-times-circle"></i>
        </div>';
        unset($_SESSION["success"]);
    }
    ?>

    <!-- failure message -->
    <?php
    if (isset($_SESSION["failure"])) {
        echo '<div class="js-popup d-flex a-center j-between bg-alert t-white t-2 t-bold p-1">
        <div>
            <i class="fas fa-exclamation-circle pr-1"></i>
            <span>' . $_SESSION["failure"] . '</span>
        </div>
        <i class="js-close-popup h-pointer h-opacity t-3 far fa-times-circle"></i>
        </div>';
        unset($_SESSION["failure"]);
    }
    ?>
</section>