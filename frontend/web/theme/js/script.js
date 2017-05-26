// Rooms (hotel)
function getRooms(hotelId, lang, params, sort) {

    // Default sort
    if (typeof sort === 'undefined') {
        var sort = 'price-asc';
    }

    // add lang to params
    params = params + '&lang=' + lang;

    // add sort to params
    params = params + '&sort=' + sort;

    $.ajax({
        method: 'POST',
        url: urlPrefix(lang) + '/hotels/rooms',
        data: params,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-CSRF-Token': document.getElementsByName('csrf-token')[0].content
        },
    }).success(function (data) {
        // Hide preloader
        $('.preloader-wrapper').hide();

        // Response
        $('#rooms-container').html(data);

        // Init modals
        $('.modal').modal();

        // Active item
        $('#sort-select').val(sort);

        // Init select
        $('#sort-select').material_select();

        // Sort change
        $('#sort-select').on('change', function () {
            getRooms(hotelId, lang, params, $(this).val());
        });
    });
}

$('.booking-guests .select-dropdown').change(function () {
    console.log('select');
    $('.servio-search-input-age .select-dropdown').material_select();
});

function showAll() {
    $('.room').removeClass('hide');
    $('#button-all-rooms').hide();
}

// Show all offers on index page
$('#offers-show-all').click(function () {
    $.ajax({
        method: 'GET',
        url: urlPrefix() + '/offers-list',
    }).success(function (data) {
        $('#offers').html(data);
        // Hide button
        $("#offers-show-all").hide();
    });
});


// Show all hotels in hotels category 
$('#hotels-show-all').click(function () {
    $.ajax({
        method: 'GET',
        url: urlPrefix() + '/hotels-list',
    }).success(function (data) {
        $('#city-hotels').html(data);
        // Hide button
        $("#hotels-show-all").hide();
    });
});

// Show all conference rooms in conferense rooms category 
$('#conf-rooms-show-all').click(function () {
    $.ajax({
        method: 'GET',
        url: urlPrefix() + '/confrooms-list',
    }).success(function (data) {
        $('#services-hotels').html(data);
    });
});

// Booking button
function reserve(id, hashKey) {
    var lang = $('html').attr('lang');

    $.ajax({
        method: 'POST',
        url: '/booking/search?hashKey=' + hashKey + '&refStep=1&lang=' + lang,
        data: 'selectedRoom[0]=' + id,
    }).success(function (data) {
        window.location.href = data.result.redirect + '&lang=' + lang;
    }).error(function () {

    });
}

// Reserve (not hotel)
// Get modal
function showReserve(type, itemId) {
    $.ajax({
        method: 'GET',
        url: urlPrefix() + '/feedback/feedback-template/' + type + '/' + itemId,
    }).success(function (data) {
        $('#reserve-modal').html(data);

        // init modal
        var reserve = $('#reserve-modal').modal({
            complete: function () {
                //console.log(this);
                //alert('Closed');
            } // Callback for Modal close
        }
        );

        reserve.modal('open')

        // init date picker
        $('.datepicker').pickadate({
            selectMonths: false, // Creates a dropdown to control month
            selectYears: false, // Creates a dropdown of 15 years to control year
            showWeekdaysFull: true,
            onRender: function () {
                $('.picker__date-display').remove();
            },
            onSet: function (context) {
                // Hide picker
                this.close();
            }
        });

    });
}

// Send mail
function reserveSend(formId) {
    var form = $('#' + formId);
    var id = $('#reserve-item-id').val();
    var button = $('#action-' + id);

    $.ajax({
        method: 'POST',
        url: $('#' + formId).attr('action'),
        data: 'phone=' + $('#reserve-phone').val() + '&name=' + $('#reserve-name').val()
                + '&id=' + id + '&date=' + $('#reserve-date').val()
                + '&type=' + $('#reserve-type').val(),
    }).success(function (data) {
        if (data[0] == 'success') {
            button.html(button.data('success'));
            button.addClass('green-text');
        } else {
            button.html(button.data('error'));
            button.addClass('red-text');
        }
        $('#reserve-modal').modal('close');
    }).error(function () {
        button.html(button.data('error'));
        button.addClass('red-text');
        $('#reserve-modal').modal('close');
    });
}
// /Reserve

// Mobile header

$('#search-icon').click(function () {
    $('#open-menu').hide();
    $('#logo-m').hide();
    $('#search-icon').hide();
    $('#header-search').show();
});

$('#search-close').click(function () {
    $('#header-search').hide();
    $('#open-menu').show();
    $('#logo-m').show();
    $('#search-icon').show();
});

$('#open-menu').click(function () {
    $('#menu-main-m').show();
});

$('#menu-close').click(function () {
    $('#menu-main-m').hide();
});




/**
 * Map functions
 */
// Show hotel by id
function showHotel(id, x, y) {
// Hide all hotels
    var subs = document.getElementById('hotels').children;
    for (var i = 0; i < subs.length; i++) {
        var a = subs[i];
        a.style.display = 'none';
    }

// Hotel
    var hotel = document.getElementById(id);

// map width
    var width = document.getElementById("map").offsetWidth;

// Svg width = 900 px
    var wRatio = width / 900;

// map height
    var height = document.getElementById("map").offsetHeight;

// Svg height = 600 px
    var hRatio = height / 600;

// new coordinates
    var newX = x * wRatio;
    var newY = y * hRatio;

// correct x coord.
    if ((newX + 400) > width) {
        newX = newX - 400;
    }

    if (hotel) {
        if (!hotel.style || hotel.style.display == "none") {
            hotel.style.display = "block";
            hotel.style.left = newX + "px";
            hotel.style.top = newY + "px";
        } else {
            hotel.style.display = "none";
        }
    }
}

// Hide hotel or list hotels/hostels
function hideHotel(id) {
    var hotel = document.getElementById(id);
    if (hotel.style.display == "block") {
        hotel.style.display = "none";
    } else {
        hotel.style.display = "block";
    }
}
/**
 *  / Map
 */

// Url prefix
function urlPrefix(lang) {
    var prefix = '';

    if (typeof lang === 'undefined') {
        lang = $('html').attr('lang');
    }

    if (lang != 'uk') {
        prefix = '/' + lang;
    }
    return prefix;
}

// Contacts form
$('#feedbackForm').submit(function (e) {
    e.preventDefault();
    $.ajax({
        method: 'POST',
        url: $('#feedbackForm').attr('action'),
        data: 'name=' + $('#feedback-name').val()
                + '&email=' + $('#feedback-email').val()
                + '&phone=' + $('#feedback-phone').val(),
    }).success(function (data) {
        $('#result').html(data[0]);
    }).error(function () {
        $('#result').html('Error');
    });


});

// Callback
function callback() {
    $.ajax({
        method: 'GET',
        url: urlPrefix() + '/feedback/callback-template',
    }).success(function (data) {
        $('#callback').html(data);
        $('#callback').modal('open');
    }).error(function () {
        $('#callback').html('Error');
    });
}

// Close modal
function callbackCancel(id) {
    $('#' + id).modal('close');
}

// callback send mail

// Send mail
function callbackSend(formId) {
    var form = $('#' + formId);

    $.ajax({
        method: 'POST',
        url: $('#' + formId).attr('action'),
        data: 'phone=' + $('#callback-phone').val(),
    }).success(function (data) {
        $('#callback').modal('close');
    }).error(function () {
        $('#callback').modal('close');
    });
}

// Carousel
// Resize on load
//document.addEventListener("DOMContentLoaded", function(event) { 
document.addEventListener("DOMContentLoaded", function (event) {
    //document ready - resize
    resizeCarousel();

});

// Resize on resize window
window.addEventListener('resize', function () {
    resizeCarousel();
});

// Resize carousel
function resizeCarousel() {
    var carousel = document.getElementById("carousel");
    var carouselHotel = document.getElementById("carousel-hotel-images");

    if (carousel) {
        var width = carousel.clientWidth;
        // background image 1920*853
        var ratio = 0.444;

        // Mobile
        if (width < 600) {
            ratio = 0.85;
        }
        var height = Math.round(width * ratio);

        // need resize
        var currentHeight = $('#carousel').height();
        if (currentHeight > height + 5 || currentHeight < height - 5) {
            carousel.style.height = height + "px";
        }
    } else if (carouselHotel) {
        var ratioGallery = 0.22;
        if (carouselHotel.clientWidth < 600) {
            ratioGallery = 0.57;
        }
        var height = Math.round(carouselHotel.clientWidth * ratioGallery);
        //carouselHotel.style.height = height + "px";
    }
}
// /Carousel