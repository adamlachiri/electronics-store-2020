//imports


import Animation from "./inc/Animation.js";

import Functionality from "./inc/Functionality.js";


//create instances


let animation = new Animation();


let functionality = new Functionality();





//exe


function exe() {


  functionality.submit_from_target(".js-products-target", ".js-products-btn");


  functionality.submit_from_target(".js-default-target", ".js-default-btn");


  functionality.submit_from_target(


    ".js-target-language",


    ".js-submit-language"


  );


  animation.carousel_pages();


  animation.carousel_items();


  animation.carousel_items_vertical();


  animation.links_visibility();


  animation.zoom(


    "js-small-image",


    "js-medium-image",


    "js-large-image",


    "js-zoom-prev",


    "js-zoom-next"


  );


  animation.open_window("js-window", "js-open-window");


  animation.close_window("js-window", "js-close-window");


  animation.close_window("js-popup", "js-close-popup");


  animation.dropdown();


  animation.stars_rating();


  functionality.stars();


  animation.open_window("js-confirm-delete", "js-open-confirm-delete");


  animation.close_window("js-confirm-delete", "js-close-confirm-delete");


  animation.box_selecting("js-payment-method");


}





exe();


