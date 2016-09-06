// Load Events
var $ = jQuery;
$(document).ready(function () {

    $('.details').hide();

    $('.person').click(function (e) {
        e.preventDefault();
        var that = $(this);
        var container = that.parent();
        $('.persons .details').slideUp(400, function () {
          $(this).detach();
        })


        if (!that.hasClass('open')) {
            $('.person').removeClass('open');
            var detail = $('*[data-id="' + that.data('details_id') + '"]');
            var newDetail = detail.clone();
            var newDetailMobile = detail.clone().removeClass('details--desktop').addClass('details--mobile')

            container.append(newDetail);
            that.append(newDetailMobile);

            newDetail.slideDown(400);
            newDetailMobile.slideDown(400);
            that.addClass('open');

        } else {
            that.removeClass('open');
        }

        // if (person.hasClass('open')) {
        //     // person.slideUp();
        //     person.removeClass('open');
        //
        // } else {
        //     // console.log(person.offset().top);
        //     // $('html, body').animate({
        //     //     scrollTop: person.offset().top
        //     // }, 500);
        //     person.slideDown(400);
        //     person.addClass('open');
        // }


    });

    $(window).resize(function () {
        $('.details').removeClass('open').slideUp();
    });

    $(document).on('click','.details__close', function (e) {
        e.preventDefault();
        console.log('ASd');
        $('.persons .details').slideUp(400, function () {
            $(this).parents('.person').removeClass('open');
        });
    });


    $.fn.isOnScreen = function () {

        var win = $(window);

        var viewport = {
            top: win.scrollTop(),
            left: win.scrollLeft()
        };
        viewport.right = viewport.left + win.width();
        viewport.bottom = viewport.top + win.height();

        var bounds = this.offset();
        bounds.right = bounds.left + this.outerWidth();
        bounds.bottom = bounds.top + this.outerHeight();

        return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));

    };

    $(window).scroll(function () {
        // console.log($('.animateNumber').isOnScreen());

        $.each($('.animateNumber'), function (key, numField) {
            // console.log($(numField).isOnScreen());
            if ($(numField).isOnScreen() && !$(numField).hasClass('counted')) {

                var number = $(numField).text().match(/\d+/);
                // var number = $(numField);
                // console.log(number);
                $(numField).addClass('counted');
                $(numField).animateNumber({
                        number: number,
                        // color: 'green', // require jquery.color
                        // 'font-size': '50px',

                        easing: 'linear', // require jquery.easing

                    }, 1000,
                    function () {
                        // $(numField).addClass('counted');
                    });
            }
        });

    });
});

