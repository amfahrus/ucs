<div style="background:#ffffff;">
<?
$buku = base64_decode($_GET['j']);
?>
<table width="400" border="0" align="center" cellpadding="3" cellspacing="1">
<tr>
<td><strong>Contact Form </strong></td>
</tr>
</table>

<table width="400" border="0" align="center" cellpadding="0" cellspacing="1">
<tr>
<td><form name="form1" method="post" action="send_contact.php">
<table width="100%" border="0" cellspacing="1" cellpadding="3">
<tr>
<td width="16%">Judul</td>
<td width="2%">:</td>
<td width="82%"><input name="subject" type="text" id="subject" size="50"><input type="hidden" name="buku" value="<? echo $buku; ?>" ></td>
</tr>
<tr>
<td>Detail</td>
<td>:</td>
<td><textarea name="detail" cols="50" rows="4" id="detail"></textarea></td>
</tr>
<tr>
<td>Nama</td>
<td>:</td>
<td><input name="nama" type="text" id="nama" size="50"></td>
</tr>
<tr>
<td>Email</td>
<td>:</td>
<td><input name="dari" type="text" id="dari" size="50"></td>
</tr>
<tr>
<td>No Hp</td>
<td>:</td>
<td><input name="hp" type="text" id="hp" size="50"></td>
</tr>
<tr>
<td>Alamat Lengkap</td>
<td>:</td>
<td><textarea name="alamat" cols="50" rows="4" id="alamat"></textarea></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Submit"> <input type="reset" name="Submit2" value="Reset"></td>
</tr>
</table>
</form>
</td>
</tr>
</table>
<p align="center">
* Pesanan bisa langsung menghubungi 085223568961<br>
* Pesanan akan dikirim setelah pemesan mengirimkan biaya yang sudah disepakati<br>
* Ongkos kirim disesuaikan dengan lokasi pemesan<br></p>
</div>