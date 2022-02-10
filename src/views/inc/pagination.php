<?php
//variables
$total_pages = $_SESSION["total_pages"];
$page = $_GET["page"];

//pagination
if ($total_pages > 1) {
    echo '<div class="d-flex-center py-1">';
    //prev btn
    if ($page != 1) {
        echo '<label class="btn-secondary m-1 btn-small t-1">
        ' . translator("precedant", "prev") . '
        <input form="default-form" type="radio" name="page" class="d-none js-default-target" value=' . ($page - 1) . ' >
        </label>';
    }
    //variables
    $page_btns = [];

    //buttons display conditions
    if ($page == 3) {
        array_push($page_btns, 1);
    }
    if ($page >= 4) {
        array_push($page_btns, 1);
    }
    if ($page - 1 > 0) {
        array_push($page_btns, $page - 1);
    }
    array_push($page_btns, $page);
    if ($page + 1 <= $total_pages) {
        array_push($page_btns, $page + 1);
    }
    if ($page + 2 < $total_pages) {
        array_push($page_btns, $total_pages);
    }
    if ($page + 2 == $total_pages) {
        array_push($page_btns, $total_pages);
    }

    //display buttons
    foreach ($page_btns as $page_btn) {
        if ($page_btn == $total_pages && $page + 2 < $total_pages) {
            echo ". . .";
        }
        echo '<label class="';
        echo $page_btn == $page ? ' bg-primary t-white ' : ' btn-secondary ';
        echo 'm-1 t-1 btn-small">
        ' . ($page_btn) . '
        <input form="default-form" type="radio" name="page" class="d-none js-default-target" value=' . ($page_btn) . ' >
        </label>';
        if ($page_btn == 1 && $page >= 4) {
            echo ". . .";
        }
    }

    //next btn
    if ($page != $total_pages) {
        echo ' <label class="btn-secondary m-1 btn-small t-1">
        ' . translator("suivant", "next") . '
        <input form="default-form" type="radio" name="page" class="d-none js-default-target" value=' . ($page + 1) . ' >
        </label>';
    }
    echo '</div>';
}
