<?php
/**
 * SLiMS Union Catalog server
 *
 * Copyright (C) 2009  Arie Nugraha (dicarve@yahoo.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

require 'ucsysconfig.inc.php';
// common files
require INC_DIR.'common.inc.php';

// page title
$page_title = $sysconf['server']['name'].' | '.$sysconf['server']['subname'];
// default library info
$info = __('Web Online Public Access Catalog - Use the search options to find documents quickly');
// total opac result page
$total_pages = 1;
// default header info
$header_info = '';
// HTML metadata
$metadata = '';

// start the output buffering for main content
ob_start();
if (isset($_GET['p'])) {
    $path = trim($_GET['p']);
    // some extra checking
    $path = preg_replace('@^(http|https|ftp|sftp|file|smb):@i', '', $path);
    // check if the file exists
    if ($path == 'show_detail') {
        include LIB_DIR.'contents/show_detail.inc.php';
    } else if (file_exists(INC_DIR.'contents/'.$path.'.inc.php')) {
        include INC_DIR.'contents/'.$path.'.inc.php';
        if ($path != "show_detail") {
            $metadata = '<meta name="robots" content="index, follow" />
<meta name="description" content="Union Catalog Server merupakan katalog terpadu dari berbagai perpustakaan yang memiliki koleksi bibliografi dan buku yang memanfaatkan aplikasi library open source SLIMS (Senayan Library Management Systems)" />
<meta name="keywords" content="buku,biblio,bibliografi,books,book,library,perpustakaan,katalog,catalog,google,koleksi,server,guru,sekolah,universitas,teacher,school,university,terpadu,union,ilmu,pengetahuan,knowledge,librarian,pustakawan,kesehatan,healthy,informasi,info,information,pendidikan,education,digital,pdf,senayan,open source,asuransi,insurance,car insurance,life insurance,home insurance" />
';
        }
    } else {
        // get content data from database
        $metadata = '<meta name="robots" content="index, follow" />
<meta name="description" content="Union Catalog Server merupakan katalog terpadu dari berbagai perpustakaan yang memiliki koleksi bibliografi dan buku yang memanfaatkan aplikasi library open source SLIMS (Senayan Library Management Systems)" />
<meta name="keywords" content="buku,biblio,bibliografi,books,book,library,perpustakaan,katalog,catalog,google,koleksi,server,guru,sekolah,universitas,teacher,school,university,terpadu,union,ilmu,pengetahuan,knowledge,librarian,pustakawan,kesehatan,healthy,informasi,info,information,pendidikan,education,digital,pdf,senayan,open source,asuransi,insurance,car insurance,life insurance,home insurance" />
';
        include LIB_DIR.'content.inc.php';
        $content = new content();
        $content_data = $content->get($dbs, $path);
        if ($content_data) {
            $page_title = $content_data['Title'];
            $info = '<div class="contentTitle">'.$content_data['Title'].'</div>';
            echo '<div class="contentDesc">'.$content_data['Content'].'</div>';
            unset($content_data);
        } else {
            header ("location: index.php");
        }
    }
} else {
    $metadata = '<meta name="robots" content="index, follow" />
<meta name="description" content="Union Catalog Server merupakan katalog terpadu dari berbagai perpustakaan yang memiliki koleksi bibliografi dan buku yang memanfaatkan aplikasi library open source SLIMS (Senayan Library Management Systems)" />
<meta name="keywords" content="buku,biblio,bibliografi,books,book,library,perpustakaan,katalog,catalog,google,koleksi,server,guru,sekolah,universitas,teacher,school,university,terpadu,union,ilmu,pengetahuan,knowledge,librarian,pustakawan,kesehatan,healthy,informasi,info,information,pendidikan,education,digital,pdf,senayan,open source,asuransi,insurance,car insurance,life insurance,home insurance" />
';
    include LIB_DIR.'contents/default.inc.php';
}
// main content grab
$main_content = ob_get_clean();

// template output
require THEMES_BASE_DIR.'default'.DSEP.'index_template.inc.php';
?>
