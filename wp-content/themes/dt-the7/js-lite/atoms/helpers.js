    dtGlobals.isInViewport = function ($item){
    //Window Object
    var win = $(window);
    //Object to Check
    var obj = $item;
    //the top Scroll Position in the page
    var scrollPosition = win.scrollTop();
    //the end of the visible area in the page, starting from the scroll position
    var visibleArea = win.scrollTop() + win.height();
    //the end of the object to check
    var objEndPos = (obj.offset().top + 20);
    return(visibleArea >= objEndPos && scrollPosition <= objEndPos ? true : false);
    };

    //Layzy img loading
    $.fn.layzrInitialisation = function(container) {
        return this.each(function() {
            var $this = $(this);

            var layzr = new Layzr({
                container: container,
                selector: '.lazy-load',
                attr: 'data-src',
                attrSrcSet: 'data-srcset',
                retinaAttr: 'data-src-retina',
                hiddenAttr: 'data-src-hidden',
                threshold: 0,
                before: function() {

                    this.style.willChange = 'opacity';

                    if($(this).parents(".blog-shortcode.mode-list").length > 0 || $(this).parents(".blog-media").length > 0){
                        this.setAttribute("sizes", this.width+"px");
                    }else if($(this).parents(".woocom-project").length > 0){
                        this.setAttribute("sizes", "(max-width:" + $(this).attr('width')+"px) 100vw," + $(this).attr('width')+"px" );
                    }
                },
                callback: function() {

                    this.classList.add("is-loaded");

                    var $this =  $(this);
                    $this.parents('.fancy-media-wrap.photoswipe-wrapper').initPhotoswipe();
                    setTimeout(function(){
                        $this.parents().removeClass("layzr-bg");
                        $this.css("will-change",'auto');
                    }, 350)
                },
                after: function() {
                    var $this =  $(this);
                    if(this.complete && !$this.hasClass("is-loaded") ){
                        this.classList.add("is-loaded");
                        setTimeout(function(){
                            var $this =  $(this);

                            $this.parents().removeClass("layzr-bg");
                            $this.css("will-change",'auto');
                        }, 350)
                    }
                }
            });
        });
    };