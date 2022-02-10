<?php


require_once ROOT . "/src/views/inc/start.php";


recover_post();


?>


<main class="py-5">





    <!-- form -->


    <form class="p-2 w-p-30 m-auto b-gray b-radius-small" action="auth/sign_in" method="POST">





        <!-- title -->


        <div>


            <span class="t-5 t-capitalize">


                <?php


                echo translator("se connecter", "sign_in")


                ?>


            </span>


        </div>


        <hr class="mt-2">





        <!-- email -->


        <div class="pt-2">


            <span class="t-bold t-capitalize">email</span>


            <div class="flex-1 d-flex pt-1">


                <?php


                //variables


                $value = isset($_POST["email"]) ? $_POST["email"] : "guest@gmail.com";


                $class = input_err_class("global");





                echo '<input type="email" name="email" class="p-1 flex-1 ' . $class . '" value="' . $value . '">';


                ?>


            </div>


        </div>





        <!-- password -->


        <div class="pt-2">


            <span class="t-bold t-capitalize">


                <?php


                echo translator("mot de passe", "password")


                ?>


            </span>


            <div class="flex-1 d-flex pt-1">


                <?php


                //variables


                $value = isset($_POST["password"]) ? $_POST["password"] : "123456789";


                $class = input_err_class("global");





                echo '<input type="password" name="password" class="p-1 flex-1 ' . $class . '" value="' . $value . '">';


                ?>


            </div>


        </div>





        <!-- error msg -->


        <div class="t-center">


            <?php


            input_err("global");


            ?>


        </div>





        <!-- sign in -->


        <div class="d-flex-center pt-3">


            <button type="submit" name="submit" class="btn-large btn-primary">


                <?php


                echo translator("se connecter", "sign in")


                ?>


            </button>


        </div>


    </form>





    <!-- alternative -->


    <div class="t-center pt-2">


        <span class="t-bold t-capitalize">


            <?php


            echo translator("ou", "or")


            ?>


        </span>


    </div>





    <div class="d-flex-center pt-2">


        <a href="auth/sign_up_form" class="btn-large btn-secondary ">


            <?php


            echo translator("créer un compte", "create an account")


            ?>


        </a>


    </div>





</main>


<?php


require_once ROOT . "/src/views/inc/end.php";


?>