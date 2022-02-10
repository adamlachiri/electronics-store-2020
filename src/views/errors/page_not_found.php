<?php
require_once ROOT . "/src/views/inc/start.php";
?>
<main class="h-fill d-flex">
    <div class="d-flex-vertical j-center flex-1">
        <div class="t-center t-4 pt-3 t-capitalize">
            <?php
            echo translator("desolé, mais cette page n'existe pas", "sorry but this page does not exist")
            ?>
        </div>
        <div class="pt-3 d-flex-center">
            <a href="" class="btn-primary btn-small">
                <?php
                echo translator("retourner a la page d'acceuil", "go back to the home page")
                ?>
            </a>
        </div>
    </div>
    <div class="flex-2 d-flex-center">
        <img src="img/bg/bg-404.png" alt="" class="img-fluid">
    </div>

</main>
<?php
require_once ROOT . "/src/views/inc/end.php";
?>