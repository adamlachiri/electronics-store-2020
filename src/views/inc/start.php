<?php



require_once ROOT . "/src/views/inc/components.php";



require_once ROOT . "/src/views/inc/functions.php";



?>



<!DOCTYPE html>



<html lang="en">







<head>



    <meta charset="UTF-8">



    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />


    <!-- test -->


    <base href="<?php echo URLROOT ?>">



    <link rel="stylesheet" href="css/app.css">



    <script src="https://kit.fontawesome.com/edfed9decb.js" crossorigin="anonymous"></script>



    <title><?php echo SITENAME; ?></title>



</head>







<body class="t-lato t-2">



    <!-- loading -->

    <section class="js-loading-page ">
        <div>
            <div class="d-flex a-center j-center">
                <img src="img/icons/logo.png" alt="">
            </div>
            <div class="pt-3 text-center">
                <h6>LOADING . . .</h6>
            </div>
        </div>
    </section>



    <!-- default form -->



    <form id="default-form" action="" method="GET" class="d-none">



        <button type="submit" class="js-default-btn"></button>



    </form>







    <?php



    require_once ROOT . "/src/views/inc/navigation.php";



    ?>