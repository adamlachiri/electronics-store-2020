<?php
require_once ROOT . "/src/views/inc/start.php";
recover_post();
//variables
$user_city = $_SESSION["user_city"];
$user_address = $_SESSION["user_address"];
$user_phone = $_SESSION["user_phone"];
?>

<main>
    <!-- title -->
    <div class="t-center pt-5">
        <span class="t-capitalize t-4 t-bold">
            <?php
            echo translator("entrez votre numero de telephone et votre adresse", "enter your phone number and address")
            ?>
        </span>
    </div>

    <!-- form -->
    <form action="orders/confirm_personal_info" method="POST" class="w-p-70 m-auto pt-5">

        <!-- city -->
        <div class="d-flex a-center">
            <div class="flex-1">
                <span class="t-blue t-capitalize">
                    <?php
                    echo  translator("selectionez votre ville de livraison", "select your delivery city");
                    ?>
                </span>
                <strong class="t-alert t-3">*</strong>
            </div>
            <div class="flex-2 d-flex">
                <select name="city" class="p-1">
                    <?php
                    echo '<option disabled';
                    echo $user_city ? '>' : 'selected>';
                    echo '. . . </option>';

                    //cities
                    $cities = ["FES", "RABAT", "CASABLANCA", "MARRAKESH", "MEKNES", "TANGER", "AGADIR", "TETOUAN"];
                    foreach ($cities as $city) {
                        echo '<option value="' . $city . '"';
                        echo $user_city === $city ? ' selected>' : '>';
                        echo $city . '</option>';
                    }
                    ?>
                </select>
            </div>
            <!-- error msg -->
            <div class="t-center">
                <?php
                input_err("city");
                ?>
            </div>
        </div>

        <!-- address -->
        <div class="d-flex a-center pt-2">
            <div class="flex-1">
                <span class="t-blue t-capitalize">
                    <?php
                    echo translator("entrez votre adresse de livraison", "enter your delivery address");
                    ?>
                </span>
                <strong class="t-alert t-3">*</strong>
            </div>
            <div class="flex-2 d-flex">
                <?php
                //variables
                $value = isset($_POST["address"]) ? $_POST["address"] : $user_address;
                $class = input_err_class("address");

                echo '<input type="text" name="address" class="p-1 flex-1 ' . $class . '" value="' . $value . '">';
                ?>
            </div>
            <!-- error msg -->
            <div class="t-center">
                <?php
                input_err("address");
                ?>
            </div>
        </div>

        <!-- phone -->
        <div class="d-flex a-center pt-2">
            <div class="flex-1">
                <span class="t-blue t-capitalize">
                    <?php
                    echo translator("entrez votre numero de telephone", "enter your phone number");
                    ?>
                </span>
                <strong class="t-alert t-3">*</strong>
            </div>

            <div class="flex-2 d-flex">
                <?php
                //variables
                $value = isset($_POST["phone"]) ? $_POST["phone"] : $user_phone;
                $class = input_err_class("phone");

                echo '<input type="text" name="phone" class="p-1 flex-1 ' . $class . '" value="' . $value . '">';
                ?>
            </div>

            <!-- error msg -->
            <div class="t-center">
                <?php
                input_err("phone");
                ?>
            </div>

        </div>

        <!-- error msg -->
        <div class="t-center">
            <?php
            input_err("global");
            ?>
        </div>


        <!-- choice -->
        <div class="d-flex-center pt-4">
            <a href="cart" class="btn-large btn-secondary t-capitalize mr-4">
                <?php
                echo translator("<< retour", "<< back");
                ?>
            </a>
            <button type="submit" name="submit" class="btn-large btn-primary t-capitalize">
                <?php
                echo translator("suivant >>", "next >>");
                ?>
            </button>
        </div>
    </form>
</main>

<?php
require_once ROOT . "/src/views/inc/end.php";
?>