<?php
class Product extends Database
{
    public function check_product_name($name)
    {
        $sql = "SELECT * from products where name = ?;";
        $info = [$name];
        $data = $this->get_data($sql, $info);
        return count($data) > 0 ? true : false;
    }

    public function register_product(
        $name,
        $category,
        $price,
        $original_price,
        $promotion,
        $image_1,
        $image_2,
        $image_3,
        $image_4,
        $image_5,
        $quantity,
        $video_src,
        $coupon_code,
        $coupon_reduction,
        $guarantee
    ) {
        $sql = "INSERT into products 
        (name, category, price, original_price, quantity, image_1,
        image_2,
        image_3,
        image_4,
        image_5, 
        promotion, 
        video_src,
        coupon_code,
        coupon_reduction,
        guarantee) 
        values (:name,:category,:price,:original_price, :quantity, :image_1,
        :image_2,
        :image_3,
        :image_4,
        :image_5, 
        :promotion,
        :video_src,
        :coupon_code,
        :coupon_reduction,
        :guarantee
        )";

        $info = [
            ":name" => $name,
            ":category" => $category,
            ":original_price" => $original_price,
            ":price" => $price,
            ":image_1" => $image_1,
            ":image_2" => $image_2,
            ":image_3" => $image_3,
            ":image_4" => $image_4,
            ":image_5" => $image_5,
            ":quantity" => $quantity,
            ":promotion" => $promotion,
            ":video_src" => $video_src,
            ":coupon_code" => $coupon_code,
            ":coupon_reduction" => $coupon_reduction,
            ":guarantee" => $guarantee
        ];

        $this->post_data($sql, $info);
    }

    public function count_products($name, $category, $rating, $max_price)
    {
        $info = [];
        $first_part = "";

        //check name
        if ($name) {
            $name_part = " name LIKE :regex ";
            $info[":regex"] = "%" . strToLower($name) . "%";
        } else {
            $name_part = "";
        }

        //check category
        if ($category) {
            $category_part = $name ? " and category = :category " : " category = :category ";
            $info[":category"] = $category;
        } else {
            $category_part = "";
        }

        //check rating
        if ($rating) {
            $rating_part = ($name || $category) ? " and rating >= :rating " : " rating >= :rating ";
            $info[":rating"] = $rating;
        } else {
            $rating_part = "";
        }

        //check max price
        if ($max_price) {
            $max_price_part = ($name || $category || $rating) ? " and price <= :max_price " : " price <= :max_price ";
            $info[":max_price"] = $max_price;
        } else {
            $max_price_part = "";
        }

        if ($name || $category || $rating || $max_price) {
            $first_part = " WHERE ";
        }

        $sql = "SELECT count(*) 
               from products" . $first_part . $name_part . $category_part . $rating_part . $max_price_part;

        return (int)$this->get_data($sql, $info)[0]["count(*)"];
    }

    public function get_products($name, $category, $rating, $max_price, $order_command, $order_limit)
    {
        $info = [];
        $first_part = "";

        //check name
        if ($name) {
            $name_part = " name LIKE :regex ";
            $info[":regex"] = "%" . strToLower($name) . "%";
        } else {
            $name_part = "";
        }

        //check category
        if ($category) {
            $category_part = $name ? " and  category = :category " : " category = :category ";
            $info[":category"] = $category;
        } else {
            $category_part = "";
        }

        //check rating
        if ($rating) {
            $rating_part = ($name || $category) ? " and rating >= :rating " : " rating >= :rating ";
            $info[":rating"] = $rating;
        } else {
            $rating_part = "";
        }

        //check max price
        if ($max_price) {
            $max_price_part = ($name || $category || $rating) ? " and price <= :max_price " : " price <= :max_price ";
            $info[":max_price"] = $max_price;
        } else {
            $max_price_part = "";
        }

        if ($name || $category || $rating || $max_price) {
            $first_part = " WHERE ";
        }

        $sql = "SELECT * 
               from products" . $first_part . $name_part . $category_part . $rating_part . $max_price_part . $order_command . $order_limit;


        return $this->get_data($sql, $info);
    }

    public function count_search_results($name)
    {
        $regex = "%" . strToLower($name) . "%";

        $sql = "SELECT id from products where name LIKE :regex;";

        $info = [":regex" => $regex];

        return count($this->get_data($sql, $info));
    }

    public function get_products_by_name($name)
    {
        $regex = "%" . strToLower($name) . "%";

        $sql = "SELECT * from products where name LIKE :regex;";

        $info = [":regex" => $regex];
        return $this->get_data($sql, $info);
    }

    public function get_product_by_id($product_id)
    {
        $sql = "SELECT * from products 
        where id = :product_id;";

        $info = [":product_id" => $product_id];

        return $this->get_data($sql, $info)[0];
    }

    public function get_similar_products($category, $product_id)
    {
        $sql = "SELECT * from products 
        where category = :category 
        and id != :product_id
        limit 10";

        $info = [":category" => $category, ":product_id" => $product_id];

        return $this->get_data($sql, $info);
    }

    public function edit_product(
        $id,
        $name,
        $category,
        $price,
        $original_price,
        $promotion,
        $image_1,
        $image_2,
        $image_3,
        $image_4,
        $image_5,
        $quantity,
        $video_src,
        $coupon_code,
        $coupon_reduction,
        $guarantee
    ) {
        $sql = " UPDATE products 
        set
        name = :name,
        price = :price,
        original_price = :original_price,        
        category = :category,        
        promotion = :promotion,
        image_1 = :image_1,
        image_2 = :image_2,
        image_3 = :image_3,
        image_4 = :image_4,
        image_5 = :image_5,
        quantity = :quantity,
        video_src = :video_src,
        coupon_code = :coupon_code,
        coupon_reduction = :coupon_reduction,
        guarantee = :guarantee
        where id = :id";

        $info = [
            ":name" => $name, ":id" => $id,
            ":category" => $category,
            ":original_price" => $original_price,
            ":price" => $price,
            ":image_1" => $image_1,
            ":image_2" => $image_2,
            ":image_3" => $image_3,
            ":image_4" => $image_4,
            ":image_5" => $image_5,
            ":quantity" => $quantity,
            ":promotion" => $promotion,
            ":video_src" => $video_src,
            ":coupon_code" => $coupon_code,
            ":coupon_reduction" => $coupon_reduction,
            ":guarantee" => $guarantee
        ];

        $this->post_data($sql, $info);
    }

    public function edit_stock($product_id, $quantity)
    {
        $sql = "UPDATE products 
        set 
        quantity = quantity - :quantity,
        total_sells = total_sells + :quantity
        where product_id = :product_id
        ";
        $info = [":product_id" => $product_id, ":quantity" => $quantity];
        $this->post_data($sql, $info);
    }

    public function check_review($product_id)
    {
        $sql = "SELECT rating from products
        where product_id = :product_id
        ";

        $info = [":product_id" => $product_id];

        $data = $this->get_data($sql, $info);
        return $data[0];
    }

    public function retreat_rating_infos($product_id)
    {
        $sql = "SELECT total_reviews, rating from products
        where id = :product_id
        ";

        $info = [":product_id" => $product_id];

        $data = $this->get_data($sql, $info);
        return $data[0];
    }

    public function add_rating($product_id, $rating)
    {
        $product_data = $this->retreat_rating_infos($product_id);
        $product_total_reviews = $product_data['total_reviews'];
        $product_rating = $product_data['rating'];

        if ($product_rating) {
            $rating = ($product_rating * $product_total_reviews + $rating) / ($product_total_reviews + 1);
            $sql = "UPDATE products 
                set 
                total_reviews = total_reviews + 1,
                rating = :rating
                where id = :product_id
                ";
        } else {
            $sql = "UPDATE products 
                set 
                rating = :rating,
                total_reviews = 1
                where id = :product_id
                ";
        }

        $info = [":rating" => $rating, ":product_id" => $product_id];
        $this->post_data($sql, $info);
    }

    public function edit_rating($product_id, $rating, $old_rating)
    {
        $product_data = $this->retreat_rating_infos($product_id);
        $product_total_reviews = $product_data['total_reviews'];
        $product_rating = $product_data['rating'];

        $rating = ($product_rating * $product_total_reviews + $rating - $old_rating) / $product_total_reviews;

        $sql = "UPDATE products 
            set 
            rating = :rating
            where id = :product_id
            ";


        $info = [":rating" => $rating, ":product_id" => $product_id];
        $this->post_data($sql, $info);
    }

    public function register_order($product_id, $quantity)
    {
        $sql = "UPDATE products 
            set 
            total_sells = total_sells + :quantity
            where id = :product_id
            ";

        $info = [":product_id" => $product_id, ":quantity" => $quantity];

        $this->post_data($sql, $info);
    }

    public function get_coupon_code($product_id)
    {
        $sql = "SELECT coupon_code from products
        where id = :product_id
        ";

        $info = [":product_id" => $product_id];

        return $this->get_data($sql, $info)[0]["coupon_code"];
    }

    public function get_images_names($product_id)
    {
        $sql = "SELECT image_1, image_2, image_3, image_4, image_5 from products
      where id = :product_id
      ";

        $info = [":product_id" => $product_id];

        return $this->get_data($sql, $info)[0];
    }

    public function delete_product($product_id)
    {
        $sql = 'DELETE from products
        where id = :product_id
        ';

        $info = [":product_id" => $product_id];

        $this->post_data($sql, $info);
    }

    public function get_all_ids()
    {
        $sql = "SELECT id from products";
        return $this->get_data($sql);
    }

    public function add_guarantee($product_id, $guarantee)
    {
        $sql = 'UPDATE products set
        guarantee = :guarantee
        where id = :product_id
        ';

        $info = [":guarantee" => $guarantee, ":product_id" => $product_id];

        $this->post_data($sql, $info);
    }
}
