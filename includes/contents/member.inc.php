<link href="../../css/demo_page.css" rel="stylesheet" type="text/css" />
<link href="../../css/demo_table.css" rel="stylesheet" type="text/css" />
<link href="../../css/jquery-ui-1.8.4.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css/demo_table_jui.css" rel="stylesheet" type="text/css" />
<!--<style type="text/css" title="currentStyle">
			@import "/ucs/css/demo_page.css";
			@import "/ucs/css/demo_table.css";
			@import "/ucs/css/demo_table_jui.css";
		</style>-->
		<script type="text/javascript" language="javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>jquery.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>jquery.dataTables.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>jquery.dataTables.min.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				oTable = $('#dataperpus').dataTable( {
                                        "bJQueryUI": true,
					"sPaginationType": "full_numbers"
				} );
			} );
		</script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
var infowindow = null;
    $(document).ready(function () { initialize(); });

    function initialize() {

        var centerMap = new google.maps.LatLng(-7.349016,108.222726);

        var myOptions = {
            zoom: 9,
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
	['Universitas Siliwangi', -7.349022,108.222724, 1, 'Ini Lokasi Kampus Universitas Siliwangi'],
	['SMAN 2 Tasikmalaya', -7.301934,108.20294, 2, 'Ini Lokasi SMAN 2 Tasikmalaya'],
	['STIKES BTH Tasikmalaya', -7.347684,108.233686, 3, 'Ini Lokasi STIKES BTH Tasikmalaya'],
        ['Latifah Mubarokiyah Tasikmalaya', -7.1234735,108.2144415, 4, 'Ini Lokasi Latifah Mubarokiyah Tasikmalaya'],
        ['IAIN Syekh Nurjati Cirebon', -6.7350502,108.5336821, 5, 'Ini Lokasi IAIN Syekh Nurjati Cirebon'],
        ['IAID Ciamis', -7.3342184,108.391808, 6, 'Ini Lokasi IAID Ciamis'],
        ['STIKES Muhammadiyah Ciamis', -7.3315236,108.3470392, 7, 'Ini Lokasi STIKES Muhammadiyah Ciamis'],
        ['STIKES Respati Tasikmalaya', -7.336789,108.153517, 8, 'Ini Lokasi STIKES Respati Tasikmalaya'],
        ['SMPN 5 Tasikmalaya', -7.3154924,108.2148627, 9, 'Ini Lokasi SMPN 5 Tasikmalaya'],
        ['Thira Reading Park', -7.342122,108.1929463, 10, 'Thira Reading Park'],
        ['STAI Tasikmalaya', -7.349995,108.229938, 11, 'Ini Lokasi STAI Tasikmalaya'],
        ['STAI Madinatul Ilmi Depok', -6.3970189,106.7747498, 12, 'Ini Lokasi STAI Madinatul Ilmi Depok']
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
                alert(this.html);
                infowindow.setContent(this.html);
                infowindow.open(map, this);
            });
        }
    }
</script>
<h2>Peta Lokasi Anggota Primurlib</h2>
<div id="map_canvas" style="width: 740px; height: 600px;"></div>
<br>
<h2>Daftar Perpustakaan Yang Sudah Bergabung</h2>
<?php 
$page_title = $sysconf['server']['name'].' :: Anggota Primurlib';
mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD);
mysql_select_db(DB_NAME);
$q = mysql_query('Select count(biblio_id) as total from biblio');
$total_buku = mysql_fetch_assoc($q);
echo 'Jumlah total buku yang ada : <b>'.$total_buku['total'].'</b> bibliografi <br><br>';
echo '<p>Untuk informasi dan proposal&nbsp; lebih lanjut silakan menghubungi:</p>
<blockquote>
<p>Asep M Fahrus: 081323025598</p>
<p>Indra Jiwana Thira : 083826028282</p>
</blockquote><br><br>';
echo '<div id="demo"><table id="dataperpus" class="display" border="0" cellspacing="0" cellpadding="3" width="25%">';
echo "<thead>\n<tr valign='top'>\n";
echo "<th>Perpustakaan</th>\n<th>Jumlah Bibliografi</th>\n<th>Status OPAC</th>\n";
echo "</tr>\n</thead>\n<tbody>\n";
for ($i=1; $i<13; $i++){
$q2 = mysql_query('Select count(biblio_id) as jumlah from biblio where node_id =\''.$sysconf['node']['slims-node'.$i]['id'].'\'');
$jum_buku = mysql_fetch_assoc($q2);
echo "<tr valign='top'>\n";
echo "<td align='center'><b>".$sysconf['node']['slims-node'.$i]['name'].'</b></td>';
echo "<td align='center'><b>".$jum_buku['jumlah']."</b></td>";
if (isset($sysconf['node']['slims-node'.$i]['baseurl'])){
echo '<td align="center"><a href="'.$sysconf['node']['slims-node'.$i]['baseurl'].'" target="_blank"><font color="#0000FF"><b>ONLINE</b></font></a></td>';
}
else
{
echo "<td align='center'> OFFLINE</td>";
}
echo "</tr>\n";
}
echo "</tbody></table></div>";
?>