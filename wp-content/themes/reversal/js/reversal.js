jQuery('html').removeClass('no-js').addClass('js');

jQuery(document).ready(function($) {
	
	function closeMap() {
		
		if( jQuery( '#show-map' ).hasClass( 'map-current' ) ) 
			jQuery( '#show-map' ).click();
		
	}
	
    /*
    function resetHash() {
        window.location.hash = '';
    }

    resetHash();
    */

    function isAppleMobile() {
        if (navigator && navigator.userAgent && navigator.userAgent != null) {
            var strUserAgent = navigator.userAgent.toLowerCase();
            var arrMatches = strUserAgent.match(/(iphone|ipod|ipad)/);
            if (arrMatches) 
                 return true;
        } 

        return false;
    } 

    var isAppleMobile = isAppleMobile(),
        wWidth = $(window).width(),
        mobileRes = 767;

    function stopEvent(event){
        event.preventDefault();
        event.stopPropagation();
        if ($.browser.msie) {
            event.originalEvent.keyCode = 0;
            event.originalEvent.cancelBubble = true;
            event.originalEvent.returnValue = false;
        }
    }

    /* ==============================================
    Section Position
    =============================================== */
    function setSections() {
        var sections = $("section"),
            wWidth = $(window).width(),
            wCounter = 0;
        
        if(wWidth > mobileRes) {  

            $.each(sections, function(eq) {
                if(eq > 0) {
                    $(this).css({'left': wCounter});
                }
                wCounter = wCounter + $(this).width();            
            }); 

        } else {
            $.each(sections, function(eq) {
                $(this).css({'left': 0});          
            }); 
        }     
    }

    function forcePosition() {
        var hash = window.location.hash,
            $panels = $('section'),
            scrollElement = 'html, body',
            $mainNav = $('#main-nav ul li a'),
            found = false;
        $panels.each(function(eq) {
            var panelId = $(this).attr('id');
            if( '#' + panelId == hash ) {
                found = true;
                var wWidth = $(window).width();

                $(scrollElement).stop().animate({
                    scrollLeft: wWidth * eq
                }, 300, 'easeOutCubic');

                var linkToSetActive = $($mainNav[eq]);
                if(linkToSetActive.hasClass('active') == false) {
                    //$($mainNav).removeClass('current');
                    //$($mainNav[eq]).addClass('current');
                    //console.log($mainNav);
                }
            }
        });

        if(!found) {
            var scroll = $(window).scrollLeft();
            if(scroll != 0) {
               $(scrollElement).stop().animate({
                    scrollLeft: 0
                }, 300, 'easeOutCubic');
            }          
        }
    }

    function resetWindowWidth() {
        wWidth = $(window).width();
    }

    $(window).resize(function() {
        setSections();
        forcePosition();
        resetWindowWidth();
    });

    setSections();

    $(window).on('hashchange', forcePosition);

    /* ==============================================
    Navigation
    =============================================== */
    var noIntro = $('body').hasClass('no-intro');

    function setNavigation() {
        var nav = $('nav#main-nav'),
            wWidth = $(window).width();
            
        if( !noIntro ) {
            if(wWidth > mobileRes) {
                nav.css({'left': wWidth });
            }
        }
        
    }

    setNavigation();

    function adjustNavigation() {
        var nav = $('nav#main-nav'),
            scroll = $(window).scrollLeft(),
            wWidth = $(window).width();

        if( !noIntro ) {
            if(wWidth > mobileRes) {
               if(scroll >= wWidth) {
                    nav.css({
                        'left': 0
                    });
                } else {
                    nav.css({
                        'left': wWidth - scroll
                    });
                } 
            } else {
                nav.css({
                    'left': 0
                });
            }     
        }
        
    }

    $(window).scroll(function() {
        adjustNavigation();
    });

    $(window).resize(function() {
        adjustNavigation();
    });

    /* ==============================================
    Mobile Navigation
    =============================================== */

    $(function() {  
        var trigger = $('#responsive-nav');  
            menu = $('#main-nav ul');
      
        $(trigger).on('click', function(event) {  
            stopEvent(event);
            menu.slideToggle();
            $(this).toggleClass('nav-visible');
        }); 

        $(window).resize(function(){  
            var windowW = $(window).width();  
            if(windowW > mobileRes && menu.is(':hidden')) {  
                menu.removeAttr('style');
            }  
        }); 
    });  

    /* ==============================================
    Smooth Scrolling
    =============================================== */
    var scrollElement = 'html, body',
        $scrollElement,
        isMoving = false;

    $(function() {

        $('html, body').each(function () {
            if(wWidth > mobileRes) {
                var initScrollLeft = $(this).attr('scrollLeft');
            
                $(this).attr('scrollLeft', initScrollLeft + 1);
                if ($(this).attr('scrollLeft') == initScrollLeft + 1) {
                    scrollElement = this.nodeName.toLowerCase();
                    $(this).attr('scrollLeft', initScrollLeft);
                    return false;
                }
            }
                
        });
        $scrollElement = $(scrollElement);
    });

    $(function() {
        var $sections = $('section.section');  

        $sections.each(function() {
            var $section = $(this);
            var hash = '#' + this.id;

            $('a[href="' + "http://" + window.location.host + window.location.pathname + hash + '"]').on('click touchstart', function(event) {
				closeMap();
                stopEvent(event);
                isMoving = true;
                if(wWidth > mobileRes) {  
                    $scrollElement.stop().animate({
                        scrollLeft: $section.offset().left
                    }, 600, 'easeOutCubic', function() {
                        window.location.hash = hash;
                        isMoving = false;
                    });      
                } else {
                    $scrollElement.stop().animate({
                        scrollTop: $section.offset().top
                    }, 600, 'easeOutCubic', function() {
                        isMoving = false;
                    });
                }
                $('nav#main-nav a').removeClass('active');
                if($(this).hasClass('content-menu-link')) {
                    var link = $(this).attr('href');
                    $('a[href="' + "http://" + window.location.host + window.location.pathname + hash + '"]').addClass('active');
                } else {
                    $(this).addClass('active');
                }

                var trigger = $('#responsive-nav'),
                    menu = $('#main-nav ul'); 

                if(trigger.hasClass('nav-visible')) {
                    menu.slideToggle();
                    trigger.toggleClass('nav-visible');
                }
                
            });
        });

    });

    function setInitActiveMenu() {
        var hash = window.location.hash;
        $('a[href="' + "http://" + window.location.host + window.location.pathname + hash + '"]').addClass('active');
    }

    setInitActiveMenu();

    /* ==============================================
    Mobile Menu
    =============================================== */
    if ($('.mobile-nav').length && $('.mobile-nav').attr('data-autogenerate') == 'true') {
        var mobileMenu = $('.mobile-nav');
        $('ul.nav li a').each(function(index, elem) {
            mobileMenu.append($('<option></option>').val($(elem).attr('href')).html($(elem).html()));
        });
    }

    $('.mobile-nav').on('change', function() {
        link = $(this).val();
        if (!link) {
            return;
        }
		
		closeMap();

        if (link.substring(0,1) == '#') {
            $('html, body').animate({scrollTop: $(link).offset().top - 74}, 750);
        } else {
            document.location.href = link;
        }
    });

    /* ==============================================
    Fancybox
    =============================================== */
    function bindFancybox() {
        $("a.fancybox").fancybox({
            'overlayShow'   : false,
            'transitionIn'  : 'elastic',
            'transitionOut' : 'elastic'
        });
    }

    bindFancybox();

    /* ==============================================
    Input Placeholder for IE
    =============================================== */

    if(!Modernizr.input.placeholder){

        $('[placeholder]').focus(function() {
            var input = $(this);
            if (input.val() == input.attr('placeholder')) {
                input.val('');
                input.removeClass('placeholder');
            }
        }).blur(function() {
            var input = $(this);
            if (input.val() == '' || input.val() == input.attr('placeholder')) {
                input.addClass('placeholder');
                input.val(input.attr('placeholder'));
            }
        }).blur();
        $('[placeholder]').parents('form').submit(function() {
            $(this).find('[placeholder]').each(function() {
                var input = $(this);
                if (input.val() == input.attr('placeholder')) {
                    input.val('');
                }
            });
        });

    }

    /* ==============================================
    Portfolio
    =============================================== */
    $(window).load(function(){

        var $container = $('.portfolio-container');
        $container.each( function() {

            var $this = $( this ),
                id = $this.closest( '.section' ).attr( 'id' );

            $this.isotope({
                filter: '*',
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false
                }
            });

        });

        $('nav.portfolio-filter ul a').click(function(){
            var selector = $(this).attr('data-filter');
            $( this ).closest( '.section' ).find( '.portfolio-container' ).isotope({
                filter: selector,
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false
                }
            });
          return false;
        });

        var $optionSets = $('nav.portfolio-filter ul'),
            $optionLinks = $optionSets.find('a');
         
        $optionLinks.click(function(){
            var $this = $(this);
            if ( $this.hasClass('selected') ) {
                return false;
            }
            var $optionSet = $this.parents('nav.portfolio-filter ul');
            $optionSet.find('.selected').removeClass('selected');
            $this.addClass('selected'); 
        });

        $(window).resize(function () {
            $container.isotope('destroy');
            $('.portfolio-item').css({
                'opacity': 1,
                '-webkit-transform': ''
            });
            $optionSets.find('.selected').trigger('click');
        });

        var $portfolioContainer = $('.portfolio > .container'),
            $portfolioSingle = $('.single-portfolio'),
            portfolioSingleH = 0;
            portfolioActive = false;

        function loadPortfolio(toLoad, element) {

            var $this = $( element );

            $portfolioContainer = $this.closest( 'section' ).children( '.container' );

            $portfolioSingle =  $portfolioContainer.closest( '.section' ).find('#' + toLoad),
            portfolioSingleH = $portfolioSingle.outerHeight(true);

            console.log( $portfolioContainer );
            console.log( $portfolioSingle );

            console.log( $this );

            checkVideo(false);

            $portfolioSingle.slideDown();

            if(wWidth > mobileRes) {
                $('.portfolio').animate({ scrollTop: 0 }, "slow");
                $portfolioContainer.stop().animate({
                    'marginTop': portfolioSingleH
                });
            } else {
                var portfolioPos = $('.portfolio').offset().top;
                $scrollElement.animate({ scrollTop: portfolioPos}, "slow");
                $portfolioContainer.stop().animate({
                    'marginTop': portfolioSingleH
                });
            }
                   
            portfolioActive = true;

            bindClosePortfolio();
            bindFancybox();
            setupFlexslider();         

        }

        function checkVideo(removeSource) {
            var isVideo = ($portfolioSingle.find('.video-container').length > 0) ? true : false;
            if(isVideo) {
                var videoIframe = $portfolioSingle.find('iframe'),
                    videoSource = videoIframe.attr('src');
                if(removeSource) {
                    videoIframe.attr('src', '');
                } else {
                    if(videoSource == '') {
                        var setupSource = videoIframe.data('source');
                        videoIframe.attr('src', setupSource);
                    } else {
                        videoIframe.data('source', videoSource);
                    }
                }     
            }
        }

        function changePortfolio(toLoad, element) {
            checkVideo(true);
            $portfolioSingle.slideUp();
            loadPortfolio(toLoad, element);
        }

        function bindClosePortfolio() {
            $portfolioSingle.find('.portfolio-close').bind('click touchstart', function() {

                checkVideo(true);
                closePortfolio(false);
                    
            });
			
			$('#nav a').bind('click touchstart', function() {

                checkVideo(true);
                closePortfolio(false);
                    
            });
        }

        function closePortfolio(reopen, toLoad, element) {
            if(reopen) {
                   changePortfolio(toLoad, element) 
            } else {
                $portfolioSingle.slideUp(500, function() {
                    portfolioActive = false;
                });
                $portfolioContainer.stop().animate({
                    'marginTop': 0
                });
                portfolioSingleH = 0;
            }
            
        }

        $(".portfolio-container .portfolio-item a").on('click tap', function(event) {
			
            stopEvent(event);

            var toLoad = $(this).data('portfolio');

            if(portfolioActive) {
                closePortfolio(true, toLoad, this);
            } else {
                loadPortfolio(toLoad, this);
            }
            
        });

        $(window).resize(function () {
            if(portfolioSingleH != 0) {
                portfolioSingleH = $portfolioSingle.outerHeight(true);
            }

            $portfolioContainer.css({
                'marginTop': portfolioSingleH
            });



        });

        /* ==============================================
        Flexslider
        =============================================== */

        function setupFlexslider() {

            $('.flexslider').flexslider({
                pauseOnHover: true,
                directionNav: true,
                controlNav: false
            });

        }

        setupFlexslider();

        /* ==============================================
        Google Maps
        =============================================== */

        var $mapTrigger = $('#show-map'),
            $map = $('#google-map'),
            $contactForm = $('.contact-form'),
            mapActiveClass = 'map-current',
            mapFadeTime = 500,
            $contactsContainer = $map.parent();

        $mapTrigger.on('click', function(event) {

            event.preventDefault();
            var $this = $(this);
            if($this.hasClass(mapActiveClass)) {
                hideMap();      
            } else {
                showMap();               
            }
            
        });

        function hideMap() {
            $contactForm.fadeIn(mapFadeTime);
            $mapTrigger.removeClass(mapActiveClass);
			
			$map.css({ 'visibility' : 'hidden' }).animate({opacity:0},mapFadeTime, function() { $map.hide( 0 ); });
			
        }

        function showMap() {
            $map.show( 0 );
            $contactForm.fadeOut(mapFadeTime, function() {
                var cHeight = jQuery( '.section' ).height(),
                    cWidth  = jQuery( '.section' ).width();
					
					$map.css({ 'height' : cHeight,'width' : cWidth - 5,'visibility' : 'visible' }).animate({opacity:1},mapFadeTime);

                $mapTrigger.addClass(mapActiveClass);
                google.maps.event.trigger( window.gmap, 'resize' );
            }); 
        }
		
		$(window).resize(function () {
		
             var cHeight = jQuery( '.section' ).height(),
                 cWidth  = jQuery( '.section' ).width();
                   
				$map.css({ 'height' : cHeight }).css({ 'width' : cWidth - 5 }); 

        });   
		
		

    });

    /* ==============================================
    FitVids
    =============================================== */
    $(".post-media").fitVids();

    /* ==============================================
    Touch
    =============================================== */    
    function swipeHandler(direction) {

        if(!isMoving) {

            var hash = window.location.hash,
                $panels = $('section'),
                $mainNav = $('#main-nav ul li'),
                eqNext;

            if(direction == 'left') {
                eqNext = 1;
            } else if(direction == 'right') {
                eqNext = 0;
            }

            if(hash) {
                $panels.each(function(eq) {
                    var panelId = $(this).attr('id');

                    if( '#' + panelId == hash ) {
                        
                        if(direction == 'left') {
                            eqNext = eq+1;
                        } else if(direction == 'right') {
                            eqNext = eq-1;
                        }
                       
                    }
                });

            }

            var linkToTrigger = $($mainNav[eqNext]).find('a'),
                newHash = linkToTrigger.attr('href');

            if( /#/i.test(newHash) || hash == '') {
                $($mainNav[eqNext]).find('a').trigger('click');
            }   

        }
    }
	
	var startX,startY;
	
	if ($.pixelentity.browser.mobile) {
		
		$("body").bind('touchstart', function (e){
			startX = e.originalEvent.touches[0].clientX;
			startY = e.originalEvent.touches[0].clientY;
		});
		
		$("body").bind('touchmove', function (e){
			var currentX = e.originalEvent.touches[0].clientX;
			var currentY = e.originalEvent.touches[0].clientY;
			if (Math.abs(startX-currentX) > Math.abs(startY-currentY)){
				e.preventDefault();
			}
		});
		
	}
	
	/*
    if(isAppleMobile) {
       $('body').swipe( {
            swipeLeft:function() {
                swipeHandler('left');
            },
            swipeRight:function() {
                swipeHandler('right');
            },
            threshold: 50,
            excludedElements: ""
        }); 
    }
	*/
    
});