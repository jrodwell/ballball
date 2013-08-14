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

	jQuery('#promoted > .promoted-item-small').click(function() {
		var current = jQuery(this);
		var currentString = current.attr('id');
		var targetString =  currentString.replace('small','large');
		var target = jQuery('#' + targetString);
		
		if(!target.hasClass('active')){
			jQuery('#promoted > .promoted-item-large').hide().removeClass('active');
			target.addClass('active').show();
			jQuery('#promoted > .promoted-item-small').removeClass('active');
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

		if (jQuery("body").hasClass("home")) {
			jQuery('.match').each(function () {
				if (jQuery(this).find('a.external-link').length > 0) {
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

	$('nav li:has(ul)').addClass('has-children'); //doubleTapToGo()

	$('nav li.is-parent').on('touchstart click', function(e) {
		e.preventDefault();
		$(this).find('> .sub-menu').slideToggle();
		$(this).toggleClass('active');
	});

	
	
}); /* end of as page load scripts */


/*A fix for the iOS orientationchange zoom bug.*/(function(a){function m(){d.setAttribute("content",g),h=!0}function n(){d.setAttribute("content",f),h=!1}function o(b){l=b.accelerationIncludingGravity,i=Math.abs(l.x),j=Math.abs(l.y),k=Math.abs(l.z),(!a.orientation||a.orientation===180)&&(i>7||(k>6&&j<8||k<8&&j>6)&&i>5)?h&&n():h||m()}var b=navigator.userAgent;if(!(/iPhone|iPad|iPod/.test(navigator.platform)&&/OS [1-5]_[0-9_]* like Mac OS X/i.test(b)&&b.indexOf("AppleWebKit")>-1))return;var c=a.document;if(!c.querySelector)return;var d=c.querySelector("meta[name=viewport]"),e=d&&d.getAttribute("content"),f=e+",maximum-scale=1",g=e+",maximum-scale=10",h=!0,i,j,k,l;if(!d)return;a.addEventListener("orientationchange",m,!1),a.addEventListener("devicemotion",o,!1)})(this);

/*
	doubleTapToGo
    AUTHOR: Osvaldas Valutis, www.osvaldas.info
*/
;(function($,window,document,undefined){$.fn.doubleTapToGo=function(params){if(!('ontouchstart'in window)&&!navigator.msMaxTouchPoints&&!navigator.userAgent.toLowerCase().match(/windows phone os 7/i))return false;this.each(function(){var curItem=false;$(this).on('click',function(e){var item=$(this);if(item[0]!=curItem[0]){e.preventDefault();curItem=item}});$(document).on('click touchstart MSPointerDown',function(e){var resetItem=true,parents=$(e.target).parents();for(var i=0;i<parents.length;i++)if(parents[i]==curItem[0])resetItem=false;if(resetItem)curItem=false})});return this}})(jQuery,window,document);
