<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr"><head><title><?php echo $page_title; ?></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="webicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="webicon.ico" type="image/x-icon" />
<link href="<?php echo THEMES_WEB_ROOT_DIR; ?>default/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo THEMES_WEB_ROOT_DIR; ?>default/960.css" rel="stylesheet" type="text/css" />
<style>  
#floatdiv{
position:absolute;
padding: 2px;
background-color: lightwhite;
width: 40px;
z-index: 100;
}
.addthis_toolbox.atfixed {
    border: 1px solid #eee;
    padding: 5px 5px 1px;
    width: 32px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
}

.addthis_toolbox .custom_images a {
    width: 32px;
    height: 32px;
    margin: 0;
    padding: 0;
    cursor: pointer;
}
.addthis_toolbox .custom_images a img { border: 0; margin: 0 0 1px; opacity: 1.0; }
.addthis_toolbox .custom_images a:hover img { margin: 1px 0 0; opacity: 0.75; }
</style>
<script type="text/javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>floating-1.2.js"/></script>
<script type="text/javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>prototype.js"></script>
<script type="text/javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>form.js"></script>
<script type="text/javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>gui.js"></script>
<script type="text/javascript">  
     floatingMenu.add('floatdiv',  
         {  
             // Represents distance from left or right browser window  
             // border depending upon property used. Only one should be  
             // specified.  
             // targetLeft: 0,  
             targetRight: 10,  
   
             // Represents distance from top or bottom browser window  
             // border depending upon property used. Only one should be  
             // specified.  
             targetTop: 10,  
             // targetBottom: 0,  
   
             // Uncomment one of those if you need centering on  
             // X- or Y- axis.  
             // centerX: true,  
             // centerY: true,  
   
             // Remove this one if you don't want snap effect  
             snap: true  
         });  
</script>  
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-7207925-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script>
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: 'auto',
    gaTrack: true,
    gaId: 'UA-7207925-2'
  });
}
</script><script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script><?php echo $metadata; ?>
</head>
<body>
<div id="floatdiv">
<div class="addthis_toolbox atfixed">
<div class="custom_images">
        <a class="addthis_button_facebook"><img src="<? echo UCS_WEB_ROOT_DIR; ?>images/facebook32.png" alt="Share to Facebook" title="Share to Facebook" /></a>
        <a class="addthis_button_twitter"><img src="<? echo UCS_WEB_ROOT_DIR; ?>images/twitter32.png"  alt="Share to Twitter"  title="Share to Twitter" /></a>
        <a class="addthis_button_google"><img src="<? echo UCS_WEB_ROOT_DIR; ?>images/google32.png"  alt="Share to Google" title="Share to Google" /></a>
        <a class="addthis_button_blogger"><img src="<? echo UCS_WEB_ROOT_DIR; ?>images/blogspot32.png"  alt="Share to Blogger" title="Share to Blogger" /></a>
	<a class="addthis_button_wordpress"><img src="<? echo UCS_WEB_ROOT_DIR; ?>images/wordpress32.png"  alt="Share to Wordpress" title="Share to Wordpress" /></a>
        <a class="addthis_button_more"><img src="<? echo UCS_WEB_ROOT_DIR; ?>images/addthis_32.png" alt="More..." title="More..." /></a>    
</div>
</div>

<script type="text/javascript">var addthis_config = {"data_track_clickback":true};</script>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=blackwiz"></script>
</div>
<div class="container_12">

<!--application main menu-->
    <div class="grid_12 tabs" id="main-menu">
        <ul id="primary-links">
            <li><a class="menu" href="<?php echo UCS_WEB_ROOT_DIR; ?>"><span><?php echo __('Home'); ?></a></span></li>
           
                        <li><a class="menu" href="<?php echo $sysconf['baseurl']; ?>kami-about-about_us.html"><span>Tentang Kami</span></a></li>
			<li><a class="menu" href="<?php echo $sysconf['baseurl']; ?>gabung-join-join_with_us.html"><span>Cara Gabung</span></a></li>
			<li><a class="menu" href="<?php echo $sysconf['baseurl']; ?>kerjasama-cooperation-cooperation_with_us.html"><span>Kerja Sama</span></a></li>
                        <li><a class="menu" href="<?php echo $sysconf['baseurl']; ?>TnT-tips-tips_and_tricks.html"><span>Tips & Trik</span></a></li>
                        <li><a class="menu" href="<?php echo $sysconf['baseurl']; ?>member-anggota-membership.html"><span>Anggota PrimurLib</span></a></li>
                        <li><a class="menu" href="http://senayan.diknas.go.id" target="_blank"><span>SLiMS</span></a></li>
			<li><a class="menu" href="http://jogjalib.net" target="_blank"><span>JogjaLib.Net</span></a></li>
        </ul>
    </div>
	
    <!--header-->
    <div class="grid_12" id="header">
    <h1 id="app-title"><a href="index.php"><?php echo $sysconf['server']['name']; ?></a><div><?php echo $sysconf['server']['subname']; ?></div></h1>
    </div>
    <div class="clear">&nbsp;</div>
    <!--header end-->

 
 <div class="grid_12" id="gooads">
<fieldset id="simple-search">
        <div class="block-header"><?php echo __('Google Search'); ?>&nbsp;<form action="http://www.primurlib.net" id="cse-search-box">
  <div>
    <input type="hidden" name="cx" value="partner-pub-5549337631353789:y7lunfyw93f" />
    <input type="hidden" name="cof" value="FORID:10" />
    <input type="hidden" name="ie" value="ISO-8859-1" />
    <input type="text" name="q" size="100" />
    <input type="submit" name="sa" value="Search" />
  </div>
</form>
<script type="text/javascript" src="http://www.google.com/cse/brand?form=cse-search-box&amp;lang=en"></script>
</div>
                <script type="text/javascript"><!--
google_ad_client = "ca-pub-5549337631353789";
/* 468x15, created 3/9/11 */
google_ad_slot = "6135390977";
google_ad_width = 468;
google_ad_height = 15;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></fieldset>
<div class="grid_12" id="cse-search-results"></div>
<script type="text/javascript">
  var googleSearchIframeName = "cse-search-results";
  var googleSearchFormName = "cse-search-box";
  var googleSearchFrameWidth = 800;
  var googleSearchDomain = "www.google.com";
  var googleSearchPath = "/cse";
</script>
<script type="text/javascript" src="http://www.google.com/afsonline/show_afs_search.js"></script>
</div>

    <div class="clear">&nbsp;</div>
    <div class="spacer">&nbsp;</div>
    <!--application main menu end-->


    <!--application navigation menu/side menu-->
    <div class="grid_2" id="side-menu">
	<div class="block-side">	
		<div class="block-header">Contact Person</div>
			<table align="center" border="0">
			<tr><td align="center">Indra</td><td><a href="ymsgr:sendIM?primurlib"><img border=0 src="http://opi.yahoo.com/online?u=primurlib&amp;m=g&amp;t=1" /> </a></td></tr>
	                <tr><td align="center">Fahrus</td><td><a href="ymsgr:sendIM?f4ztr1k"><img border=0 src="http://opi.yahoo.com/online?u=f4ztr1k&amp;m=g&amp;t=1" /> </a></td></tr>	        
                        </table>
	</div>
	<div class="clear">&nbsp;</div>
    <div class="spacer">&nbsp;</div>
<div class="block-side">	
<div class="block-header">Random Cloud Tags</div>
				 <? mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD);
		mysql_select_db(DB_NAME);
		$q = mysql_query("SELECT topic FROM mst_topic WHERE length( topic ) < 20 and topic NOT LIKE '%''%' ORDER BY rand( ) LIMIT 20  ");
		
?> 

<script type="text/javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>tagcloud/swfobject.js"></script>
<div id="flashcontent"></div>
<script type="text/javascript">
var so = new SWFObject("<?php echo JS_WEB_ROOT_DIR; ?>tagcloud/tagcloud.swf", "tagcloud", "180", "180", "7", "#ffffff");
so.addParam("wmode", "transparent");
so.addVariable("tcolor", "0x0307bc");
so.addVariable("tcolor2", "0x138002");
so.addVariable("hicolor", "0xfb3f1a");
so.addVariable("mode", "tags");
so.addVariable("distr", "true");
so.addVariable("tspeed", "100");
so.addVariable("tagcloud", "<tags><? 
while ($tag = mysql_fetch_assoc($q)) {
$trans1 = array("'" => "", "`" => "", " " => "+","-" => "+");
$trans2 = array("'" => "`", "`" => "`", "-" => "");
$tagurl = strtr($tag['topic'],$trans1);
$tagview = strtr($tag['topic'],$trans2);
$bil = rand(10,18);
$url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?keywords='.$tagurl.'&search=Search';
$cloud = urlencode("<a href='".$url."' style='".$bil."'>".$tagview."</a>".$cloud);
echo $cloud; }?></tags>");
so.write("flashcontent");
</script>
</div>
                <div class="clear">&nbsp;</div>
    		<div class="spacer">&nbsp;</div>
			<div class="block-side">	
                
        <!-- language selection -->
        
            <div class="block-header"><?php echo __('Select Language'); ?></div>
            <form name="langSelect" action="index.php" method="get">
            <select name="select_lang" onchange="document.langSelect.submit();">
            <?php echo $language_select; ?>
            </select>
            </form>
        <!-- language selection end -->
			</div>
			<div class="clear">&nbsp;</div>
    		<div class="spacer">&nbsp;</div>
			<div class="block-side">
        <!-- advanced search -->
            <div class="block-header"><?php echo __('Advanced Search'); ?></div>
            <form name="advSearchForm" id="advSearchForm" action="index.php" method="get">
            <?php echo __('Title'); ?> :
            <input type="text" name="title" />
            <?php echo __('Author(s)'); ?> :
            <?php echo $advsearch_author; ?>
            <?php echo __('Subject(s)'); ?> :
            <?php echo $advsearch_topic; ?>
            <?php echo __('ISBN/ISSN'); ?> :
            <input type="text" name="isbn" />
            <?php echo __('GMD'); ?> :
            <select name="gmd" />
            <?php echo $gmd_list; ?>
            </select>
            <?php echo __('Location'); ?> :
            <select name="node" />
            <?php echo $location_list; ?>
            </select>

            <input type="submit" name="search" value="<?php echo __('Search'); ?>" />
            <!-- <input type="button" value="More Options" onclick="" class="button marginTop" /> -->
            </form>
        <!-- advanced search end -->
			</div>
			<div class="clear">&nbsp;</div>
    		<div class="spacer">&nbsp;</div>
			<div class="block-side">
        <!-- license -->
            <div class="block-header">License</div>
            <p>
            This Software is Released Under <a href="http://www.gnu.org/copyleft/gpl.html" title="GNU GPL License" target="_blank">GNU GPL License</a>
            Version 3.
            </p></div>
        <!-- license end -->
<div class="clear">&nbsp;</div>
<div class="spacer">&nbsp;</div>
<div class="block-side">
<div class="block-header">Sponsor</div>
<p align="center">
<script type="text/javascript"><!--
google_ad_client = "pub-5549337631353789";
/* 120x240, created 2/21/11 */
google_ad_slot = "7277572376";
google_ad_width = 120;
google_ad_height = 240;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></p>
        </div>
	<div class="clear">&nbsp;</div>
    <div class="spacer">&nbsp;</div>
	<div class="block-side">
		<div class="block-header">Web Statistik  <a href="http://www.prchecker.info/" title="Check Google Page Rank" target="_blank">
<img src="http://pr.prchecker.info/getpr.php?codex=aHR0cDovL3d3dy5wcmltdXJsaWIubmV0Lw==&tag=3" alt="Check Google Page Rank" style="border:0;" /></a>
</div>
		<p align="center"><!-- Histats.com  START  (standard)-->
<script type="text/javascript">document.write(unescape("%3Cscript src=%27http://s10.histats.com/js15.js%27 type=%27text/javascript%27%3E%3C/script%3E"));</script>
<a href="http://www.histats.com" target="_blank" title="web log free" ><script  type="text/javascript" >
try {Histats.start(1,1321954,4,406,165,100,"00011011");
Histats.track_hits();} catch(err){};
</script></a>
<noscript><a href="http://www.histats.com" target="_blank"><img  src="http://sstatic1.histats.com/0.gif?1321954&101" alt="web log free" border="0"></a></noscript>
<!-- Histats.com  END  --></p>
</div>
    </div>
    <!--application navigation menu/side menu-->
       
    <!--application main content -->
    <div class="grid_9" id="main-content">
    <?php echo $header_info; ?>
    <div id="info-box"><?php echo $info; ?></div>
    <!-- simple search -->
    <div class="spacer">&nbsp;</div>
    <fieldset id="simple-search">
        <div class="block-header"><?php echo __('Quick Search'); ?></div>
        <form name="simpleSearch" action="index.php" method="get">
        <input type="text" name="keywords" style="width: 80%;" /> <input type="submit" name="search" value="<?php echo __('Search'); ?>" class="button" />
        </form>
    </fieldset>
    <div class="spacer">&nbsp;</div>

    <!-- simple search end -->


    <?php echo $main_content; ?>
    </div>
    <!--application main content end -->
    <div class="grid_12" id="gooads" align="center"><script type="text/javascript"><!--
google_ad_client = "pub-5549337631353789";
/* 728x90, created 3/16/11 */
google_ad_slot = "6974919199";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></div>
    <!--footer-->
    <div class="grid_12" id="footer">
    <?php echo $sysconf['page_footer']; ?> 
    <div class="block-header">Komentar</div>
    <div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#appId=172971532722321&amp;xfbml=1"></script><fb:comments xid="172971532722321" numposts="5" width="600" publish_feed="true"></fb:comments>		
    <script type="text/javascript"><!--
google_ad_client = "pub-5549337631353789";
/* 300x250, created 2/4/11 */
google_ad_slot = "2704586952";
google_ad_width = 300;
google_ad_height = 250;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></div>
    <!--footer end-->

    <div class="clear">&nbsp;</div>
    <div class="spacer">&nbsp;</div>
</div>
</body>
</html>
