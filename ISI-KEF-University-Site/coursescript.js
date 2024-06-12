function active_course() {
  if ($(".active_course").length) {
    $(".active_course").owlCarousel({
      loop: true,
      margin: 20,
      items: 3,
      nav: true,
      autoplay: 2500,
      smartSpeed: 1500,
      dots: false,
      responsiveClass: true,
      thumbs: true,
      thumbsPrerendered: true,
      navText: ["<img src='https://colorlib.com/preview/theme/edustage/img/prev.png'>",
        "<img src='https://colorlib.com/preview/theme/edustage/img/next.png'>"
      ],
      responsive: {
        0: {
          items: 1,
          margin: 0
        },
        991: {
          items: 2,
          margin: 30
        },
        1200: {
          items: 3,
          margin: 30
        }
      }
    });
  }
}
active_course();