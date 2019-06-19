/**
 * Stock Coupon - Responsive Coupons, Deal and Promo Template  
 *
 * This file contains all theme JS functions
 *
 * @package 
--------------------------------------------------------------
				   Contents
--------------------------------------------------------------
 * 01 - Search
 * 02 - Navigation / Menu
 * 03 - Sort Dropdown 
 * 04 - Owl
        - Menu Deal Slider
        - Featured Deals Slider
        - Featured Stores Slider
 * 05 - Clipboard
 * 06 - Click To Select Text
 * 07 - Smooth Scroll
 * 08 - Summernote
 * 09 - Datatables
 * 10 - Miscellaneous
 * 11 - MailChimp Form
 * 12 - Preloader

--------------------------------------------------------------*/

(function($) {
  "use strict";

// Search
    $('.search-icon').on('click', function (e) {
      	e.preventDefault();
      	$('.search').addClass('active');
    });

    $('.search-close').on('click', function (e) {
      	e.preventDefault();
      	$('.search').removeClass('active');
    });

// Navigation Menu
	$(function(){
	    $(".nav-dropdown").hover(            
	        function() {
	            $('.nav-dropdown-menu', this).not('.in .nav-dropdown-menu').stop(true,true).slideDown("400");
	            $(this).toggleClass('open');        
	        },
	        function() {
	            $('.nav-dropdown-menu', this).not('.in .nav-dropdown-menu').stop(true,true).slideUp("400");
	            $(this).toggleClass('open');       
	        }
	    );
	});
	
// Sort Dropdown
    $("#merchant-dropdown .dropdown-menu-two").on('click', 'a', function(){
      	$("#merchant-dropdown .dropdown-toggle").text($(this).text());
      	$("#merchant-dropdown .dropdown-toggle").val($(this).text());
   	});
   	$("#cat-dropdown .dropdown-menu-two").on('click', 'a', function(){
      	$("#cat-dropdown .dropdown-toggle").text($(this).text());
      	$("#cat-dropdown .dropdown-toggle").val($(this).text());
   	});

// Owl Carousel
	// Menu Deal Slider
    $("#menu-deal-slider").owlCarousel({
      loop: true,
      items: 2,
      dots: true,
      nav: false,
      autoplayTimeout: 5000,
      smartSpeed: 1500,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 30,
      autoplay: true,
      slideSpeed: 5000,
      navText: ['', ''],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        600: {
            items: 1,
            nav: false,
            dots: true,
        },
        768: {
            items: 1,
            nav: false,
            dots: true,
        },
        1100: {
            items: 2,
            nav: false,
            dots: true,
        }
      }
    });

	// Home Slider
    $("#home-slider").owlCarousel({
      loop: true,
      items: 1,
      dots: true,
      nav: false,
      autoplayTimeout: 5000,
      smartSpeed: 3000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 0,
      autoplay: true,
      slideSpeed: 10000,
      navText: ['', ''],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        600: {
            items: 1,
            nav: false,
            dots: true,
        },
        768: {
            items: 1,
            nav: false,
            dots: true,
        },
        1100: {
            items: 1,
            nav: false,
            dots: true,
        }
      }
    });

	// Featured Deals Slider
    $("#featured-deal-slider").owlCarousel({
      loop: true,
      items: 1,
      dots: false,
      nav: false,
      autoplayTimeout: 3000,
      smartSpeed: 1500,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 30,
      autoplay: true,
      slideSpeed: 5000,
      navText: ['<i class="fas fa-angle-left" aria-hidden="true"></i>', '<i class="fas fa-angle-right" aria-hidden="true"></i>'],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        600: {
            items: 2,
            nav: false,
            dots: false,
        },
        768: {
            items: 3,
            nav: false,
            dots: false,
        },
        1100: {
            items: 5,
            nav: false,
            dots: false,
        }
      }
    });

  	// Featured Stores Slider
    $("#featured-store-slider").owlCarousel({
      loop: true,
      items: 1,
      dots: false,
      nav: false,
      autoplayTimeout: 5000,
      smartSpeed: 1500,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 30,
      autoplay: true,
      slideSpeed: 5000,
      navText: ['<i class="fas fa-angle-left" aria-hidden="true"></i>', '<i class="fas fa-angle-right" aria-hidden="true"></i>'],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        600: {
            items: 2,
            nav: false,
            dots: false,
        },
        768: {
            items: 3,
            nav: false,
            dots: false,
        },
        1100: {
            items: 5,
            nav: false,
            dots: false,
        }
      }
    });

  // Sidebar Stores Slider
    $("#sidebar-store-slider").owlCarousel({
      loop: true,
      items: 1,
      dots: false,
      nav: false,
      autoplayTimeout: 3000,
      smartSpeed: 1500,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 30,
      autoplay: true,
      slideSpeed: 5000,
      navText: ['', ''],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        600: {
            items: 1,
            nav: false,
            dots: false,
        },
        768: {
            items: 1,
            nav: false,
            dots: false,
        },
        1100: {
            items: 1,
            nav: false,
            dots: false,
        }
      }
    });

// Clipboard
	$('.coupon-cpy-btn .btn').tooltip({
		 trigger: 'click',
		 placement: 'bottom'
	});
	function setTooltip(btn, message) {
	  $(btn).tooltip('hide')
	    .attr('data-original-title', message)
	    .tooltip('show');
	}
	function hideTooltip(btn) {
	  setTimeout(function() {
	    $(btn).tooltip('hide');
	  }, 1000);
	}
	var clipboard = new ClipboardJS('.coupon-cpy-btn .btn');
	clipboard.on('success', function(e) {
	  	setTooltip(e.trigger, 'Copied!');
	  	hideTooltip(e.trigger);
	});
	clipboard.on('error', function(e) {
	  	setTooltip(e.trigger, 'Press CTRL + C');
	  	hideTooltip(e.trigger);
	});

// Click To Select Text
	$(".coupon-code").on('mouseup', function() { 
	    var sel, range;
	    var el = $(this)[0];
	    if (window.getSelection && document.createRange) { //Browser compatibility
	      sel = window.getSelection();
	      if(sel.toString() == ''){ //no text selection
	         window.setTimeout(function(){
	            range = document.createRange(); //range object
	            range.selectNodeContents(el); //sets Range
	            sel.removeAllRanges(); //remove all ranges from selection
	            sel.addRange(range);//add Range to a Selection.
	        },1);
	      }
	    }else if (document.selection) { //older ie
	        sel = document.selection.createRange();
	        if(sel.text == ''){ //no text selection
	            range = document.body.createTextRange();//Creates TextRange object
	            range.moveToElementText(el);//sets Range
	            range.select(); //make selection.
	        }
	    }
	});

// Smooth Scroll
	let anchorlinks = document.querySelectorAll('a[id="ac-followers-btn"]')
	for (let item of anchorlinks) {
	    item.addEventListener('click', (e)=> {
	        let hashval = item.getAttribute('href')
	        let target = document.querySelector(hashval)
	        target.scrollIntoView({
	            behavior: 'smooth',
	            block: 'start'
	        })
	        history.pushState(null, null, hashval)
	        e.preventDefault()
	    })
	}
	let anchorlinks2 = document.querySelectorAll('a[id="ac-followings-btn"]')
	for (let item of anchorlinks2) {
	    item.addEventListener('click', (e)=> {
	        let hashval = item.getAttribute('href')
	        let target = document.querySelector(hashval)
	        target.scrollIntoView({
	            behavior: 'smooth',
	            block: 'start'
	        })
	        history.pushState(null, null, hashval)
	        e.preventDefault()
	    })
	};

// Datepicker 
	if ($('.date-pick').length) {
	   	$('.date-pick').datepicker({
	      	format : "dd/mm/yyyy",
          startDate: '+1d',
         autoclose: true,
	    });
	};

// Summernote
	$('#summernote-main').summernote({
	  	height: 100,
	});
  $('#summernote').summernote({
    height: 200,                 // set editor height
  });


// Datatables
	$('#forum-table').dataTable( {
	  "ordering": false,
	  "responsive": true,
	  // "columns": [
	  //       { responsivePriority: 1 },
	  //       { responsivePriority: 6 },
	  //       { responsivePriority: 3 },
	  //       { responsivePriority: 4 },
	  //       { responsivePriority: 5 },
	  //       { responsivePriority: 2 },
	  //   ]
	});

	$(function() {
	    var dataTable = $('#forum-table').dataTable();
	    $("#forum-searchbox").on('keyup click',function() {
	        dataTable.fnFilter(this.value);
	    });  

  //Miscellaneous
   $('.pagination li a').addClass('page-link');
    $('.pagination li span').addClass('page-link');
    $('.pagination li').addClass('page-item');

    $( ".share-btn" ).click(function(e) {
      $('.networks-5').not($(this).next( ".networks-5" )).each(function(){
        $(this).removeClass("active");
      });
     
      $(this).next( ".networks-5" ).toggleClass( "active" );
    });   

    $('body').on('click', '.reply-btn', function(){
      event.preventDefault();
      var rep_id=$(this).data("value");
      $("#review").toggle().css("display","block");
      $('#review [name=replyid]').val(rep_id);
    });

    $(".set-rating").rateYo({
      starWidth: "18px",
      spacing: "1px",
      normalFill: "#CCCCCC",
      ratedFill: "#E8511C",
      readOnly: true
    });

    $('.select2').select2({
        minimumResultsForSearch: 2 // at least 20 results must be displayed
    });

   $("#catInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#catList li").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    $("#storeInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#storeList li").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

// Mailchimp Form
    $('#subscribe-form').ajaxChimp({
        url: 'http://blahblah.us1.list-manage.com/subscribe/post?u=5afsdhfuhdsiufdba6f8802&id=4djhfdsh9'
    });

// Preloader =====*/
    $(window).on('load', function()  { 
      	$('.status').fadeOut();
      	$('.preloader').delay(350).fadeOut('slow'); 
    }); 

});

})(jQuery);