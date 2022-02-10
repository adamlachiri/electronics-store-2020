<?php
require_once ROOT . "/src/views/inc/start.php";
recover_post();
?>
<main class="py-5">
    <!-- form -->
    <form class="p-2 w-p-40 m-auto b-gray b-radius-small" action="auth/sign_up" method="POST">
        <!-- title -->
        <div>
            <span class="t-5 t-capitalize">
                <?php
                echo translator("créer un compte", "sign up")
                ?>
            </span>
        </div>
        <hr class="mt-2">

        <!-- names -->
        <div class="d-flex pt-2">

            <!-- first name -->
            <div class="flex-1">
                <div>
                    <span class="t-bold t-capitalize pr-2">
                        <?php
                        echo translator("prenom", "first name");
                        ?>
                    </span><span class="t-gray t-1">
                        <?php
                        echo translator("que des lettres", "only letters")
                        ?>
                    </span>
                </div>
                <!-- input -->
                <div class="flex-1 d-flex pt-1">
                    <?php
                    //variables
                    $value = isset($_POST["first_name"]) ? $_POST["first_name"] : "";
                    $class = input_err_class("first_name");

                    echo '<input type="text" name="first_name" class="p-1 w-15 ' . $class . '" value="' . $value . '">';
                    ?>
                </div>
                <!-- error msg -->
                <?php
                input_err("first_name");
                ?>
            </div>

            <!-- last name -->
            <div class="flex-1">
                <div>
                    <span class="t-bold t-capitalize pr-2">
                        <?php
                        echo translator("nom de famille", "last name");
                        ?>
                    </span><span class="t-gray t-1">
                        <?php
                        echo translator("que des lettres", "only letters")
                        ?>
                    </span>
                </div>
                <!-- input -->
                <div class="flex-1 d-flex pt-1">
                    <?php
                    //variables
                    $value = isset($_POST["last_name"]) ? $_POST["last_name"] : "";
                    $class = input_err_class("last_name");

                    echo '<input type="text" name="last_name" class="p-1 w-15 ' . $class . '" value="' . $value . '">';
                    ?>
                </div>
                <!-- error msg -->
                <?php
                input_err("last_name");
                ?>
            </div>
        </div>

        <!-- email -->
        <div class="pt-2">
            <!-- title -->
            <div>
                <span class="t-bold t-capitalize">email</span>
            </div>
            <!-- input -->
            <div class="flex-1 d-flex pt-1">
                <?php
                //variables
                $value = isset($_POST["email"]) ? $_POST["email"] : "";
                $class = input_err_class("email");

                echo '<input type="email" name="email" class="p-1 flex-1 ' . $class . '" value="' . $value . '">';
                ?>
            </div>
            <!-- error msg -->
            <?php
            input_err("email");
            ?>
        </div>

        <!-- password -->
        <div class="pt-2">
            <!-- title -->
            <div>
                <span class="t-bold t-capitalize pr-2">
                    <?php
                    echo translator("mot de passe", "password")
                    ?>
                </span>
                <span class="t-gray t-1">
                    <?php
                    echo translator("au moins 9 caractéres, que des lettres et des chiffres", "at least 9 characters, only letters and digits")
                    ?>
                </span>
            </div>

            <!-- input -->
            <div class="flex-1 d-flex pt-1">
                <?php
                //variables
                $value = isset($_POST["password"]) ? $_POST["password"] : "";
                $class = input_err_class("password");


                echo '<input type="password" name="password" class="p-1 flex-1 ' . $class . '" value="' . $value . '">';
                ?>
            </div>

            <!-- error msg -->
            <?php
            input_err("password");
            ?>
        </div>

        <!-- confirmed password -->
        <div class="pt-2">
            <!-- title -->
            <div>
                <span class="t-bold t-capitalize">
                    <?php
                    echo translator("re entrez votre mot de passe", "re enter your password")
                    ?>
                </span>
            </div>

            <!-- input -->
            <div class="flex-1 d-flex pt-1">
                <?php
                //variables
                $value = isset($_POST["confirmed_password"]) ? $_POST["confirmed_password"] : "";
                $class = input_err_class("confirmed_password");


                echo '<input type="password" name="confirmed_password" class="p-1 flex-1 ' . $class . '" value="' . $value . '">';
                ?>
            </div>

            <!-- error msg -->
            <?php
            input_err("confirmed_password");
            ?>

        </div>

        <!-- error msg -->
        <div class="t-center">
            <?php
            input_err("global");
            ?>
        </div>

        <!-- create account -->
        <div class="d-flex-center pt-3">
            <button type="submit" name="submit" class="btn-large btn-primary">
                <?php
                echo translator("créer votre compte", "sign up")
                ?>
            </button>
        </div>
    </form>

    <!-- alternative -->
    <div class="t-center pt-2">
        <span class="t-capitalize t-bold">
            <?php
            echo translator("ou", "or")
            ?>
        </span>
    </div>
    <div class="d-flex-center pt-2">
        <a href="auth/sign_in_form" class="btn-large btn-secondary">
            <?php
            echo translator("j'ai deja un compte", "i already have an account")
            ?>
        </a>
    </div>

</main>
<?php
require_once ROOT . "/src/views/inc/end.php";
?>