<?php

class Koneksi
{
    private $host = 'localhost',
        $user = 'root',
        $pass = '',
        $db   = 'pengaduan_masyarakat';

    function conn()
    {
        $koneksi = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
        if (mysqli_connect_error()) {
            return mysqli_connect_error();
        }
        return $koneksi;
    }
}
