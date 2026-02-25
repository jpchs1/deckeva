
/* #Custom menu
================================================== */
	var customTimeoutShow;

	

	var item = $('.main-nav li.has-children > a:not(.not-clickable-item), .level-arrows-on > li.has-children > a, .mobile-main-nav li.has-children > a');
	$("<i class='next-level-button'></i>").insertAfter(item);
	var itemMenu = $(' .dt-sub-menu-display-on_click li.has-children > a');
	$("<i class='next-level-button'></i>").appendTo(itemMenu);

	$(".sub-downwards .main-nav li.has-children, .mobile-main-nav li.has-children").each(function(){
		var $this = $(this);
		var subMenu = $this.find(" > .sub-nav, .sub-menu, .vertical-sub-nav");
		if($this.find(".sub-nav li, .sub-menu li, .vertical-sub-nav li").hasClass("act")){
			$this.addClass('active');
		};

		if($this.find(".sub-nav li.act, .sub-menu li.act, .vertical-sub-nav li.act").hasClass("act")){
			$this.addClass('open-sub');
			subMenu.stop(true, true).slideDown(100);

			subMenu.layzrInitialisation();
		};
		// $this.find("> a").on("focus", function(e) {
		// 	if(!$this.parents().hasClass("mobile-main-nav")){
		// 		$this.siblings().find(" .sub-nav, .dt-mega-menu-wrap, .sub-menu").stop(true, true).slideUp(400);
		// 		subMenu.stop(true, true).slideDown(500);
		// 		$this.siblings().removeClass("active");
		// 		$this.addClass('active');
		// 		$this.siblings().removeClass('open-sub');
		// 		$this.addClass('open-sub');

		// 		$this.siblings().find("> a").removeClass("act");
		// 		$this.find('a').addClass('act');

		// 		$(" .main-nav").layzrInitialisation();
		// 	}
		// })
		$this.find(" > .next-level-button").on("click", function(e){
			var $this = $(this).parent();
			if ($this.hasClass("active")){
				subMenu.stop(true, true).slideUp(500, function(){
					$(" .main-nav").layzrInitialisation();
				});
				$this.removeClass("active");
				$this.removeClass('open-sub');
				$this.find('a').removeClass('act');

			}else{
				$this.siblings().find(" .sub-nav, .dt-mega-menu-wrap, .sub-menu").stop(true, true).slideUp(400);
				subMenu.stop(true, true).slideDown(500);
				$this.siblings().removeClass("active");
				$this.addClass('active');
				$this.siblings().removeClass('open-sub');
				$this.addClass('open-sub');

				$this.siblings().find("> a").removeClass("act");
				$this.find('a').addClass('act');

				$(" .main-nav").layzrInitialisation();
			};

		})
	});

	$(" .dt-sub-menu-display-on_click li.has-children, .dt-sub-menu-display-on_item_click li.has-children").each(function(){
			var $this = $(this),
				itemLink = $this.find('> a'),
                iconData = itemLink.find('.next-level-button i').attr('class')
                iconDataAct = itemLink.find('.next-level-button').attr('data-icon');
		  	$this_sub = $this.find(" > .dt-mega-menu-wrap > .vertical-sub-nav");
            $this_sub.unwrap();
			var subMenu = $this.find(" > .vertical-sub-nav");
			if($this.find(".vertical-sub-nav li").hasClass("act")){
				$this.addClass('active');
			};

			if($this.find(".vertical-sub-nav li").hasClass("act")){
				$this.addClass('open-sub');
				subMenu.stop(true, true).slideDown(100);
				$this.find(' > a').addClass('active');
				$this.find(' > a .next-level-button i').attr('class', iconDataAct);
				subMenu.layzrInitialisation();
			};
			if(itemLink.hasClass('not-clickable-item') && $this.parents('nav').hasClass("dt-sub-menu-display-on_item_click")){
                var clickItem = itemLink;
            }else{
                 var clickItem =  itemLink.find(" > .next-level-button");
            }
			clickItem.on("click", function(e){
				e.stop
				//var $this = $(this);
				if(itemLink.hasClass('not-clickable-item') && itemLink.parents('nav').hasClass("dt-sub-menu-display-on_item_click")){
                    var $this = $(this),
                        openIcon = $(this).find('.next-level-button i');
                }else{
                    var $this = $(this).parent(),
                        openIcon = $(this).find('i');
                }
				e = window.event || e; 
    			if(!$(e.target).parent().hasClass('next-level-button') && itemLink.parents('nav').hasClass("dt-sub-menu-display-on_click")) {
    				return true;
    			}else{
    				e.stopPropagation();
    				e.preventDefault();
					if ($this.hasClass("active")){
						openIcon.attr('class', iconData);
						subMenu.stop(true, true).slideUp(500, function(){
							$(" .main-nav").layzrInitialisation();
						});
						$this.removeClass("active");
						$this.removeClass('open-sub');
						$this.find('a').removeClass('act');
					
					}else{
						openIcon.attr('class', iconDataAct);
						$this.siblings().find(" .vertical-sub-nav").stop(true, true).slideUp(400);
						subMenu.stop(true, true).slideDown(500);
						$this.siblings().removeClass("active");
						$this.addClass('active');
						$this.siblings().removeClass('open-sub');
						$this.addClass('open-sub');

						$this.siblings().find("> a").removeClass("act");
						$this.find('a').addClass('act');
						
						$(" .main-nav").layzrInitialisation();
					};
				}

			})
		});


	if(!$(".dt-parent-menu-clickable").length > 0){
		$(".sub-downwards .main-nav li > a, .mobile-main-nav li.has-children > a").each(function(){
			var $this = $(this);
			if($this.parent("li").find(".sub-nav li, .sub-menu li").hasClass("act")){
				$this.addClass('act');
			};
			if($this.parent("li").find(".sub-nav li.act, .sub-menu li.act").hasClass("act")){
				$this.parent("li").addClass('open-sub');
				$this.siblings(".sub-nav, .sub-menu").stop(true, true).slideDown(100,function() {
					$this.siblings(".sub-nav, .sub-menu").layzrInitialisation();
				});
			};
			$this.on("click", function(e){
				$menuItem = $this.parent();
				if ($menuItem.hasClass("has-children menu-item-language")) e.preventDefault();
				
				if ($this.hasClass("act")){
					$this.siblings(".sub-nav, .sub-menu").stop(true, true).slideUp(500);
					$this.removeClass("act");
					$this.parent("li").removeClass('open-sub');
				}else{
					$this.parent().siblings().find(".sub-nav, .dt-mega-menu-wrap, .sub-menu").stop(true, true).slideUp(400);
					$this.siblings(".sub-nav, .sub-menu").stop(true, true).slideDown(500);
					$this.parent().siblings().find("> a").removeClass("act");
					$this.addClass('act');
					$this.parent("li").siblings().removeClass('open-sub active');
					$this.parent("li").addClass('open-sub active');
					//$this.parent().layzrInitialisation();
				};
				$(".header-bar").mCustomScrollbar("update");
			});
		});

	};


	$(".custom-nav > li > a").click(function(e){
		var $menuItem = $(this).parent(),
			$this = $(this);
		if ($menuItem.hasClass("has-children")) e.preventDefault();
		
		
			if (!$this.hasClass("active")){
					$(".custom-nav > li > ul").stop(true).slideUp(400);
					$this.next().stop(true).slideDown(500);
					$(".custom-nav > li > a").removeClass("active");
					$this.addClass('active');
			}else{
					$this.next().stop(true).slideUp(500);
					$this.removeClass("active");
			}

			$menuItem.siblings().removeClass("act");
			$menuItem.addClass("act");
	});

	$(".custom-nav > li > ul").each(function(){
		clearTimeout(customTimeoutShow);
		$this = $(this);
		$thisChildren = $this.find("li");
		if($thisChildren.hasClass("act")){
			$this.prev().addClass("active");
			$this.parent().siblings().removeClass("act");
			$this.parent().addClass("act");
			$this.slideDown(500);
		}
	});