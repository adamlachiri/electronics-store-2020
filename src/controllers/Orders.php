<?php

class Orders extends controller
{
    public function index()
    {
        $this->send_404();
    }

    public function personal_info()
    {
        //security
        $this->check_if_logged();

        //serve
        $this->view("orders/personal_info");
    }

    public function confirm_personal_info()
    {
        //security
        $this->check_if_logged();
        $this->sanitize();

        //check step
        if (!$this->session("order_step") == 1) {
            $this->send_404();
        }

        //input
        $city = $this->post("city");
        $address = $this->post("address");
        $phone = $this->post("phone");

        //get models & helpers
        $this->model("User");
        $user_table = new User();
        require_once ROOT . "/src/libraries/Check_input.php";

        //check nulls
        $inputs = [$city, $address, $phone];
        foreach ($inputs as $input) {
            if (!$input) {
                $this->send_error("global", $this->translator("ne laissez pas d'espace vide", "don't leave any empty fields"));
            }
        }

        //check city
        $cities = ["FES", "RABAT", "CASABLANCA", "MARRAKESH", "MEKNES", "TANGER", "AGADIR", "TETOUAN"];
        if (!in_array($city, $cities)) {
            $this->send_error("city", "stop");
        }

        //check address
        if (!Check_input::check_address($address)) {
            $this->send_error("address", $this->translator("mauvais caractéres utilisé", "wrong characters used"));
        }

        //check_phone
        if (!Check_input::check_phone($phone)) {
            $this->send_error("phone", $this->translator("mauvais caractéres utilisé", "wrong characters used"));
        }
        if ($user_table->check_phone($phone)) {
            $this->send_error("phone", $this->translator("ce numeros est deja pris", "this phone is taken by another user"));
        }

        //complete user infos
        $user_table->complete_info($city, $address, $phone);

        //alter session
        $_SESSION["user_phone"] = $phone;
        $_SESSION["user_address"] = $address;
        $_SESSION["user_city"] = $city;
        $_SESSION["order_step"] = 2;

        //redirect
        header("location:/orders/payment_methods");
    }

    public function payment_methods()
    {
        //security
        $this->check_if_logged();
        $this->sanitize();

        //get models
        $this->model("Product");
        $product_table = new Product();

        //get total price
        $total_price = 0;
        foreach ($_SESSION["cart"] as $item) {
            //item variables
            $product_id = $item["product_id"];
            $user_coupon_code = $item["coupon_code"];
            $order_quantity = (float)$item["quantity"];

            //product variables
            $product = $product_table->get_product_by_id($product_id);
            $unit_price = (float)$product["price"];
            $product_coupon_code = $product["coupon_code"];
            $coupon_reduction = (float)$product["coupon_reduction"];

            //check user coupon
            if ($product_coupon_code && $user_coupon_code === $product_coupon_code) {
                $unit_price *= (100 - $coupon_reduction) / 100;
            }

            //add to total price
            $sub_total = $unit_price * $order_quantity;
            $total_price += $sub_total;
        }

        //calculate final price
        $transport_fees_data = ["FES" => 50, "RABAT" => 40, "CASABLANCA" => 40, "MARRAKESH" => 50, "MEKNES" => 50, "TANGER" => 20, "AGADIR" => 60, "TETOUAN" => 30];
        $transport_fees = $total_price > 1000 ? 0 : (float)$transport_fees_data[$_SESSION["user_city"]];
        $final_price = $total_price + $transport_fees;
        $final_price = number_format($final_price, 2, '.', '');

        //serve
        $this->view("orders/payment_methods", ["total_price" => $total_price, "transport_fees" => $transport_fees, "final_price" => $final_price]);
    }

    public function register_order()
    {
        //security
        $this->check_if_logged();
        $this->sanitize();

        //check order step
        if ($this->session("order_step") < 2) {
            $this->send_404();
        }

        //call model
        $this->model("Order");
        $order_table = new Order();
        $this->model("Product");
        $product_table = new Product();

        //variables
        $payment_method = $this->post("payment_method");

        //check empty
        if (!$payment_method) {
            $this->send_error("global", $this->translator("choisissez une methode de paiement", "choose a payment method"));
        }

        foreach ($_SESSION["cart"] as $item) {
            //item variables
            $product_id = $item["product_id"];
            $user_coupon_code = $item["coupon_code"];
            $order_quantity = $item["quantity"];

            //product variables
            $product = $product_table->get_product_by_id($product_id);
            $unit_price = (float)$product["price"];
            $product_coupon_code = $product["coupon_code"];
            $coupon_reduction = (float)$product["coupon_reduction"];

            //check user coupon
            if ($product_coupon_code && $user_coupon_code === $product_coupon_code) {
                $unit_price *= (100 - $coupon_reduction) / 100;
            }

            //add to total price
            $sub_total = $unit_price * $order_quantity;
            $sub_total = number_format($sub_total, 2, '.', '');

            //register order
            $order_table->register_order($product_id, $order_quantity, $sub_total, $payment_method);
        }

        //unset session
        unset($_SESSION["cart"]);
        $_SESSION["order_step"] = 3;

        //redirect
        header("location:/orders/confirmation");
    }

    public function confirmation()
    {
        //security
        $this->check_if_logged();
        $this->sanitize();

        //check order step
        if ($this->session("order_step") != 3) {
            $this->send_404();
        }
        unset($_SESSION["order_step"]);

        //serve
        $this->view("orders/confirmation");
    }
}
