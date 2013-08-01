var $j = jQuery;
var fixes = function () {
	$j('.livematch').each(function() {
		if($j('.livematch > .match-time > abbr').text() == 'HT') {
			$j(this).addClass('halfTime');
		}
		else if($j('.livematch > .match-score > match-score-divider').text() == 'v.') {
			$j(this).addClass('notLive');
		}
		else {
			$j(this).addClass('live');
		}
	});
	$j('h2').each(function() {
		$j(this).remove();
	});
	$j('h4').each(function() {
		$j(this).remove();
	});
},
_optaParams = {
	custID: '0901705c87db7592177aacda260075cb',
	lang: 'en_GB',
	callbacks: [fixes]
};
