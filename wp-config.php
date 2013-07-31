<?php
# Database Configuration
define('DB_NAME','wp_ballball');
define('DB_USER','ballball');
define('DB_PASSWORD','RlebinOeHxk14FdXMkTN');
define('DB_HOST','127.0.0.1');
define('DB_HOST_SLAVE','localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'wp_';

# Security Salts, Keys, Etc
define('AUTH_KEY',         'ibmIl*xq]L$a>Cx:`t+Iq#`07,m-]J<,bIx`(?{<`]YCdth|9!{*$3a|sjL!k1~t');
define('SECURE_AUTH_KEY',  'EmyD#F!NA$`7kX<|%eyL#JxX43bx>{P6=M)R{_zNT112GT+{1DtdQB`egUhh$Mda');
define('LOGGED_IN_KEY',    'Q~p4Dz+U*1O,/f@4#Wzc9Lrtq]du?+!,+zw--df)d>H2[4i_ZS!}}x Fn<!d]p>^');
define('NONCE_KEY',        '.)W^@]CF+&4jEOK9pfiVLbG~{$ g<-&Bjgm]+oPx*-%ujh>mNH`!JG|Ly +_~)xJ');
define('AUTH_SALT',        'hXM!LA:M[<Cbrrlp)jVAA-v~AF=p9!+D1qcfy8Gd iY>3Sz(y1]RNtdMc5)8Ey|#');
define('SECURE_AUTH_SALT', 'x/G[4Ue|Kz((gbRj S}//UF` C:dm<Fo+_G-HC7}v OhD1v$j0ey|=S$jkm3*?h/');
define('LOGGED_IN_SALT',   '8wrp&_I,Z*In5<n l6KW)T^{&XdOP|sA12yL1$#NRhg|#K.$,d>b#jQ{X=f];qZt');
define('NONCE_SALT',       'A+j <nTN3+Ip:y6-xoJ1={)W7ls0Av44R}%#]~7%qgYo$o)[bpy2wWb6$h)XuCaP');


# Localized Language Stuff

define('WP_CACHE',TRUE);

define('PWP_NAME','ballball');

define('FS_METHOD','direct');

define('FS_CHMOD_DIR',0775);

define('FS_CHMOD_FILE',0664);

define('PWP_ROOT_DIR','/nas/wp');

define('WPE_APIKEY','d177760f0bdd67b35ecaedb77e4c184d5740d4c9');

define('WPE_FOOTER_HTML',"");

define('WPE_CLUSTER_ID','8058');

define('WPE_CLUSTER_TYPE','pod');

define('WPE_ISP',true);

define('WPE_BPOD',false);

define('WPE_RO_FILESYSTEM',false);

define('WPE_LARGEFS_BUCKET','largefs.wpengine');

define('WPE_CDN_DISABLE_ALLOWED',true);

define('DISALLOW_FILE_EDIT',FALSE);

define('DISALLOW_FILE_MODS',FALSE);

define('DISABLE_WP_CRON',false);

define('WPE_FORCE_SSL_LOGIN',false);

define('FORCE_SSL_LOGIN',false);

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define('WPE_EXTERNAL_URL',false);

define('WP_POST_REVISIONS',FALSE);

define('WPE_WHITELABEL','wpengine');

define('WP_TURN_OFF_ADMIN_BAR',false);

define('WPE_BETA_TESTER',false);

umask(0002);

$wpe_cdn_uris=array ();

$wpe_no_cdn_uris=array ();

$wpe_content_regexs=array ();

$wpe_all_domains=array (  0 => 'ballball.wpengine.com',);

$wpe_varnish_servers=array (  0 => 'pod-8058',);

$wpe_ec_servers=array ();

$wpe_largefs=array ();

$wpe_netdna_domains=array ();

$wpe_netdna_push_domains=array ();

$wpe_domain_mappings=array ();

$memcached_servers=array (  'default' =>   array (    0 => 'unix:///tmp/memcached.sock',  ),);
define('WPLANG','');

# WP Engine ID


# WP Engine Settings






# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-settings.php');

$_wpe_preamble_path = null; if(false){}

# J.R. Custom Settings

define('WP_DEBUG', true);
