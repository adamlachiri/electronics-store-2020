export default class Animation {
  //variables
  body = document.body;

  ////////////////////////////////////////// links visibility /////////////////////////
  links_visibility() {
    if (!document.querySelector(".js-link")) {
        return;
    }
      const js_targets = document.querySelectorAll(".js-link");
      const exceptions = ["http://personalproject578134612978.epizy.com/"];
      if (js_targets.length > 0) {
        const page_location = window.location.href;
        for (let i = 0; i < js_targets.length; i++) {
          let js_target = js_targets[i];
          const js_target_location = js_target.href;
          if (js_target_location == page_location) {
            js_target.classList.add("t-white", "bg-black");
          } else if (
            page_location.includes(js_target_location) &&
            !exceptions.includes(js_target_location)
          ) {
              console.log(js_target_location);
            js_target.classList.add("t-white", "bg-black");
          } else {
            js_target.classList.remove("t-white", "bg-black");
          }
        }
      }
    
  }

  ////////////////////////////////////////////// carousel pages ///////////////////////
  carousel_pages() {
    if (document.querySelector(".js-carousel-pages")) {
      //variables
      const carousel = document.querySelector(".js-carousel-pages");
      const slider = carousel.querySelector(".js-slider");
      const items = carousel.querySelectorAll(".js-item");
      const paginations = carousel.querySelectorAll(".js-pagination");

      let limit = items.length;
      let index = 0;

      //scroll function
      function scroll() {
        index++;
        check_pagination();
        slider.classList.add("a-ease-out-slow");
        slider.style.transform =
          "translateX(-" + index * carousel.clientWidth + "px)";
        if (index == limit - 1) {
          index = 0;
          check_pagination();
          setTimeout(() => {
            slider.classList.remove("a-ease-out-slow");
            slider.style.transform = "translateX(0)";
          }, 5000);
        }
      }

      //add select functionality
      for (let i = 0; i < paginations.length; i++) {
        const pagination = paginations[i];
        const dataset = parseInt(pagination.dataset.index);
        pagination.addEventListener("click", function () {
          console.log(carousel.clientWidth);
          index = dataset;
          check_pagination();
          slider.classList.remove("a-ease-out-slow");
          slider.style.transform =
            "translateX(-" + index * carousel.clientWidth + "px)";
        });
      }

      //check pagination
      function check_pagination() {
        for (let i = 0; i < paginations.length; i++) {
          const pagination = paginations[i];
          const dataset = parseInt(pagination.dataset.index);
          if (index == dataset) {
            pagination.classList.add("bg-primary");
            pagination.classList.remove("bg-white");
          } else {
            pagination.classList.remove("bg-primary");
            pagination.classList.add("bg-white");
          }
        }
      }

      //resize
      window.addEventListener("resize", function () {
        slider.classList.remove("a-ease-out-slow");
        slider.style.transform =
          "translateX(-" + index * carousel.clientWidth + "px)";
      });

      //starters
      setInterval(() => {
        scroll();
      }, 10000);
      check_pagination();
    }
  }

  /////////////////////////////////////// carousel items /////////////////////////////
  carousel_items() {
    if (document.querySelector(".js-carousel-items")) {
      const carousels = document.querySelectorAll(".js-carousel-items");
      //loop through carousels
      for (let i = 0; i < carousels.length; i++) {
        //html elements
        const carousel = carousels[i];
        const slider_container = carousel.querySelector(".js-slider-container");
        const slider = carousel.querySelector(".js-slider");
        const scrollbar = carousel.querySelector(".js-scrollbar");
        const next = carousel.querySelector(".js-next");
        const prev = carousel.querySelector(".js-prev");

        //general parameters
        let slider_position = 0;
        let step;
        let link;

        //slider parameters
        let slider_container_width;
        let slider_width;
        let slider_limit;

        //scroll bar parameters
        let scrollbar_limit;
        let scrollbar_width;
        let scrollbar_position = 0;
        let old_scrollbar_position = 0;
        let is_down;
        let start;

        //calculate sizes function
        function calculate_sizes() {
          slider_container_width = slider_container.clientWidth;
          slider_width = slider.clientWidth;
          scrollbar_width =
            (slider_container_width * slider_container_width) / slider_width;
          scrollbar.style.width = scrollbar_width + "px";
          slider_limit = slider_width - slider_container_width;
          scrollbar_limit = slider_container_width - scrollbar_width;
          link = scrollbar_limit / slider_limit;
          step = slider_container_width * 0.8;
        }

        //scroll function
        function scroll() {
          slider.style.transform = "translateX(-" + slider_position + "px)";
          scrollbar.style.left = slider_position * link + "px";
          if (slider_position == 0) {
            prev.classList.add("d-none");
            next.classList.remove("d-none");
          } else if (slider_position == slider_limit) {
            next.classList.add("d-none");
            prev.classList.remove("d-none");
          } else {
            next.classList.remove("d-none");
            prev.classList.remove("d-none");
          }
        }

        //mouse event listeners
        scrollbar.addEventListener("mousedown", function (e) {
          is_down = true;
          start = e.clientX;
        });
        window.addEventListener("mouseup", function (e) {
          is_down = false;
          old_scrollbar_position = scrollbar_position;
        });
        window.addEventListener("mousemove", function (e) {
          if (is_down) {
            calculate_sizes();
            scrollbar_position = old_scrollbar_position + e.clientX - start;
            scrollbar_position =
              scrollbar_position > 0
                ? scrollbar_position < scrollbar_limit
                  ? scrollbar_position
                  : scrollbar_limit
                : 0;
            slider_position = scrollbar_position / link;
            scroll();
          }
        });

        //buttons events listeners
        next.addEventListener("click", function () { 
          calculate_sizes();
          slider_position =
            slider_position + step > slider_limit
              ? slider_limit
              : slider_position + step;
          old_scrollbar_position = slider_position * link;
          scroll();
        });
        prev.addEventListener("click", function () {
          calculate_sizes();
          slider_position =
            slider_position - step < 0 ? 0 : slider_position - step;
          old_scrollbar_position = slider_position * link;
          scroll();
        });

        //starter check
        calculate_sizes();
        if (slider_width <= slider_container_width) {
          next.classList.add("d-none");
          prev.classList.add("d-none");
          scrollbar.classList.add("d-none");
          slider.classList.add("d-flex-center");
        } else {
          scroll();
        }

        window.addEventListener("resize", function () {
          calculate_sizes();
          scroll();
        });
      }
    }
  }

  /////////////////////////////////////// carousel items vertical /////////////////////////////
  carousel_items_vertical() {
    if (document.querySelectorAll(".js-carousel-items-vertical").length > 0) {
      //variables
      const carousel = document.querySelector(".js-carousel-items-vertical");
      const slider_container = carousel.querySelector(".js-slider-container");
      const slider = carousel.querySelector(".js-slider");
      const scroll_btn = carousel.querySelector(".js-scrollbar");
      const next = carousel.querySelector(".js-next");
      const prev = carousel.querySelector(".js-prev");
      const slider_height = slider.clientHeight;
      const slider_container_height = slider_container.clientHeight;

      //parameters
      const limit = slider_height - slider_container_height;
      const step = slider_container_height * 0.8;
      let position = 0;
      let bar_position = 0;
      let old_bar_position = 0;
      let is_down;
      let start;

      //scroll button parameters
      const scroll_btn_height =
        (slider_container_height * slider_container_height) / slider_height;
      scroll_btn.style.height = scroll_btn_height + "px";
      const scroll_limit = slider_container_height - scroll_btn_height;
      const link = scroll_limit / limit;

      //check carousel size
      if (slider_height <= slider_container_height) {
        next.classList.add("d-none");
        prev.classList.add("d-none");
        scroll_btn.classList.add("d-none");
        slider.classList.add("d-flex-center");
        return;
      }

      //check buttons
      function scroll() {
        slider.style.transform = "translateY(-" + position + "px)";
        scroll_btn.style.top = position * link + "px";
        if (position == 0) {
          prev.classList.add("d-none");
          next.classList.remove("d-none");
        } else if (position == limit) {
          next.classList.add("d-none");
          prev.classList.remove("d-none");
        } else {
          next.classList.remove("d-none");
          prev.classList.remove("d-none");
        }
      }

      //page load
      scroll();

      //event listeners
      scroll_btn.addEventListener("mousedown", function (e) {
        is_down = true;
        start = e.clientY;
      });
      window.addEventListener("mouseup", function (e) {
        is_down = false;
        old_bar_position = bar_position;
      });
      window.addEventListener("mousemove", function (e) {
        if (is_down) {
          bar_position = old_bar_position + e.clientY - start;
          bar_position =
            bar_position > 0
              ? bar_position < scroll_limit
                ? bar_position
                : scroll_limit
              : 0;
          position = bar_position / link;
          scroll();
        }
      });
      next.addEventListener("click", function () {
        position = position + step > limit ? limit : position + step;
        old_bar_position = position * link;
        scroll();
      });
      prev.addEventListener("click", function () {
        position = position - step < 0 ? 0 : position - step;
        old_bar_position = position * link;
        scroll();
      });
    }
  }

  /////////////////////////////////////////// stars rating  /////////////////
  stars_rating() {
    if (!document.querySelector(".js-rating")) {
      return;
    }
    //variables
    const stars_container = document.querySelector(".js-rating");
    //functions
    function fill_star(js_class) {
      let star = stars_container.querySelector(js_class);
      star.classList.remove("far");
      star.classList.add("fas");
    }
    function empty_star(js_class) {
      let star = stars_container.querySelector(js_class);
      star.classList.add("far");
      star.classList.remove("fas");
    }

    //rating
    const classes = [
      ".js-rating-1",
      ".js-rating-2",
      ".js-rating-3",
      ".js-rating-4",
      ".js-rating-5",
    ];
    for (let i = 0; i < classes.length; i++) {
      let star = stars_container.querySelector(classes[i]);
      star.addEventListener("click", function () {
        for (let j = i; j >= 0; j--) {
          fill_star(classes[j]);
        }
        for (let j = i + 1; j < classes.length; j++) {
          empty_star(classes[j]);
        }
      });
    }
  }

  /////////////////////////////////////////// window open ///////////////////////////
  open_window($window, $open_btn) {
    //variables
    const window = document.getElementsByClassName($window)[0];
    const open_btns = document.getElementsByClassName($open_btn);

    //open event listeners
    for (let i = 0; i < open_btns.length; i++) {
      const open_btn = open_btns[i];
      open_btn.addEventListener("click", function () {
        window.classList.remove("d-none");
      });
    }
  }

  /////////////////////////////////////////// window close ///////////////////////////////

  close_window($window, $close_btn) {
    //variables
    const window = document.getElementsByClassName($window)[0];
    const close_btns = document.getElementsByClassName($close_btn);

    //close event listeners
    for (let i = 0; i < close_btns.length; i++) {
      const close_btn = close_btns[i];
      close_btn.addEventListener("click", function () {
        window.classList.add("d-none");
      });
    }
  }

  //////////////////////////////////////////// box selecting //////////////////////////
  box_selecting($box_class) {
    //variables
    const boxes = document.getElementsByClassName($box_class);

    //get the boxes
    for (let j = 0; j < boxes.length; j++) {
      const box = boxes[j];
      box.style.color = "white";

      box.addEventListener("click", function () {
        for (let k = 0; k < boxes.length; k++) {
          const box = boxes[k];
          const input = box.querySelector("input");
          const icon = box.getElementsByClassName("js-icon")[0];
          icon.style.left = "-1.5rem";
          icon.style.top = "-1.5rem";
          //checked
          if (input.checked) {
            box.style.border = "solid 3px orange";
            box.style.color = "orange";
            icon.classList.remove("d-none");
          }
          //non checked
          else {
            box.style.border = "none";
            box.style.color = "white";
            icon.classList.add("d-none");
          }
        }
      });
    }
  }

  /////////////////////////////////// zoom //////////////////////

  zoom($small_image, $medium_image, $large_image, $prev_btn, $next_btn) {
    if (
      document.getElementsByClassName($small_image).length > 0 &&
      document.getElementsByClassName($medium_image).length > 0 &&
      document.getElementsByClassName($large_image).length > 0 &&
      document.getElementsByClassName($prev_btn).length > 0 &&
      document.getElementsByClassName($next_btn).length > 0
    ) {
      //variables
      const small_images = document.getElementsByClassName($small_image);
      const medium_image = document.getElementsByClassName($medium_image)[0];
      const large_image = document.getElementsByClassName($large_image)[0];
      const prev_btn = document.getElementsByClassName($prev_btn)[0];
      const next_btn = document.getElementsByClassName($next_btn)[0];
      let index;

      //small images
      const carousel_sources = [];
      for (let i = 0; i < small_images.length; i++) {
        const small_image = small_images[i];
        small_image.addEventListener("mouseenter", function () {
          medium_image.src = small_image.src;
        });
        small_image.addEventListener("click", function () {
          large_image.src = small_image.src;
          check_index();
        });
        carousel_sources.push(small_image.src);
      }

      //medium image
      medium_image.addEventListener("click", function () {
        large_image.src = medium_image.src;
        check_index();
      });

      //prev image
      prev_btn.addEventListener("click", function () {
        if (index > 0) {
          large_image.src = carousel_sources[index - 1];
          check_index();
        }
      });

      //next image
      next_btn.addEventListener("click", function () {
        if (index < carousel_sources.length - 1) {
          large_image.src = carousel_sources[index + 1];
          check_index();
        }
      });

      //check index
      function check_index() {
        index = carousel_sources.indexOf(large_image.src);
        //next btn visibility
        if (index >= carousel_sources.length - 1) {
          next_btn.classList.add("d-none");
        } else {
          next_btn.classList.remove("d-none");
        }

        //prev btn visibility
        if (index <= 0) {
          prev_btn.classList.add("d-none");
        } else {
          prev_btn.classList.remove("d-none");
        }
      }
    }
  }

  dropdown() {
    if (
      !document.querySelector(".js-dropdown-window") ||
      !document.querySelector(".js-dropdown-toggler")
    ) {
      return;
    }

    //html elements
    const dropdown_window = document.querySelector(".js-dropdown-window");
    const dropdown_toggler = document.querySelector(".js-dropdown-toggler");

    dropdown_toggler.addEventListener("click", function () {
      dropdown_window.classList.toggle("d-none");
    });
  }
}
