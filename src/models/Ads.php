<?php

class Ads extends Database
{

    public function get_ads()
    {
        $sql = 'SELECT * from ads
        ';

        return $this->get_data($sql, []);
    }

    public function get_ad($ad_id)
    {
        $sql = 'SELECT * from ads
        where id = :ad_id
        ';

        $info = [":ad_id" => $ad_id];

        return $this->get_data($sql, $info)[0];
    }

    public function get_image_name($ad_id)
    {
        $sql = 'SELECT image_name from ads
        where id = :ad_id
        ';

        $info = [":ad_id" => $ad_id];

        return $this->get_data($sql, $info)[0];
    }

    public function register_ad($image_name, $product_id, $type)
    {
        $sql = "
        INSERT into ads
        (image_name, product_id, type)
        VALUES (:image_name, :product_id, :type)
        ";

        $info = [":image_name" => $image_name, ":product_id" => $product_id, ":type" => $type];

        $this->post_data($sql, $info);
    }

    public function get_carousel_ads()
    {
        $sql = 'SELECT * from ads
        where type = "carousel"
        ';

        return $this->get_data($sql, []);
    }

    public function edit_ad($ad_id, $image_name, $product_id)
    {
        $sql = "
        UPDATE ads set
        image_name = :image_name,
        product_id = :product_id
        where id = :ad_id
        ";

        $info = [":ad_id" => $ad_id, ":image_name" => $image_name, ":product_id" => $product_id];

        $this->post_data($sql, $info);
    }

    public function get_banner_ads()
    {
        $sql = 'SELECT * from ads
        where type = "banner"
        ';

        return $this->get_data($sql, []);
    }

    public function get_vertical_ads()
    {
        $sql = 'SELECT * from ads
        where type = "vertical"
        ';

        return $this->get_data($sql, []);
    }

    public function delete_ad($ad_id)
    {
        $sql = 'DELETE from ads
        where id = :ad_id
        ';

        $info = [":ad_id" => $ad_id];

        $this->post_data($sql, $info);
    }
}
