<?php



class Auth extends Controller



{







    public function index()



    {



        $this->send_404();
    }







    public function sign_in_form()



    {



        $this->check_if_not_logged();



        $this->view("auth/sign_in");
    }







    public function sign_in()



    {



        $this->check_if_not_logged();



        $this->sanitize();







        //variables



        $email = $this->post("email");



        $password = $this->post("password");







        //get models



        $this->model("User");



        $user_table = new User();



        $this->model("Order");



        $order_table = new Order();



        $this->model("Review");



        $review_table = new Review();



        $this->model("Reaction");



        $reaction_table = new Reaction();



        $this->model("Favourite");



        $favourite_table = new Favourite();



        require_once ROOT . "/src/libraries/Check_input.php";







        //check null



        if (!$email || !$password) {



            $this->send_error("global", $this->translator("ne laissez pas d'espace libre", "don't leave any empty fields"));
        }







        //check user



        if (!$user_table->check_user($email, $password)) {



            $this->send_error("global", $this->translator("email ou mot de passe erroné", "wrong email or password"));
        }







        //create user_id session



        $user_data = $user_table->get_user_data($email);



        $_SESSION["user_id"] = $user_data["id"];







        //get user orders



        $user_orders = $order_table->get_user_orders();



        foreach ($user_orders as $key => $order) {



            $user_orders[$key] = $order["product_id"];
        }



        $user_orders = array_unique($user_orders);







        //get user reviews



        $user_reviews = $review_table->get_user_reviews();



        foreach ($user_reviews as $key => $review) {



            $user_reviews[$key] = $review["product_id"];
        }



        $user_reviews = array_unique($user_reviews);







        //get user reactions



        $user_reactions = $reaction_table->get_user_reactions();



        foreach ($user_reactions as $key => $reaction) {



            $user_reactions[$key] = $reaction["comment_id"];
        }



        $user_reactions = array_unique($user_reactions);







        // get users favourites



        $user_favourites = $favourite_table->get_user_favourites();



        foreach ($user_favourites as $key => $user_favourite) {



            $user_favourites[$key] = $user_favourite["product_id"];
        }



        $user_favourites = array_unique($user_favourites);







        //session creation



        $_SESSION["user_orders"] = $user_orders;



        $_SESSION["user_reviews"] = $user_reviews;



        $_SESSION["user_reactions"] = $user_reactions;



        $_SESSION["user_favourites"] = $user_favourites;







        //personal infos



        $_SESSION["first_name"] = $user_data["first_name"];



        $_SESSION["last_name"] = $user_data["last_name"];



        $_SESSION["user_email"] = $user_data["email"];



        $_SESSION["user_phone"] = $user_data["phone"];



        $_SESSION["user_address"] = $user_data["address"];



        $_SESSION["user_city"] = $user_data["city"];



        $_SESSION["user_type"] = $user_data["type"];



        $_SESSION["user_image"] = $user_data["image_name"];







        //redirect



        $this->send_home();
    }







    public function sign_up_form()



    {



        $this->check_if_not_logged();



        $this->view("auth/sign_up");
    }







    public function sign_up()



    {



        $this->check_if_not_logged();



        $this->sanitize();







        //variables



        $first_name = $this->post("first_name");



        $last_name = $this->post("last_name");



        $email = $this->post("email");



        $password = $this->post("password");



        $confirmed_password = $this->post("confirmed_password");







        //call models and requirements



        require_once ROOT . "/src/libraries/Check_input.php";



        $this->model("User");



        $user_table = new User();







        //check nulls



        $inputs = [$first_name, $last_name, $email, $password, $confirmed_password];



        foreach ($inputs as $input) {



            if (!$input) {



                $this->send_error("global", $this->translator("ne laissez pas d'espace libre", "don't leave any empty fields"));
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







        //check the email



        if (!Check_input::check_email($email)) {



            $this->send_error("email", $this->translator("mauvais caractéres utilisé", "wrong characters used"));
        }



        if ($user_table->check_email($email)) {



            $this->send_error("email", $this->translator("cet email est deja pris", "this email is taken"));
        }











        //check the passwords



        if (!Check_input::check_password($password)) {



            $this->send_error("password", $this->translator("mot de passe trop court, ou mauvais caractéres utilisé", "short password or wrong characters used"));
        }



        if (!Check_input::check_password_confirmation($password, $confirmed_password)) {



            $this->send_error("confirmed_password", $this->translator("vos mots de passes ne sont pas identiques", "your passwords are not matching"));
        }







        //hash the password



        $password = password_hash($password, PASSWORD_DEFAULT);







        //register the user 



        $user_table->register_user($first_name, $last_name, $email, $password);







        //alter session



        $_SESSION['success'] = $this->translator("votre compte a été créé", "you have been registered");







        //redirect



        header("location:/auth/sign_in_form");
    }







    public function sign_out()



    {



        $this->check_if_logged();



        session_destroy();



        $this->send_home();
    }
}
