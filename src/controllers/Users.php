<?php



class Users extends Controller

{



    public function index()

    {

        $this->send_404();
    }



    public function profile()

    {

        //security

        $this->check_if_logged();



        //serve

        $this->view("users/profile");
    }



    public function orders()

    {

        //security

        $this->check_if_logged();



        //prepare data

        $data = [];



        //get models

        $this->model("Order");

        $order_table = new Order();



        //get orders details

        $data["user_orders_details"] =   $order_table->get_user_orders_details();





        //serve

        $this->view("users/orders", $data);
    }



    public function edit_profile_form()

    {

        $this->check_if_logged();

        $this->view("users/edit_profile");
    }



    public function edit_profile()

    {

        $this->check_if_logged();

        $this->sanitize();



        //variables

        $first_name = $this->post("first_name");

        $last_name = $this->post("last_name");

        $email = $this->post("email");

        $city = $this->post("city");

        $address = $this->post("address");

        $phone = $this->post("phone");

        $old_image_name = $this->post("old_image_name");

        $image = $this->file("image");



        //call models and requirements

        require_once ROOT . "/src/libraries/Check_input.php";

        $this->model("User");

        $user_table = new User();



        //check nulls

        $inputs = [$first_name, $last_name, $email];

        foreach ($inputs as $input) {

            if (!$input) {

                $this->send_error("global", $this->translator("entrez les champs obligatoires", "enter the required values"));
            }
        }



        //check first name

        if (!Check_input::check_name($first_name)) {

            $this->send_error("first_name", $this->translator("mauvais caractéres utilisé", "wrong characters used"));
        }



        //check last name

        if (!Check_input::check_name($last_name)) {

            $this->send_error("last_name", $this->translator("mauvais caractéres utilisé", "wrong characters used"));
        }



        //check the new email

        if (!Check_input::check_email($email)) {

            $this->send_error("email", $this->translator("mauvais caractéres utilisé", "wrong characters used"));
        }

        if ($user_table->check_email($email)) {

            $this->send_error("email", $this->translator("cet email est deja pris", "this email is taken"));
        }



        //check_phone

        if ($phone && !Check_input::check_phone($phone)) {

            $this->send_error("phone", $this->translator("mauvais caractéres utilisé", "wrong characters used"));
        }

        if ($phone && $user_table->check_phone($phone)) {

            $this->send_error("phone", $this->translator("ce numero est deja pris", "this phone number is taken"));
        }



        //check city

        $cities = ["FES", "RABAT", "CASABLANCA", "MARRAKESH", "MEKNES", "TANGER", "AGADIR", "TETOUAN"];

        if ($city && !in_array($city, $cities)) {

            $this->send_error("city", "stop trying kid");
        }



        //check address

        if ($address && !Check_input::check_address($address)) {

            $this->send_error("address", $this->translator("mauvais caractéres utilisé", "wrong characters used"));
        }



        //update image if can

        if ($image) {

            if (!Check_input::check_upload($image, ["jpeg", "png", "jpg"], 5000000)) {

                $this->send_error("image", $this->translator("mauvais type de fichier 

                téléversé", "wrong file uploaded"));
            }

            $temp = explode(".", $image['name']);

            $file_extention = strtolower(end($temp));

            $image_name = uniqid() . "." . $file_extention;

            $temp_location = $image["tmp_name"];

            $image_location = ROOT . "/img/profiles/" . $image_name;

            move_uploaded_file($temp_location, $image_location);

            if ($old_image_name != "default.jpg") {

                unlink(ROOT . "/img/products/" . $old_image_name);
            }
        } else {

            $image_name = $old_image_name;
        }



        //edit the user 

        $user_table->edit_user($first_name, $last_name, $email, $phone, $city, $address, $image_name);



        //alter session

        $_SESSION["first_name"] = $first_name;

        $_SESSION["last_name"] = $last_name;

        $_SESSION["user_email"] = $email;

        $_SESSION["user_phone"] = $phone;

        $_SESSION["user_city"] = $city;

        $_SESSION["user_address"] = $address;

        $_SESSION["user_image"] = $image_name;

        $_SESSION["success"] = $this->translator("votre profile a été mis a jour", "your profile has been updated");



        //redirect

        header("location:/users/profile");
    }



    public function add_reaction()

    {

        $this->check_if_logged();

        //variables

        $comment_id = $this->get("comment_id");



        //call models

        $this->model("Reaction");

        $reaction_table = new Reaction();

        $this->model("Review");

        $review_table = new Review();



        //add reaction

        $review_table->add_reaction($comment_id);

        $reaction_table->add_reaction($comment_id);



        //alter session

        array_push($_SESSION["user_reactions"], $comment_id);
    }



    public function remove_reaction()

    {

        $this->check_if_logged();

        //variables

        $comment_id = $this->get("comment_id");



        //call models

        $this->model("Reaction");

        $reaction_table = new Reaction();

        $this->model("Review");

        $review_table = new Review();



        //remove reaction

        $review_table->remove_reaction($comment_id);

        $reaction_table->remove_reaction($comment_id);



        //alter session

        foreach ($_SESSION["user_reactions"] as $key => $value) {

            if ($comment_id == $value) {

                unset($_SESSION["user_reactions"][$key]);
            }
        }
    }



    public function change_password_form()

    {

        $this->check_if_logged();

        $this->view("users/change_password");
    }



    public function change_password()

    {

        $this->check_if_logged();

        $this->sanitize();



        //variables

        $old_password = $this->post("old_password");

        $password = $this->post("password");

        $confirmed_password = $this->post("confirmed_password");



        //call models and requirements

        require_once ROOT . "/src/libraries/Check_input.php";

        $this->model("User");

        $user_table = new User();



        //check nulls

        $inputs = [$old_password, $password, $confirmed_password];

        foreach ($inputs as $input) {

            if (!$input) {

                $this->send_error("global", $this->translator("ne laissez pas d'espace vide", "don't leave empty fields"));
            }
        }



        //check old password

        if (!$user_table->check_old_password($old_password)) {

            $this->send_error("old_password", $this->translator("mot de passe erroné", "wrong password"));
        }



        //check the passwords

        if (!Check_input::check_password($password)) {

            $this->send_error("password", $this->translator("mot de passe trop court ou mauvais caractéres utilisé", "short password or wrong characters used"));
        }

        if (!Check_input::check_password_confirmation($password, $confirmed_password)) {

            $this->send_error("confirmed_password", $this->translator("vos nouveaux mots ed passes ne sont pas identiques", "your new passwords don't match"));
        }



        //hash the password

        $password = password_hash($password, PASSWORD_DEFAULT);



        //change password

        $user_table->change_password($password);



        //success

        $_SESSION["success"] = $this->translator("votre mot de passe a été mis a jour", "your password has been updated");



        //redirect

        header("location:/users/profile");
    }



    public function add_to_favourites()

    {

        //security

        $this->check_if_logged();

        $this->sanitize();



        //input

        $product_id = $this->get("product_id");



        //call models

        $this->model("Favourite");

        $favourite_table = new Favourite();



        //add to the list

        $favourite_table->add_product($product_id);



        //alter session

        array_push($_SESSION["user_favourites"], $product_id);



        //redirect

        $this->send_back();
    }



    public function favourites()

    {

        //security

        $this->check_if_logged();



        //call models

        $this->model("Product");

        $product_table = new Product();



        //prepare data

        $data = [];



        //get products data

        $products = [];

        foreach ($_SESSION["user_favourites"] as $product_id) {

            $product = $product_table->get_product_by_id($product_id);

            array_push($products, $product);
        }



        //inset data

        $data["products"] = $products;



        //serve

        $this->view("users/favourites", $data);
    }



    public function remove_from_favourites()

    {

        //security

        $this->check_if_logged();

        $this->sanitize();



        //input

        $product_id = $this->get("product_id");



        //call models

        $this->model("Favourite");

        $favourite_table = new Favourite();



        //remove from the list

        $favourite_table->remove_product($product_id);



        //alter session

        foreach ($_SESSION["user_favourites"] as $key => $favourite_product_id) {

            if ($favourite_product_id == $product_id) {

                unset($_SESSION["user_favourites"][$key]);
            }
        }



        //redirect

        $this->send_back();
    }



    public function report_form()

    {

        //security

        $this->check_if_logged();



        //serve

        $this->view("users/report");
    }



    public function report()

    {

        //security

        $this->check_if_logged();

        $this->sanitize();



        //input

        $title = $this->post("title");

        $description = $this->post("description");



        //check description

        if (!$description) {

            $_SESSION["failure"] = $this->translator("entrez une description du probleme", "entrez the problem description");

            $this->send_back();
        }



        //call models

        $this->model("Report");

        $report_table = new Report();



        //insert report

        $report_table->add_report($title, $description);



        //redirect

        $_SESSION["success"] = $this->translator("le probleme a été signalé", "the problem have been reported");

        $this->send_home();
    }
}
