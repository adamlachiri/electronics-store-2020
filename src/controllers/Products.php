<?php







class Products extends Controller



{



    public function index()



    {



        //security



        $this->sanitize();







        //call model



        $this->model("Product");



        $product_table = new Product();



        $this->model("Ads");



        $ads_table = new Ads();







        //input



        $name = $this->get("name");



        $category = $this->get("category");



        $rating = $this->get("rating");



        $max_price = $this->get("max_price");



        $ranking = $this->get("ranking");







        //prepare data object



        $data = ["products" => [], "ads" => [], "cart" => []];







        //pagination



        $results_per_page = 10;



        $total_results = $product_table->count_products($name, $category, $rating, $max_price);



        $total_pages = ceil($total_results / $results_per_page);



        $this->get_page($total_pages);











        //make order_command



        switch ($ranking) {



            case "low_price":



                $order_command = " order by price asc ";



                break;



            case "high_price":



                $order_command = " order by price desc ";



                break;



            case "name":



                $order_command = " order by name asc ";



                break;



            case "promotion":



                $order_command = " order by promotion desc ";



                break;



            case "total_sells":



                $order_command = " order by total_sells desc ";



                break;



            default:



                $order_command = " order by rating desc ";
        }







        //make limit command



        $offset = ($_GET['page'] - 1) * $results_per_page;



        $limit_command = " limit " . $results_per_page . " offset " . $offset;











        //get the products



        $products = $product_table->get_products($name, $category, $rating, $max_price, $order_command, $limit_command);



        $data["products"] = $products;







        //get the ad



        $ads = $ads_table->get_vertical_ads();



        $data["ads"] = $ads;







        //get the cart



        if (isset($_SESSION["cart"])) {



            foreach ($_SESSION["cart"] as $item) {



                $product_id = $item["product_id"];



                $product = $product_table->get_product_by_id($product_id);



                array_push($data["cart"], $product);
            }
        }







        //alter session



        $_SESSION["total_pages"] = $total_pages;



        $_SESSION["results_per_page"] = $results_per_page;



        $_SESSION["total_results"] = $total_results;







        //serve



        $this->view("products/index", $data);
    }











    public function product_details()



    {



        //security



        $this->sanitize();







        //call model



        $this->model("Product");



        $product_table = new Product();



        $this->model('Review');



        $reviews_table = new Review();



        $this->model('Ads');



        $ad_table = new Ads();







        //prepare data 



        $data = [];







        //input



        $product_id = $this->get('id');



        $product = $product_table->get_product_by_id($product_id);



        $category = $product["category"];



        $similar_products = $product_table->get_similar_products($category, $product_id);



        $ranking = $this->get("reviews_ranking");







        //make order command



        switch ($ranking) {



            case "worst_reviews":



                $order_command = "order by r.rating asc";



                break;



            case "most_helpful":



                $order_command = "order by r.helpful desc";



                break;



            case "best_reviews":



                $order_command = "order by r.rating desc";



                break;



            default:



                $order_command = "order by r.helpful desc";
        }







        //get reviews



        $total_reviews = $reviews_table->count_product_reviews($product_id);



        if ($total_reviews > 5) {



            $_SESSION["show_more"] = true;
        }



        $data["total_comments"] = $total_reviews;



        $reviews = $reviews_table->get_product_reviews($product_id, $order_command, " limit 5 ");







        //inject data



        $data["product"] = $product;



        $data["similar_products"] = $similar_products;



        $data["reviews"] = $reviews;



        $data["vertical_ads"] = $ad_table->get_vertical_ads();



        $data["banner_ads"] = $ad_table->get_banner_ads();







        //check if logged or not



        if (isset($_SESSION['user_reviews']) && in_array($product_id, $_SESSION['user_reviews'])) {



            $data["user_review"] = $reviews_table->get_user_review($product_id);
        }







        //serve



        $this->view("products/details", $data);
    }







    public function check_coupon_ajax()



    {



        //security



        $this->check_if_logged();



        $this->sanitize();







        //call models



        $this->model("Product");



        $product_table = new Product();







        //input



        $product_id = $this->get("product_id");



        $coupon_code = $this->get("coupon_code");







        //check coupon code



        if ($coupon_code === $product_table->get_coupon_code($product_id)) {



            echo "positive";
        };
    }
}
