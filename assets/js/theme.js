(function( $ ) {
	'use strict';
	var resizeTimer;
    // Fire on document ready.
    $( document ).ready( function() {
        overcome_StickyHeader();
        overcome_toggle_menu();
        overcome_touched_side();
        overcome_open_mobile_menu();
        overcome_popup();
        overcome_toggle();
        overcome_side_nav();
        overcome_video_size();
        overcome_vcRow();
        overcome_inlineCss();
        overcome_ajax_pagination();
        overcome_woo_filters();
        overcome_wc_single_product_gallery();
        overcome_wooscp_change_text();
        // WooCommerce
        overcome_quantity_plus_minus();
        overcome_quantity_plus_minus_action();
        overcome_remove_cart_actions();

        overcome_svg_color();
        overcome_smooth_scroll();

        overcome_tabs();
    });
	// On Load 
	$(window).load(function() {
        "use strict";
		overcome_page_loading();
        overcome_vcRow();
        overcome_woo_price_filter_add_data_title();
        overcome_wooscp_change_text();
        overcome_masonry_filter();
        overcome_vc_animation_callback();

        overcome_tabs();
	});
	// On scroll
	$( window ).scroll( function() {
        "use strict";
	});
	// On Resize
	$( window ).resize( function() {
        "use strict";
		clearTimeout( resizeTimer );
		overcome_touched_side();
        overcome_vcRow();
	});

    // Ajax Complete
    $(document).ajaxComplete(function(event, xhr, settings){
        "use strict";
        // WooCommerce Default Orderby
        $( '.woocommerce-ordering' ).on( 'change', 'select.orderby', function() {
            $( this ).closest( 'form' ).submit();
        });
        overcome_video_size();
        overcome_popup();
        overcome_init_price_filter();
        overcome_masonry_filter();
        overcome_vc_animation_callback();
        overcome_remove_cart_actions();
    });
    jQuery( document ).on( 'updated_wc_div', function() {
        overcome_remove_cart_actions();
    } );

	/**
	 * Add page loading
	*/
	function overcome_page_loading(){
		'use strict';
		$("#ef5-loading").fadeOut("slow");
	}
    /**
     * Sticky Header 
    */
    function overcome_StickyHeader(){
        'use strict';
        var c, currentScrollTop = 0,
           navbar = $('.sticky-on'),
           menu = navbar.find('#ef5-header-menu');
        $(window).scroll(function () {
          var a = $(window).scrollTop();
          var b = navbar.height();
          currentScrollTop = a;
          if (c < currentScrollTop && a > b + b) {
            navbar.removeClass('header-sticky').addClass('scrollDown');
            if(navbar.hasClass('header-ontop-sticky')){
                navbar.addClass('header-ontop');
                menu.addClass('menu-ontop').removeClass('menu-sticky');
            }
            if(navbar.hasClass('header-default-sticky')){
                navbar.addClass('header-default');
                menu.addClass('menu-default').removeClass('menu-sticky');
            }
          } else if (c > currentScrollTop && !(a <= b)) {
            navbar.addClass('header-sticky').removeClass('scrollDown');
            if(navbar.hasClass('header-ontop-sticky')) {
                navbar.removeClass('header-ontop');
                menu.removeClass('menu-ontop').addClass('menu-sticky');
            }
            if(navbar.hasClass('header-default-sticky')) {
                navbar.removeClass('header-default');
                menu.removeClass('menu-default').addClass('menu-sticky');
            }
          } else if(c > currentScrollTop){
            navbar.removeClass('header-sticky');
            if(navbar.hasClass('header-ontop-sticky')) {
                navbar.addClass('header-ontop');
                menu.addClass('menu-ontop').removeClass('menu-sticky');
            }
            if(navbar.hasClass('header-default-sticky')) {
                navbar.addClass('header-default');
                menu.addClass('menu-default').removeClass('menu-sticky');
            }
          }
          c = currentScrollTop;
        });
    }
	/**
	 * Toggle Menu 
	*/
	function overcome_toggle_menu(){ 
		'use strict';
		$('.ef5-toggle').on('click', function(e){
            e.preventDefault();
			$(this).find('.ef5-toggle-inner').toggleClass('active');
            $(this).prev().find('.ef5-toggle-inner').toggleClass('active');
			$(this).parent().parent().toggleClass('clicked');
            $(this).parent().next().slideToggle();
		});
        $('.ef5-toggle-block').on('click', function(e){
            e.preventDefault();
            $(this).toggleClass('active');
            $(this).parents('.ef5-page').find('.ef5-toggle-block-content').slideUp();
            e.stopPropagation();
            $(this).parent().find('.ef5-toggle-block-content').slideToggle();
        });
        $('body').on('click', function(e){
            $(this).find('.ef5-toggle-block-content').slideUp();
        });
	}
	/**
	 * Menu Back
	 * Sub menu touched on side left/right
	*/
	function overcome_touched_side(){
        'use strict';
        var $menu = $('.ef5-header-menu');
        if($(window).width() > 1200 ){
            $('#ef5-navigation').attr('style','');
            $menu.find('li').each(function(){
                var $submenu = $(this).find('> .ef5-dropdown');
                if($submenu.length > 0){
                    if($submenu.offset().left + $submenu.outerWidth() > $(window).innerWidth()){
                        $submenu.addClass('touched');
                    } else if($submenu.offset().left < 0){
                        $submenu.addClass('touched');
                    }
                    /* remove css style display from mobile to desktop menu */
                    $submenu.css('display','');
                }            
            });
        }
    }

    /**
	 * Open Mobile Menu 
    */
    function overcome_open_mobile_menu(){
    	'use strict';
        $("#ef5-main-menu-mobile").on('click',function(){
            $(this).toggleClass('opened').find('.btn-nav-mobile').toggleClass('opened');
            $('#ef5-navigation').slideToggle();
        })
    }
    /**
	 * Popup
    */
    function overcome_popup(){
        'use strict';
    	if(typeof $.magnificPopup != 'undefined'){
            /* ===================
             Popup Images Gallery
             ===================== */
            $('.ef5-gallery').each(function() {
                $(this).magnificPopup({
                    delegate: 'a.light-box',
                    type: 'image',
                    gallery: {
                        enabled: true
                    },
                    titleSrc: 'title',
                    removalDelay: 300,
                    mainClass: 'animated slideInRight mfp-gallery',
                    closeBtnInside: false,
                    zoom: {
                        //enabled: true,
                        duration: 300,
                        easing: 'ease-in-out', 
                        opener: function(openerElement) {
                            return openerElement.is('img') ? openerElement : openerElement.find('img');
                        }
                    },
                    callbacks: {
                        beforeOpen: function() {
                           this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure animated ' + this.st.el.attr('data-effect'));
                        }
                    }
                });
            });
            /* ===================
             Header Icon Popup
             ===================== */
             $('.ef5-header-popup').magnificPopup({
                type:'inline',
                closeBtnInside: false,
                removalDelay: 300,
                mainClass: 'mfp-with-zoom',
                focus: '.search-field',
                zoom: {
                    enabled: true,
                    duration: 500,
                    easing: 'ease-in-out', 
                    opener: function(openerElement) {
                        return openerElement.is('img') ? openerElement : openerElement.find('img');
                    }
                }
            });
            /* ===================
             Popup Inline HTML
             with content verticle middle
             ===================== */
             $('.mfp-inline').magnificPopup({
                type:'inline',
                closeBtnInside: false,
                removalDelay: 300,
                mainClass: 'mfp-with-zoom',
                zoom: {
                    enabled: true,
                    duration: 500,
                    easing: 'ease-in-out', 
                    opener: function(openerElement) {
                        return openerElement.is('img') ? openerElement : openerElement.find('img');
                    }
                }
            });
            /*==================
             Popup Iframe
             show youtube, vimeo, google maps and more 
            ====================*/
            $('.popup-iframe').magnificPopup({
               //disableOn: 700,
               type: 'iframe',
               mainClass: 'mfp-fade',
               removalDelay: 160,
               preloader: false,
               fixedContentPos: false
            });
        }
    }
    /**
     * Smooth Scroll
     * https://www.w3schools.com/howto/howto_css_smooth_scroll.asp#section2
    */
    function overcome_smooth_scroll(){
        'use strict';
        $('body').on('click', '.ef5-scroll, .is-one-page', function () {
            var target = $(this.hash),
                offset = $('.header-sticky').innerHeight();
                target = target.length ? target : '';
            if (target.length) {
                $('html,body').animate({scrollTop: target.offset().top - offset}, 750);
                return false;
            }
        });
    }
    /**
	 * Toggle
    */
    function overcome_toggle(){
        'use strict';
    	/* ===================
         Search Toggle
         ===================== */
        $('.ef5-search-toggle').on('click',function(e){
            e.preventDefault();
            $('.ef5-cartform').removeClass('active');
            $('.ef5-searchform').toggleClass('active').find('.ef5-search-field').focus();
        });
        $('.ef5-search-submit').on('click',function(e){
            if( $(this).parent().find('.ef5-search-field').val() == '' ) {
                e.preventDefault();
                $(this).parents('.ef5-searchform').removeClass('active');
            }
        });

        /* ===================
         Cart Toggle
         ===================== */
        $('.ef5-cart-toggle').on('click',function(e){
            e.preventDefault();
            $('.ef5-searchform').removeClass('active');
            $('.ef5-cartform').toggleClass('active').slideToggle();
        });
    }
    /**
	 * Side Nav
    */
    function overcome_side_nav(){
        "use strict";
    	/* Widget Nav */
        $("#ef5-main-sidenav .open-menu").on('click',function(){
            $(this).toggleClass('opened');
            $('#ef5-page').toggleClass('sidenav-open');
            $('#ef5-sidenav').toggleClass('open');
        })
        $('#ef5-close-sidenav').on('click',function(){
            $('#ef5-page').removeClass('sidenav-open');
            $('#ef5-sidenav').removeClass('open');
            $('#ef5-main-sidenav .btn-nav-mobile').removeClass('opened');
        })
    }
	/**
     * Media Embed dimensions
     * 
     * Youtube, Vimeo, Iframe, Video, Audio.
     * @author Chinh Duong Manh
     */
    function overcome_video_size() {
        'use strict';
        setTimeout(function(){
	        $('.ef5-featured iframe , .ef5-featured  video, .ef5-featured .wp-video-shortcode').each(function(){
	            var v_width = $(this).parent().width();
	            var v_height = Math.floor(v_width / (16/9));
	            $(this).attr('width',v_width).css('width',v_width);
	            $(this).attr('height',v_height).css('height',v_height);
	        });
	    }, 100);
    }
    // VC Row 
    function overcome_vcRow() {
        'use strict';
        if($(window).width() < 1200 ) return;
        var $site_boxed      = $('.site-boxed [data-vc-full-width="true"]'),
            $site_bordered   = $('.site-bordered [data-vc-full-width="true"]'),
            bordered_left    = parseInt($('body').css('padding-left')),
            bordered_right   = parseInt($('body').css('padding-right')),
            $header_layout_3 = $('body.header-3:not(site-boxed) [data-vc-full-width="true"]'),
            $header_layout_3_boxed = $('body.header-3.site-boxed [data-vc-full-width="true"]'),
            rtl = $('html[dir="rtl"]');

        setTimeout(function() {
            // boxed
            $.each($site_boxed, function(key, item) {
                var $el = $(this),
                    offset = parseInt($el.css('left').replace('-',''));
                if($el.data("vcStretchContent")){
                    $el.css({
                        'padding-left': offset + bordered_right + 'px',
                        'padding-right': offset + bordered_left + 'px'
                    });
                }
            }), 
            $(document).trigger("vc-full-width-row", $site_boxed);
            // bordered 
            $.each($site_bordered, function(key, item) {
                var $el = $(this);
                if($el.data("vcStretchContent")){
                    $el.css({
                        'padding-left': bordered_left + 'px',
                        'padding-right': bordered_right + 'px',
                    });
                }
            }), 
            $(document).trigger("vc-full-width-row", $site_bordered);
            // Header Layout 3
            $.each($header_layout_3, function(key, item) {
                var $el = $(this),
                    offset = parseInt($el.css('left').replace('-',''));
                if($el.data("vcStretchContent")){
                    if(rtl.length){
                        $el.css({
                            'padding-right': bordered_right + 'px',
                        });
                    } else {
                        $el.css({
                            'padding-left': bordered_left + 'px',
                        });
                    }
                } else {
                    if(rtl.length){
                        $el.css({
                            'padding-left': offset - bordered_right + 'px',
                        });
                    }
                }
            }), 
            $(document).trigger("vc-full-width-row", $header_layout_3);

            // Header Layout 3 & Boxed || Bordered
            $.each($header_layout_3_boxed, function(key, item) {
                var $el = $(this),
                    offset = parseInt($el.css('left').replace('-',''));
                if($el.data("vcStretchContent")){
                    if(rtl.length){
                        $el.css({
                            'padding-left': offset - bordered_right + 'px',
                            'padding-right': offset - bordered_left + 'px',
                        });
                    } else {
                        $el.css({
                            'padding-left': offset - bordered_right + 'px',
                            'padding-right': offset - bordered_left + 'px',
                        });
                    }
                } else {
                    if(rtl.length){
                        $el.css({
                            'padding-left': offset - bordered_right + 'px',
                        });
                    }
                }
            }), 
            $(document).trigger("vc-full-width-row", $header_layout_3_boxed);

        }, 0 );
    }
    // Inline CSS to head
    function overcome_inlineCss(){
        'use strict';
        var _inline_css = '<style class="ef5-inline-css">';
        $(document).find('div.ef5-inline-css').each(function () {
            var _this = $(this);
            _inline_css += _this.attr("data-css");
            _this.remove();
        });
        _inline_css += '</style>';
        $('head').append(_inline_css);
    }
    // Unbreak Ajax Pagination
    function overcome_ajax_pagination(){
        'use strict';
        $('.ef5-posts').each(function(){
            "use strict";
            var $this = $(this),
                $id = $(this).attr('id'),
                $loading_class = 'ef5-loading';
            $this.find('.ef5-loop-pagination a').live('click',function(){
                $this.fadeTo('slow',0.3).addClass($loading_class);
                $this.addClass($loading_class);
                var $link = $(this).attr('href');
                jQuery.get($link,function(data){
                    $this.html($(data).find('#'+$id).html());
                    $this.fadeTo('slow',1).removeClass($loading_class);
                    $this.removeClass($loading_class);
                    $this.find('.wpb_animate_when_almost_visible').addClass('wpb_start_animation animated');
                });
                $('html,body').animate({scrollTop: $this.offset().top - 100}, 750);
                return false;
            });
        });
    }
    // WooCommerce Filters 
    function overcome_woo_filters(){
        "use strict";
        $('.ef5-main').each(function(){
            var $this = $(this),
                $id = $(this).attr('id'),
                $loading_class = 'ef5-loading',
                $filtered_nav = $('.widget_layered_nav_filters ul');

            $this.find('.wc-layered-nav-term > a, .chosen > a, .wc-layered-nav-rating > a, .ef5-filter').live('click touch',function(){
                'use strict';
                $this.fadeTo('slow',0.3).addClass($loading_class);
                $this.addClass($loading_class);
                var $link = $(this).attr('href');
                window.history.pushState({url: "" + $link + ""}, "", $link);
                jQuery.get($link,function(data){
                    $this.html($(data).find('#'+$id).html());
                    $this.removeClass($loading_class);
                    $this.fadeTo('slow',1).removeClass($loading_class);
                });
                return false;
            });
        })
    };
    
    // Re-Run filer by Price
    function overcome_init_price_filter() {
        "use strict";
        $( 'input#min_price, input#max_price' ).hide();
        $( '.price_slider, .price_label' ).show();

        var min_price = $( '.price_slider_amount #min_price' ).data( 'min' ),
            max_price = $( '.price_slider_amount #max_price' ).data( 'max' ),
            current_min_price = $( '.price_slider_amount #min_price' ).val(),
            current_max_price = $( '.price_slider_amount #max_price' ).val();
        if(typeof $.slider != 'undefined'){
            $( '.price_slider:not(.ui-slider)' ).slider({
                range: true,
                animate: true,
                min: min_price,
                max: max_price,
                values: [ current_min_price, current_max_price ],
                create: function() {

                    $( '.price_slider_amount #min_price' ).val( current_min_price );
                    $( '.price_slider_amount #max_price' ).val( current_max_price );

                    $( document.body ).trigger( 'price_slider_create', [ current_min_price, current_max_price ] );
                },
                slide: function( event, ui ) {

                    $( 'input#min_price' ).val( ui.values[0] );
                    $( 'input#max_price' ).val( ui.values[1] );

                    $( document.body ).trigger( 'price_slider_slide', [ ui.values[0], ui.values[1] ] );
                },
                change: function( event, ui ) {

                    $( document.body ).trigger( 'price_slider_change', [ ui.values[0], ui.values[1] ] );
                }
            });
        }
    }
    /* 
     * Woocomere filter modify
     * Add data title
    */
    function overcome_woo_price_filter_add_data_title(){
        "use strict";
        $('.price_slider_wrapper ').each(function () {
            var _this = $(this);
            if(_this.find('.ui-slider-handle').length < 2)
                return;
            var from = _this.find('.price_label .from'),
                to = _this.find('.price_label .to'),
                handle_left = $(_this.find('.ui-slider-handle')[0]),
                handle_right = $(_this.find('.ui-slider-handle')[1]);
            /**
             * _this.find('.price_label').hide();
             */
            handle_left.attr('data-title',from.html());
            handle_right.attr('data-title',to.html());
            from.on('DOMSubtreeModified',function () {
                handle_left.attr('data-title',$(this).html());
            });
            to.on('DOMSubtreeModified',function () {
                handle_right.attr('data-title',$(this).html());
            });
        });
    }
    rebuild_price_filter();
    function rebuild_price_filter() {
        "use strict";
        var price_filter = $('.widget_price_filter form');
        /**
         * price_filter.find('button[type="submit"]').css('visibility', 'hidden');
        */
        price_filter.find('.price_slider').on('slidestop', function () {
            /**
             * do_filter();
            */
        });
    }
    /**
     * Single Product
    */
    //quantity number field custom
    function overcome_quantity_plus_minus(){
        "use strict";
        $( ".quantity input" ).wrap( "<div class='ef5-quantity'></div>" );
        $('<span class="quantity-button quantity-down"></span>').insertBefore('.quantity input');
        $('<span class="quantity-button quantity-up"></span>').insertAfter('.quantity input');
    }
    function overcome_ajax_quantity_plus_minus(){
        "use strict";
        $('<span class="quantity-button quantity-down"></span>').insertBefore('.quantity input');
        $('<span class="quantity-button quantity-up"></span>').insertAfter('.quantity input');
    }
    function overcome_quantity_plus_minus_action(){
        "use strict";
        $(document).on('click','.quantity .quantity-button',function () {
            var $this = $(this),
                spinner = $this.closest('.quantity'),
                input = spinner.find('input[type="number"]'),
                step = input.attr('step'),
                min = input.attr('min'),
                max = input.attr('max'),value = parseInt(input.val());
            if(!value) value = 0;
            if(!step) step=1;
            step = parseInt(step);
            if (!min) min = 0;
            var type = $this.hasClass('quantity-up') ? 'up' : 'down' ;
            switch (type)
            {
                case 'up':
                    if(!(max && value >= max))
                        input.val(value+step).change();
                    break;
                case 'down':
                    if (value > min)
                        input.val(value-step).change();
                    break;
            }
            if(max && (parseInt(input.val()) > max))
                input.val(max).change();
            if(parseInt(input.val()) < min)
                input.val(min).change();
        });
    }
    // WooCommerce Single Product Gallery 
    function overcome_wc_single_product_gallery(){
        'use strict';
        if(typeof $.flexslider != 'undefined'){

            $('.wc-gallery-sync').each(function() {
                var itemW      = parseInt($(this).attr('data-thumb-w')),
                    itemH      = parseInt($(this).attr('data-thumb-h')),
                    itemN      = parseInt($(this).attr('data-thumb-n')),
                    itemMargin = parseInt($(this).attr('data-thumb-margin')),
                    itemSpace  = itemH - itemW + itemMargin;
                if($(this).hasClass('thumbnail_v')){
                    $(this).flexslider({
                        selector       : '.wc-gallery-sync-slides > .wc-gallery-sync-slide',
                        animation      : 'slide',
                        controlNav     : false,
                        directionNav   : true,
                        prevText       : '<span class="flex-prev-icon"></span>',
                        nextText       : '<span class="flex-next-icon"></span>',
                        asNavFor       : '.woocommerce-product-gallery',
                        direction      : 'vertical',
                        slideshow      : false,
                        animationLoop  : false,
                        itemWidth      : itemW, // add thumb image height
                        itemMargin     : itemSpace, // need it to fix transform item
                        move           : 3,
                        start: function(slider){
                            var asNavFor     = slider.vars.asNavFor,
                                height       = $(asNavFor).height(),
                                height_thumb = $(asNavFor).find('.flex-viewport').height(),
                                window_w = $(window).width();
                            if(window_w > 1024) {
                                slider.css({'max-height' : height_thumb, 'overflow': 'hidden'});
                                slider.find('> .flex-viewport > *').css({'height': height, 'width': ''});
                            }
                        }
                    });
                }
                if($(this).hasClass('thumbnail_h')){
                    $(this).flexslider({
                        selector       : '.wc-gallery-sync-slides > .wc-gallery-sync-slide',
                        animation      : 'slide',
                        controlNav     : false,
                        directionNav   : true,
                        prevText       : '<span class="flex-prev-icon"></span>',
                        nextText       : '<span class="flex-next-icon"></span>',
                        asNavFor       : '.woocommerce-product-gallery',
                        slideshow      : false,
                        animationLoop  : false, // Breaks photoswipe pagination if true.
                        itemWidth      : itemW,
                        itemMargin     : itemSpace,
                        start: function(slider){

                        }
                    });
                };
            });
        }
    }
    /**
     * Cart Page
    */
    function overcome_table_move_column(table, selected ,from, to, remove, colspan, colspan_value) {
        "use strict";
        var rows = jQuery(selected, table);
        var cols;
        rows.each(function() {
            cols = jQuery(this).children('th, td');
            cols.eq(from).detach().insertAfter(cols.eq(to));
        });
        var rows_remove = jQuery(remove, table);
        rows_remove.each(function(){
            jQuery(this).remove(remove);
        });
        var colspan = jQuery(colspan, table);
        colspan.each(function(){
            jQuery(this).attr('colspan',colspan_value);
        });
    }
    function overcome_remove_cart_actions(){
        "use strict";
        /** 
         * jQuery('.actions > .coupon').remove();
         * jQuery('.actions > [name="update_cart"]').remove();
         */
    }

    // Woo Smart Compare 
    function overcome_wooscp_change_text(){
        'use strict';
        $('.wooscp-btn , .woosw-btn').each(function(){
            "use strict";
            var $this = $(this),
                $id = $(this).attr('data-id'),
                selected_title = $(this).parent().attr('data-selected')
                ;
            if($this.hasClass('wooscp-btn-added') || $this.hasClass('woosw-added')){
                $this.parent().attr('data-hint',selected_title);
            }
            
        });
        $( 'body' ).on( 'click touch', '.wooscp-btn, .woosw-btn', function( e ) {
            "use strict";
            var product_id = $( this ).attr( 'data-id' ),
                selected_title = $(this).parent().attr('data-selected');
            if ( $( this ).hasClass( 'wooscp-btn-added' ) || $( this ).hasClass( 'woosw-added' )) {
                $(this).parent().attr('data-hint',selected_title);
            } else {
                $(this).parent().attr('data-hint',selected_title);
            }

            e.preventDefault();
        } );
    }
    /* Masonry */
    function overcome_masonry_filter(){
        "use strict";
        if(typeof $.fn.masonry != 'undefined'){
            if (jQuery(".ef5-posts-masonry").length) {
                var blog_dom = jQuery(".ef5-posts-masonry").get(0),
                    originLeft = jQuery(".ef5-posts-masonry").data('originleft');
                var $grid = imagesLoaded( blog_dom, function() {
                    jQuery(".ef5-posts-masonry").isotope({
                        layoutMode: 'masonry',
                        percentPosition: true,
                        itemSelector: '.ef5-masonry-item',
                        originLeft: originLeft,
                        masonry: {
                            columnWidth: '.ef5-masonry-sizer',
                            gutter: '.ef5-masonry-gutter'
                        }
                    });
                    jQuery(window).trigger('resize');
                }); 
            }
            var $filter = jQuery(".ef5-masonry-filters .filter-item");
            $filter.on("click", function (e){
              e.preventDefault();

              jQuery(this).addClass("active").siblings().removeClass("active");
              var filterValue = jQuery(this).attr('data-filter');  
              jQuery($grid.elements).isotope({ filter: filterValue });
            });
        }
    }
    /* Tabs */
    function overcome_tabs(){
        'use strict';
        $('.ef5-tabs-nav .filter-item').on('click', function (event) {
            event.preventDefault();
            console.log($(this));
            $('.ef5-tab-active').removeClass('ef5-tab-active active');
            $(this).addClass('ef5-tab-active active');
            $('.ef5-tabs-stage .ef5-tab-item').removeClass('go');
            $($(this).attr('data-tab')).addClass('go');
        });
        $('.ef5-tabs-nav .filter-item:first').trigger('click');
    }
    /* VC Animation */
    function overcome_vc_animation_callback(){
        "use strict";
        if(typeof $.fn.waypoint != 'undefined'){
            jQuery(".wpb_animate_when_almost_visible:not(.wpb_start_animation)").waypoint(function() {
                jQuery(this).addClass("wpb_start_animation animated")
            }, {
                offset: "85%"
            })
        }
    }
    function overcome_svg_color(){
        "use strict";
        jQuery('img.ef5-svg').each(function(){
            var $img = jQuery(this);
            var imgID = $img.attr('id');
            var imgClass = $img.attr('class');
            var imgURL = $img.attr('src');
        
            jQuery.get(imgURL, function(data) {
                // Get the SVG tag, ignore the rest
                var $svg = jQuery(data).find('svg');
        
                // Add replaced image's ID to the new SVG
                if(typeof imgID !== 'undefined') {
                    $svg = $svg.attr('id', imgID);
                }
                // Add replaced image's classes to the new SVG
                if(typeof imgClass !== 'undefined') {
                    $svg = $svg.attr('class', imgClass+' replaced-svg');
                }
        
                // Remove any invalid XML tags as per http://validator.w3.org
                $svg = $svg.removeAttr('xmlns:a');
                
                // Check if the viewport is set, else we gonna set it if we can.
                if(!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
                    $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
                }
        
                // Replace image with new SVG
                $img.replaceWith($svg);
        
            }, 'xml');
        
        });
    };
})( jQuery );

(function ($) { "use strict";
    function getDirection(ev, obj) {
        "use strict";
        var w = $(obj).width(),
            h = $(obj).height(),
            x = (ev.pageX - $(obj).offset().left - (w / 2)) * (w > h ? (h / w) : 1),
            y = (ev.pageY - $(obj).offset().top - (h / 2)) * (h > w ? (w / h) : 1),
            d = Math.round( Math.atan2(y, x) / 1.57079633 + 5 ) % 4;
        return d;
    }
    function addClass( ev, obj, state ) {
        "use strict";
        var direction = getDirection( ev, obj ),
        class_suffix = null;
        $(obj).removeAttr('class');
        switch ( direction ) {
            case 0 : class_suffix = '-top';    break;
            case 1 : class_suffix = '-right';  break;
            case 2 : class_suffix = '-bottom'; break;
            case 3 : class_suffix = '-left';   break;
        }
        $(obj).addClass( state + class_suffix );
    }
    $.fn.EF5HoverDir = function () {
        this.each(function () {
            $(this).hover(function(ev){
                addClass( ev, this, 'in' );
            },function(ev){
                addClass( ev, this, 'out' );
            })
        })
    }
    $('.hoverdir-wrap > *').wrap( "<div class='hover-dir'></div>");
    $('.hover-dir').EF5HoverDir();
 })(jQuery);

jQuery(document).ready(function() {
    "use strict";
    overcome_btt_start();
    jQuery(window).scroll(function(e) {
        "use strict";
        overcome_btt_start();
    });
    jQuery('#ef5-btt-circle').on('click', function() {
        "use strict";
        jQuery('html, body').animate({
            scrollTop: 0
        }, 'slow');
    });
});

function overcome_btt_start() {
    "use strict";
    var scrollTop = jQuery(window).scrollTop();
    var docHeight = jQuery(document).height();
    var winHeight = jQuery(window).height();
    var scrollPercent = (scrollTop) / (docHeight - winHeight);
    var scrollPercentRounded = Math.round(scrollPercent * 100);
    
    if (scrollPercentRounded > scrollPercent) {
        if (jQuery('#ef5-btt-btn').hasClass('show')) {} else {
            jQuery('#ef5-btt-btn').addClass('show');
        }
    } else {
        jQuery('#ef5-btt-btn').removeClass('show');
    }
    overcome_btt_btn(scrollPercentRounded);
};

function overcome_btt_btn(i) {
    "use strict";
    var prec = i * 3.6;
    jQuery('#ef5-btt-prec').html(i + '%');
    var borderColor = overcome_ajax_opts.primary_color,
        borderActiveColor = overcome_ajax_opts.accent_color;
    if (prec <= 180) {
        jQuery('#ef5-btt-border').css('background-image', 'linear-gradient(' + (prec + 90) + 'deg, transparent 50%, ' + borderColor + ' 50%),linear-gradient(90deg, ' + borderColor + ' 50%, transparent 50%)');
    } else {
        jQuery('#ef5-btt-border').css('background-image', 'linear-gradient(' + (prec - 90) + 'deg, transparent 50%, ' + borderActiveColor + ' 50%),linear-gradient(90deg, ' + borderColor + ' 50%, transparent 50%)');
    }
};