<?php
require_once ROOT . "/src/views/inc/start.php";
?>
<main class="pb-10">
    <!-- section title -->
    <div class="py-4 t-center">
        <span class="t-capitalize t-6">rapports</span>
    </div>

    <!-- section reports -->
    <section class="w-p-70 m-auto">
        <?php
        foreach ($data["reports"] as $report) {
            //variables
            $username = $report["first_name"] . ' ' . $report["last_name"];
            $date = $report["date"];
            $title = $report["title"];
            $description = $report["description"];
            $id = $report["id"];

            //render
            echo '
        <section class="mt-2 b-gray">
            <div class="d-flex j-between p-1 bg-lightgray">
                <div>
                    <span class="t-gray">de la part de : </span>
                    <span class="t-capitalize">' . $username . '</span>
                </div>
                <div>
                    <span class="t-gray">signalé le : </span>
                    <span class="t-capitalize">' . $date . '</span>
                </div>
            </div>
            <div class="p-2 bg-white">
                <div class="t-bold">
                    ' . $title . '
                </div>
                <hr class="my-1">
                <div>
                    ' . $description . '
                </div>
            </div>
            <div class="p-1 d-flex j-end bg-lightgray">
                <a href="admin/delete_reports?id=' . $id . '" class="t-link">-- supprimer --</a>
            </div>
        </section>
        ';
        }
        ?>
    </section>

</main>
<?php
require_once ROOT . "/src/views/inc/end.php";
?>