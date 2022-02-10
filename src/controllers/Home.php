<?php

class Home extends Controller
{
    public function index()
    {
        //call models
        $this->model("Product");
        $product_table = new Product();
        $this->model("Ads");
        $ads_table = new Ads();

        //get data
        $carousel_ads = $ads_table->get_carousel_ads();
        $banner_ads = $ads_table->get_banner_ads();
        $vertical_ads = $ads_table->get_vertical_ads();
        $best_games = $product_table->get_products(null, "games", null, null, " order by rating desc ", " limit 10");
        $best_deals = $product_table->get_products(null, null, null, null, " order by promotion desc ", " limit 10");
        $cheapest = $product_table->get_products(null, null, null, null, " order by price asc ", " limit 10");

        //serve
        $this->view("home/index", [
            "best_games" => $best_games,
            "best_deals" => $best_deals,
            "cheapest" => $cheapest,
            "carousel_ads" => $carousel_ads,
            "banner_ads" => $banner_ads,
            "vertical_ads" => $vertical_ads
        ]);
    }
}
