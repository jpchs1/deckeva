
/* #Images Styling & Hovers
================================================== */



/**
 * jquery.hoverdir.js v1.1.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2012, Codrops
 * http://www.codrops.com
 */

    
    'use strict';

    $.HoverDir = function( options, element ) {
        
        this.$el = $( element );
        this._init( options );

    };

    // the options
    $.HoverDir.defaults = {
        speed : 300,
        easing : 'ease',
        hoverDelay : 0,
        inverse : false
    };

    $.HoverDir.prototype = {

        _init : function( options ) {
            
            // options
            this.options = $.extend( true, {}, $.HoverDir.defaults, options );
            // transition properties
            this.transitionProp = 'all ' + this.options.speed + 'ms ' + this.options.easing;
            // support for CSS transitions
            this.support = Modernizr.csstransitions;
            // load the events
            this._loadEvents();

        },
        
        _loadEvents : function() {

            var self = this;
            
            this.$el.on( 'mouseenter.hoverdir, mouseleave.hoverdir', function( event ) {
                
                var $el = $( this ),
                    $hoverElem = $el.find( '.rollover-content, .gallery-rollover, .post-entry-content' ),
                    direction = self._getDir( $el, { x : event.pageX, y : event.pageY } ),
                    styleCSS = self._getStyle( direction );
                
                if( event.type === 'mouseenter' ) {
                    
                    $hoverElem.hide().css( styleCSS.from );
                    clearTimeout( self.tmhover );

                    self.tmhover = setTimeout( function() {
                        
                        $hoverElem.show( 0, function() {
                            
                            var $el = $( this );
                            if( self.support ) {
                                $el.css( 'transition', self.transitionProp );
                            }
                            self._applyAnimation( $el, styleCSS.to, self.options.speed );

                        } );
                        
                    
                    }, self.options.hoverDelay );
                    
                }
                else {
                
                    if( self.support ) {
                        $hoverElem.css( 'transition', self.transitionProp );
                    }
                    clearTimeout( self.tmhover );
                    self._applyAnimation( $hoverElem, styleCSS.from, self.options.speed );
                    
                }
                    
            } );

        },
        // credits : http://stackoverflow.com/a/3647634
        _getDir : function( $el, coordinates ) {
            
            // the width and height of the current div
            var w = $el.width(),
                h = $el.height(),

                // calculate the x and y to get an angle to the center of the div from that x and y.
                // gets the x value relative to the center of the DIV and "normalize" it
                x = ( coordinates.x - $el.offset().left - ( w/2 )) * ( w > h ? ( h/w ) : 1 ),
                y = ( coordinates.y - $el.offset().top  - ( h/2 )) * ( h > w ? ( w/h ) : 1 ),
            
                // the angle and the direction from where the mouse came in/went out clockwise (TRBL=0123);
                // first calculate the angle of the point,
                // add 180 deg to get rid of the negative values
                // divide by 90 to get the quadrant
                // add 3 and do a modulo by 4  to shift the quadrants to a proper clockwise TRBL (top/right/bottom/left) **/
                direction = Math.round( ( ( ( Math.atan2(y, x) * (180 / Math.PI) ) + 180 ) / 90 ) + 3 ) % 4;
            
            return direction;
            
        },
        _getStyle : function( direction ) {
            
            var fromStyle, toStyle,
                slideFromTop = { left : '0px', top : '-100%' },
                slideFromBottom = { left : '0px', top : '100%' },
                slideFromLeft = { left : '-100%', top : '0px' },
                slideFromRight = { left : '100%', top : '0px' },
                slideTop = { top : '0px' },
                slideLeft = { left : '0px' };
            
            switch( direction ) {
                case 0:
                    // from top
                    fromStyle = !this.options.inverse ? slideFromTop : slideFromBottom;
                    toStyle = slideTop;
                    break;
                case 1:
                    // from right
                    fromStyle = !this.options.inverse ? slideFromRight : slideFromLeft;
                    toStyle = slideLeft;
                    break;
                case 2:
                    // from bottom
                    fromStyle = !this.options.inverse ? slideFromBottom : slideFromTop;
                    toStyle = slideTop;
                    break;
                case 3:
                    // from left
                    fromStyle = !this.options.inverse ? slideFromLeft : slideFromRight;
                    toStyle = slideLeft;
                    break;
            };
            
            return { from : fromStyle, to : toStyle };
                    
        },
        // apply a transition or fallback to jquery animate based on Modernizr.csstransitions support
        _applyAnimation : function( el, styleCSS, speed ) {

            $.fn.applyStyle = this.support ? $.fn.css : $.fn.animate;
            el.stop().applyStyle( styleCSS, $.extend( true, [], { duration : speed + 'ms' } ) );

        },

    };
    
    var logError = function( message ) {

        if ( window.console ) {

            window.console.error( message );
        
        }

    };
    
    $.fn.hoverdir = function( options ) {

        var instance = $.data( this, 'hoverdir' );
        
        if ( typeof options === 'string' ) {
            
            var args = Array.prototype.slice.call( arguments, 1 );
            
            this.each(function() {
            
                if ( !instance ) {

                    logError( "cannot call methods on hoverdir prior to initialization; " +
                    "attempted to call method '" + options + "'" );
                    return;
                
                }
                
                if ( !$.isFunction( instance[options] ) || options.charAt(0) === "_" ) {

                    logError( "no such method '" + options + "' for hoverdir instance" );
                    return;
                
                }
                
                instance[ options ].apply( instance, args );
            
            });
        
        } 
        else {
        
            this.each(function() {
                
                if ( instance ) {

                    instance._init();
                
                }
                else {

                    instance = $.data( this, 'hoverdir', new $.HoverDir( options, this ) );
                
                }

            });
        
        }
        
        return instance;
        
    };

	/* !Append tag </i> to rolovers*/
	$.fn.addRollover = function() {
		return this.each(function() {
			var $this = $(this);
			if ($this.hasClass("this-ready")) {
				return;
			}

			$this.append("<i></i>");
			if($this.find(".rollover-thumbnails").length){
				$this.addClass("rollover-thumbnails-on");
			}
			if($this.parent().find(".links-container").length){
				$this.addClass("rollover-buttons-on");
			}

			$this.addClass("this-ready");
		});
	};

	/* #Hover layouts
	================================================== */

	/*!-Scale in hover*/
	$.fn.scaleInHover = function() {
		return this.each(function() {

			var $this = $(this);
			if ($this.hasClass("scale-ready")) {
				return;
			}
			var $img = $this.find("img.preload-me"),
				imgWidth = parseInt($img.attr('width')),
				imgHeight = parseInt($img.attr('height')),
				imgRatio = imgWidth/imgHeight;
			if(imgRatio < 2 && imgRatio >= 1.5){
				$this.addClass("ratio_3-2");
			}else if(imgRatio < 1.5 && imgRatio >= 1){
				$this.addClass("ratio_4-3");
			}else if(imgRatio < 1 && imgRatio >= 0.75){
				$this.addClass("ratio_3-4");
			}else if(imgRatio < 0.75 && imgRatio >= 0.6){
				$this.addClass("ratio_2-3");
			}else{
				$this.removeClass("ratio_2-3").removeClass("ratio_3-2").removeClass("ratio-2").removeClass("ratio_4-3").removeClass("ratio_3-4");
			};
			if(imgRatio >= 2){
				$this.addClass("ratio-2");
			};
			if(imgRatio == 0.5){
				$this.addClass("ratio_0-5");
			};
			if(imgRatio == 1){
				$this.removeClass("ratio_2-3").removeClass("ratio-2").removeClass("ratio_3-2").removeClass("ratio_4-3").removeClass("ratio_3-4");
			};

			$this.addClass("scale-ready");
		});
	};

	$.fn.touchNewHover = function() {
		return this.each(function() {
			var $this = $(this);
			if ($this.hasClass("this-ready")) {
				return;
			}

			if( $(".rollover-content", this).length > 0 ){
				$body.on("touchend", function(e) {
					$(".mobile-true .rollover-content, .mobile-true .rollover-project, .mobile-true .woocom-project").removeClass("is-clicked");
				});
				
				$this.on("touchstart", function(e) {
					origY = e.originalEvent.touches[0].pageY;
					origX = e.originalEvent.touches[0].pageX;
				});
				$this.on("touchend", function(e) {
					var touchEX = e.originalEvent.changedTouches[0].pageX,
						touchEY = e.originalEvent.changedTouches[0].pageY;
					if( origY == touchEY || origX == touchEX ){
			
						if ($this.hasClass("is-clicked")) {
							if($this.find(".dt-gallery-container").length > 0){
								$this.find(".rollover-content").on("click.dtAlbums", function(e){
									$this.find(".rollover-content").off("click.dtAlbums");
									$(this).find("a.dt-gallery-pspw, .dt-trigger-first-pspw, .dt-pswp-item").first().trigger('click');
								});
							}
							if($(this).find(".rollover-click-target.go-to").length > 0){
								window.location.href = $(this).find(".rollover-click-target.go-to").attr('href');
							}else if($(this).hasClass("woocom-project")){
								if ( $(e.target).is(".add_to_cart_button") ) {
									return true
								}else{
									window.location.href = $(this).find(" > a").attr('href');
								}
							}
						} else {

							$('.links-container > a', $this).on('touchend', function(e) {
								e.stopPropagation();
								$this.addClass("is-clicked");
							});
							e.preventDefault();
							$(".mobile-true .rollover-content, .mobile-true .rollover-project,.mobile-true .woocom-project").removeClass("is-clicked");
							$this.addClass("is-clicked");
							$this.find(".rollover-content").addClass("is-clicked");
							return false;
						};
					};
				});
			};

			$this.addClass("this-ready");
		});
	};



	/*!Trigger post click for blog Overlay (background)/Overlay (gradient) layouts */
    $.fn.triggerPostClick = function() {
        return this.each(function() {
            var $this = $(this);
            if ($this.hasClass("post-ready")) {
                return;
            }

            var $thisSingleLink = $this.find(".post-thumbnail-rollover").first(),
                $thisCategory = $this.find(".entry-meta a, .fancy-date a, .fancy-categories a");

            if( $thisSingleLink.length > 0 ){
                $thisSingleLink.on("click", function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                     if ($thisSingleLink.parents(".ts-wrap").hasClass("ts-interceptClicks")) return;
                });

                var alreadyTriggered = false;

                $this.on("click", function(){

                    if ($this.parents(".ts-wrap").hasClass("ts-interceptClicks")) return;

                    if ( !alreadyTriggered ) {
                        alreadyTriggered = true;

                       // $thisSingleLink.trigger("click");
                         window.location.href = $thisSingleLink.attr('href');
                        
                        alreadyTriggered = false;
                    }
                    return false;
                })
                $this.find($thisCategory).click(function(e) {

                     e.stopPropagation();
                    window.location.href = $thisCategory.attr('href');
                });
            }
            $this.addClass("post-ready");
        });
    };

   $.fn.touchTriggerPostClick = function() {
        return this.each(function() {
            var $this = $(this);
            if ($this.hasClass("touch-post-ready")) {
                return;
            }
            var $thisSingleLink = $this.find(".post-thumbnail-rollover").first(),
			    $thisCategory = $this.find(".entry-meta a, .fancy-date a, .fancy-categories a"),
			    $thisOfTop = $this.find(".entry-excerpt").height() + $this.find(".post-details").height();

            $body.on("touchend", function(e) {
                $(".mobile-true .post").removeClass("is-clicked");
            });
          
            $this.on("touchstart", function(e) { 
                origY = e.originalEvent.touches[0].pageY;
                origX = e.originalEvent.touches[0].pageX;
            });
            $this.on("touchend", function(e) {
                var touchEX = e.originalEvent.changedTouches[0].pageX,
                    touchEY = e.originalEvent.changedTouches[0].pageY;
                if( origY == touchEY || origX == touchEX ){
                	if($this.parents().hasClass("disable-layout-hover")){
                		if(e.target.tagName.toLowerCase() === 'a'){
                			$(e.target).trigger("click");
                		}else{
                			window.location.href = $thisSingleLink.attr('href');
                		}
                	}else {
						 if ($this.hasClass("is-clicked")) {
	                            window.location.href = $thisSingleLink.attr('href');
	                    } else {
	                        e.preventDefault();
	                       	if(e.target.tagName.toLowerCase() === 'a'){
	                			$(e.target).trigger("click");
	                		}
	                        $(".mobile-ture .post").removeClass("is-clicked");
	                        $this.addClass("is-clicked");
	                        $this.parent().siblings().find(".post").removeClass("is-clicked");
	                        return false;
	                    };
	                };
                };
            });

            $this.addClass("touch-post-ready");
        });
    };
	
    //Gradient overlap layout
	 $.fn.triggerPostClickOnBefore = function() {
        return this.each(function() {
            var $this = $(this),
            	$thisPar = $this.parents(".post");
            if ($this.hasClass("post-before-ready")) {
                return;
            }

            var $thisSingleLink = $thisPar.find(".post-thumbnail-rollover").first(),
                $thisCategory = $thisPar.find(".entry-meta a, .fancy-date a, .fancy-categories a");

            if( $thisSingleLink.length > 0 ){
                $thisSingleLink.on("click", function(event) {
                    // event.preventDefault();
                    // event.stopPropagation();
                     if ($thisSingleLink.parents(".ts-wrap").hasClass("ts-interceptClicks")) return;
                });

                var alreadyTriggered = false;
                $this.on("mouseenter mousemove", function(e){
                	var elOfTop = $this.offset().top,
                		origY = e.pageY;
                	if((elOfTop - 10) <= origY && (elOfTop + 125) >= (origY)){
                		if(!$thisPar.hasClass("on-hover")){
                			$thisPar.addClass("on-hover");
                		}
                	}else{
                		$thisPar.removeClass("on-hover");
                	}
                });
                
                $this.on("mouseleave", function(e) {
                	var elOfTop = $this.offset().top,
                		origY = e.pageY;
                	$thisPar.removeClass("on-hover");
                });

                $this.on("click", function(){

                   if($thisPar.hasClass("on-hover")){
	                    if ( !alreadyTriggered ) {
	                        alreadyTriggered = true;
	                         window.location.href = $thisSingleLink.attr('href');
	                        
	                        alreadyTriggered = false;
	                    }
	                    return false;
	                }
                })
                $this.find($thisCategory).click(function(e) {
                	if($thisPar.hasClass("on-hover")){
	                    e.stopPropagation();
	                    window.location.href = $thisCategory.attr('href');
	                }
                });
            }
            $this.addClass("post-before-ready");
        });
    };

    window.the7AddHovers = function ($context) {
        $(".rollover, .rollover-video, .post-rollover, .rollover-project .show-content, .vc-item .vc-inner > a", $context).addRollover();
        /* !- Grayscale */
        $(".filter-grayscale .slider-masonry", $context).on("mouseenter tap", function (e) {
            if (e.type == "tap") {
                e.stopPropagation();
            }
            $(this).addClass("dt-hovered");
        });
        $(".filter-grayscale .slider-masonry", $context).on("mouseleave", function (e) {
            $(this).removeClass("dt-hovered");
        });
        $(".hover-scale .rollover-project, .hover-scale .post", $context).scaleInHover();
    };

    window.the7AddMobileHovers = function($context) {
        /*TOUCH DEVICE*/
        /*!Description on hover show content on click(albums projects touch device)*/
        $(".rollover-project, .woocom-project", $context).touchNewHover();
        $(".content-rollover-layout-list:not(.portfolio-shortcode):not(.albums-shortcode) .post, .gradient-overlay-layout-list:not(.portfolio-shortcode):not(.albums-shortcode)  .post", $context).touchTriggerPostClick();
    };

    window.the7AddDesktopHovers = function($context) {
        /*!-Hover Direction aware init*/
        $(".hover-grid.gallery-shortcode figure, .hover-grid .rollover-project, .hover-grid.portfolio-shortcode .post", $context).each(function () {
            $(this).hoverdir();
        });
        $(".hover-grid-reverse.gallery-shortcode figure, .hover-grid-reverse .rollover-project, .hover-grid-reverse.portfolio-shortcode .post", $context).each(function () {
            $(this).hoverdir({
                inverse: true
            });
        });

        $(".albums .rollover-content a:not(.portfolio-categories a), .media .rollover-content, .dt-gallery-container .rollover-content", $context).on("click", function (e) {
            if ($(e.target).is("a")) {
                return true
            }
            $(this).siblings("a.dt-pswp-item").first().click();
        });
        $(".content-rollover-layout-list:not(.portfolio-shortcode):not(.albums-shortcode) .post, .gradient-overlay-layout-list:not(.portfolio-shortcode):not(.albums-shortcode) .post", $context).triggerPostClick();
        $(".gradient-overlap-layout-list:not(.portfolio-shortcode):not(.albums-shortcode)  .post-entry-content", $context).triggerPostClickOnBefore();
    };

    the7AddMobileHovers($("html.mobile-true"));
    the7AddDesktopHovers($("html.mobile-false"));
    the7AddHovers(document);