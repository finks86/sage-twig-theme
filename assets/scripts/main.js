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

(function($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages
      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired
      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
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
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

  //dropdown script

  $(".dropdown-container .dropdown-menu li a").click(function(e){
    e.preventDefault();
    var buttonSelector = '.' + $(this).attr("class") + " button.btn";

    $(buttonSelector).text($(this).text());
    $(buttonSelector).val($(this).text());

  });

  $(".dropdown-2 li a").click(function(e){
    if($(this).text() === "BMW") {
      $(".ul-model-list").append('<li><a>BMW Model 1</a></li><li><a>BMW Model 2</a></li><li><a>BMW Model 3</a></li>');
    }
  });

  $(".oil-finder-submit").click(function(){
      $(".oil-finder-form").hide();
      $(".oil-finder-lastscreen-container").fadeIn(800);
  });

  $(".oil-finder-return").click(function(){
    $(".oil-finder-lastscreen-container").hide();
    $(".oil-finder-form").fadeIn(800);
  });

  $(".food-map-area").on("click", function(e){
    e.preventDefault();
    console.log($(this).attr('id'));

    if( $(this).attr('id') === "rhubarb-small") {
      $(".food-overlay-image").hide();
      $('.rhubarb').fadeIn(400);
    }

    if( $(this).attr('id') === "elderberry-small") {
      $(".food-overlay-image").hide();
      $('.elderberry').fadeIn(400);
    }

    if( $(this).attr('id') === "raspberry-small") {
      $(".food-overlay-image").hide();
      $('.raspberry').fadeIn(400);
    }

    if( $(this).attr('id') === "blueberry-small") {
      $(".food-overlay-image").hide();
      $('.blueberry').fadeIn(400);
    }

    if( $(this).attr('id') === "strawberry-small") {
      $(".food-overlay-image").hide();
      $('.strawberry').fadeIn(400);
    }

    if( $(this).attr('id') === "seasbuckthorn-small") {
      $(".food-overlay-image").hide();
      $('.seasbuckthorn').fadeIn(400);
    }
  });

})(jQuery); // Fully reference jQuery after this point.
