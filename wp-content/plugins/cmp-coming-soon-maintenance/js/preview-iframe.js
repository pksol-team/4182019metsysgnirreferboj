
$( document ).ready(function() {
	var timeout;
	var slug;
	var autoslide;
	if ( typeof ga === 'undefined' ) {
		ga = function() {
			return false;
		}
	}

	const defaultBackground = {
		"construct" : '1',
		"countdown" : '6',
		"hardwork" : '1',
		"agency" : '1',
		"apollo" : '1',
		"eclipse" : '1',
		"element" : '1',
		"fifty" : '1',
		"frame" : '1',
		"hardwork_premium" : '1',
		"mercury" : '1',
		"orbit" : '1',
		"postery" : '1',
		"stylo" : '1',
		"vega" : '1',
		"juno" : '1',
		"pluto" : '4'
	}

	slider(defaultBackground);

	$('iframe').one('load', function() {
	    $('body').addClass('loaded');
	});

	$('iframe').on('load', function() {
	    // resizeIframe(this);
	    $(this).addClass('loaded');
	});

	$('.panel-wrapper').click(function(e){
		e.preventDefault();
		ga('send', 'event', 'Close or Open Selector', 'Close or Open Selector');
		$('body').toggleClass('open');
	});

	
	$('.theme-customizer a').click(function(e){
		e.preventDefault();
		var new_url = $(this).attr('href');
		iframe_url = new_url.replace('&selector=true', '');

		var param = $(this).data('param');
		var old_value = getUrlParameter(param);
		var new_value = $(this).data(param);

		$('#theme-preview').removeClass('loaded');

		$(this).siblings().removeClass('selected');
		$(this).addClass('selected');

		ga('send', 'event', 'Change ' + param, 'Change '+ param +' to: ' + new_value);

		// // reload iframe and change browser URL history
		$('#theme-preview').attr('src', iframe_url);

		ChangeUrl(new_url, new_url);

		// change customizers href src to new params
		$('.settings-section:not(.'+ param +') a').each(function(){
			var old_href = $(this).attr('href');
			if ( param != '' ) {
				var new_href = old_href.replace( param + '=' + old_value, param + '=' + new_value );
			} else {
				var new_href = old_href + '&'+ param + '=' + new_value;
			}
			$(this).attr('href', new_href)
		});

	});

	function resizeIframe(obj) {
		obj.style.height = 0;
		obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
	}
	
	function ChangeUrl(page, url) {
		if (typeof (window.parent.history.pushState) != "undefined") {
			var obj = { Page: page, Url: url };
			window.parent.history.pushState(obj, obj.Page, obj.Url);
		} else {
			return;
		}
	}
	
	function slider(defaultBackground) {
		var slideCount = $('#slider ul li').length;
		var slideWidth = $('#slider ul li').width();
		var slideHeight = 200;
		var sliderUlWidth = slideCount * slideWidth;
		
		$('#slider').css({ width: slideWidth, height: slideHeight });
		
		$('#slider ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });
		
		$('#slider ul li:last-child').prependTo('#slider ul');
	
		function moveLeft() {
			$('#slider ul').animate({
				left: + slideWidth
			}, 200, function () {
				$('#slider ul li:last-child').prependTo('#slider ul');
				$('#slider ul').css('left', '');
				changeSlide();
			});
		};
	
		function moveRight() {
			$('#slider ul').animate({
				left: - slideWidth
			}, 200, function () {
				$('#slider ul li:first-child').appendTo('#slider ul');
				$('#slider ul').css('left', '');
				changeSlide();
			});
		};
	
		function changeSlide() {
			var title 		= $('#slider ul li:nth-child(2)').data('title');
			var position 	= $('#slider ul li:nth-child(2)').data('position');
			var slug 		= $('#slider ul li:nth-child(2)').data('slug');
			var currentSubmitUrl = $('#submit-change').attr('href');
			var currentSlug = getUrlStringParameter('theme', currentSubmitUrl);
			var currentBckgr = getUrlStringParameter('background', currentSubmitUrl);
			var newSubmitUrl = '';
	
			$('.theme-title').text(title);
			$('.theme-count').text(position);
	
			newSubmitUrl = currentSubmitUrl.replace('theme=' + currentSlug, 'theme=' + slug);
			newSubmitUrl = newSubmitUrl.replace('background=' + currentBckgr, 'background=' + defaultBackground[slug]);
	
			// change submit button theme attr in href
			$('#submit-change').attr('href', newSubmitUrl);
		}
	
		$('a.control_prev').click(function (e) {
			e.preventDefault();
			moveLeft();
			clearTimeout(autoslide);
		});
	
		$('a.control_next').click(function (e) {
			e.preventDefault();
			moveRight();
			clearTimeout(autoslide);
		});
	
		autoslide = setInterval(function () {
			moveRight();
		}, 7000);
	}
	
	$('#submit-change').click(function (e) {
		e.preventDefault();
		var newUrl = $(this).attr('href');
		var newSlug = getUrlStringParameter('theme', newUrl);
		var newBckgr = getUrlStringParameter('background', newUrl);
		var premiumThemes = $('.buy-theme').data('premium');
		var customize = $(this).data('customize');
		clearTimeout(autoslide);
		// get buy url
		for (var i = 0, len = premiumThemes.length; i < len; i++) {
			if ( premiumThemes[i].name === newSlug) {
				var buyUrl = premiumThemes[i].url;
				break;
			}
		}
	
		// get customize sections supported
		for (var i = 0, len = customize.length; i < len; i++) {
			if ( customize[i].theme === newSlug) {
				var section = customize[i].section;
				break;
			}
		}
	
		$('.settings-section').removeClass('zoomIn').addClass('zoomOut');
	
		$.each(section, function( index, value ) {
			$('.settings-section.' + value ).removeClass('zoomOut').removeClass('not-active').addClass('zoomIn');
			
		});
	
		// change browser url history
		ChangeUrl(newUrl, newUrl);
	
		// change customizers href src to new theme
		$('.settings-section a').each(function(){
			const oldUrl = $(this).attr('href');
			const currentSlug = getUrlStringParameter('theme', oldUrl);
			const new_href = oldUrl.replace( 'theme=' + currentSlug, 'theme=' + newSlug );
			$(this).attr('href', new_href);
		});

		$('.settings-section.effect a').each(function(){
			const oldUrl = $(this).attr('href');
			const currentBckgr = getUrlStringParameter('background', oldUrl);
			const new_href = oldUrl.replace( 'background=' + currentBckgr, 'background=' + newBckgr );
			$(this).attr('href', new_href);
		});
	
		// change select preview button url
		$('#theme-preview').attr('src', $(this).attr('href').replace('&selector=true', ''));
	
		$('.settings-section.background a').removeClass('selected');

		$('.settings-section.background a[data-background="'+ defaultBackground[newSlug] +'"]').addClass('selected');
	
		$('.buy-theme').attr('href', buyUrl);
	
		ga('send', 'event', 'Change Theme', 'Change Theme to: ' + newSlug);
	});
	
	
	var getUrlParameter = function getUrlParameter(sParam) {
		var sPageURL = window.location.search.substring(1),
			sURLVariables = sPageURL.split('&'),
			sParameterName,
			i;
	
		for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');
	
			if (sParameterName[0] === sParam) {
				return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
			}
		}
	};
	
	var getUrlStringParameter = function getUrlStringParameter(sParam, urlString) {
		var sPageURL = urlString.substring(1),
			sURLVariables = sPageURL.split('&'),
			sParameterName,
			i;
	
		for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');
	
			if (sParameterName[0] === sParam) {
				return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
			}
		}
	};
	

});

