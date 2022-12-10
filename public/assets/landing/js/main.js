jQuery(document).ready(function ($) {

    'use strict';

    let colorPicker = $('.color-picker')
    colorPicker.click(function (e) {
        for (let i = 0; i < colorPicker.length; i++) {
            $(colorPicker[i]).removeClass('color-active')
        }
        $(e.target).addClass('color-active')
        let color = $(e.target).attr('color')
        let url = $(`img[color="${color}"]`).attr('src')
        $('.lg-img').attr('src',url)
    })

    let smallImages = $('.sm-img')
    smallImages.click(function (e) {
        $('.lg-img').attr('src',e.target.getAttribute('src'))
    })

    $('.add-to-cart').click(function (e){
        e.preventDefault()
        let product = $('input[name="color"]:checked').val()
        let quantity = $('input[name="quantity"]').val()
        if(product && quantity){
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val(),
                },
                url : `/addCart`,
                method : 'post',
                data : JSON.stringify({
                    product,
                    quantity
                }),
                contentType : "application/json",
                dataType: 'json',
                success: function(result) {
                    createToast(result.message,'success')
                },
                error: function(error) {
                    let resp = JSON.parse(error.responseText);
                    if(resp.status == 401){
                        window.location.href = '/login'
                    }
                    else{
                        createToast(resp.message,'danger')
                    }
                }
            })
        }else{
            createToast("Vui lòng chọn màu sắc và số lượng để tiếp tục",'danger')
        }

    })
    $('.buy-now').click(function (e){
        e.preventDefault()
        let product = $('input[name="color"]:checked').val()
        let quantity = $('input[name="quantity"]').val()
        if(product && quantity){
            $('#add-to-cart-form')[0].submit();
        }
        else{
            createToast("Vui lòng chọn màu sắc và số lượng để tiếp tục",'danger')
        }
    })
    function createToast(content,type,duration = 3000){
        Toastify({
            text: content,
            duration: duration,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true, // Prevents dismissing of toast on hover
            className:type
        }).showToast();
    }


    $('.delete-cart').click(function (e){
        e.preventDefault();
        $.ajax({
            url:'/cart/delete',
            headers: {
                'X-CSRF-Token': $('input[name="_token"]').val(),
            },
            method : 'post',
            data : JSON.stringify({
                productId:e.target.getAttribute('pid')
            }),
            contentType : "application/json",
            dataType: 'json',
            success: function(result) {
                $(e.target).parents('.cartlines__box-content').remove()
                $('.btn-checkout').remove()
                updatePrice(result)
                createToast(result.message,'success')
            },
            error: function(error) {
                let resp = JSON.parse(error.responseText)
                createToast(resp.message,'danger')
            }
        })
    })

    function updatePrice(data,selector = null){
        if(selector){
            $(selector).parents('.cartlines__box-content').find('.price-product')
                .empty().append(`${Intl.NumberFormat('en-US').format(data.product_price)} đ`)
        }
        $('.price-total').each((index,item) => {
            item.innerHTML = `<strong>${Intl.NumberFormat('en-US').format(data.total_price)}</strong>`
        })
    }

    $('.icr,.dcr').on('click',debounce(function (e){
        const input = $(e.target).parents('.quantity').find('.quantity-number-input')
        if($(e.target).hasClass('icr')){
            input.val(parseInt(input.val())+1)
        }
        if($(e.target).hasClass('dcr') && parseInt(input.val())>1){
            input.val(parseInt(input.val())-1)
        }
        updateQuantity(input[0])
    },300));
    (function (){
        let lastValue
        $(".quantity-number-input").focusin(function(e){
            lastValue = e.target.value
        });

        $(".quantity-number-input").focusout(function(e){
            if(!(/^\d+$/.test(e.target.value) && parseInt(e.target.value)>0)){
                e.target.value = lastValue.toString()
            }else{
                if(e.target.value != lastValue){
                    updateQuantity(e.target)
                }
            }
        });
    })()
    function updateQuantity(input){
        $.ajax({
            url:'/cart/update',
            headers: {
                'X-CSRF-Token': $('input[name="_token"]').val(),
            },
            method : 'post',
            data : JSON.stringify({
                productId:input.getAttribute('pid'),
                quantity: input.value
            }),
            contentType : "application/json",
            dataType: 'json',
            beforeSend: function (){
                $(input).attr('readonly','true')
            },
            success: function(result) {
                $(input).removeAttr('readonly')
                updatePrice(result,input)
            },
            error: function(error) {
                $(input).removeAttr('readonly')
                let resp = JSON.parse(error.responseText)
                createToast(resp.message,'danger')
            }
        })
    }
    function debounce(func, timeout = 300){
        let timer;
        return (...args) => {
            if (timer) {
                clearTimeout(timer);
            }
            timer = setTimeout(()=>{func.apply(this, args)}, timeout);
        };
    }
















    //=====================================================================
    $(function () {

        // Vars
        var modBtn = $('#modBtn'),
            modal = $('#modal'),
            close = modal.find('.close'),
            modContent = modal.find('.modal-content');

        // open modal when click on open modal button
        modBtn.on('click', function () {
            modal.css('display', 'block');
            modContent.removeClass('modal-animated-out').addClass('modal-animated-in');
        });

        // close modal when click on close button or somewhere out the modal content
        $(document).on('click', function (e) {
            var target = $(e.target);
            if (target.is(modal) || target.is(close)) {
                modContent.removeClass('modal-animated-in').addClass('modal-animated-out').delay(300).queue(function (next) {
                    modal.css('display', 'none');
                    next();
                });
            }
        });

    });


    (function ($) {
        $(".accordion > li:eq(0) .accordion-trigger")
            .addClass("active")
            .next()
            .slideDown();

        $(".accordion-trigger").click(function (j) {
            var dropDown = $(this)
                .closest("li")
                .find(".accordion-content");

            $(this)
                .closest(".accordion")
                .find(".accordion-content")
                .not(dropDown)
                .slideUp();

            if ($(this).hasClass("active")) {
                $(this).removeClass("active");
            } else {
                $(this)
                    .closest(".accordion")
                    .find(".accordion-trigger.active")
                    .removeClass("active");
                $(this).addClass("active");
            }

            dropDown.stop(false, true).slideToggle();

            j.preventDefault();
        });
    })(jQuery);


    $('.owl-carousel-products').owlCarousel({
        loop: true,
        margin: 70,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            500: {
                items: 2,
                nav: false
            },
            800: {
                items: 3,
                nav: false
            },
            1000: {
                items: 3,
                nav: true,
                loop: false
            },
            1200: {
                items: 4,
                nav: true,
                loop: false
            },
            1500: {
                items: 4,
                nav: true,
                loop: false
            }
        }
    })

    $('.owl-carousel-img').owlCarousel({
        loop: true,
        margin: 70,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            500: {
                items: 2,
                nav: false
            },
            800: {
                items: 2,
                nav: false
            },
            1000: {
                items: 3,
                nav: true,
                loop: false
            },
            1200: {
                items: 3,
                nav: true,
                loop: false
            },
            1500: {
                items: 3,
                nav: true,
                loop: false
            }
        }
    })

    $('#form-submit .date').datepicker({});

    /**
     * jquery.responsive-menu.js
     * jQuery + CSS Multi Level Responsive Menu
     */

    jQuery(function ($) {
        $.fn.responsivenav = function (args) {
            // Default settings
            var defaults = {
                responsive: true,
                width: 993,                           // Responsive width
                button: $(this).attr('id') + '-button', // Menu button id
                animation: {                          // Menu animation
                    effect: 'slide',                    // Accepts 'slide' or 'fade'
                    show: 150,
                    hide: 100
                },
                selected: 'selected',                 // Selected class
                arrow: 'downarrow'                    // Dropdown arrow class
            };
            var settings = $.extend(defaults, args);

            // Initialize the menu and the button
            init($(this).attr('id'), settings.button);

            function init(menuid, buttonid) {
                setupMenu(menuid, buttonid);
                // Add a handler function for the resize and orientationchange event
                $(window).bind('resize orientationchange', function () {
                    resizeMenu(menuid, buttonid);
                });
                // Trigger initial resize
                resizeMenu(menuid, buttonid);
            }

            function setupMenu(menuid, buttonid) {
                var $mainmenu = $('#' + menuid + '>ul');

                var $headers = $mainmenu.find("ul").parent();
                // Add dropdown arrows
                $headers.each(function (i) {
                    var $curobj = $(this);
                    $curobj.children('a:eq(0)').append('<span class="' + settings.arrow + '"></span>');
                });

                if (settings.responsive) {
                    // Menu button click event
                    // Displays top-level menu items
                    $('#' + buttonid).click(function (e) {
                        e.preventDefault();

                        if (isSelected($('#' + buttonid))) {
                            // Close menu
                            collapseChildren('#' + menuid);
                            animateHide($('#' + menuid), $('#' + buttonid));
                        } else {
                            // Open menu
                            animateShow($('#' + menuid), $('#' + buttonid));
                        }
                    });
                }
            }

            function resizeMenu(menuid, buttonid) {
                var $ww = document.body.clientWidth;

                // Add mobile class to elements for CSS use
                // instead of relying on media-query support
                if ($ww > settings.width || !settings.responsive) {
                    $('#' + menuid).removeClass('mobile');
                    $('#' + buttonid).removeClass('mobile');
                } else {
                    $('#' + menuid).addClass('mobile');
                    $('#' + buttonid).addClass('mobile');
                }

                var $headers = $('#' + menuid + '>ul').find('ul').parent();

                $headers.each(function (i) {
                    var $curobj = $(this);
                    var $link = $curobj.children('a:eq(0)');
                    var $subul = $curobj.find('ul:eq(0)');

                    // Unbind events
                    $curobj.unbind('mouseenter mouseleave');
                    $link.unbind('click');
                    animateHide($curobj.children('ul:eq(0)'));

                    if ($ww > settings.width || !settings.responsive) {
                        // Full menu
                        $curobj.hover(function (e) {
                                var $targetul = $(this).children('ul:eq(0)');

                                var $dims = {
                                    w: this.offsetWidth,
                                    h: this.offsetHeight,
                                    subulw: $subul.outerWidth(),
                                    subulh: $subul.outerHeight()
                                };
                                var $istopheader = $curobj.parents('ul').length == 1 ? true : false;
                                $subul.css($istopheader ? {} : {top: 0});
                                var $offsets = {
                                    left: $(this).offset().left,
                                    top: $(this).offset().top
                                };
                                var $menuleft = $istopheader ? 0 : $dims.w;
                                $menuleft = ($offsets.left + $menuleft + $dims.subulw > $(window).width()) ? ($istopheader ? -$dims.subulw + $dims.w : -$dims.w) : $menuleft;
                                $targetul.css({
                                    left: $menuleft + 'px',
                                    width: $dims.subulw + 'px'
                                });

                                animateShow($targetul);
                            },
                            function (e) {
                                var $targetul = $(this).children('ul:eq(0)');
                                animateHide($targetul);
                            });
                    } else {
                        // Compact menu
                        $link.click(function (e) {
                            e.preventDefault();

                            var $targetul = $curobj.children('ul:eq(0)');
                            if (isSelected($curobj)) {
                                collapseChildren($targetul);
                                animateHide($targetul);
                            } else {
                                //collapseSiblings($curobj);
                                animateShow($targetul);
                            }
                        });
                    }
                });

                collapseChildren('#' + menuid);

                if (settings.responsive && isSelected($('#' + buttonid))) {
                    //collapseChildren('#'+menuid);
                    $('#' + menuid).hide();
                    $('#' + menuid).removeAttr('style');
                    $('#' + buttonid).removeClass(settings.selected);
                }
            }

            function collapseChildren(elementid) {
                // Closes all submenus of the specified element
                var $headers = $(elementid).find('ul');
                $headers.each(function (i) {
                    if (isSelected($(this).parent())) {
                        animateHide($(this));
                    }
                });
            }

            function collapseSiblings(element) {
                var $siblings = element.siblings('li');
                $siblings.each(function (i) {
                    collapseChildren($(this));
                });
            }

            function isSelected(element) {
                return element.hasClass(settings.selected);
            }

            function animateShow(menu, button) {
                if (!button) {
                    var button = menu.parent();
                }

                button.addClass(settings.selected);

                if (settings.animation.effect == 'fade') {
                    menu.fadeIn(settings.animation.show);
                } else if (settings.animation.effect == 'slide') {
                    menu.slideDown(settings.animation.show);
                } else {
                    menu.show();
                    menu.removeClass('hide');
                }
            }

            function animateHide(menu, button) {
                if (!button) {
                    var button = menu.parent();
                }

                if (settings.animation.effect == 'fade') {
                    menu.fadeOut(settings.animation.hide, function () {
                        menu.removeAttr('style');
                        button.removeClass(settings.selected);
                    });
                } else if (settings.animation.effect == 'slide') {
                    menu.slideUp(settings.animation.hide, function () {
                        menu.removeAttr('style');
                        button.removeClass(settings.selected);
                    });
                } else {
                    menu.hide();
                    menu.addClass('hide');
                    menu.removeAttr('style');
                    button.removeClass(settings.selected);
                }
            }
        };
    });

    jQuery(function ($) {
        $('#primary-nav').responsivenav();
        $('#top-nav').responsivenav({responsive: false});
    });

});
