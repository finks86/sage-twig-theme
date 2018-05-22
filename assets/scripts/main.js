/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function ($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function () {
        // JavaScript to be fired on all pages
      },
      finalize: function () {
        // JavaScript to be fired on all pages, after page specific JS is fired
      }
    },
    // Home page
    'home': {
      init: function () {
        // JavaScript to be fired on the home page
      },
      finalize: function () {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function () {
        // JavaScript to be fired on the about us page
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function (func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function () {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function (i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }

  function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
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


  var gaProperty = 'UA-64509624-1';

  var disableStr = 'ga-disable-' + gaProperty;

  if (document.cookie.indexOf(disableStr + '=true') > -1) {
    window[disableStr] = true;
  }

  // Load Events
  $(document).ready(function () {
    $('.button--submit').click(function (e) {
      e.preventDefault();
      console.log('Asd');
      $.ajax({
        type: 'POST',
        url: ajax_url.ajax_url,
        data: $('#contact-form').serialize(),
        dataType: 'json',
        success: function (response) {
          //console.log(response);
          $('#contact-form').fadeOut();
          $('.success').fadeIn();
        }
      }).done(function (response) {
        console.log('done');
        $('#contact-form').fadeOut();
        $('.success').fadeIn();
      });
    });

    $(function () {
      var nav_height = $('.navigation').outerHeight();
      $('a[href*="#"]:not([href="#"])').click(function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
          var target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
          if (target.length) {
            $('html, body').animate({
              scrollTop: target.offset().top - nav_height
            }, 1000);
            return false;
          }
        }
      });
    });

    //Modal open
    $('.post-item__image').click(function (e) {
      var id = $(this).data('id');
      var modal = $('*[data-post-id="' + id + '"]');
      var img = modal.find('img');
      $('.is-open').removeClass('is-open');
      img.attr('src', img.data('src'));
      modal.addClass('is-open');
    })

    $('.modal__button').click(function () {
      $('.is-open').removeClass('is-open');
    })

    $(document).keyup(function (e) {
      if (e.keyCode == 27) $('.is-open').removeClass('is-open');
    });

    $('.ga-optout').click(function (e) {
      e.preventDefault();

      document.cookie = disableStr + '=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/';
      window[disableStr] = true;
    })



    $('.js-cookie-bar-button').click(function (e) {
      e.preventDefault();
      setCookie('cookie_notification_dismissed', true);
      $('.cookie-bar').fadeOut();
    });

  });

})(jQuery); // Fully reference jQuery after this point.
