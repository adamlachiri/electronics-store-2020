export default class Functionality {

  constructor() {

    this.cart();

    this.loading_page();

    this.handle_reactions();

    this.submit_from_target();

    this.show_more_comments();

    this.stars.bind(this);

    this.handle_reactions.bind(this);

  }



  //////////////////////////////////////////// handle reaction //////////////////////////



  handle_reactions() {

    if (!document.querySelector(".js-reaction-group")) {

      return;

    }

    //variables

    const reaction_groups = document.querySelectorAll(".js-reaction-group");

    const request = new XMLHttpRequest();



    for (let i = 0; i < reaction_groups.length; i++) {

      const reaction_group = reaction_groups[i];

      const add_reaction = reaction_group.querySelector(".js-add-reaction");

      const remove_reaction = reaction_group.querySelector(

        ".js-remove-reaction"

      );



      //add event

      add_reaction.addEventListener("click", function () {

        const comment_id = add_reaction.dataset.comment_id;

        const url = "/users/add_reaction?comment_id=" + comment_id;

        request.open("GET", url, true);



        //send request

        request.send();



        //change button

        add_reaction.classList.add("d-none");

        remove_reaction.classList.remove("d-none");

      });



      //remove event

      remove_reaction.addEventListener("click", function () {

        const comment_id = remove_reaction.dataset.comment_id;

        const url = "/users/remove_reaction?comment_id=" + comment_id;

        request.open("GET", url, true);



        //send request

        request.send();



        //change button

        add_reaction.classList.remove("d-none");

        remove_reaction.classList.add("d-none");

      });

    }

  }



  ///////////////////////////////////////////////// submit from input ////////////////

  submit_from_target($target, $btn) {

    if (!document.querySelector($btn) || !document.querySelector($target)) {

      return;

    }

    //variables

    const button = document.querySelector($btn);

    const targets = document.querySelectorAll($target);



    //exe

    for (let i = 0; i < targets.length; i++) {

      targets[i].onchange = function () {

        button.click();

      };

    }

  }



  ////////////////////////////////////////////////////// cart ////////////////////////////

  cart() {

    if (!document.querySelector(".js-cart-item")) {

      return;

    }

    //variables

    const items = document.querySelectorAll(".js-cart-item");

    const total_span = document.querySelector(".js-total");

    const HT_span = document.querySelector(".js-HT");

    const request = new XMLHttpRequest();



    //calculate total price

    function calculate_total() {

      let sum = 0;

      for (let i = 0; i < items.length; i++) {

        //html elements

        const item = items[i];

        const quantity_input = item.querySelector(".js-quantity");

        const sub_total_span = item.querySelector(".js-sub-total");

        const unit_price_span = item.querySelector(".js-unit-price");



        //calculate subtotal

        const unit_price = parseFloat(unit_price_span.innerHTML);

        const quantity = parseInt(quantity_input.value);

        const sub_total = unit_price * quantity;

        //render subtotal

        sub_total_span.innerHTML = parseFloat(sub_total).toFixed(2);



        //add subtotal to sum

        sum += sub_total;

      }



      //render total price

      total_span.innerHTML = sum.toFixed(2);

      HT_span.innerHTML = (sum * 0.8).toFixed(2);

    }

    calculate_total();



    //loop through items

    for (let i = 0; i < items.length; i++) {

      //html elements

      const item = items[i];

      const quantity_input = item.querySelector(".js-quantity");

      const sub_total_span = item.querySelector(".js-sub-total");

      const coupon_input = item.querySelector(".js-coupon");

      const coupon_validation = item.querySelector(".js-coupon-validation");

      const unit_price_span = item.querySelector(".js-unit-price");

      const loading = item.querySelector(".js-coupon-loading");



      //variables

      const original_unit_price = parseFloat(item.dataset.price);

      const id = item.dataset.id;

      const coupon_reduction = item.dataset.reduction;



      //coupon change

      if (coupon_input) {

        coupon_input.onkeyup = function () {

          //request variables

          const url =

            "/products/check_coupon_ajax?product_id=" +

            id +

            "&coupon_code=" +

            coupon_input.value;



          //request preparation

          request.open("GET", url, true);



          //request handle response

          request.onreadystatechange = function () {

            //loading

            if (request.readyState == 3) {

              loading.classList.remove("d-none");

            }



            //response

            if (request.readyState == 4) {

              loading.classList.add("d-none");

              if (request.status == 200) {

                //positive

                if (request.responseText === "positive") {

                  //change unit price

                  const unit_price = parseFloat(

                    (original_unit_price * (100 - coupon_reduction)) / 100

                  ).toFixed(2);

                  unit_price_span.innerHTML = unit_price;



                  //change styles

                  coupon_input.classList.add("b-success");

                  unit_price_span.classList.add("t-success");

                  coupon_validation.classList.remove("d-none");

                  sub_total_span.classList.add("t-success");

                  calculate_total();

                }

                //negative

                else {

                  unit_price_span.innerHTML = original_unit_price;



                  //change styles

                  coupon_input.classList.remove("b-success");

                  unit_price_span.classList.remove("t-success");

                  coupon_validation.classList.add("d-none");

                  sub_total_span.classList.remove("t-success");

                  calculate_total();

                }

              } else {

                console.log("failed");

              }

            }

          };



          //send request

          request.send();

        };

      }



      quantity_input.addEventListener("change", calculate_total);

    }

  }



  //////////////////////////////// show more comments //////////////////////////////



  show_more_comments = () => {

    if (!document.querySelector(".js-show-more-comments")) {

      return;

    }



    const get_This = () => {

      return this;

    };



    //html elements

    const show_more_comments_btn = document.querySelector(

      ".js-show-more-comments"

    );

    const loading = document.querySelector(".js-loading");

    const comments_box = document.querySelector(".js-comments");



    //event listener

    show_more_comments_btn.addEventListener("click", function () {

      //data

      const product_id = show_more_comments_btn.dataset.product_id;

      const ranking = show_more_comments_btn.dataset.ranking;

      const displayed_comments =

        show_more_comments_btn.dataset.displayed_comments;

      const total_comments = show_more_comments_btn.dataset.total_comments;



      // request

      const request = new XMLHttpRequest();

      const url =

        "reviews/get_comments_ajax?product_id=" +

        product_id +

        "&displayed_comments=" +

        displayed_comments +

        "&total_comments=" +

        total_comments +

        "&ranking=" +

        ranking;



      //request preparation

      request.open("GET", url, true);



      //request handle response

      request.onreadystatechange = function () {

        //loading

        if (request.readyState == 3) {

          loading.classList.remove("d-none");

          show_more_comments_btn.classList.add("d-none");

        }



        //response

        if (request.readyState == 4) {

          loading.classList.add("d-none");

          show_more_comments_btn.classList.remove("d-none");

          if (request.status == 200) {

            //get response elemnts

            const {

              reviews,

              connected,

              new_displayed_comments,

              no_more_comments,

              language,

            } = JSON.parse(request.responseText);



            //translator

            function translator(fr, eng) {

              return language == "french" ? fr : eng;

            }



            //change btn dataset

            show_more_comments_btn.dataset.displayed_comments = new_displayed_comments;



            //check if we reach the limit

            if (no_more_comments) {

              show_more_comments_btn.classList.add("d-none");

            }



            //create response element

            let response_element = "";



            //inject the comments

            for (let i = 0; i < reviews.length; i++) {

              //get comment details

              const {

                first_name,

                last_name,

                image_name,

                helpful,

                id,

                comment,

                comment_date,

                liked,

                rating,

              } = reviews[i];



              //create the helpful btn

              let helpful_btn = "";

              if (connected) {

                helpful_btn += '<div class="js-reaction-group">';

                if (liked) {

                  helpful_btn +=

                    "<button data-comment_id=" +

                    id +

                    ' class=" btn-secondary btn-small js-remove-reaction">' +

                    translator("enlevez utile", "remove helpful") +

                    "</button><button data-comment_id=" +

                    id +

                    ' class=" btn-secondary btn-small js-add-reaction d-none">' +

                    translator("utile", "helpful") +

                    "</button>";

                } else {

                  helpful_btn +=

                    "<button data-comment_id=" +

                    id +

                    ' class=" btn-secondary btn-small js-add-reaction">' +

                    translator("utile", "helpful") +

                    "</button><button data-comment_id=" +

                    id +

                    ' class=" btn-secondary btn-small js-remove-reaction d-none">' +

                    translator("enlevez utile", "remove helpful") +

                    "</button>";

                }

                helpful_btn += "</div>";

              } else {

                helpful_btn =

                  '<div><a href="auth/sign_in_form" class="btn-secondary btn-small">' +

                  translator("utile", "helpful") +

                  "</a></div>";

              }



              //helpful msg section

              const helpful_message =

                helpful > 1

                  ? '<span class="pl-3 t-blue">' +

                  $helpful +

                  translator(

                    "  utilisateurs on trouvé ce commentaire utile",

                    " users found this comment helpful"

                  ) +

                  "</span>"

                  : "";



              //create comment object

              let comment_element = "";

              comment_element +=

                '<div class="pt-5"><div class="d-flex a-center "><div style="background-image: url(img/profiles/' +

                image_name +

                ')" class="b-radius-circle h-2 w-2 bg-img bg-center"></div><span class="pl-2 t-capitalize t-blue">' +

                first_name +

                " " +

                last_name +

                '</span></div><div class="pl-5 t-warning">';



              comment_element +=

                '<span class="' + get_stars_class(rating) + '"></span>';



              comment_element +=

                '<span class="pl-2 t-gray">' +

                translator("posté le ", "posted in ") +

                comment_date +

                '</span><span class="t-warning pl-2">' +

                translator("achat verifié ", "verified purchase ") +

                '</span></div><div class="pl-5 pt-1"><p>' +

                comment +

                '</p></div><div class="pl-5 pt-2 d-flex a-center">';

              comment_element += helpful_btn;

              comment_element += helpful_message;

              comment_element += "</div></div>";



              //add comment to response

              response_element += comment_element;

            }



            //add response to comments box

            comments_box.innerHTML += response_element;



            //reactivate some methods

            get_This().stars();

            get_This().handle_reactions();

          }

          //treat error

          else {

          }

        }

      };



      //send request

      request.send();

    });



    //functions

    function get_stars_class(rating) {

      //get the class

      let $class = "";

      switch (true) {

        case rating == 5:

          $class = "js-star-5";

          break;

        case rating >= 4.5:

          $class = "js-star-4-half";

          break;

        case rating >= 4:

          $class = "js-star-4";

          break;

        case rating >= 3.5:

          $class = "js-star-3-half";

          break;

        case rating >= 3:

          $class = "js-star-3";

          break;

        case rating >= 2.5:

          $class = "js-star-2-half";

          break;

        case rating >= 2:

          $class = "js-star-2";

          break;

        case rating >= 1.5:

          $class = "js-star-1-half";

          break;

        case rating >= 1:

          $class = "js-star-1";

          break;

      }



      return $class;

    }

  };



  //////////////////////////////////// stars ///////////////////////////////////////



  stars() {

    //stars object

    const stars = {

      ".js-star-1":

        '<i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>',



      ".js-star-1-half":

        '<i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>',



      ".js-star-2":

        '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>',



      ".js-star-2-half":

        '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i><i class="far fa-star"></i>',



      ".js-star-3":

        '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>',



      ".js-star-3-half":

        '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i>',



      ".js-star-4":

        '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>',



      ".js-star-4-half":

        '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>',



      ".js-star-5":

        '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>',

    };



    const stars_classes = [

      ".js-star-1",

      ".js-star-1-half",

      ".js-star-2",

      ".js-star-2-half",

      ".js-star-3",

      ".js-star-3-half",

      ".js-star-4",

      ".js-star-4-half",

      ".js-star-5",

    ];



    for (let i = 0; i < stars_classes.length; i++) {

      if (document.querySelector(stars_classes[i])) {

        //variables

        const star_class = stars_classes[i];

        const divs = document.querySelectorAll(star_class);

        const star_element = stars[star_class];

        //find star containers

        for (let j = 0; j < divs.length; j++) {

          const div = divs[j];

          //inject the stars

          div.innerHTML = star_element;

        }

      }

    }

  }



  // loading

  loading_page() {
    // check
    if (!document.querySelector(".js-loading-page")
    ) {
      return;
    }

    // html
    const loading = document.querySelector(".js-loading-page");
    const delay = 300;

    // exe
    window.addEventListener("load", function () {
      loading.style.animation = delay + "ms fade_out linear forwards";
      setTimeout(() => {
        loading.classList.add("d-none");
      }, delay);
    })
  }


}





