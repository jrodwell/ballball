// IE8 ployfill for GetComputed Style (for Responsive Script below)
if (!window.getComputedStyle) {
    window.getComputedStyle = function(el, pseudo) {
        this.el = el;
        this.getPropertyValue = function(prop) {
            var re = /(\-([a-z]){1})/g;
            if (prop == 'float') prop = 'styleFloat';
            if (re.test(prop)) {
                prop = prop.replace(re, function () {
                    return arguments[2].toUpperCase();
                });
            }
            return el.currentStyle[prop] ? el.currentStyle[prop] : null;
        }
        return this;
    }
}

/* Match link replacement */
if (language_code != 'en') {
	var base_url = '/' + language_code + '/match/';
}
else {
	var base_url = '/match/';
}

/* Navigation */
function navigationExpand () {
	jQuery(this).toggleClass('expanded');
}

/* Live matches */
function liveMatchesToggle() {
	jQuery('#widgetOutput').slideToggle('slow');
	jQuery('.total-match-count > span').toggleClass('toggled');
}

// as the page loads, call these scripts
jQuery(document).ready(function($) {
	
	/* Navigation */
	jQuery('.home-link-menu-container').click(navigationExpand);
	
	/* Live matches menu */
	jQuery('.total-match-count').append('<span>&nbsp;</span>');
	jQuery('.total-match-count > span').click(liveMatchesToggle);
	
	jQuery('#live-league-0').addClass('active');
	jQuery('#menu-league-0').addClass('active');

	jQuery('#live-league-menu > .league-menu-item').click(function() {
		var current = jQuery(this);
		var currentString = current.attr('id');
		var targetString =  currentString.replace('menu-league-','live-league-');
		var target = jQuery('#' + targetString);
		
		if(!target.hasClass('active')){
			jQuery('#widgetOutput > .live-league').hide().addClass('notActive').removeClass('active').slideUp();
			target.removeClass('notActive').addClass('active').slideDown();
			jQuery('#live-league-menu > .league-menu-item').removeClass('active');
			current.addClass('active');
		}
	});
	
	/* Promo box mob */
	
	/* Promo box desktop */
	jQuery('#promoted-item-large-1').addClass('active');
	jQuery('#promoted-item-small-1').addClass('active');

	jQuery('#promoted .promoted-item-small').click(function() {
		var current = jQuery(this);
		var currentString = current.attr('id');
		var targetString =  currentString.replace('small','large');
		var target = jQuery('#' + targetString);
		
		if(!target.hasClass('active')){
			jQuery('#promoted .promoted-item-large').hide().removeClass('active');
			target.addClass('active').show();
			jQuery('#promoted .promoted-item-small').removeClass('active');
			current.addClass('active');
		}
	});

	/* League page tabs */
	jQuery('#latest-tab').addClass('active');
	jQuery('#latest-viewport').addClass('active');

	jQuery('#tab-controls > div').click(function() {
		var current = jQuery(this);
		var currentString = current.attr('id');
		var targetString =  currentString.replace('tab','viewport');
		var target = jQuery('#' + targetString);
		
		if(!target.hasClass('active')){
			jQuery('#tab-viewports > .viewport').hide().removeClass('active');
			target.addClass('active').show();
			jQuery('#tab-controls > .tab').removeClass('active');
			current.addClass('active');
		}
	});
	/* Opta calls and callbacks */
	var fixes = function () {
		/* extra styling */
		jQuery('.livematch').each(function() {
			if(jQuery(this).find('.match-time abbr').text() == 'HT') {
				jQuery(this).addClass('halfTime');
			}
			else if(jQuery(this).find('.match-score-divider').text() == 'v.') {
				jQuery(this).addClass('notLive');
			}
			else {
				jQuery(this).addClass('live');
			}
		});
		
		/* link change */

		if (jQuery("body").is('.tax-league, .home')) {
			jQuery('.match').each(function () {
				if ((jQuery(this).find('a.external-link').length > 0) && (array_matches.length > 0)) {
					var optaID = jQuery(this).find('a.external-link').attr('href').split('match=')[1];
					var found = jQuery.map(array_matches, function(item) {
						if (item.o.indexOf(optaID) >= 0) {
							return item;
						}
					});
					if (found.length > 0) {
						var final_url = base_url + found[0].m;
						jQuery(this).find('a.external-link').contents().unwrap();
						jQuery(this).append('<span class="matchDetails"><a href=' + final_url + '><span>Match Details</span></a></span>');
						jQuery(this).removeClass('match').addClass('linked-match');
					}
					else {
						jQuery(this).find('a.external-link').contents().unwrap();
						jQuery(this).append('<span class="matchDetails">&nbsp;</span>');
						jQuery(this).removeClass('match').addClass('unlinked-match');
					}
				}
				else {
					jQuery(this).append('<span class="matchDetails">&nbsp;</span>');
					jQuery(this).removeClass('match').addClass('unlinked-match');
				}
			});
		};
	};
	
	/* set timezone */
	var local_offset = new Date().getTimezoneOffset()/-60;
	var final_offset = local_offset - wordpress_offset;
	
	_optaParams = {
		custID: '0901705c87db7592177aacda260075cb',
		lang: 'en_GB',
		timezone: final_offset,
		callbacks: [fixes]
	};

	$('li:last-child').addClass('last');

	//doubleTapToGo()
	$('.header nav li:has(ul)').addClass('has-children').find('> a').on('touchstart click', function(e) {
		if(jQuery.browser.mobile || $(window).width() < 700) {
			e.preventDefault();
			$(this).toggleClass('active').next('.sub-menu').slideToggle();
		}
	});

}); /* end of as page load scripts */


/*A fix for the iOS orientationchange zoom bug.*/(function(a){function m(){d.setAttribute("content",g),h=!0}function n(){d.setAttribute("content",f),h=!1}function o(b){l=b.accelerationIncludingGravity,i=Math.abs(l.x),j=Math.abs(l.y),k=Math.abs(l.z),(!a.orientation||a.orientation===180)&&(i>7||(k>6&&j<8||k<8&&j>6)&&i>5)?h&&n():h||m()}var b=navigator.userAgent;if(!(/iPhone|iPad|iPod/.test(navigator.platform)&&/OS [1-5]_[0-9_]* like Mac OS X/i.test(b)&&b.indexOf("AppleWebKit")>-1))return;var c=a.document;if(!c.querySelector)return;var d=c.querySelector("meta[name=viewport]"),e=d&&d.getAttribute("content"),f=e+",maximum-scale=1",g=e+",maximum-scale=10",h=!0,i,j,k,l;if(!d)return;a.addEventListener("orientationchange",m,!1),a.addEventListener("devicemotion",o,!1)})(this);

/*
	doubleTapToGo
    AUTHOR: Osvaldas Valutis, www.osvaldas.info
*/
;(function($,window,document,undefined){$.fn.doubleTapToGo=function(params){if(!('ontouchstart'in window)&&!navigator.msMaxTouchPoints&&!navigator.userAgent.toLowerCase().match(/windows phone os 7/i))return false;this.each(function(){var curItem=false;$(this).on('click',function(e){var item=$(this);if(item[0]!=curItem[0]){e.preventDefault();curItem=item}});$(document).on('click touchstart MSPointerDown',function(e){var resetItem=true,parents=$(e.target).parents();for(var i=0;i<parents.length;i++)if(parents[i]==curItem[0])resetItem=false;if(resetItem)curItem=false})});return this}})(jQuery,window,document);

/**
 * jQuery.browser.mobile (http://detectmobilebrowser.com/)
 * jQuery.browser.mobile will be true if the browser is a mobile device
 **/
(function(a){jQuery.browser.mobile=/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))})(navigator.userAgent||navigator.vendor||window.opera);