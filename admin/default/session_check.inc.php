<?php
/**
 * Session variables check
 *
 * Copyright (C) 2007,2008  Arie Nugraha (dicarve@yahoo.com)
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

// be sure that this file not accessed directly
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die();
}

// check session
$unauthorized = !isset($_SESSION['uid']) && !isset($_SESSION['uname']) && !isset($_SESSION['realname']);
if ($unauthorized) {
    $msg = '<script type="text/javascript">'."\n";
    $msg .= 'alert(\''.__('You are not authorized to view this section').'\');'."\n";
    $msg .= 'top.location.href = \''.UCS_WEB_ROOT_DIR.'index.php?p=login\';'."\n";
    $msg .= '</script>'."\n";
    // unset cookie admin flag
    setcookie('ucs_admin_logged_in', false, time()-86400, UCS_WEB_ROOT_DIR);
    simbio_security::destroySessionCookie($msg, UCS_SESSION_COOKIES_NAME, UCS_WEB_ROOT_DIR.'admin', true);
}

// checking session checksum
$unauthorized = $_SESSION['checksum'] != md5($_SERVER['SERVER_ADDR'].UCS_BASE_DIR.'admin');
if ($unauthorized) {
    $msg = '<div style="padding: 5px; border: 1px dotted #FF0000; color: #FF0000;">';
    $msg .= __('You are not authorized to view this section');
    $msg .= '</div>'."\n";
    // unset cookie admin flag
    setcookie('ucs_admin_logged_in', false, time()-86400, UCS_WEB_ROOT_DIR);
    simbio_security::destroySessionCookie($msg, UCS_SESSION_COOKIES_NAME, UCS_WEB_ROOT_DIR.'admin', true);
}

// check for session timeout
$curr_timestamp = time();
$timeout = ($curr_timestamp-$_SESSION['logintime']) >= $sysconf['session_timeout'];
if ($timeout) {
    $msg = '<div style="padding: 5px; border: 1px dotted #FF0000; color: #FF0000;">';
    $msg .= __('Your Login Session has already timeout!').' <a target="_top" href="'.UCS_WEB_ROOT_DIR.'index.php?p=login">Re-Login</a>';
    $msg .= '</div>'."\n";
    // unset cookie admin flag
    setcookie('ucs_admin_logged_in', false, time()-86400, UCS_WEB_ROOT_DIR);
    simbio_security::destroySessionCookie($msg, UCS_SESSION_COOKIES_NAME, UCS_WEB_ROOT_DIR.'admin', true);
} else {
    // renew session logintime
    $_SESSION['logintime'] = time();
}
?>
