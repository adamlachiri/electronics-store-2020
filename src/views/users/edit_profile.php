<?php
require_once ROOT . "/src/views/inc/start.php";
recover_post();
?>
<main class="pb-10">

    <!-- title -->
    <div class="py-4 t-center">
        <span class="t-capitalize t-6">
            <?php
            echo translator("modifier votre profile", "edit profile");
            ?>
        </span>
    </div>

    <!-- form -->
    <form action="users/edit_profile" method="POST" enctype="multipart/form-data">

        <!-- hidden info -->
        <?php
        echo '<input type="text" class="d-none" name="old_image_name" value="' . $_SESSION["user_image"] . '">';
        ?>

        <!-- section picture -->
        <section class="d-flex-center">
            <div>
                <!-- picture -->
                <?php
                echo '<div style="background-image: url(img/profiles/' . $_SESSION["user_image"] . ')" class="b-radius-circle b-gray h-10 w-10 bg-img bg-center m-auto"></div>';
                ?>

                <!-- upload picture -->
                <div class="pt-2 d-flex-center">
                    <label class="btn-secondary btn-small">
                        <span class="pr-2">
                            <?php
                            echo translator("changer l'image", "change picture")
                            ?>
                        </span>
                        <i class="t-2 fas fa-camera"></i>
                        <input class="d-none" type="file" name="image">
                    </label>
                </div>
                <!-- error msg -->
                <div class="t-center">
                    <?php
                    input_err("image");
                    ?>
                </div>
            </div>
        </section>

        <!-- section inputs -->
        <section class="pt-4 m-auto w-p-50">
            <!-- first name -->
            <div class="d-flex a-center">
                <div class="flex-2">
                    <span class="t-bold t-capitalize">
                        <?php
                        echo translator("prenom", "first name")
                        ?>
                        <strong class="t-alert t-3">*</strong>
                    </span>
                </div>
                <div class="flex-5">
                    <?php
                    //variables
                    $value = isset($_POST["first_name"]) ? $_POST["first_name"] : $_SESSION["first_name"];
                    $class = input_err_class("first_name");

                    echo '<input type="text" name="first_name" class="p-1 w-p-100 ' . $class . '" value="' . $value . '">';
                    ?>
                </div>
            </div>
            <!-- error msg -->
            <div class="d-flex">
                <div class="flex-2"></div>
                <div class="flex-5">
                    <?php
                    input_err("first_name");
                    ?>
                </div>
            </div>


            <!-- last name -->
            <div class="d-flex a-center pt-4">
                <div class="flex-2">
                    <span class="t-bold t-capitalize">
                        <?php
                        echo translator("nom de famille", "last name")
                        ?>
                        <strong class="t-alert t-3">*</strong>
                    </span>
                </div>
                <div class="flex-5">
                    <?php
                    //variables
                    $value = isset($_POST["last_name"]) ? $_POST["last_name"] : $_SESSION["last_name"];
                    $class = input_err_class("last_name");

                    echo '<input type="text" name="last_name" class="p-1 w-p-100 ' . $class . '" value="' . $value . '">';
                    ?>
                </div>
            </div>
            <!-- error msg -->
            <div class="d-flex">
                <div class="flex-2"></div>
                <div class="flex-5">
                    <?php
                    input_err("last_name");
                    ?>
                </div>
            </div>

            <!-- email -->
            <div class="d-flex a-center pt-4">
                <div class="flex-2">
                    <span class="t-bold t-capitalize">
                        email
                        <strong class="t-alert t-3">*</strong>
                    </span>
                </div>
                <div class="flex-5">
                    <?php
                    //variables
                    $value = isset($_POST["email"]) ? $_POST["email"] : $_SESSION["user_email"];
                    $class = input_err_class("email");

                    echo '<input type="email" name="email" class="p-1 w-p-100 ' . $class . '" value="' . $value . '">';
                    ?>
                </div>
            </div>
            <!-- error msg -->
            <div class="d-flex">
                <div class="flex-2"></div>
                <div class="flex-5">
                    <?php
                    input_err("email");
                    ?>
                </div>
            </div>

            <!-- phone -->
            <div class="d-flex a-center pt-4">
                <div class="flex-2">
                    <span class="t-bold t-capitalize">
                        <?php
                        echo translator("telephone", "phone")
                        ?>
                    </span>
                </div>
                <div class="flex-5">
                    <?php
                    //variables
                    $value = isset($_POST["phone"]) ? $_POST["phone"] : $_SESSION["user_phone"];
                    $class = input_err_class("phone");

                    echo '<input type="text" name="phone" class="p-1 w-p-100 ' . $class . '" value="' . $value . '">';
                    ?>
                </div>
            </div>
            <!-- error msg -->
            <div class="d-flex">
                <div class="flex-2"></div>
                <div class="flex-5">
                    <?php
                    input_err("phone");
                    ?>
                </div>
            </div>

            <!-- city -->
            <div class="d-flex a-center pt-4">
                <div class="flex-2">
                    <span class="t-bold t-capitalize">
                        <?php
                        echo translator("ville", "city")
                        ?>
                    </span>
                </div>
                <div class="flex-5">
                    <select name="city" class="p-1">
                        <?php
                        //variables
                        $value = isset($_POST["city"]) ? $_POST["city"] : $_SESSION["user_city"];
                        $class = input_err_class("city");

                        echo '<option disabled';
                        echo $value ? '>' : 'selected>';
                        echo '. . . </option>';

                        //cities
                        $cities = ["FES", "RABAT", "CASABLANCA", "MARRAKESH", "MEKNES", "TANGER", "AGADIR", "TETOUAN"];
                        foreach ($cities as $city) {
                            echo '<option class="' . $class . '" value="' . $city . '"';
                            echo $value === $city ? ' selected>' : '>';
                            echo $city . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <!-- error msg -->
            <div class="d-flex">
                <div class="flex-2"></div>
                <div class="flex-5">
                    <?php
                    input_err("city");
                    ?>
                </div>
            </div>

            <!-- address -->
            <div class="d-flex a-center pt-4">
                <div class="flex-2">
                    <span class="t-bold t-capitalize">
                        <?php
                        echo translator("adresse", "address")
                        ?>
                    </span>
                </div>
                <div class="flex-5">
                    <?php
                    //variables
                    $value = isset($_POST["address"]) ? $_POST["address"] : $_SESSION["user_address"];
                    $class = input_err_class("address");

                    echo '<input type="text" name="address" class="p-1 w-p-100 ' . $class . '" value="' . $value . '">';
                    ?>
                </div>
            </div>
            <!-- error msg -->
            <div class="d-flex">
                <div class="flex-2"></div>
                <div class="flex-5">
                    <?php
                    input_err("address");
                    ?>
                </div>
            </div>

        </section>

        <!-- section submit -->
        <section class="pt-5 d-flex-center">
            <button type="submit" name="submit" class="btn-large btn-primary t-capitalize">
                <?php
                echo translator("sauvegarder les changements", "save changes")
                ?>
            </button>
        </section>
    </form>

</main>
<?php
require_once ROOT . "/src/views/inc/end.php";
?>