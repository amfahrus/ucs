<?
$loc = base64_decode($_GET['lok']);
$nm = base64_decode($_GET['nm']);
switch ($loc) {
case "slims-node1":
	$lat = "-7.301934";
	$long = "108.20294";
	break;
case "slims-node2":
	$lat = "-7.347684";
	$long = "108.233686";
	break;
}
?>
<script src='js/jquery.js' type='text/javascript'></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript"><!--
google_ad_client = "pub-5549337631353789";
/* 468x15, created 3/9/11 */
google_ad_slot = "6135390977";
google_ad_width = 468;
google_ad_height = 15;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<script type="text/javascript">
var infowindow = null;
    $(document).ready(function () { initialize(); });

    function initialize() {

        var centerMap = new google.maps.LatLng(<?php echo $lat . ',' . $long; ?>);

        var myOptions = {
            zoom: 17,
            center: centerMap,
            mapTypeId: google.maps.MapTypeId.HYBRID
        }

        var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

        setMarkers(map, sites);
	infowindow = new google.maps.InfoWindow({
                content: "loading..."
            });
    }

    var sites = [
	[<?php echo '\''.$nm . '\',' . $lat . ',' . $long . ', 1,\'' . $nm .'\''; ?>]
];



    function setMarkers(map, markers) {

        for (var i = 0; i < markers.length; i++) {
            var sites = markers[i];
            var siteLatLng = new google.maps.LatLng(sites[1], sites[2]);
            var marker = new google.maps.Marker({
                position: siteLatLng,
                map: map,
                title: sites[0],
                zIndex: sites[3],
                html: sites[4]
            });

            var contentString = "Some content";

            

            google.maps.event.addListener(marker, "click", function () {
                infowindow.setContent(this.html);
                infowindow.open(map, this);
            });
        }
    }
</script>
<div align="center" id="map_canvas" style="width: 620px; height: 380px;"></div>
<div align="center"><script type="text/javascript"><!--
google_ad_client = "pub-5549337631353789";
/* 468x60, created 3/9/11 */
google_ad_slot = "1212668671";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></div>