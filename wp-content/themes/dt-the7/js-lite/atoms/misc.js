
/* #Misc
================================================== */

	$window.trigger("dt.removeLoading");

	var $mainSlideshow = $("#main-slideshow");
	if(!$mainSlideshow.find("> div").length > 0){
		$mainSlideshow.addClass("empty-slider");
	};
	/*!-Revolution slider*/
	if ($(".rev_slider_wrapper").length > 0){
		if( $mainSlideshow.find("> .rev_slider_wrapper")){
			$mainSlideshow.addClass("fix rv-slider");
		};
		if ($(".rev_slider_wrapper").hasClass("fullscreen-container") || $(".rev_slider_wrapper").hasClass("fullwidthbanner-container")){
			$mainSlideshow.removeClass("fix");
		};
	};





	/*!-Search*/
	var $header = $(".masthead, .dt-mobile-header");
	var $searchMicrowidget = $(".popup-search", $header);
	if($searchMicrowidget.length > 0){

		$body.on("click", function(e){
			var target = $(e.target);
			if(!target.is(".field", $searchMicrowidget)) {
				$(".searchform .submit", $header).removeClass("act");
				$searchMicrowidget.removeClass("act");
				//$(".mini-search .field", $header).fadeOut(100);
				$(".popup-search-wrap", $searchMicrowidget).stop().animate({
					"opacity": 0
				}, 150, function() {
					$(this).css("visibility", "hidden");
				});
				setTimeout(function() {
					$(".popup-search-wrap", $searchMicrowidget).removeClass("right-overflow bottom-overflow left-overflow").css({
						right: "",
						left: "",
						'max-width': ""
					});
				}, 400);
			}
		})
		$(".searchform .submit", $header).on("click", function(e){
			e.preventDefault();
			e.stopPropagation();
			var $_this = $(this);
			if($_this.hasClass("act")){
				$_this.removeClass("act");
				$_this.parents(".mini-search").removeClass("act");
				$_this.siblings(".popup-search-wrap").stop().animate({
					"opacity": 0
				}, 150, function() {
					$(this).css("visibility", "hidden");
				});
				setTimeout(function() {
					$_this.siblings(".popup-search-wrap").removeClass("right-overflow bottom-overflow left-overflow").css({
						right: "",
						left: "",
						'max-width': ""
					});
				}, 400);
			}else{
				$_this.addClass("act");
				$_this.parents(".mini-search").addClass("act");
				if($_this.parents(".dt-mobile-header").length > 0) {
					$_this.siblings(".popup-search-wrap").css({
						top: $_this.parents(".mini-search").position().top  - $_this.siblings(".popup-search-wrap").innerHeight()
					});

				}
				if ($_this.parents(".searchform").offset().left - $_this.siblings(".popup-search-wrap").innerWidth() < 0) {
					$_this.siblings(".popup-search-wrap").addClass("left-overflow");
				};
				if ($page.width() - ($_this.parents(".searchform").offset().left - $page.offset().left) - $_this.siblings(".popup-search-wrap").innerWidth() < 0) {
					$_this.siblings(".popup-search-wrap").addClass("right-overflow");
					$_this.siblings(".popup-search-wrap").removeClass("left-overflow");
				}
				if ($page.width() - ($_this.parents(".searchform").offset().left - $page.offset().left) - $_this.siblings(".popup-search-wrap").innerWidth() < 0 && $_this.parents(".searchform").offset().left - $_this.siblings(".popup-search-wrap").innerWidth() < 0) {
					$_this.siblings(".popup-search-wrap").css({
						'max-width': $_this.parents(".searchform").offset().left
					})
				}
				/*Bottom overflow menu*/
				if ($window.height() - ($_this.siblings(".popup-search-wrap").offset().top - dtGlobals.winScrollTop) - $_this.siblings(".popup-search-wrap").innerHeight() < 0) {
					$_this.siblings(".popup-search-wrap").addClass("bottom-overflow");
				};
				$_this.siblings(".popup-search-wrap").stop().css("visibility", "visible").animate({
					"opacity": 1
				}, 150)
				$_this.siblings(".popup-search-wrap").find("input.searchform-s").focus();

			}
		});
	}

	if($(".overlay-search").length > 0){
		var searchHtml = $(".overlay-search .searchform").first(),
			searchHtmlClone = searchHtml.clone();
		$("body").append("<div class='overlay-search-microwidget'><i class='overlay-close icomoon-the7-font-the7-cross-01'></i></div>");

		var overlay = $(".overlay-search-microwidget");
		overlay.append(searchHtmlClone);
		if($(".overlay-search").hasClass('default-icon')){
			overlay.addClass('default-icon');
		}
		$(".mini-search .submit").on("click", function(e){
			e.preventDefault();
			overlay.addClass("open");
			$("#page").addClass("overlay-open");

			overlay.find("input.searchform-s").focus();
		});
		$(".overlay-close", overlay).on("click", function(){
			$("#page").removeClass("overlay-open");
			$(this).parent(overlay).removeClass("open");

		});
	}



	/* #Shortcodes
	================================================== */


	/*!-Before After*/
	$(".twentytwenty-container .preload-me").loaded(null, function() {
		$(".twentytwenty-container").each(function(){
			var $this = $(this),
				$thisOrient = $this.attr("data-orientation").length > 0 ? $this.attr("data-orientation") : 'horizontal',
				$pctOffset = (typeof $this.attr("data-offset") != 'undefined' && $this.attr("data-offset").length > 0) ? $this.attr("data-offset") : 0.5,
				$navigationType = $this.attr("data-navigation") ? true : false;
			$this.twentytwenty({
				default_offset_pct: $pctOffset,
				orientation: $thisOrient,
				navigation_follow: $navigationType
			});
		});
	}, true);

	/*!-Isotope fix for tabs*/
	if($('.wpb_tabs .iso-container').length > 0){
		var tabResizeTimeout;
		$('.wpb_tour_tabs_wrapper').each(function(){
			var $this = $(this),
				isoInside = $this.parents(".wpb_tabs").find(".iso-container");
			$this.tabs( {
				activate: function( event, ui ) {
					isoInside.isotope("layout");
				}
			});
			$this.find("li").each(function(){
				$(this).on("click", function(){
					clearTimeout(tabResizeTimeout);
					$window.trigger( "debouncedresize" );
					$(this).parents(".wpb_tabs").find(".iso-container").isotope("layout");
				});
			});
		});
	}


	/* #Widgets
	================================================== */


	// /*!Instagram style photos*/

	$.fn.calcPics = function() {
			var $collection = $(".instagram-photos");
			if ($collection.length < 1) return false;

			return this.each(function() {
				var maxitemwidth = maxitemwidth ? maxitemwidth : parseInt($(this).attr("data-image-max-width")),
					itemmarg = parseInt($(this).find("> a").css("margin-left"));
				$(this).find(" > a").css({
					"max-width": maxitemwidth,
					"opacity": 1
				});

				// Cahce everything
				var $container = $(this),
					containerwidth = $container.width(),
					itemperc = (100/(Math.ceil(containerwidth/maxitemwidth)));

				$container.find("a").css({ "width": itemperc+'%' });
		});
	};
	$(".instagram-photos").calcPics();

	$('.st-accordion').each(function(){
		var accordion = $(this);
		accordion.find('ul > li > a').on("click", function(e){
			e.preventDefault();
			var $this = $(this),
				$thisNext = $this.next();
			$(".st-content", accordion).not($thisNext).slideUp('fast');
			$thisNext.slideToggle('fast');
		});
	});
	simple_tooltip(".shortcode-tooltip","shortcode-tooltip-content");

	/*!-search widget*/
	$('.widget .searchform .submit, .search-icon, form.searchform:not(.mini-widget-searchform) .submit').on('click', function(e) {
		e.preventDefault();
		$(this).closest('form').find('input.searchsubmit').click();
		return false;
	});

	// !- Skills
	$.fn.animateSkills = function() {
		$(".skill-value", this).each(function () {
			var $this = $(this),
				$this_data = $this.data("width");

			$this.css({
				width: $this_data + '%'
			});
		});
	};

	// !- Animation "onScroll" loop
	function doSkillsAnimation() {

		if(dtGlobals.isMobile){
			$(".skills").animateSkills();
		}
	};
	// !- Fire animation
	doSkillsAnimation();


	/* #Posts
	================================================== */
	var socTimeoutShow,
		socTimeoutHide;

	/*!-Show share buttons*/
	$(".project-share-overlay.allways-visible-icons .share-button").on("click", function(e){
		e.preventDefault();
	});
	//Solve multiple window.onload conflict
	function addOnloadEvent(fnc){
	  if ( typeof window.addEventListener != "undefined" )
		window.addEventListener( "load", fnc, false );
	  else if ( typeof window.attachEvent != "undefined" ) {
		window.attachEvent( "onload", fnc );
	  }
	  else {
		if ( window.onload != null ) {
		  var oldOnload = window.onload;
		  window.onload = function ( e ) {
			oldOnload( e );
			window[fnc]();
		  };
		}
		else
		  window.onload = fnc;
	  }
	}
	function showShareBut() {
		$(".album-share-overlay, .project-share-overlay:not(.allways-visible-icons)").each(function(){
			var $this = $(this);
			$this.find(".share-button").on("click", function(e){
				e.preventDefault();
			});

			$this.on("mouseover tap", function(e) {
				if(e.type == "tap") e.stopPropagation();

				var $this = $(this);
				$this.addClass("dt-hovered");

				clearTimeout(socTimeoutShow);
				clearTimeout(socTimeoutHide);

				socTimeoutShow = setTimeout(function() {
					if($this.hasClass("dt-hovered")){
						$this.find('.soc-ico a').css("display", "inline-block");
						$this.find('.soc-ico').stop().css("visibility", "visible").animate({
							"opacity": 1
						}, 200);
					}
				}, 100);
			});

			$this.on("mouseleave ", function(e) {
				var $this = $(this);
				$this.removeClass("dt-hovered");

				clearTimeout(socTimeoutShow);
				clearTimeout(socTimeoutHide);

				socTimeoutHide = setTimeout(function() {
					if(!$this.hasClass("dt-hovered")){
						$this.find('.soc-ico').stop().animate({
							"opacity": 0
						}, 150, function() {
							$this.find('.soc-ico a').css("display", "none");
							$(this).css("visibility", "hidden");
						});
					}
				}, 50);

			});
		});
	};
	addOnloadEvent(function(){ showShareBut() });

	/*!-Project floating content*/
	var $floatContent = $(".floating-content"),
		projectPost = $(".project-post");
	var $parentHeight,
		$floatContentHeight,
		phantomHeight = 0;

	//var $scrollHeight;

	function setFloatinProjectContent() {
		$(".preload-me").loaded(null, function() {
			var $sidebar = $(".floating-content");
			var $parentHeight = $floatContent.siblings(".project-wide-col").height();
        	var $floatContentHeight = $floatContent.height();
			if ($(".floating-content").length > 0) {
				var offset = $sidebar.offset();
				if($topBar.length > 0 && $(".phantom-sticky").length > 0){
					var topBarH = $topBar.height();
				}else{
					var topBarH = 0;
				}
					//$scrollHeight = $(".project-post").height();
				var $scrollOffset = $(".project-post").offset();
				//var $headerHeight = $phantom.height();
				$window.on("scroll", function () {
					if (window.innerWidth > 1050) {
						if (dtGlobals.winScrollTop + $phantom.height() > offset.top) {
							if (dtGlobals.winScrollTop + $phantom.height() + $floatContentHeight + 40 < $scrollOffset.top + $parentHeight) {
								$sidebar.css(
									'transform', 'translateY(' + (dtGlobals.winScrollTop - offset.top + $phantom.height() + 5 - topBarH) + 'px)'
								);
							} else {
								$sidebar.css(
									'transform', 'translateY(' + ($parentHeight - $floatContentHeight - 40 - topBarH) + 'px)'
								);
							}
						} else {
							$sidebar.css(
								'transform', 'translateY(0px)'
							);
						}
					} else {
						$sidebar
							.css({
								"transform": "translateY(0)",
							});
					}
				})
			}
		}, true);
	}
	setFloatinProjectContent();

	
	/* !Fancy header*/
	var fancyFeaderOverlap = $(".transparent #fancy-header").exists(),
		titleOverlap = $(".transparent .page-title").exists(),
		checkoutOverlap = $(".transparent .checkout-page-title").exists();


	$.fancyFeaderCalc = function() {
		$(".branding .preload-me").loaded(null, function() {
			if (fancyFeaderOverlap) {
				$(".transparent #fancy-header").css({
					"padding-top" : $(".masthead:not(.side-header)").height()
				});
			};
			if (titleOverlap) {
				$(".transparent .page-title").css({
					"padding-top" : $(".masthead:not(.side-header)").height()
				});
				$(".transparent .page-title").css("visibility", "visible");
			};
		}, true);
	};


	/*!-Paginator*/
	var $paginator = $('.paginator[role="navigation"]'),
		$dots = $paginator.find('a.dots');
	$dots.on('click', function() {
		$paginator.find('div:hidden').show().find('a').unwrap();
		$dots.remove();
	});

	// pin it
	$(".share-buttons a.pinit-marklet").click(function(event){
		event.preventDefault();
		$("#pinmarklet").remove();
		var e = document.createElement('script');
		e.setAttribute('type','text/javascript');
		e.setAttribute('charset','UTF-8');
		e.setAttribute('id','pinmarklet');
		e.setAttribute('async','async');
		e.setAttribute('defer','defer');
		e.setAttribute('src','//assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e);
	});

	/*!-Scroll to Top*/
	$window.on("debouncedresize", function() {
		if(window.innerWidth  > dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off") || $body.hasClass("responsive-off")) {
			if($(".masthead:not(.side-header):not(.mixed-header)").length > 0){
				dtGlobals.showTopBtn = $(".masthead:not(.side-header):not(.mixed-header)").height() + 150;
			}else if($(".masthead.side-header-h-stroke").length > 0){
				dtGlobals.showTopBtn = $(".side-header-h-stroke").height() + 150;
			}else{
				dtGlobals.showTopBtn = 500;
			}
		}else{
			dtGlobals.showTopBtn = 500;
		}
	});
	$window.scroll(function () {
		
		if (dtGlobals.winScrollTop > dtGlobals.showTopBtn) {
			$('.scroll-top').removeClass('off').addClass('on');
		}
		else {
			$('.scroll-top').removeClass('on').addClass('off');
		}
	});
	$(".scroll-top").click(function(e) {
		e.preventDefault();
		$("html, body").animate({ scrollTop: 0 }, "slow");
		return false;
	});

	var $dtscrollElement  = $( '.woocommerce-NoticeGroup-updateOrderReview, .woocommerce-NoticeGroup-checkout' );
	if ( ! $dtscrollElement.length && $( 'form.checkout' ).exists() ) {
		$dtscrollElement = $( 'form.checkout' ).parents('.content').offset().top;
	}
	//$.scroll_to_notices( scrollElement );
	$( document.body ).on( 'checkout_error', function() {
	   // jQuery( 'html, body' ).scrollTop($dtscrollElement - 50);
	    $("html, body").animate({ scrollTop: $dtscrollElement - ($headerBar, $phantom).height() }, "slow");
	} );

	/*!-Custom select*/

	// Create the dropdown base
	$("<select aria-label=\"Dropdown menu\"/>").prependTo("#bottom-bar .mini-nav .menu-select");

	// Create default option "Select"
	$("<option />", {
		"selected"  :  "selected",
		"value"     :  "",
		"text"      :  "———"
	}).appendTo(".mini-nav .menu-select select");

	// Populate dropdown with menu items
	$("#bottom-bar .mini-nav").each(function() {
		var elPar = $(this),
			thisSelect = elPar.find("select");
		$("a", elPar).each(function() {
			var el = $(this);
			$("<option />", {
				"value"   : el.attr("href"),
				"text"    : el.text(),
				"data-level": el.attr("data-level")
			}).appendTo(thisSelect);
		});
	});

	$(".mini-nav select").change(function() {
		window.location = $(this).find("option:selected").val();
	});
	$(".mini-nav select option").each(function(){
		var $this = $(this),
			winHref = window.location.href;
		 if($this.attr('value') == winHref){
			$this.attr('selected','selected');
		};
	})
	/*!-Appearance for custom select*/
	$(' #bottom-bar .mini-nav select').each(function(){
		$(this).customSelect();
	});
	$(".menu-select select, .mini-nav .customSelect1, .vc_pie_chart .vc_pie_wrapper").css("visibility", "visible");

	$(".mini-nav option").each(function(){
		var $this	= $(this),
			text	= $this.text(),

			prefix	= "";

		switch ( parseInt($this.attr("data-level"))) {
			case 1:
				prefix = "";
			break;
			case 2:
				prefix = "— ";
			break;
			case 3:
				prefix = "—— ";
			break;
			case 4:
				prefix = "——— ";
			break;
			case 5:
				prefix = "———— ";
			break;
		}
		$this.text(prefix+text);
	});

	/*!-Material click for menu and buttons*/
	var ua = navigator.userAgent,
		event = (ua.match(/iPhone/i)) ? "touchstart" : "click";

	$(".project-navigation a, .mobile-sticky-header-overlay").bind(event, function(e) {});

	

	

	$(function(){
		$.fn.clickMaterialEffect = function() {
			return this.each(function() {
				var ink, d, x, y;
				var $this = $(this),
			        $this_timer = null,
			         $link_timer = null;
				if($this.find(".ink").length === 0){
					$this.prepend("<span class='ink'></span>");
				}
				
				$this.addClass("ripplelink");

				ink = $this.find(".ink");
				ink.removeClass("animate");

				if(!ink.height() && !ink.width()){
					d = Math.max($(this).outerWidth(), $this.outerHeight());
					ink.css({height: d, width: d});
				}
				
				$this.bind( 'mousedown', function( e ) {
					clearTimeout( $this_timer );
					x = e.pageX - $this.offset().left - ink.width()/2;
					y = e.pageY - $this.offset().top - ink.height()/2;

						ink.css({top: y+'px', left: x+'px'}).addClass("animate");

				} );
				$this.bind( 'mouseup mouseleave', function( e ) {
					clearTimeout( $link_timer );
					clearTimeout( $this_timer );
					$this._timer = setTimeout( function() {
						ink.removeClass("animate");
					},400)
				} );
				
			});
		};

		$(".rollover.material-click-effect, .post-rollover.material-click-effect, .rollover-video.material-click-effect").clickMaterialEffect();
	});

	/* #Misc(desctop only)
	================================================== */
	
		
	if(!dtGlobals.isMobile){
			/*!-parallax initialisation*/
		$('.stripe-parallax-bg, .fancy-parallax-bg, .page-title-parallax-bg').each(function(){
			var $_this = $(this),
				speed_prl = $_this.data("prlx-speed");
			$_this.parallax("50%", speed_prl);
			$_this.addClass("parallax-bg-done");
			$_this.css("opacity", "1")
		});
	

		/*!-Animate fancy header elements*/
		var j = -1;
		$("#fancy-header .fancy-title:not(.start-animation), #fancy-header .fancy-subtitle:not(.start-animation), #fancy-header .breadcrumbs:not(.start-animation)").each(function () {
			var $this = $(this);
			var animateTimeout;
			if (!$this.hasClass("start-animation") && !$this.hasClass("start-animation-done")) {
				$this.addClass("start-animation-done");
				j++;
				setTimeout(function () {
					$this.addClass("start-animation");
					
				}, 300 * j);
			};
		});
	};

	jQuery('.wpcf7').each(function(){
		var $this = $(this);
		$this.on('wpcf7submit', function(e) {
			$this.find(".wpcf7-response-output").wrapInner( "<div class='wpcf7-not-valid-tip-text'></div>").addClass('run-animation');
			setTimeout(function() {
				$this.find(".wpcf7-response-output").removeClass('run-animation');
			},12000);
		})
		$this.on('wpcf7invalid', function(e) {
    		setTimeout(function() {
				$this.find(".wpcf7-response-output").wrapInner( "<div class='wpcf7-not-valid-tip-text'></div>")
			},100);
		});
		$this.on('wpcf7mailsent', function(e) {
    		setTimeout(function() {
				$this.find(".wpcf7-response-output").wrapInner( "<div class='wpcf7-valid-tip-text'></div>").addClass('wpcf7-mail-sent-ok')
			},100);
			setTimeout(function() {
				$this.find(".wpcf7-response-output").removeClass('wpcf7-mail-sent-ok');
			},12000);
		});
		$this.on('invalid.wpcf7', function(e) {
    		setTimeout(function() {
				$this.find(".wpcf7-validation-errors").wrapInner( "<div class='wpcf7-not-valid-tip-text'></div>")
			},100);
		});
		$this.on('mailsent.wpcf7', function(e) {
    		setTimeout(function() {
				$this.find(".wpcf7-mail-sent-ok").wrapInner( "<div class='wpcf7-valid-tip-text'></div>")
			},100);
		});
	});




	/* #sidebar sticky
	================================================== */
	if($(".dt-sticky-sidebar").length > 0 ){
		if (headerDocked) {
			var $headerBar = $(".sticky-on");
		}else{
			var $headerBar = $(".masthead:not(.side-header):not(.side-header-v-stroke) .header-bar");
		}
		if ($topBar.exists() && !$topBar.is( ":hidden" ) && !$topBar.hasClass( "top-bar-empty" )  && !$topBar.hasClass( "hide-top-bar" ) ) {
			topBarH = $topBar.innerHeight();
		}else {
			topBarH = 0;
		};
		if( phantomFadeExists || phantomSlideExists) {
			var headerHeight = $($phantom).height() + 20;
		}else if(dtLocal.themeSettings.floatingHeader.showMenu && phantomStickyExists) {
			if($body.hasClass("floating-top-bar")){
				var headerHeight = dtLocal.themeSettings.floatingHeader.height + topBarH + 20;
			}else{
				var headerHeight = dtLocal.themeSettings.floatingHeader.height + 20;
			}
		}else if(stickyTopLine.exists()){
			var headerHeight = stickyTopLine.find('.header-bar').height() + topBarH + 20
		}else{
			var headerHeight = 0;
		}
		

		var stickySidebar = new StickySidebar('#sidebar', {
			topSpacing: headerHeight,
			bottomSpacing: 20,
			viewportTop: 0,
			containerSelector: '.wf-container-main',
			innerWrapperSelector: '.sidebar-content',
			minWidth: dtLocal.themeSettings.sidebar.switchPoint
		});

		
	}




	/*Booking plugin*/
	
	$('#mphb-booking-details').find('.mphb-booking-details-title, .mphb-check-in-date, .mphb-check-out-date').wrapAll('<div class="mphb-details-sidebar"></div>');
	$('#mphb-price-details').appendTo('.mphb-details-sidebar');
	/* #Footer
	================================================== */


	/*Adding class if footer is empty*/
	if(!$(".footer .widget").length > 0) {
		$(".footer").addClass("empty-footer");
	}
