

(function($) {
$.noConflict();
    $( document ).ready(function() {

        //Var Declaration

        var header = $('header.site-header'),

            pageContainer = $('#primary'),

            menuTrigger = $('button#menu-responsive-trigger'),

            menuContainer = $('div#menu-responsive-container');
			

        //Set Nav Search Trigger

        setSearchTrigger($);

        //Is User Scrolling

        isUserScrolling($, header, pageContainer);

        //Responsive Menu

        responsiveMenu(menuTrigger, menuContainer);

        //Smooth Scroll

        smoothScrolling($);
		
		var mobilesearch = '<li id="mobile-search"></li>';
		
		$('#primary-menu').prepend(mobilesearch);
		$('#mobile-search').html('<?php get_search_form(); ?>');
		
		
		
	
	
	

        //Owl Slider

        $(".owl-carousel").owlCarousel({

            singleItem: true,

            pagination: true,
			
			autoPlay: true

        });




        // Mobile dropdown navigation

        showSubMenu($);



        var default_city = $('.city-select').find('option:selected').val();

        showCityCrimeData($, default_city)



        $('.city-select').on('change', function() {

            showCityCrimeData($, $(this).find('option:selected').val());

        });



        //Back to the top fuction

        backToTop($)

    });



})(jQuery);



function showCityCrimeData($, city) {

    $('.city-crime-data-container').find('.is-active').removeClass('is-active');

    $('.single-city-crime-data[data-city="'+city+'"]').addClass('is-active');

}



// Show the modal for a safe line model

function showSafeModal($, model) {

    // $(model).closest('.single-safe-model').find('.safe-line-modal').show();

}





/****Functions****/

//Set Search Trigger

function setSearchTrigger($) {

    var searchField = $('.search-field-row'),

        searchSpan = $('.search-label');

    $('.search-label').on('click', function() {

        searchField.addClass('is-active');

        searchSpan.addClass('is-hidden');

    });

};


//		function setSearchTrigger($) {
//	
//		var searchField = $('.search-field'),
//	
//			searchSpan = $('#search-label');
//	
//		$('#searchsubmit').on('click', function() {
//	
//			searchField.toggleClass('is-active');
//	
//			searchSpan.toggleClass('is-hidden');
//	
//		});
//	
//	};

//Detect If User Is Scrolling

function isUserScrolling($, header, pageContainer) {

    $(window).scroll(function (event) {

        var scroll = $(this).scrollTop();

        if(scroll > 0) {

            header.addClass('is-scrolling');

            pageContainer.addClass('is-scrolling');

        } else {

            header.removeClass('is-scrolling');

            pageContainer.removeClass('is-scrolling');

        };

    });

};

//Responsive Menu Trigger

function responsiveMenu(trigger, container) {

    trigger.on('click', function() {

        jQuery('.closed-menu-text').toggleClass('is-active');

        jQuery('.opened-menu-text').toggleClass('is-active');

        trigger.toggleClass('is-active');

        container.toggleClass('is-visible');

        jQuery('.responsive-menu-icon').toggleClass('open');

    });

};

//Smooth Scrolling

function smoothScrolling($) {

    $(function() {

        $('a[href*="#"]:not([href="#"]):not(".open-modal")').click(function() {

            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {

                var target = $(this.hash);

                target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

                if (target.length) {

                    $('html, body').animate({

                        scrollTop: target.offset().top

                    }, 1000);

                    return false;

                }

            }

        });

    });

};



function showSubMenu($) {
	  
    $('#menu-responsive-container').find('ul.menu').children('li.menu-item-has-children').each(function() {

        $(this).children('.arrow').on('click', function() {

            $(this).closest('li.menu-item-has-children').toggleClass('is-active');

        });

    });

}





function backToTop($) {

    // browser window scroll (in pixels) after which the "back to top" link is shown

    var offset = 300,

    //browser window scroll (in pixels) after which the "back to top" link opacity is reduced

        offset_opacity = 1200,

    //duration of the top scrolling animation (in ms)

        scroll_top_duration = 700,

    //grab the "back to top" link

        $back_to_top = $('.cd-top');



    //hide or show the "back to top" link

    $(window).scroll(function () {

        ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');

        if ($(this).scrollTop() > offset_opacity) {

            $back_to_top.addClass('cd-fade-out');

        }

    });



    //smooth scroll to top

    $back_to_top.on('click', function (event) {

        event.preventDefault();

        $('body,html').animate({

                scrollTop: 0,

            }, scroll_top_duration

        );

    });
	
	
	document.getElementById("currentyear").innerHTML = new Date().getFullYear()
	
	
	
	
$(document).ready(function() {
	
	


	$('.aboutvideo').on('click', function(ev) {
		$("#abvideo")[0].src += "?autoplay=1";
		ev.preventDefault();
		
	});
	
	$('.mfp-content').on('click', function(ev) {
		$('#playerID').get(0).stopVideo();
	});
	
	
	
	//.mfp-content

	
	});
	
	
	

}

	
