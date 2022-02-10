<?php
require_once ROOT . "/src/views/inc/start.php";
//variables
$total_price = $data["total_price"];
$transport_fees = $data["transport_fees"];
$final_price = $data["final_price"];
?>

<main>
    <!-- title -->
    <div class="pt-5 t-4 t-bold t-capitalize t-center">
        <?php
        echo translator("choisisez votre methode de paiement", "choose your payment method");
        ?>

    </div>

    <!-- payment methods -->
    <form action="orders/register_order" method="POST" class="w-p-60 m-auto pt-4">
        <!-- payment icons -->
        <div class="d-flex j-around">
            <?php
            $methods = [
                ["title" => translator("paiement en ligne", "online payment"), "value" => "online", "class" => "bg-online-payment"],
                ["title" => translator("carte banquaire", "credit card"), "value" => "card", "class" => "bg-credit-card"],
                ["title" => translator("payer a livraison", "cash at delivery"), "value" => "cash", "class" => "bg-cash"],
            ];

            foreach ($methods as $method) {
                echo '
            <label class="p-relative d-flex-vertical b-radius-small bg-darkblue h-opacity h-pointer t-capitalize h-15 w-15 js-payment-method">
                <i class="js-icon p-absolute t-5 fas fa-check-circle d-none"></i>
                <input class="d-none" type="radio" name="payment_method" value="' . $method["value"] . '" required>
                <div class="t-center py-1 bg-lightgray t-black">
                    <span>' . $method["title"] . '</span> 
                </div>
                <div class="flex-1 ' . $method["class"] . ' bg-img bg-center">
                </div>
            </label>
            ';
            }
            ?>
        </div>

        <!-- price -->
        <div class="pt-5">
            <?php
            echo '
            <div class="t-center">
                <span>' . translator("prix total sans frais de transport", "total price without transport fees") . ' : 
                <span class="t-bold">' . $total_price . '</span> DH
                <span>
            </div>
            <div class="t-center t-gray pt-1">
                <span><i class="fas fa-dolly-flatbed pr-1"></i>' . translator("frais de transport", "transport fees") . ' : 
                + ' . $transport_fees . ' Dhs
                <span>
            </div>
            <div class="t-center pt-4">
                <span class="t-capitalize">' . translator("prix final", "final price") . ' : 
                <span class="t-bold t-warning t-5">' . $final_price . '</span> Dhs
                <span>
            </div>
            ';
            ?>
        </div>

        <!-- error msg -->
        <?php
        input_err("global");
        ?>

        <!-- confirmation -->
        <div class="d-flex-center pt-3">
            <button type="submit" class="btn-large btn-primary">
                <?php
                echo translator("confirmer votre commande", "confirm your order")
                ?>
            </button>
        </div>



    </form>
</main>

<?php
require_once ROOT . "/src/views/inc/end.php";
?>