	var $wrap,$header,$gnb,$btnGnb,$lnb;
	var $common
$(document).ready(function(){
	$wrap = $('#wrap');
	$header = $('#header');
	$gnb = $('#gnb');
	$btnGnb = $('#btnGnb');
	$lnb = $('#lnb');
	$('body').append('<div id="tabletCheck"></div>');
	$('body').append('<div id="lnbMask"></div>');
	headerFix();//상단 메뉴 고정
	$(window).scroll(headerFix);//상단 메뉴 고정
	$('#btnGnb').click(function(){//LNB 활성화
		//lnbActive();
		var lnbWidth = $('#lnb').outerWidth();
		if ($('#tabletCheck').css('display') == 'block') {//태블릿일 경우
			if ($lnb.css('left') == '0px'){
				$lnb.animate({left:-lnbWidth});
				$wrap.animate({paddingLeft:0});
				if ($header.hasClass('headerFix')){
					$gnb.animate({paddingLeft:48});
					$btnGnb.animate({left:0});
				}
			} else {
				$lnb.animate({left:'0px'});
				$wrap.animate({paddingLeft:lnbWidth});
				if ($header.hasClass('headerFix')){
					$gnb.animate({paddingLeft:lnbWidth + 48});
					$btnGnb.animate({left:lnbWidth});
				}
			}
		} else {//모바일일 경우
			$lnb.animate({left:0});
			$('#lnbMask').fadeTo(500,0.7);
			$(window).off('scroll');
			$('body').attr( 'data-pos', $(window).scrollTop());//get actual scrollpos
			$('body').addClass('hidden');// add class to body
			$('#wrap').scrollTop($('body').attr('data-pos'));//let wrapper scroll to scrollpos
		}
	});

	$('#lnbClose, #lnbMask').click(function(){//LNB 클로즈
		var lnbWidth = $('#lnb').outerWidth();
		$lnb.animate({left:-lnbWidth});
		$('#lnbMask').fadeOut(500);
		$(window).on('scroll', function(){
			headerFix();
		});
		$("body").removeClass('hidden');
		$( window ).scrollTop( $('body').attr( 'data-pos' ));
	});

	/* 모바일 태블릿 화면 움직일시 */
	$(window).resize(function(){
		var lnbWidth = $('#lnb').outerWidth();
		if ($('#tabletCheck').css('display') == 'block') {//태블릿일 경우
			$lnb.css('left','0px');
			$wrap.css('padding-left',lnbWidth);
			if ($('#header').hasClass('headerFix')){
				$('#gnb').css('padding-left','268px');
				$('#btnGnb').css('left','220px');
			} else {
				$('#gnb').css('padding-left','0px');
				$('#btnGnb').css('left','0px');
			}
		} else {//모바일일 경우
			$lnb.css('left',-lnbWidth);
			$('#lnbMask').hide();
			$("body").removeClass('hidden');
			$('#btnGnb').css('left','0');
			$('#wrap').css('padding-left','0px');
			if ($('#header').hasClass('headerFix')){
				$('#gnb').css('padding-left','48px');
			} else {
				$('#gnb').css('padding-left','0px');
			}
		}
	});
});

/* 상단 메뉴 고정*/
function headerFix(){
	if ($(window).scrollTop() >= 49){
		$header.addClass('headerFix');
	} else {
		$header.removeClass('headerFix');
	}
	if ($('#tabletCheck').css('display') == 'block'){//태블릿일 경우
		if ($lnb.css('left') == '0px'){
			if ($header.hasClass('headerFix')){
				$gnb.css('padding-left','268px');
				$btnGnb.css('left','220px');
			} else {
				$gnb.css('padding-left','0px');
				$btnGnb.css('left','0px');
			}
		}
		if ($lnb.css('left') == '-220px'){
			if ($header.hasClass('headerFix')){
				$gnb.css('padding-left','48px');
			} else {
				$gnb.css('padding-left','0px');
			}
		}
	} else {//모바일일 경우
		if ($header.hasClass('headerFix')){
			$gnb.css('padding-left','48px');
		} else {
			$gnb.css('padding-left','0px');
		}
	}
}
