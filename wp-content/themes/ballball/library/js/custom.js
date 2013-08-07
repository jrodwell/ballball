var $j = jQuery;

var fixes = function () {
	$j('.livematch').each(function() {
		if($j('.match-time abbr').text() == 'HT') {
			$j(this).addClass('halfTime');
		}
		else if($j('.match-score-divider').text() == 'v.') {
			$j(this).addClass('notLive');
		}
		else {
			$j(this).addClass('live');
		}
	});
	/* Hide Fixtures */
	$j('.opta-widget-container h2').each(function() {
		$j(this).remove();
	});
	/* Hide date */
	$j('.opta-widget-container h4').each(function() {
		$j(this).remove();
	});
},
_optaParams = {
	custID: '0901705c87db7592177aacda260075cb',
	lang: 'en_GB',
	timezone: 0,
	callbacks: [fixes]
};