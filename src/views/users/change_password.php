<?php
require_once ROOT . "/src/views/inc/start.php";
recover_post();
?>
<main class="pb-10">

    <!-- title -->
    <div class="py-4 t-center">
        <span class="t-capitalize t-6">
            <?php
            echo translator("changer votre mot de passe", "change password");
            ?>
        </span>
    </div>

    <!-- form -->
    <form action="users/change_password" method="POST">

        <!-- section inputs -->
        <section class="m-auto w-p-70">
            <!-- old_password -->
            <div class="d-flex a-center pt-4">
                <div class="flex-3">
                    <span class="t-bold t-capitalize">
                        <?php
                        echo translator("ancien mot de passe", "old password")
                        ?>
                        <strong class="t-alert t-3">*</strong>
                    </span>
                </div>
                <div class="flex-5">
                    <?php
                    //variables
                    $class = input_err_class("old_password");

                    echo '<input type="password" name="old_password" class="p-1 w-p-100 ' . $class . '" >';
                    ?>
                </div>
            </div>
            <!-- error msg -->
            <div class="t-center">
                <?php
                input_err("old_password");
                ?>
            </div>

            <!-- password -->
            <div class="d-flex a-center pt-4">
                <div class="flex-3">
                    <span class="t-bold t-capitalize">
                        <?php
                        echo translator("nouveau mot de passe", "new password")
                        ?>
                        <strong class="t-alert t-3">*</strong>
                    </span>
                </div>
                <div class="flex-5">
                    <?php
                    //variables
                    $class = input_err_class("password");

                    echo '<input type="password" name="password" class="p-1 w-p-100 ' . $class . '" >';
                    ?>
                </div>
            </div>
            <!-- error msg -->
            <div class="t-center">
                <?php
                input_err("password");
                ?>
            </div>

            <!-- confirmed password -->
            <div class="d-flex a-center pt-4">
                <div class="flex-3">
                    <span class="t-bold t-capitalize">
                        <?php
                        echo translator("confirmer votre nouveau mot de passe", "confirm your new password")
                        ?>
                        <strong class="t-alert t-3">*</strong>
                    </span>
                </div>
                <div class="flex-5">
                    <?php
                    //variables
                    $class = input_err_class("confirmed_password");

                    echo '<input type="password" name="confirmed_password" class="p-1 w-p-100 ' . $class . '" >';
                    ?>
                </div>
            </div>
            <!-- error msg -->
            <div class="t-center">
                <?php
                input_err("confirmed_password");
                ?>
            </div>

        </section>

        <!-- error msg -->
        <div class="t-center">
            <?php
            input_err("global");
            ?>
        </div>

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