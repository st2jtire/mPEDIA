	var $wrap, $header, $gnb, $btnGnb, $lnb;
	var $common
	$(document).ready(function () {
	    $wrap = $('#wrap');
	    $header = $('#header');
	    $gnb = $('#gnb');
	    $btnGnb = $('#btnGnb');
	    $lnb = $('#lnb');
	    $('body').append('<div id="tabletCheck"></div>');
	    $('body').append('<div id="lnbMask"></div>');
	    $('body').append('<div id="mask"></div>');
	    headerFix(); //상단 메뉴 고정
	    $(window).scroll(headerFix); //상단 메뉴 고정
	    $('#btnGnb').click(function () { //LNB 활성화
	        //lnbActive();
	        var lnbWidth = $('#lnb').outerWidth();
	        if ($('#tabletCheck').css('display') == 'block') { //태블릿일 경우
	            if ($lnb.css('left') == '0px') {
	                $lnb.animate({
	                    left: -lnbWidth
	                });
	                $wrap.animate({
	                    paddingLeft: 0
	                });
	                if ($header.hasClass('headerFix')) {
	                    $gnb.animate({
	                        paddingLeft: 48
	                    });
	                    $btnGnb.animate({
	                        left: 0
	                    });
	                }
	            } else {
	                $lnb.animate({
	                    left: '0px'
	                });
	                $wrap.animate({
	                    paddingLeft: lnbWidth
	                });
	                if ($header.hasClass('headerFix')) {
	                    $gnb.animate({
	                        paddingLeft: lnbWidth + 48
	                    });
	                    $btnGnb.animate({
	                        left: lnbWidth
	                    });
	                }
	            }
	        } else { //모바일일 경우
	            $lnb.animate({
	                left: 0
	            });
	            $('#lnbMask').fadeTo(500, 0.7);
	            $(window).off('scroll');
	            $('body').attr('data-pos', $(window).scrollTop()); //get actual scrollpos
	            $('body').addClass('hidden'); // add class to body
	            $('#wrap').scrollTop($('body').attr('data-pos')); //let wrapper scroll to scrollpos
	        }
	    });

	    $('#lnbClose, #lnbMask').click(function () { //LNB 클로즈
	        var lnbWidth = $('#lnb').outerWidth();
	        $lnb.animate({
	            left: -lnbWidth
	        });
	        $('#lnbMask').fadeOut(500);
	        $(window).on('scroll', function () {
	            headerFix();
	        });
	        $("body").removeClass('hidden');
	        $(window).scrollTop($('body').attr('data-pos'));
	    });

	    /* 모바일 태블릿 화면 움직일시 */
	    $(window).resize(function () {
	        var lnbWidth = $('#lnb').outerWidth();
	        if ($('#tabletCheck').css('display') == 'block') { //태블릿일 경우
	            $lnb.css('left', '0px');
	            $wrap.css('padding-left', lnbWidth);
	            if ($('#header').hasClass('headerFix')) {
	                $('#gnb').css('padding-left', '268px');
	                $('#btnGnb').css('left', '220px');
	            } else {
	                $('#gnb').css('padding-left', '0px');
	                $('#btnGnb').css('left', '0px');
	            }
	        } else { //모바일일 경우
	            $lnb.css('left', -lnbWidth);
	            $('#lnbMask').hide();
	            $("body").removeClass('hidden');
	            $('#btnGnb').css('left', '0');
	            $('#wrap').css('padding-left', '0px');
	            if ($('#header').hasClass('headerFix')) {
	                $('#gnb').css('padding-left', '48px');
	            } else {
	                $('#gnb').css('padding-left', '0px');
	            }
	        }
	    });

	    $('#popupOpenBtn').click(function () { //레이어 오픈
	        var href = $(this).attr("href");
	        layer(href);
	        return false;
	    });
	    $('#popupCloseBtn').click(function () { //레이어클로즈
	        var parents = $(this).parents('.layer')
	        layerClose(parents);
	    });
	});

	/* 상단 메뉴 고정*/
	function headerFix() {
	    if ($(window).scrollTop() >= 49) {
	        $header.addClass('headerFix');
	    } else {
	        $header.removeClass('headerFix');
	    }
	    if ($('#tabletCheck').css('display') == 'block') { //태블릿일 경우
	        if ($lnb.css('left') == '0px') {
	            if ($header.hasClass('headerFix')) {
	                $gnb.css('padding-left', '268px');
	                $btnGnb.css('left', '220px');
	            } else {
	                $gnb.css('padding-left', '0px');
	                $btnGnb.css('left', '0px');
	            }
	        }
	        if ($lnb.css('left') == '-220px') {
	            if ($header.hasClass('headerFix')) {
	                $gnb.css('padding-left', '48px');
	            } else {
	                $gnb.css('padding-left', '0px');
	            }
	        }
	    } else { //모바일일 경우
	        if ($header.hasClass('headerFix')) {
	            $gnb.css('padding-left', '48px');
	        } else {
	            $gnb.css('padding-left', '0px');
	        }
	    }
	}

	/* 레이어 오픈 */
	function layer(href) {
	    $('#mask').fadeTo(600, 0.6, function () {
	        $(href).fadeIn({
	            queue: false,
	            duration: 600
	        });
	        $(href).css('margin-top', '-50px');
	        $(href).animate({
	            marginTop: 30
	        }, 600);
	        $(href).animate({
	            marginTop: 0
	        }, 400);
	        if ($(href).hasClass('layerPopup')) {
	            layerCenter();
	            $('body').css('overflow', 'hidden');
	        }
	    });
	}

	/* 레이어센터 */
	function layerCenter() {
	    $('.layerPopup').each(function () {
	        var $this = $(this);
	        if ($(window).height() <= $this.find('.layerBox').height() + 30) {
	            $this.find('.layerInner').css('padding-top', 15);
	        } else {
	            $this.find('.layerInner').css('padding-top', $(window).height() / 2 - $this.find('.layerBox').height() / 2);
	        }
	        //}
	    });
	}

	/* 레이어 클로즈 */
	function layerClose(parents) {
	    $('#mask').fadeOut();
	    $('body').css('overflow', 'auto');
	    parents.fadeOut();
	}
