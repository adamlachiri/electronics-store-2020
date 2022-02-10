<?php
require_once ROOT . "/src/views/inc/start.php";
?>

<main>

    <!-- section form -->
    <form action="users/report" method="post" class="w-p-50 m-auto mt-5 p-2 b-gray">

        <!-- title -->
        <div class="">
            <span class="t-capitalize t-5">
                <?php
                echo translator("decrivez le probleme rencontré", "describe the problem");
                ?>
            </span>
        </div>
        <hr class="mt-2">

        <!-- report title -->
        <div class="d-flex pt-2">
            <div class="flex-3">
                <span class="t-capitalize">
                    <?php
                    echo translator("titre", "title");
                    ?>
                </span>
            </div>
            <input class="flex-5 p-1" type="text" name="title" />
        </div>

        <!-- description -->
        <div class="d-flex pt-2">
            <div class="flex-3">
                <span class="t-capitalize">
                    <?php
                    echo translator("description du problem", "problem description");
                    ?>
                    <strong class="t-alert t-3">*</strong>
                </span>
            </div>
            <textarea name="description" rows="10" class="flex-5 p-1"></textarea>
        </div>

        <!-- submit -->
        <div class="d-flex-center pt-4">
            <button class="btn-primary btn-large">
                <?php
                echo translator("soumettre le rapport", "submit the report")
                ?>
            </button>
        </div>

    </form>
</main>

<?php
require_once ROOT . "/src/views/inc/end.php";
?>