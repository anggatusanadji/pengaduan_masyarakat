<?php

class Masyarakat extends Koneksi
{
    private $koneksi;
    function __construct()
    {
        $this->koneksi = $this->conn();
    }

    public function tampil_pengaduan()
    {
        $nik = $_SESSION['nik'];
        $data = mysqli_query($this->koneksi, "SELECT * FROM pengaduan INNER JOIN masyarakat using(nik) WHERE nik='$nik'");
        if ($data->num_rows > 0) {
            while ($d = $data->fetch_assoc()) {
                $hasil[] = $d;
            }
        } else {
            $hasil = [];
        }
        return $hasil;
    }

    public function tambah_pengaduan()
    {
        $date = date('Y-m-d');
        $nik = $_SESSION['nik'];
        $laporan = $_POST['isi_laporan'];
        $foto = $_FILES['foto']['name'];
        $file = $_FILES['foto']['tmp_name'];
        $status = 'proses';
        move_uploaded_file($file, '../../assets/gambar/' . $foto);

        $data = mysqli_query($this->koneksi, "INSERT INTO pengaduan (`tgl_pengaduan`,`nik`,`isi_laporan`,`foto`,`status`) VALUES ('$date', '$nik', '$laporan', '$foto', '$status')");
        return $data;
    }

    public function tampil_tanggapan()
    {
        $nik = $_SESSION['nik'];
        $data = mysqli_query($this->koneksi, "SELECT * FROM tanggapan 
                                                INNER JOIN pengaduan using(id_pengaduan)
                                                INNER JOIN masyarakat using(nik)
                                                INNER JOIN petugas using(id_petugas) WHERE nik = '$nik'");
        if ($data->num_rows > 0) {
            while ($d = $data->fetch_assoc()) {
                $hasil[] = $d;
            }
        } else {
            $hasil = [];
        }
        return $hasil;
    }
}
