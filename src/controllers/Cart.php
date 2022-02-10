<?php
class Cart extends Controller
{

    public function index()
    {
        //prepare data
        $data = ["cart" => []];

        //call model
        $this->model("Product");
        $product_table = new Product();

        //check cart session
        if (isset($_SESSION["cart"])) {
            foreach ($_SESSION["cart"] as $item) {
                $product_id = $item["product_id"];
                $product = $product_table->get_product_by_id($product_id);
                array_push($data["cart"], $product);
            }
        }

        //serve
        $this->view("cart/cart", $data);
    }

    public function add_to_cart()
    {
        //security
        $this->sanitize();
        unset($_SESSION["order_step"]);

        //input
        $product_id = $this->get("product_id");

        //get product
        $cart_item = [
            "product_id" => $product_id,
            "quantity" => 1,
            "coupon_code" => null
        ];

        if (isset($_SESSION["cart"])) {
            //check if product already in cart
            foreach ($_SESSION["cart"] as $item) {
                if ($item["product_id"] === $product_id) {
                    $this->send_404();
                }
            }

            //alter session
            array_push($_SESSION["cart"], $cart_item);
        } else {
            //create session
            $_SESSION["cart"] = [$cart_item];
        }

        //redirect
        header("location:" . $_SERVER['HTTP_REFERER']);
    }

    public function remove_from_cart()
    {
        //security
        $this->sanitize();
        unset($_SESSION["order_step"]);

        //input
        $product_id = $this->get('product_id');

        //check
        foreach ($_SESSION["cart"] as $key => $item) {
            if ($item["product_id"] === $product_id) {
                unset($_SESSION["cart"][$key]);
            }
        }

        //redirect
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function confirm_cart()
    {
        //security
        $this->check_if_logged();
        $this->sanitize();

        //check cart
        if (!isset($_SESSION["cart"]) || count($_SESSION["cart"]) == 0) {
            $this->send_404();
        }

        //finish setting the cart
        foreach ($_SESSION["cart"] as $key => $item) {
            //input
            $product_id = $item["product_id"];
            $quantity = $this->post("quantity_" . $product_id);
            $user_coupon_code = $this->post("coupon_code_" . $product_id);

            //check quantity
            if (!$quantity) {
                unset($_SESSION["cart"]);
                $_SESSION["failure"] = "something went wrong with your cart";
                $this->send_404();
            }

            //alter cart session
            $_SESSION["cart"][$key]["quantity"] = $quantity;
            $_SESSION["cart"][$key]["coupon_code"] = $user_coupon_code;
        }

        //confirm cart
        $_SESSION["order_step"] = 1;

        //redirect
        header("location:/orders/personal_info");
    }
}
