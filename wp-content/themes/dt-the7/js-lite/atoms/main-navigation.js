
/* #Main menu
================================================== */
	/* We need to fine-tune timings and do something about the usage of jQuery "animate" function */

	//Menu decoration Underline > Left to right

	$(".l-to-r-line > li:not(.menu-item-language) > a > span:last-child").not(".l-to-r-line > li > a > span.mega-icon").append("<i class='underline'></i>");

	
	$(".not-clickable-item").on("click", function(e){
		e.preventDefault();
		e.stopPropagation();
	});

	//Menu decoration Background / outline / line > Hover/Active line
	if($(".active-line-decoration").length > 0 || $(".hover-line-decoration").length > 0){
		$(".main-nav > .menu-item > a").append("<span class='decoration-line'></span>");
	};

	//declare vars
	var $mainNav = $(".main-nav, .mini-nav, .mini-wpml .wpml-ls-item-legacy-dropdown"),
		$mainMenu = $(".masthead:not(.sub-downwards) .main-nav, .mini-nav, .mini-wpml .wpml-ls-item-legacy-dropdown"),
		$mainNavMob = $(".main-nav"),
		$sideHeader = $(".side-header");

	/*Wpml menu item*/
	$(".menu-item-language").each(function(){
		var $this = $(this);
		if($this.children('.submenu-languages').length > 0){
			$this.addClass("has-children");
		}
	});

	var	$mobileNav = $mainNavMob.clone();
	var	$mobileTopNav = $(".mini-nav").clone();
	

	$(".mini-nav select").change(function() {
		window.location.href = $(this).val();
	});

	dtGlobals.isHovering = false;
	$(".main-nav li", $sideHeader).each(function(){
		var $this = $(this);
		if($this.hasClass("new-column")){
			var $thisPrev = $this.prev().find(" > .sub-nav");
			$(" > .sub-nav > *", $this).appendTo($thisPrev)
		}
	})
	$(".sub-downwards .main-nav > li").each(function(){
		var $this = $(this),
			$this_sub = $this.find(" > .dt-mega-menu-wrap > .sub-nav");
			$this_sub.unwrap();
	});

	/*Top bar select type menu menu*/
	var droupdownCustomMenu = $(".select-type-menu, .select-type-menu-first-switch, .select-type-menu-second-switch, .mini-wpml .wpml-ls-item-legacy-dropdown");
	var subMenuClassList = "mini-sub-nav";
	droupdownCustomMenu.find("> ul").addClass(subMenuClassList );
	$(".mini-wpml .wpml-ls-item-legacy-dropdown").find("> ul").addClass(subMenuClassList );
	/*Sub menu*/
	$mainMenu.each(function() {
		var $this = $(this);
		$(".act", $this).parents("li").addClass("act");
		$(" li.has-children ", $this).each(function() {
			var $this = $(this);
			var $thisHover = $this.find("> a");

			if($this.parent().hasClass("main-nav") && !$this.parents().hasClass("side-header") && $(".masthead").hasClass('show-sub-menu-on-hover')){
				var $thisHover = $this.find("> a");
			}else if($this.parent().hasClass("main-nav") && $this.parents().hasClass("side-header") && $(".masthead").hasClass('show-sub-menu-on-hover')){
				var $thisHover = $this;
			}else if(($this.parent().hasClass("sub-nav") || $this.parents().hasClass("mini-nav")) && $(".masthead").hasClass('show-sub-menu-on-hover')){
				var $thisHover = $this;
			};

			if(dtGlobals.isMobile || dtGlobals.isWindowsPhone){
				$this.find("> a").on("click", function(e) {
					if (!$(this).hasClass("dt-clicked")) {
						e.preventDefault();
						$mainNav.find(".dt-clicked").removeClass("dt-clicked");
						$(this).addClass("dt-clicked");
					} else {
						e.stopPropagation();
					}
				});
			};
			var menuTimeoutShow,
				menuTimeoutHide;

			//set width for sidebar within mega menu
			if($mainNav.parents().hasClass('full-width') && $this.hasClass("mega-full-width")){
				if($mainNav.parents(".header-bar").length > 0){
					var $_this_par_w = $mainNav.parents(".header-bar").innerWidth();
				}else{
					var $_this_par_w = $mainNav.parents(".ph-wrap").innerWidth();
					
				}
				if(!$sideHeader.length > 0){
					$this.find('.sub-nav-widgets').css({
						width: $_this_par_w,
					})
				}
			}

			function showSubMenu(el){
				
				
				if(el.parent("li").length > 0){
					var $thisPar = el.parent(),
						$subMenu = el.siblings("div.dt-mega-menu-wrap, ul");
				}else{
					var $thisPar = el,
						$this_a = el.find("> a"),
						$subMenu = $this_a.siblings("div.dt-mega-menu-wrap, ul");
				}
				var $this_of_l = el.offset().left,
					$this_a = el.offset().left,
					$masthead = el.parents(".masthead");
				

				$thisPar.addClass("dt-hovered");
				if($thisPar.hasClass("dt-mega-menu")) $thisPar.addClass("show-mega-menu");

				dtGlobals.isHovering = true;

				/*Right overflow menu*/
				if ($page.width() - ($subMenu.offset().left - $page.offset().left) - $subMenu.width() < 0) {
					$subMenu.addClass("right-overflow");
				}				
				/*Bottom overflow menu*/
				if ($window.height() - ($subMenu.offset().top - dtGlobals.winScrollTop) - $subMenu.innerHeight() < 0 && !$subMenu.parents().hasClass('sub-sideways')) {
					$subMenu.addClass("bottom-overflow");
				};
				if ($window.height() - ($subMenu.offset().top - dtGlobals.winScrollTop) - $subMenu.innerHeight() < 0 && !$thisPar.hasClass("dt-mega-menu")) {
					$subMenu.addClass("bottom-overflow");
				};
				if(($thisPar.find(".dt-mega-menu-wrap").length > 0 && $thisPar.find(".dt-mega-menu-wrap").offset().top + $thisPar.find(".dt-mega-menu-wrap").innerHeight()) > $window.height() && $subMenu.parents().hasClass('sub-sideways') && $thisPar.hasClass("dt-mega-menu")){

					if(el.find(".dt-mega-menu-wrap").height() <= $window.height()){
						
						$thisPar.find(".dt-mega-menu-wrap").css({
							top: -(($thisPar.position().top + $thisPar.height() + el.find(".dt-mega-menu-wrap").height()) - ($window.height() ))
						});
						
					}else{
						$thisPar.find(".dt-mega-menu-wrap").css({
							top: -(el.position().top - 5)
						});
					}

				}
				/*Left position*/
				if(!$sideHeader.length > 0){
					$subMenu.not(".right-overflow").css({
						left: $this_a - $this_of_l
					});
				};
				if(el.parents(".dt-mobile-header").length > 0) {
		            $subMenu.css({
		                top: el.position().top - 13 - $subMenu.height()
		            });
		        };
				/*Mega menu auto width */
				if($thisPar.hasClass("mega-auto-width")){
					var $_this_par_width = $thisPar.width(),
						$_this_par_of_l = $masthead.offset().left,
						$_this_of_l = $thisPar.offset().left;
						$_this_parents_ofs = $thisPar.offset().left - $_this_par_of_l;

					if(!$sideHeader.length){
						var $pageW = $page.width();
						if($(".boxed").length > 0){
							var $_this_of_l = $thisPar.position().left;
							if($subMenu.innerWidth()  > ($pageW - $thisPar.position().left)){
								$subMenu.css({
									left: -( $subMenu.innerWidth()  - ($pageW - $_this_of_l) + 20 )
								});

							}
						}else{
							var $_this_of_l = $thisPar.offset().left;
							if($subMenu.innerWidth()  > ($pageW - $thisPar.offset().left)){
								$subMenu.css({
									left: -( $subMenu.innerWidth()  - ($pageW - $_this_of_l) + 20 )
								});

							}
						}	

						if($subMenu.innerWidth() > $pageW){
							if($(".boxed").length > 0){
								$subMenu.css({
									width: $masthead.width() - 40,
									left: -($thisPar.position().left + 20)
								});
							}else{
								$subMenu.css({
									width: $masthead.width() - 40,
									left: -($_this_of_l - $_this_par_of_l + 20)
								});
							}
						}
					}
					if(typeof $subMenu.find('.slider-content') != undefined) {
						$subMenu.find('.slider-content').widgetScroller().css("visibility", "visible");
					}
					$subMenu.layzrInitialisation();
				};

				/*Mega menu -> full width*/
				if($thisPar.hasClass("mega-full-width")){
					var $_this_of_l = $thisPar.offset().left;
					if(el.parents(".header-bar").length > 0){
						if(el.parents(".masthead").hasClass('full-width')){
							var $_this_par_w = el.parents(".header-bar").innerWidth() - 40;
							var $_this_par_of_l = el.parents(".header-bar").offset().left + 20;
						}else{
							var $_this_par_w = el.parents(".header-bar").innerWidth();
							var $_this_par_of_l = el.parents(".header-bar").offset().left;
						}
					}else{
						if(el.parents(".masthead").hasClass('full-width')){
							var $_this_par_w = el.parents(".ph-wrap").innerWidth() - 40;
							var $_this_par_of_l = el.parents(".ph-wrap").offset().left + 20;
						}else{
							var $_this_par_w = el.parents(".ph-wrap").innerWidth();
							var $_this_par_of_l = el.parents(".ph-wrap").offset().left;
						}
						
					}
					if(!$sideHeader.length > 0){
						$subMenu.css({
							width: $_this_par_w,
							left: -($_this_of_l - $_this_par_of_l)
						})
					}

					if(typeof $subMenu.find('.slider-content') != undefined) {
						$subMenu.find('.slider-content').widgetScroller().css("visibility", "visible");
					}
					$subMenu.layzrInitialisation();
				}

				clearTimeout(menuTimeoutShow);
				clearTimeout(menuTimeoutHide);

				menuTimeoutShow = setTimeout(function() {
					if($thisPar.hasClass("dt-hovered")){
						$subMenu.stop().css("visibility", "visible").animate({
							"opacity": 1
						}, 150, function() {

			               $thisPar.addClass("show-mega-menu-content");
						});
						
						/*hide search*/
			            $(".searchform .submit", $header).removeClass("act");
			            $(".mini-search").removeClass("act");
			            $(".mini-search.popup-search .popup-search-wrap", $header).stop().animate({
			                "opacity": 0
			            }, 150, function() {
			                $(this).css("visibility", "hidden");
			            });
					}
				}, 100);
			}
			function hideSubMenu(el){
				var $thisLink = el.find("> a"),
					$subMenu = $thisLink.siblings("div.dt-mega-menu-wrap, ul");

				el.removeClass("dt-hovered");
				dtGlobals.isHovering = false;
				clearTimeout(menuTimeoutShow);
				clearTimeout(menuTimeoutHide);

				menuTimeoutHide = setTimeout(function() {
					if(!el.hasClass("dt-hovered")){
						$subMenu.stop().animate({
							"opacity": 0
						}, 150, function() {
							$(this).css("visibility", "hidden");
						});

						el.removeClass("show-mega-menu");

			            el.removeClass("show-mega-menu-content");
						
						setTimeout(function() {
							if(!el.hasClass("dt-hovered")){
								$subMenu.removeClass("right-overflow");
								$subMenu.removeClass("bottom-overflow");
								el.find(".dt-mega-menu-wrap").css({
									top: ""
								});
								if(el.hasClass("mega-auto-width")){
									$subMenu.css({
										width: "",
										left: ""
									});
								}
							}
						}, 400);
					}
				}, 150);

				el.find("> a").removeClass("dt-clicked");
			}
			$this.find("> a").on("focus", function(e) {
				if(e.type == "tap") e.stopPropagation();
				var $this = $(this);
				showSubMenu($this);

				$(" li.has-children").removeClass("parent-clicked");
				$this.parent().addClass("parent-clicked");
				if(!$(e.target).parents().hasClass('sub-nav')){
					$(" li.has-children").removeClass("dt-hovered");
					$this.parent().addClass("dt-hovered");
				}
				$(".main-nav > li:not(.dt-hovered) > .sub-nav, .main-nav >  li:not(.dt-hovered) > .dt-mega-menu-wrap").stop().animate({
					"opacity": 0
				}, 150, function() {
					$(this).css("visibility", "hidden");
				});
				$(" .main-nav .sub-nav li:not(.parent-clicked) .sub-nav").stop().animate({
					"opacity": 0
				}, 150, function() {
					$(this).css("visibility", "hidden");
				});
			});

			$this.find("> a").on("focusout", function(e) {
				var $this = $(this);
				//hideSubMenu($this);
				var $thisLink = $('this'),
					$subMenu = $thisLink.siblings("div.dt-mega-menu-wrap, ul");

				//$this.parent().removeClass("dt-hovered");
				dtGlobals.isHovering = false;
				clearTimeout(menuTimeoutShow);
				clearTimeout(menuTimeoutHide);

				menuTimeoutHide = setTimeout(function() {
					if(!$this.parent().hasClass("dt-hovered")){
						$subMenu.stop().animate({
							"opacity": 0
						}, 150, function() {
							$(this).css("visibility", "hidden");
						});

						$this.parent().removeClass("show-mega-menu");

			            $this.parent().removeClass("show-mega-menu-content");
						
						setTimeout(function() {
							if(!$this.parent().hasClass("dt-hovered")){
								$subMenu.removeClass("right-overflow");
								$subMenu.removeClass("bottom-overflow");
								$this.parent().find(".dt-mega-menu-wrap").css({
									top: ""
								});
								if($this.parent().hasClass("mega-auto-width")){
									$subMenu.css({
										width: "",
										left: ""
									});
								}
							}
						}, 400);
					}
				}, 150);

				$this.parent().removeClass("parent-clicked");
			});
			if($(".masthead").hasClass('show-sub-menu-on-hover')){
				$thisHover.on("mouseenter tap", function(e) {
					if(e.type == "tap") e.stopPropagation();
					var $this = $(this);
					showSubMenu($this);
				});

				$this.on("mouseleave", function(e) {
					var $this = $(this);
					hideSubMenu($this);
				});
			}else{
				$body.on("click", function(e) {
					if(!$(e.target).hasClass('sub-nav') || !$(e.target).hasClass('dt-mega-menu-wrap')){
						$(" #primary-menu li.dt-hovered:not(.dt-mega-menu) > .sub-nav").animate({
							"opacity": 0
						}, 100, function() {
							$(this).css("visibility", "hidden");
						});
						$(" #primary-menu li.dt-mega-menu > .is-clicked").siblings(" .dt-mega-menu-wrap").animate({
							"opacity": 0
						}, 100, function() {
							$(this).css("visibility", "hidden");
						});
						$(" li.has-children").removeClass("dt-hovered");
						$(" li.has-children > a").removeClass("is-clicked");
					}
	            });
	          
				$thisHover.on("click", function(e) {
					if(!$(this).parents().hasClass('mobile-main-nav')){
						if(e.type == "tap") e.stopPropagation();
						var $this = $(this),
							$thisLink = $this.parent("li");

						if ($this.hasClass("is-clicked")) {
							hideSubMenu($thisLink);
							$this.removeClass("is-clicked");
							$this.parent().removeClass("parent-clicked");
						}else{
							showSubMenu($this);
							$(" li.has-children > a").removeClass("is-clicked");
							$(" li.has-children").removeClass("parent-clicked");
							$this.parent().addClass("parent-clicked");
							if(!$(e.target).parents().hasClass('sub-nav')){
								$(" li.has-children").removeClass("dt-hovered");
								$this.parent().addClass("dt-hovered");
							}
							$(".main-nav > li:not(.dt-hovered) > .sub-nav, .main-nav >  li:not(.dt-hovered) > .dt-mega-menu-wrap").stop().animate({
								"opacity": 0
							}, 150, function() {
								$(this).css("visibility", "hidden");
							});
							$(".main-nav .sub-nav li:not(.parent-clicked) .sub-nav").stop().animate({
								"opacity": 0
							}, 150, function() {
								$(this).css("visibility", "hidden");
							});
							$this.addClass("is-clicked");
							return false;
						}
					}
				})

			}

		});
	});
	$.fn.touchMenuItem = function() {
		return this.each(function() {
			var $item = $(this);
			if ($item.hasClass("item-ready")) {
				return;
			}

			$body.on("touchend", function(e) {
				$(".mobile-true .has-children > a").removeClass("is-clicked");
			});
			var $this = $(this),
				$thisTarget = $this.attr("target") ? $this.attr("target") : "_self";
			$this.on("touchstart", function(e) { 
				origY = e.originalEvent.touches[0].pageY;
				origX = e.originalEvent.touches[0].pageX;
			});
			$this.on("touchend", function(e) {
				var touchEX = e.originalEvent.changedTouches[0].pageX,
					touchEY = e.originalEvent.changedTouches[0].pageY;
				if( origY == touchEY || origX == touchEX ){
					if ($this.hasClass("is-clicked")) {
					} else {
						if($this.parent().hasClass("dt-hovered")){
							e.preventDefault();
							$(".mobile-true .has-children > a").removeClass("is-clicked");
							$this.addClass("is-clicked");
							window.open($this.attr("href"), $thisTarget);
							return false;
						}
					};
				};
			});

			$item.addClass("item-ready");
		});
	};
	$(".mobile-true .has-children > a").touchMenuItem();

	var menuTimeoutShow,
		menuTimeoutHide;
	droupdownCustomMenu.on("mouseenter tap", function(e) {
		if(e.type == "tap") e.stopPropagation();

		var $this = $(this);
		$this.addClass("dt-hovered");

		if ($page.width() - ($this.children(".mini-sub-nav").offset().left - $page.offset().left) - $this.find(" > .mini-sub-nav").width() < 0) {
			$this.children(".mini-sub-nav").addClass("right-overflow");
		}

		if (($window.height() - ($this.children(".mini-sub-nav").offset().top - dtGlobals.winScrollTop) - $this.children(".mini-sub-nav").height() < 0) && !$this.parents(".dt-mobile-header").length > 0) {
			$this.children(".mini-sub-nav").addClass("bottom-overflow");
		};
		if($this.parents(".dt-mobile-header").length > 0) {
            $this.children(".mini-sub-nav").css({
                top: $this.position().top - 13 - $this.children(".mini-sub-nav").height()
            });
        };

		dtGlobals.isHovering = true;
		clearTimeout(menuTimeoutShow);
		clearTimeout(menuTimeoutHide);

		menuTimeoutShow = setTimeout(function() {
			if($this.hasClass("dt-hovered")){
				$(".mini-sub-nav").stop().animate({
					"opacity": 0
				}, 50, function() {
					$(this).css("visibility", "hidden");
				});
				$this.children('.mini-sub-nav').stop().css("visibility", "visible").animate({
					"opacity": 1
				}, 150);
			}
		}, 100);
	});

	droupdownCustomMenu.on("mouseleave", function(e) {
		var $this = $(this);
		$this.removeClass("dt-hovered");

		dtGlobals.isHovering = false;
		clearTimeout(menuTimeoutShow);
		clearTimeout(menuTimeoutHide);

		menuTimeoutHide = setTimeout(function() {
			if(!$this.hasClass("dt-hovered")){
				if(!$this.parents().hasClass("dt-mega-menu")){
					$this.children(".mini-sub-nav").stop().animate({
						"opacity": 0
					}, 150, function() {
						$(this).css("visibility", "hidden");
					});
				}
				
				setTimeout(function() {
					if(!$this.hasClass("dt-hovered")){
						$this.children(".mini-sub-nav").removeClass("right-overflow");
						$this.children(".mini-sub-nav").removeClass("bottom-overflow");
					}
				}, 400);
			}
		}, 150);
	});