<?php
require_once ROOT . "/src/views/inc/start.php";
?>

<main class="p-3">
    <div class="d-flex-center t-8 t-success pt-5">
        <i class="fas fa-check-circle"></i>
    </div>
    <div class="pt-3 t-center t-capitalize t-3">
        <span class="w-p-40">
            <?php
            echo translator("merci pour votre commande et votre confiance en nous, vous recevrez votre marchandise dans les ", "thank you for you order and your trust, you will be receiving your merchandise in the next ");
            ?>
            <strong>
                48
                <?php
                echo translator("heures", "hours")
                ?>
            </strong>,
            <?php
            echo translator("nous vous contacterons pour finaliser l'operation", "we will call you to finalise the transaction")
            ?>
        </span>
    </div>
</main>

<?php
require_once ROOT . "/src/views/inc/end.php";
?>