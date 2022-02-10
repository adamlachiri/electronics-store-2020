<?php
//variables
$total_pages = $_SESSION["total_pages"];
$total_results = $_SESSION["total_results"];
$results_per_page = $_SESSION["results_per_page"];
$page = $_GET["page"];
$end = $page * $results_per_page > $total_results ? $total_results : $page * 10;
$start = $page * $results_per_page - 9;

echo '<div>' . $start . ' -> ' . $end . ' / ' . $total_results . ' ' . translator("résultats", "results") . '</div>';
