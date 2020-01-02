import enterView from 'enter-view/enter-view.min';

export default {
  init() {
    // JavaScript to be fired on all pages
  },
  finalize() {

    // JavaScript to be fired on all pages, after page specific JS is fired
    $(".slider-area").slick({
      dots: true,
      arrows: false,
      infinite: true,
      slidesToShow: 3,
      slidesToScroll: 3,
      autoplay: false,
      autoplaySpeed: 6000,
      speed: 1000,
      adaptiveHeight: true,
      responsive: [{
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: true,
        }
      },
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            infinite: true,
            dots: true,
          }
        },
        {
          breakpoint: 576,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            dots: false,
            centerMode: true,
            centerPadding: '10%',
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });
    $('.slider-area').on('init', function (event, slick, direction) {
      var stHeight = $('.slick-track').height();
      $('.slick-slide').css('height', stHeight + 'px');
      console.log("direction");
    });

    enterView({
      selector: '.v-animate',
      enter: function(el) {
        el.classList.add('enter-animation');
      },

      offset: 0.3, // enter at middle of viewport
      once: true, // trigger just once
    });

    $('.pv-modal-link').on('click', function(e) {
      e.preventDefault();
      var $this = $(this),
        reload = $this.data('reload'),
        target = $this.data('target'),
        href = $this.attr('href'),
        $target = $(target),
        urlSegment = href.replace(location.origin, '');
      $('.modal').modal('hide');
      if (href) {
        $.address.state('').value(urlSegment);
      }
      if ($target.length) {
        console.log('showing modal')
        $target.modal('show')
      } else if (reload !== false) {
        window.location = href
      }
    });

// Isotope Initialization
    $('#container').imagesLoaded( function() {
      // images have loaded
      var $container = $('.review-wrap')

      $container.isotope({
        // options
        itemSelector: '.review-wrap__review'
      })
    });


// Match-height Jquery
    $(function() {
      $('.match-height').matchHeight();
    });




// Ad Popup
    $(document).ready(function() {
      if (!isTimerExpired()) {
        return false;
      }
      updateTimer();

      var id = '#dialog';
      //Get the screen height and width
      var maskHeight = $(document).height();
      var maskWidth = $(window).width();
      //Set heigth and width to mask to fill up the whole screen
      $('#mask').css({'width':maskWidth,'height':maskHeight});
      //transition effect
      $('#mask').fadeIn(500);
      $('#mask').fadeTo("slow",0.6);
      $(id).css('top',  '50%');
      $(id).css('left', '50%');
      $(id).css('transform','translate(-50%, -50%)');
      //transition effect
      $(id).fadeIn(2000);
    });

//if close button is clicked
    $('.window .close').click(function (e) {
      //Cancel the link behavior
      e.preventDefault();
      $('#mask').hide();
      $('.window').hide();
    });

//if mask is clicked
    $('#mask').click(function () {
      $(this).hide();
      $('.window').hide();
    });

    function setCookie(cname,cvalue,exdays) {
      var d = new Date();
      d.setTime(d.getTime() + (exdays*24*60*60*1000));
      var expires = "expires=" + d.toGMTString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
      var name = cname + "=";
      var decodedCookie = decodeURIComponent(document.cookie);
      var ca = decodedCookie.split(';');
      for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }

    function updateTimer() {
      setCookie("timer_shown", 'yes', 1);
    }
    function isTimerExpired() {
      var isTimerShown=getCookie("timer_shown");
      return isTimerShown == "" || isTimerShown == null;
    }
    alert('test');

  },
};
