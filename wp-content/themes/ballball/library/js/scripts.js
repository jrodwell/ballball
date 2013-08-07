// as the page loads, call these scripts
jQuery(document).ready(function($) {

	var $j = jQuery;
	
	/* Live matches menu */
	$j('#live-league-0').addClass('active');
	$j('#menu-league-0').addClass('active');

	$j('#live-league-menu > .league-menu-item').click(function() {
		var current = $j(this);
		var currentString = current.attr('id');
		var targetString =  currentString.replace('menu-league-','live-league-');
		var target = $j('#' + targetString);
		
		if(!target.hasClass('active')){
			$j('#widgetOutput > .live-league').hide().removeClass('active').slideUp();
			target.addClass('active').slideDown();
			$j('#live-league-menu > .league-menu-item').removeClass('active');
			current.addClass('active');
		}
	});
	
	/* Promo box */
	
	

	/* Opta calls and callbacks */
	var fixes = function () {
		var $j = jQuery;
		
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
		
		var matches_a = {
			  "694472" : "1-fc-saarbrucken-v-sv-werder-bremen"  ,
              "694491" : "bfc-dynamo-v-vfb-stuttgart"  ,
              "694487" : "dsc-arminia-bielefeld-v-eintracht-braunschweig"  ,
              "694477" : "fsv-optik-rathenow-v-fsv-frankfurt-1899"  ,
              "694475" : "fv-illertissen-v-eintracht-frankfurt"  ,
              "694486" : "sc-preusen-munster-v-fc-st-pauli"  ,
              "694495" : "sc-victoria-hamburg-v-hannover-96"  ,
              "694474" : "sc-wiedenbruck-2000-v-fortuna-dusseldorf"  ,
              "694479" : "sv-darmstadt-98-v-borussia-monchengladbach"  ,
              "694493" : "sv-sandhausen-v-1-fc-nurnberg"  ,
              "694470" : "sv-schott-jena-v-hamburger-sv"  ,
              "488715" : "team-1-vs-team-2"  ,
              "694469" : "tsg-pfeddersheim-v-spvgg-greuther-furth"  ,
              "694500" : "vfr-neumunster-v-hertha-bsc"  
		};
		var matches_b = [ { "o":"694472" , "m":"1-fc-saarbrucken-v-sv-werder-bremen" }, { "o":"694491" , "m":"bfc-dynamo-v-vfb-stuttgart" }, { "o":"694487" , "m":"dsc-arminia-bielefeld-v-eintracht-braunschweig" }, { "o":"694477" , "m":"fsv-optik-rathenow-v-fsv-frankfurt-1899" }, { "o":"694475" , "m":"fv-illertissen-v-eintracht-frankfurt" }, { "o":"694486" , "m":"sc-preusen-munster-v-fc-st-pauli" }, { "o":"694495" , "m":"sc-victoria-hamburg-v-hannover-96" }, { "o":"694474" , "m":"sc-wiedenbruck-2000-v-fortuna-dusseldorf" }, { "o":"694479" , "m":"sv-darmstadt-98-v-borussia-monchengladbach" }, { "o":"694493" , "m":"sv-sandhausen-v-1-fc-nurnberg" }, { "o":"694470" , "m":"sv-schott-jena-v-hamburger-sv" }, { "o":"488715" , "m":"team-1-vs-team-2" }, { "o":"694469" , "m":"tsg-pfeddersheim-v-spvgg-greuther-furth" }, { "o":"694500" , "m":"vfr-neumunster-v-hertha-bsc" }, ];
		var $j = jQuery;
		var base_url = 'http://example.com/match-page.php?match=';

		$j('.match').each(function () {
			var optaID = $j(this).find('a.external-link').attr('href').split('match=')[1];
			var match_links = $j.parseJSON(matches_b);
			var final_url = base_url + match_links[optaID[1]];
			console.log(final_url);
			
			/*
			alert(optaID);

			var final_url = base_url + matches_a[optaID[1]];
						
			

			$j(this).append('<span><a href=' + final_url + '>Info</a></span>');*/
			
			/*var hrefBits = $(this).attr('href').split('match='),
			href = url + linksTable[hrefBits[1]];
			
			$(this).attr('href', href);*/
		});
	};
	
	_optaParams = {
		custID: '0901705c87db7592177aacda260075cb',
		lang: 'en_GB',
		timezone: 0,
		callbacks: [fixes]
	};
	
}); /* end of as page load scripts */


/*! A fix for the iOS orientationchange zoom bug.
 Script by @scottjehl, rebound by @wilto.
 MIT License.
*/
(function(w){
	// This fix addresses an iOS bug, so return early if the UA claims it's something else.
	if( !( /iPhone|iPad|iPod/.test( navigator.platform ) && navigator.userAgent.indexOf( "AppleWebKit" ) > -1 ) ){ return; }
    var doc = w.document;
    if( !doc.querySelector ){ return; }
    var meta = doc.querySelector( "meta[name=viewport]" ),
        initialContent = meta && meta.getAttribute( "content" ),
        disabledZoom = initialContent + ",maximum-scale=1",
        enabledZoom = initialContent + ",maximum-scale=10",
        enabled = true,
		x, y, z, aig;
    if( !meta ){ return; }
    function restoreZoom(){
        meta.setAttribute( "content", enabledZoom );
        enabled = true; }
    function disableZoom(){
        meta.setAttribute( "content", disabledZoom );
        enabled = false; }
    function checkTilt( e ){
		aig = e.accelerationIncludingGravity;
		x = Math.abs( aig.x );
		y = Math.abs( aig.y );
		z = Math.abs( aig.z );
		// If portrait orientation and in one of the danger zones
        if( !w.orientation && ( x > 7 || ( ( z > 6 && y < 8 || z < 8 && y > 6 ) && x > 5 ) ) ){
			if( enabled ){ disableZoom(); } }
		else if( !enabled ){ restoreZoom(); } }
	w.addEventListener( "orientationchange", restoreZoom, false );
	w.addEventListener( "devicemotion", checkTilt, false );
})( this );