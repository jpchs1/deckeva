
/* #One-page
================================================== */

	var $moveBody = $("html, body");
	var phantomStickyExists = $(".phantom-sticky").exists(),
		sideHeaderHStrokeExists = $(".sticky-top-line").exists(),
		stickyMobileHeader = $(".sticky-mobile-header").exists(),
		floatMenuH = 0;
	var floatingHeaderExists = phantomStickyExists || sideHeaderHStrokeExists;

	/*Detect floating header*/
	if(floatingHeaderExists){
		var $phantom = $(".masthead"),
			$phantomVisibility = 1;
	}else{
		var $phantom = $("#phantom"),
			$phantomVisibility = $phantom.css("display")=="block";
	}


	// One page scrolling effect
	
	if ($(".mobile-header-bar").length > 0 && $(".mobile-header-bar").css('display') != 'none') {
		var $headerBar = $(".mobile-header-bar");
		if($(".sticky-top-line").exists()){
			var $headerBar = $(".sticky-top-line.masthead-mobile-header .mobile-header-bar");
		}
		if($(".phantom-sticky").length > 0 || $(".sticky-top-line").exists()){
			if($(".sticky-header .masthead.side-header").length > 0 || $(".overlay-navigation .masthead.side-header").length > 0){
				var $phantom = $(".mobile-header-bar").parent(".masthead:not(.side-header)");
			}else{
				var $phantom = $(".mobile-header-bar").parent();
			}
		}
	}else{
		if($body.hasClass("floating-top-bar")){

			var $headerBar = $(".masthead:not(.side-header):not(.side-header-v-stroke)");
		}else{
			var $headerBar = $(".masthead:not(.side-header):not(.side-header-v-stroke) .header-bar");
		}
	}

	/*Floating header height*/
	function set_sticky_header_height() {
		if(window.innerWidth < dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")){
			if(stickyMobileHeader){
				floatMenuH = $phantom.height();
			}else{
				floatMenuH = 0;
			}
		}else{
			if($phantom.css("display")=="block" || $phantom.css("display")=="-ms-flexbox" || phantomStickyExists){		
				floatMenuH = $phantom.height();
			}else if(sideHeaderHStrokeExists){
				floatMenuH = $(".sticky-top-line").height();
			}else{
				floatMenuH = 0;
			}
		}
	}
	set_sticky_header_height();

	/**
	 * Set current menu item and scroll to top/element on load.
	 */
	addOnloadEvent(function () {
		var locHash = window.location.hash;
		var urlHash = "";

		if (locHash.match("^#!")) {
			urlHash = locHash.substring(3);
		}

		setTimeout(function () {
			if (!urlHash) {
				// Set menu item, assotiated with the top position, active?
				if ($(".menu-item > a[href='#!/up']").length > 0) {
					$(".menu-item > a[href='#!/up']").parent("li").addClass("act");
				}

				return;
			}

			// Set menu item active if it is related to urlHash.
			$(".menu-item a").parent("li").removeClass("act");
			$(".menu-item a[href='" + locHash + "']").parent("li").addClass("act");
			$(".menu-item a[href*='" + locHash + "']").parent("li").addClass("act");

			// Scroll to top.
			if (urlHash === "up") {
				$.closeMobileHeader();
				$moveBody.stop().animate({scrollTop: 0}, 600, "swing", function () {
					$.closeSideHeader();
				});

				return;
			}

			// Scroll to the element.
			setTimeout(function () {
				var $targetContainer = $("#" + urlHash);

				var scrollToPosition = function (position) {
					$moveBody.stop().animate({scrollTop: position}, 650, "swing");
				};

				var getContainerOffsetOnMobile = function () {
					return $targetContainer.offset().top - $(".masthead-mobile-header .mobile-header-bar").height();
				};

				var getContainerOffsetOnDesktop = function () {
					var offset = $targetContainer.offset().top - $($headerBar, $phantom).height();

					if (floatingHeaderExists && $phantom.css("border-bottom-style") === "solid") {
						offset += 1;
					}

					return offset;
				};

				var addSomeSeriesScrollingAfterAnimation = function (curVal, computeNewVal) {
					$targetContainer.one("animationend", function () {
						var newVal = computeNewVal();
						if (newVal !== curVal) {
							scrollToPosition(newVal);
						}
					})
				};

				$moveBody
					.stop()
					.animate(
						{
							scrollTop: $targetContainer.offset().top - floatMenuH
						},
						600,
						"swing",
						function () {
							var curDesktopOffset = getContainerOffsetOnDesktop();
							var curMobileOffset = getContainerOffsetOnMobile();

							if (window.innerWidth < dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")) {
								if (stickyMobileHeader) {
									if (mobileHeaderDocked) {
										scrollToPosition(curMobileOffset);
										addSomeSeriesScrollingAfterAnimation(curMobileOffset, getContainerOffsetOnMobile);
									} else {
										scrollToPosition(curDesktopOffset);
										addSomeSeriesScrollingAfterAnimation(curDesktopOffset, getContainerOffsetOnDesktop);
									}
								}
							} else if (floatingHeaderExists) {
								scrollToPosition(curDesktopOffset);
								addSomeSeriesScrollingAfterAnimation(curDesktopOffset, getContainerOffsetOnDesktop);
							}
						}
					);
			}, 300);
		}, 300);
	});

	jQuery( window ).on('resize', function() {
		set_sticky_header_height();
	});

	
	var $menus = $( '.menu-item > a[href*="#!"]' );


	/*!-scroll to anchor*/
	window.clickAnchorLink = function( $a, e ) {
		var url = $a.attr( 'href' ),
			hash = url,
			$target = url.substring(3),
			base_speed  = 600,
			speed       = base_speed;
		if(url.match("^#!")){
			var $target = url.substring(3);
		}else{
			var $target = (url.substring(url.indexOf('#'))).substring(3);
		}
		set_sticky_header_height();

		if ( typeof $target != 'undefined' && $target && $target.length > 0 ) {
			location.hash = url;
			if($("#" + $target).length > 0) {
				var top = $("#" + $target).offset().top + 1,
					this_offset = $a.offset(),
					that_offset = $("#" + $target).offset(),
					offset_diff = Math.abs(that_offset.top - this_offset.top),
					speed = 150 * Math.log(offset_diff^2/1000 + 1.02);
					$newScrollPosition = top - floatMenuH;
			};
			if($target == "up") {
				if($body.hasClass("overlay-navigation")){
					$.closeMobileHeader();
					$.closeSideHeader();
					$moveBody.stop().animate({
						scrollTop: top - floatMenuH
					}, speed, 'swing');
				}else{
					$.closeMobileHeader();
					$moveBody.stop().animate({
						scrollTop: 0
					}, speed, 'swing',
					function() { $.closeSideHeader(); }
					);
				}
			}else {
				if($body.hasClass("overlay-navigation")){
					$.closeMobileHeader();
					$.closeSideHeader();
					$moveBody.stop().animate({
						scrollTop: top - floatMenuH
					}, speed, 'swing',
						function() { 
							if(window.innerWidth < dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")){
								if(stickyMobileHeader){
									if(mobileHeaderDocked){
										$newScrollPosition = ( top - $(".masthead-mobile-header .mobile-header-bar").height() )
									}else{
										$newScrollPosition = ( top - $($headerBar, $phantom).height() );
									}

									$moveBody.stop().animate({
										scrollTop: $newScrollPosition
									}, 650, 'swing');

								}
							}else{
								if(sideHeaderHStrokeExists){
									$newScrollPosition = ( top - $(".sticky-top-line").height() )

									$moveBody.stop().animate({
										scrollTop: $newScrollPosition
									}, 650, 'swing');
								
								}
							}
						
					});
				}else{
					$.closeMobileHeader();
					$moveBody.stop().animate({
						scrollTop: top - floatMenuH
					}, speed, 'swing',
						function() { 

							$.closeSideHeader();

							if(window.innerWidth < dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")){
								if(stickyMobileHeader){
									if(mobileHeaderDocked){
										$newScrollPosition = ( top - $(".masthead-mobile-header .mobile-header-bar").height() )
									}else if(topLineDocked){
										$newScrollPosition = ( top - $(".sticky-top-line").height() )
									}else{
										$newScrollPosition = ( top - $($headerBar, $phantom).height() );
									}

									$moveBody.stop().animate({
										scrollTop: $newScrollPosition
									}, 650, 'swing');
								}
							}else{
								if(phantomStickyExists || sideHeaderHStrokeExists){
									if(headerDocked){
										if($body.hasClass("floating-top-bar")){
											var $newScrollPosition = ( top - $(".masthead").height() );
										}else{
											$newScrollPosition = ( top - $(".header-bar").height() );
										}
									}else{
										if($('.masthead').hasClass("mixed-floating-top-bar")){
											$newScrollPosition = ( top - $(".sticky-top-line").height() )
										}else{
											$newScrollPosition = ( top - $(".sticky-top-line .header-bar").height() );
										}
									}


									$moveBody.stop().animate({
										scrollTop: $newScrollPosition
									}, 650, 'swing');
								
								}
							}

						
						//}
					});
				}
			};

			$('.menu-item a').parent("li").removeClass('act');
			$a.parent("li").addClass('act');
		};

	};

	$body.on( 'click', '.anchor-link[href^="#!"], .anchor-link a[href^="#!"], .logo-box a[href^="#!"], .branding a[href^="#!"], #branding-bottom a[href^="#!"], .mobile-branding a[href^="#!"]', function( e ) {
		clickAnchorLink( $( this ), e );
		e.preventDefault();
		return false;
	});

	$menus.on( 'click', function( e ) {
		if(!$(e.target).parent().hasClass('next-level-button')) {
			clickAnchorLink( $( this ), e );
			if($(this).attr('href').match("^#!")){
				e.preventDefault();
				return false;
			}
		}
	});
	/*!-set active menu item on scroll*/
	//if(($('.one-page-row div[data-anchor^="#"]').length > 0 || $('.vc_row[id]').length > 0 || $('.vc_section[id]').length > 0 || $('.elementor-top-section[id]').length > 0) && $(".one-page-row").length > 0){
		$window.scroll(function (e) {
			var currentNode = null;
			if(!$body.hasClass("is-scroll")){
				var currentNode;
				//for vc row id
				
				if(isMoved && $($phantom).css("border-bottom-style")=='solid'){
					var headerHeight = $($phantom).height() + 1;
				}else if(isMoved){
					var headerHeight = $($phantom).height();
				}else{
					var headerHeight = $($headerBar).height();
				}

				 $('.one-page-row .vc_row[id], .elementor-top-section[id], .one-page-row .vc_section[id], .one-page-row div[data-anchor^="#"]').each(function(){
                    var $_this = $(this),
                        activeSection = $_this,
                        currentId = $_this.attr('id');
                    if($_this.hasClass('wpb_animate_when_almost_visible')){
	                    $_this.one('webkitAnimationEnd oanimationend msAnimationEnd animationend',   
	    function(e) {
		                    if($_this.is(":visible") && dtGlobals.winScrollTop >= Math.floor($_this.offset().top - headerHeight)){
		                        currentNode = "#!/" + currentId;
		                    };

		                	$('.menu-item a[href^="#!"]').parent("li").removeClass('act');
		                	$('.menu-item a[href="'+currentNode+'"]').parent("li").addClass('act');
						})
					}
						if($_this.is(":visible") && dtGlobals.winScrollTop >= Math.floor($_this.offset().top - headerHeight)){
	                        currentNode = "#!/" + currentId;
	                   

					}
                });

        		$('.menu-item a[href^="#!"]').parent("li").removeClass('act');
        		$('.menu-item a[href="'+currentNode+'"]').parent("li").addClass('act');

                if($(".one-page-row div[data-anchor^='#']").length > 0){

                    if(dtGlobals.winScrollTop < ($(".one-page-row div[data-anchor^='#']").first().offset().top - headerHeight)&& $( '.menu-item > a[href="#!/up"]' ).length > 0) {
                        $( '.menu-item > a[href="#!/up"]' ).parent("li").addClass("act");
                    }

                }else if( $('.vc_row[id]').length > 0 || $('.vc_section[id]').length > 0 || $('.elementor-top-section[id]').length > 0){
                    //for vc row id
                   if( $('.one-page-row .vc_row[id], .one-page-row .vc_section[id], .elementor-top-section[id]').length > 0 ){
	                    var vcAnchor = $('.one-page-row .vc_row[id], .one-page-row .vc_section[id], .elementor-top-section[id]')
	                    if(dtGlobals.winScrollTop < (vcAnchor.first().offset().top - headerHeight)&& $( '.menu-item > a[href="#!/up"]' ).length > 0) {
	                        $( '.menu-item > a[href="#!/up"]' ).parent("li").addClass("act");
	                    };
	                }
                }
            };
		});
	//};