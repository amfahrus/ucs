<?php
// biblio/record detail
// output the buffer
ob_start(); /* <- DONT REMOVE THIS COMMAND */
?>
<table class="border margined" style="width: 99%;" cellpadding="5" cellspacing="0">
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Title'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{title}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Collection Location'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{location} <a href="#" title="Lihat lokasi {nm_lok}" onclick="openHTMLpop('lokasi.php?lok={lok}&nm={nm}', 640, 480, 'Lokasi {nm_lok}')" class="detailLink">Peta Lokasi</a></td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Edition'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{edition}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Call Number'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{call_number}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('ISBN/ISSN'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{isbn_issn}</td>
</tr>
<tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Author(s)'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{authors}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Subject(s)'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{subjects}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Classification'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{classification}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Series Title'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{series_title}</td>
</tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('GMD'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{gmd_name}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Language'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{language_name}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Publisher'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{publisher_name}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Publishing Year'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{publish_year}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Publishing Place'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{publish_place}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Collation'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{collation}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Abstract/Notes'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{notes}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Specific Detail Info'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{spec_detail_info}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Image'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{image}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print __('Download PDF'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">
<form action="http://www.primurlib.net" id="cse-search-box">
        <input type="hidden" name="cx" value="partner-pub-googlenya" />
    <input type="hidden" name="cof" value="FORIDNYA" />
    <input type="hidden" name="ie" value="ISONYA" />
    <input type="hidden" name="q" value="{pdf} ; filetype:pdf" size="100" />
    <input type="submit" name="sa" value="Search PDF" />
</form><script type="text/javascript" src="http://www.google.com/cse/brand?form=cse-search-box&amp;lang=en"></script><br>
atau gunakan fasilitas <b>google search</b> dengan memasukan kata kunci <br><fieldset style="font-weight:bold;">{pdf} ; filetype:pdf</fieldset></td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top">&nbsp;</td>
<td class="tblContent" style="width: 80%;" valign="top"><a href="javascript: history.back();"><?php print __('Back To Previous'); ?></a></td>
</tr>
</table>
<?php
// put the buffer to template var
$detail_template = ob_get_clean();
?>
