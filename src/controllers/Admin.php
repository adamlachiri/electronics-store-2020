<?php
class Admin extends Controller
{
    public function index()
    {
        $this->send_404();
    }

    public function add_product_form()
    {
        //security
        $this->check_if_admin();

        //serve
        $this->view("admin/add_product");
    }

    public function add_product()
    {
        //security
        $this->check_if_admin();

        //input
        $name = $this->post("name");
        $category = $this->post("category");
        $original_price = $this->post("original_price");
        $quantity = $this->post("quantity");
        $promotion = $this->post("promotion");
        $image_1 = $this->file("image_1");
        $image_2 = $this->file("image_2");
        $image_3 = $this->file("image_3");
        $image_4 = $this->file("image_4");
        $image_5 = $this->file("image_5");
        $video_src = $this->post("video_src");
        $coupon_code = $this->post("coupon_code");
        $coupon_reduction = $this->post("coupon_reduction");
        $guarantee = $this->post("guarantee");

        //call models and requirememnts
        require_once ROOT . "/src/libraries/Check_input.php";
        $this->model("Product");
        $product = new Product();

        //check empty
        $inputs = [$name, $category, $original_price, $quantity, $image_1];
        foreach ($inputs as $input) {
            if (!$input) {
                $this->send_error("global", "entrz toutes les valeurs demandées");
            }
        }

        //check name
        if ($product->check_product_name($name)) {
            $this->send_error("name", "ce produit existe deja dans notre base de donneés");
        }

        //upload images
        $images = [
            $image_1,
            $image_2,
            $image_3,
            $image_4,
            $image_5
        ];
        foreach ($images as $key => $image) {
            if ($image) {
                if (!Check_input::check_upload($image, ["jpeg", "png", "jpg"], 5000000)) {
                    $this->send_error("global", "l'une des images télévérsé est du mauvais type, ou bien trop large");
                }
                $temp = explode(".", $image['name']);
                $file_extention = strtolower(end($temp));
                $temp_location = $image["tmp_name"];
                $image_name = uniqid() . "." . $file_extention;
                $image_location = ROOT . "/img/products/" . $image_name;
                move_uploaded_file($temp_location, $image_location);
                $images[$key] = $image_name;
            }
        }


        //calculate the price
        if ($promotion) {
            $price = (float)$original_price * (100 - $promotion) / 100;
            $price = number_format($price, 2, '.', '');
        } else {
            $price = $original_price;
        }

        //register product
        $product->register_product(
            $name,
            $category,
            $price,
            $original_price,
            $promotion,
            $images[0],
            $images[1],
            $images[2],
            $images[3],
            $images[4],
            $quantity,
            $video_src,
            $coupon_code,
            $coupon_reduction,
            $guarantee
        );

        //alter session
        $_SESSION["success"] = "le produit a été rajouté avec succès";

        //redirect
        header("location:/admin/add_product");
    }

    public function search_product()
    {
        //security
        $this->check_if_admin();

        //call model
        $this->model("Product");
        $product_table = new Product();

        //input
        $name = $this->get("edit_name");

        $data = $name ? ["products" => $product_table->get_products($name, null, null, null, "", "")]  : [];

        //serve
        $this->view("admin/search_product", $data);
    }

    public function edit_product_form()
    {
        //security
        $this->check_if_admin();

        //input
        $id = $this->get("id");

        //call models
        $this->model("Product");
        $product_table = new Product();

        //get product
        $product = $product_table->get_product_by_id($id);

        //serve
        $this->view("admin/edit_product", ["product" => $product]);
    }

    public function edit_product()
    {
        //security
        $this->check_if_admin();

        //call models and requirememnts
        require_once ROOT . "/src/libraries/Check_input.php";
        $this->model("Product");
        $product_table = new Product();

        //input
        $id = $this->post("id");
        $quantity = $this->post("quantity");
        $name = $this->post("name");
        $category = $this->post("category");
        $original_price = $this->post("original_price");
        $add_to_stock = $this->post("add_to_stock");
        $promotion = $this->post("promotion");
        $old_image_1 = $this->post("old_image_1");
        $old_image_2 = $this->post("old_image_2");
        $old_image_3 = $this->post("old_image_3");
        $old_image_4 = $this->post("old_image_4");
        $old_image_5 = $this->post("old_image_5");
        $image_1 = $this->file("image_1");
        $image_2 = $this->file("image_2");
        $image_3 = $this->file("image_3");
        $image_4 = $this->file("image_4");
        $image_5 = $this->file("image_5");
        $video_src = $this->post("video_src");
        $coupon_code = $this->post("coupon_code");
        $coupon_reduction = $this->post("coupon_reduction");
        $guarantee = $this->post("guarantee");

        //check empty
        $inputs = [$name, $category, $original_price];
        foreach ($inputs as $input) {
            if (!$input) {
                $this->send_error("global", "entez toutes les valeurs obligatoire");
            }
        }

        //update image if can
        $images = [
            ["image_file" => $image_1, "old_image_name" => $old_image_1],
            ["image_file" => $image_2, "old_image_name" => $old_image_2],
            ["image_file" => $image_3, "old_image_name" => $old_image_3],
            ["image_file" => $image_4, "old_image_name" => $old_image_4],
            ["image_file" => $image_5, "old_image_name" => $old_image_5],
        ];
        foreach ($images as $key => $image) {
            // variables
            $image_file = $image["image_file"];
            $old_image_name = $image["old_image_name"];
            if ($image_file) {
                if (!Check_input::check_upload($image_file, ["jpeg", "png", "jpg"], 5000000)) {
                    $this->send_error("global", "mauvais type d'image téléversé");
                }
                $temp = explode(".", $image_file['name']);
                $file_extention = strtolower(end($temp));
                $image_name = uniqid() . "." . $file_extention;
                $temp_location = $image_file["tmp_name"];
                $image_location = ROOT . "/img/products/" . $image_name;
                move_uploaded_file($temp_location, $image_location);
                unlink(ROOT . "/img/products/" . $old_image_name);
            } else {
                $image_name = $old_image_name;
            }
            $images[$key] = $image_name;
        }


        //calculate the price
        if ($promotion) {
            $price = (float)$original_price * (100 - $promotion) / 100;
            $price = number_format($price, 2, '.', '');
        } else {
            $price = $original_price;
        }

        //add to stock
        $quantity = $quantity ? $quantity : 0;
        if ($add_to_stock) {
            $quantity += $add_to_stock;
        }

        //edit product
        $product_table->edit_product(
            $id,
            $name,
            $category,
            $price,
            $original_price,
            $promotion,
            $images[0],
            $images[1],
            $images[2],
            $images[3],
            $images[4],
            $quantity,
            $video_src,
            $coupon_code,
            $coupon_reduction,
            $guarantee
        );

        //alter session
        $_SESSION["success"] = "le produit a été modifié avec succès";

        //redirect
        header("location:/admin/search_product");
    }

    public function delete_product()
    {
        //security
        $this->check_if_admin();

        //call models
        $this->model("Product");
        $product_table = new Product();

        //input
        $product_id = $this->get("id");

        //delete image
        $images_names = $product_table->get_images_names($product_id);
        foreach ($images_names as $image_name) {
            if ($image_name) {
                unlink(ROOT . "/img/products/" . $image_name);
            }
        }


        //delete the ad
        $product_table->delete_product($product_id);

        //success
        $_SESSION["success"] = "le produit a été supprimé de notre base de données avec succès";

        header("location:/admin/search_product");
    }

    public function advertising()
    {
        //security
        $this->check_if_admin();

        //serve
        $this->view("admin/advertising");
    }

    public function add_ad_form()
    {
        //security
        $this->check_if_admin();

        //serve
        $this->view("admin/add_ad");
    }

    public function add_ad()
    {
        //security
        $this->check_if_admin();

        //input
        $product_id = $this->post("product_id");
        $image = $this->file("image");
        $type = $this->post("type");

        //call model
        $this->model("Ads");
        $ads_table = new Ads();
        require_once ROOT . "/src/libraries/Check_input.php";

        //check empty
        $inputs = [$product_id, $image, $type];
        foreach ($inputs as $input) {
            if (!$input) {
                $this->send_error("global", "entrez toutes les valeures obligatoires");
            }
        }

        //upload image if can
        if (!Check_input::check_upload($image, ["jpeg", "png", "jpg"], 10000000)) {
            $this->send_error("global", "wrong file uploaded");
        }
        $temp = explode(".", $image['name']);
        $file_extention = strtolower(end($temp));
        $image_name = uniqid() . "." . $file_extention;
        $temp_location = $image["tmp_name"];
        $image_location = ROOT . "/img/ads/" . $image_name;
        move_uploaded_file($temp_location, $image_location);

        //register add
        $ads_table->register_ad($image_name, $product_id, $type);

        //alter session
        $_SESSION["success"] = "la nouvelle pub a été rajouté";

        //redirect
        header("location:/admin/advertising");
    }

    public function edit_ad_form()
    {
        //security
        $this->check_if_admin();

        //call models
        $this->model("Ads");
        $ads_table = new Ads();

        //input
        $id = $this->get("id");

        //get ad details
        $ad_details = $ads_table->get_ad($id);

        //serve
        $this->view("admin/edit_ad", ["ad_details" => $ad_details]);
    }

    public function edit_ad()
    {
        //security
        $this->check_if_admin();

        //call models
        $this->model("Ads");
        $ads_table = new Ads();
        require_once ROOT . "/src/libraries/Check_input.php";

        //input
        $ad_id = $this->post("ad_id");
        $old_image_name = $this->post("old_image_name");
        $product_id = $this->post("product_id");
        $image = $this->file("image");

        //check empty
        $inputs = [$product_id, $old_image_name, $ad_id];
        foreach ($inputs as $input) {
            if (!$input) {
                $this->send_error("global", "entrez l'id du produit");
            }
        }

        //update image if can
        if ($image) {
            if (!Check_input::check_upload($image, ["jpeg", "png", "jpg"], 10000000)) {
                $this->send_error("global", "mauvais type d'image téléversé");
            }
            $temp = explode(".", $image['name']);
            $file_extention = strtolower(end($temp));
            $image_name = uniqid() . "." . $file_extention;
            $temp_location = $image["tmp_name"];
            $image_location = ROOT . "/img/ads/" . $image_name;
            move_uploaded_file($temp_location, $image_location);
            unlink(ROOT . "/public/img/ads/" . $old_image_name);
        } else {
            $image_name = $old_image_name;
        }

        //update ad
        $ads_table->edit_ad($ad_id, $image_name, $product_id);

        //success
        $_SESSION["success"] = "les details de la pub ont été modifiés avec succès";

        header("location:/admin/advertising");
    }

    public function delete_ad()
    {
        //security
        $this->check_if_admin();

        //call models
        $this->model("Ads");
        $ads_table = new Ads();

        //input
        $ad_id = $this->get("id");

        //delete image
        $image_name = $ads_table->get_image_name($ad_id);
        unlink(ROOT . "/public/img/ads/" . $image_name);

        //delete the ad
        $ads_table->delete_ad($ad_id);

        //success
        $_SESSION["success"] = "la pub a été supprimée de notre base de données succès";

        header("location:/admin/advertising");
    }

    public function test_form()
    {
        //security
        $this->check_if_admin();

        //serve
        $this->view("admin/test");
    }

    public function add_fake_users()
    {
        die();
        //security
        $this->check_if_admin();

        //call model
        $this->model("User");
        $user_table = new User();

        if (!isset($_POST["submit"])) {
            $_SESSION["failure"] = "mauvaise route";
            $this->send_404();
        }

        try {
            for ($i = 1; $i <= 40; $i++) {
                $first_name = "user";
                $last_name = (string)$i;
                $email = $first_name . $last_name . "@gmail.com";
                $password = password_hash("$", PASSWORD_DEFAULT);

                //register the user 
                $user_table->register_user($first_name, $last_name, $email, $password);
            }
        } catch (Exception $e) {
            echo "this is not working";
        }

        $_SESSION["success"] = "enfin";
    }

    public function add_fake_reviews()
    {
        //security
        $this->check_if_admin();

        //call models
        $this->model("Product");
        $product_table = new Product();
        $this->model("Review");
        $review_table = new Review();
        $this->model("User");
        $user_table = new User();

        if (!isset($_POST["submit"])) {
            $_SESSION["failure"] = "mauvaise route";
            $this->send_404();
        }

        //fake data
        $fake_comments = [
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi, tempore.",
            "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Vitae reiciendis officiis earum voluptate corporis molestiae quas delectus ad dolor porro",
            "Lorem ipsum dolor, sit amet consectetur adipisicing elit. Assumenda quos maxime laudantium dicta! Repellendus, nihil optio hic perferendis tempore nulla quam soluta at odit! Esse tempore provident soluta facere culpa ipsum hic quam odit nesciunt natus eaque odio fugiat vel dolorum voluptate nulla, exercitationem aliquam quae amet veniam, itaque ea.",
            "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui beatae quam maiores maxime sequi officia?",
            "Lorem ipsum dolor sit, amet consectetur adipisicing.",
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati minus ipsam magni aliquid beatae animi dolorem.",
            "Lorem ipsum, dolor sit amet consectetur adipisicing elit.",
            "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum tenetur atque asperiores dicta deserunt animi odit, corporis eaque totam pariatur perspiciatis? Tempore ad cum consectetur dolorem.",
            "Lorem ipsum dolor, sit amet consectetur adipisicing elit. Natus officia ratione alias doloremque quos sed exercitationem molestias id voluptatibus facilis consequatur, nisi, dicta illum, nemo rerum quod asperiores? Accusamus dicta a natus dolorem omnis nulla qui voluptate tempora aliquid consequuntur ut iure, suscipit in praesentium repellat ex, hic fuga nemo nihil quasi perspiciatis deleniti quod ullam! Vel, sint numquam minima esse amet voluptatum vitae sapiente consequatur optio sed ex incidunt delectus, officiis fuga aspernatur quidem officia harum nostrum neque nulla dicta ut repudiandae quas et. In ullam perferendis veritatis porro quidem vero non voluptate architecto, sit ex sapiente labore incidunt!",
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore, distinctio. Quam sequi nulla voluptates inventore nostrum provident saepe ea ipsam culpa repudiandae! Reprehenderit facilis illum explicabo consectetur dignissimos reiciendis voluptas labore architecto? Doloremque eligendi officia consequatur autem, temporibus exercitationem sit aut facilis quam. Deserunt voluptatem ad laborum iure commodi. Consequuntur soluta ratione unde numquam nulla aperiam libero distinctio quaerat nihil.",
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti facilis, cum ullam accusantium molestiae impedit sed tenetur, obcaecati necessitatibus non, id maiores eligendi ut labore optio corporis officiis. Eius porro delectus cupiditate unde assumenda obcaecati magnam omnis cumque est tempora? Quidem harum veniam quisquam reiciendis, aperiam vitae at praesentium provident delectus assumenda nemo error quaerat. Officiis, deserunt modi sint eaque itaque illo totam recusandae ipsum quia in ratione, quae nostrum?",
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa quod perferendis dolor deserunt repellendus fuga aut architecto quas! Hic numquam illum accusamus dolorum repellendus nemo a, cupiditate omnis ad iure dicta nobis alias soluta iusto ducimus molestias tenetur ipsam, tempora earum! Quo numquam inventore quam, minus provident omnis voluptatibus magnam incidunt quos? Est laborum aliquam quaerat saepe rerum iure. Commodi veniam officiis facilis, adipisci, et dignissimos sunt incidunt doloremque atque dolores accusantium quibusdam sit amet quo aliquam? Ab, molestiae quos",
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati fuga nihil optio laborum est eum facere vero deleniti numquam possimus illum enim in earum necessitatibus velit quaerat, ipsam nostrum facilis consectetur totam neque tempora? Quos esse sequi explicabo excepturi sed!",
            "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Pariatur cum voluptate eligendi, obcaecati consectetur autem omnis sapiente harum accusamus! Nostrum neque veniam aperiam accusamus architecto culpa reprehenderit laborum blanditiis consequuntur dignissimos repellat amet similique omnis accusantium odio eaque laboriosam, nemo optio, tenetur nesciunt beatae debitis ad, exercitationem voluptatem. Quasi dolorem, voluptatum nisi ducimus totam maxime corporis! Libero at expedita dignissimos accusamus blanditiis repellat dolorem maiores, minus perspiciatis ipsum repudiandae voluptas iure illo perferendis aperiam harum doloribus nobis voluptatibus necessitatibus ullam sequi, obcaecati unde doloremque. Facilis ipsa sit magni est numquam."
        ];
        $fake_ratings =
            [
                "1", "2", "3", "4", "5", "5", "5", "5", "5", "5", "5"
            ];

        //get all products ids
        $products_ids = $product_table->get_all_ids();
        foreach ($products_ids as $key => $product_id) {
            $products_ids[$key] = $product_id["id"];
        }

        //get all users ids
        $users_ids = $user_table->get_all_ids();
        foreach ($users_ids as $key => $user_id) {
            $users_ids[$key] = $user_id["id"];
        }

        //insert ratings and comments
        foreach ($products_ids as $product_id) {
            $reviews_ids = $review_table->get_product_reviews_ids($product_id);
            foreach ($reviews_ids as $key => $item) {
                $reviews_ids[$key] = $item["user_id"];
            }

            foreach ($users_ids as $user_id) {
                //fake review generator
                $fake_rating = $fake_ratings[rand(0, 8)];
                $fake_comment = $fake_comments[rand(0, count($fake_comments) - 1)];
                if (!in_array($user_id, $reviews_ids)) {
                    //register fake review
                    $review_table->register_fake_review($product_id, $fake_rating, $fake_comment, $user_id);

                    //add rating to product
                    $product_table->add_rating($product_id, $fake_rating);
                } else {
                    //get the old rating
                    $old_rating = $review_table->get_fake_rating($user_id, $product_id);

                    //edit fake review
                    $review_table->edit_fake_review($product_id, $fake_rating, $fake_comment, $user_id);

                    //edit rating to product
                    $product_table->edit_rating($product_id, $fake_rating, $old_rating);
                }
            }
        }


        //redirect
        $_SESSION["success"] = "les fakes evaluations ont eté rajouté";
        $this->send_back();
    }

    public function ads_list()
    {
        //security
        $this->check_if_admin();

        //call model
        $this->model("Ads");
        $ads_table = new Ads();

        //get data
        $ads = $ads_table->get_ads();

        //serve
        $this->view("admin/ads_list", ["ads" => $ads]);
    }

    public function test()
    {
        die();
        //security
        $this->check_if_admin();

        // get model
        $this->model("Product");
        $product_table = new Product();

        //data
        $guarantees = ["6", "12", "24", NULL];

        //get all products ids
        $products_ids = $product_table->get_all_ids();
        foreach ($products_ids as $item) {
            $product_id = $item["id"];
            $guarantee = $guarantees[rand(0, 3)];
            $product_table->add_guarantee($product_id, $guarantee);
        }

        //success
        $_SESSION["success"] = "all the guarantees have been added";

        //redirect
        $this->send_back();
    }

    public function reports()
    {
        //security
        $this->check_if_admin();

        //prepare data
        $data = [];

        //get model
        $this->model("Report");
        $reports_table = new Report();

        //get reports
        $data["reports"] = $reports_table->get_reports();

        //serve
        $this->view("admin/reports", $data);
    }

    public function delete_reports()
    {
        //security
        $this->check_if_admin();

        //input
        $report_id = $this->get("id");

        //get model
        $this->model("Report");
        $reports_table = new Report();

        //get reports
        $reports_table->delete_report($report_id);

        //serve
        $_SESSION["success"] = "rapport supprimé";
        $this->send_back();
    }
}
