<?php
require_once ROOT . "/src/views/inc/start.php";
?>
<main class="d-flex-center">
    <form action="admin/add_fake_reviews" method="post">
        <div class="d-flex-center">
            <input type="text" name="product_id" class="p-1">
        </div>
        <div class="pt-4 d-flex-center">
            <button type="submit" name="submit" class="btn-primary btn-large">apply the test</button>
        </div>
    </form>
</main>

<?php
require_once ROOT . "/src/views/inc/end.php";
?>