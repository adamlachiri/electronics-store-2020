<?php





class Reviews extends Controller


{


    public function index()


    {


        $this->send_404();
    }





    public function add_review()


    {


        //security


        $this->check_if_logged();


        $this->sanitize();





        //input


        $product_id = $this->post("product_id");


        $rating = $this->post("rating");


        $comment = $this->post("comment");





        //get models


        $this->model("Review");


        $review_table = new Review();


        $this->model("Product");


        $product_table = new Product();





        //register review


        if ($rating) {


            $review_table->register_review($product_id, $rating, $comment);
        }





        //add review to product


        $product_table->add_rating($product_id, $rating);





        //add review to history


        array_push($_SESSION['user_reviews'], $product_id);





        //redirect


        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }





    public function edit_review()


    {


        //security


        $this->check_if_logged();


        $this->sanitize();





        //input


        $product_id = $this->post("product_id");


        $rating = $this->post("rating");


        $comment = $this->post("comment");


        $old_rating = $this->post("old_rating");





        //get models


        $this->model("Review");


        $review_table = new Review();


        $this->model("Product");


        $product_table = new Product();





        //edit review


        $review_table->edit_review($product_id, $rating, $comment);





        //edit review in product


        $product_table->edit_rating($product_id, $rating, $old_rating);





        //redirect


        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }





    public function get_comments_ajax()


    {


        //security


        $this->sanitize();





        //get models


        $this->model("Review");


        $review_table = new Review();





        //input


        $product_id = $this->get("product_id");


        $displayed_comments = $this->get("displayed_comments");


        $total_comments = $this->get("total_comments");


        $ranking = $this->get("ranking");





        //make order command


        switch ($ranking) {


            case "worst_reviews":


                $order_command = "order by r.rating asc";


                break;


            case "best_reviews":


                $order_command = "order by r.rating desc";


                break;


            default:


                $order_command = "order by r.helpful desc";
        }





        //get limit command


        $limit_command = " limit " . 5 . " offset " . $displayed_comments;





        //get total reviews


        $reviews = $review_table->get_product_reviews($product_id, $order_command, $limit_command);





        //check if we reach the end


        $new_comments = count($reviews);


        $new_displayed_comments = (int)$displayed_comments + $new_comments;


        $no_more_comments = (int)$total_comments - $new_displayed_comments == 0;





        //check user reactions


        if (isset($_SESSION["user_reactions"])) {


            foreach ($reviews as $key => $review) {


                if (in_array($review["id"], $_SESSION["user_reactions"])) {


                    $review["liked"] = true;


                    $reviews[$key] = $review;
                }
            }
        }





        //check if user is connected


        $connected = isset($_SESSION["user_id"]);





        //get language


        $language = isset($_SESSION["language"]) && $_SESSION["language"] == "english" ? "english" : "french";





        //response object


        $response = [
            "reviews" => $reviews,
            "connected" => $connected,
            "new_displayed_comments" => $new_displayed_comments,
            "no_more_comments" => $no_more_comments,
            "language" => $language
        ];


        //response
        echo json_encode($response);
    }
}
