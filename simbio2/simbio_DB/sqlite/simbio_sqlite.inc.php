<?php
/**
 * simbio_sqlite class
 * Simbio SQLite connection object class
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

require 'simbio_sqlite_result.inc.php';

class simbio_sqlite extends simbio
{
    private $db_name = '';
    private $res_conn = false;
    public $insert_id = 0;
    public $affected_rows = 0;
    public $errno = 0;
    /**
     * Simbio SQLite Class Constructor
     *
     * @param   string  $str_dbname
     */
    public function __construct($str_dbname)
    {
        $this->db_name = $str_dbname;
        // execute connection
        $this->connect();
    }


    /**
     * Method to invoke connection to RDBMS
     *
     * @return  void
     */
    private function connect()
    {
        $this->res_conn = @sqlite_open($this->db_name, 0666, $this->error);
        if ($this->error) {
            parent::showError(true);
        }
    }


    /**
     * Method to create/send query to RDBMS
     *
     * @param   string  $str_query
     * @return  object
     */
    public function query($str_query = '')
    {
        if (empty($str_query)) {
            $this->error = 'Cant send query because query was empty';
            parent::showError(true);
        } else {
            $_result = new simbio_sqlite_result($str_query, $this->res_conn);
            $this->affected_rows = $_result->affected_rows;
            $this->errno = $_result->errno;
            $this->error = $_result->error;
            $this->insert_id = $_result->insert_id;
            // return the result object
            if ($this->error) {
                return false;
            } else {
                return $_result;
            }
        }
    }


    /**
     * Method to escape SQL string
     *
     * @param   string  $str_data
     * @return  string
     */
    public function escape_string($str_data)
    {
        return sqlite_escape_string($str_data);
    }


    /**
     * Method to close RDBMS connection
     *
     * @return  void
     */
    public function close()
    {
        @sqlite_close($this->res_conn);
    }
}
?>
