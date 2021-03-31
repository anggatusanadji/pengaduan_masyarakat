<?php

class Petugas extends Koneksi
{
    private $koneksi;
    public function __construct()
    {
        $this->koneksi = $this->conn();
    }

    public function tampil_petugas()
    {
        $data = mysqli_query($this->koneksi, "SELECT * FROM petugas");
        if ($data->num_rows > 0) {
            while ($d = $data->fetch_assoc()) {
                $hasil[] = $d;
            }
        } else {
            $hasil = [];
        }
        return $hasil;
    }

    // GET PETUGAS BY ID
    public function getPetugasBy($id)
    {
        $sql = mysqli_query($this->koneksi, "SELECT * FROM petugas WHERE id_petugas = '$id'");
        if ($sql->num_rows > 0) {
            while ($d = $sql->fetch_assoc()) {
                $hasil = $d;
            }
        } else {
            $hasil = [];
        }
        return $hasil;
    }

    // CRUD PETUGAS
    public function tambah_petugas()
    {
        $nama_petugas = $_POST['nama_petugas'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $telp = $_POST['telp'];
        $level = $_POST['level'];

        $data = mysqli_query($this->koneksi, "SELECT * FROM petugas WHERE username='$username'");

        if ($data->num_rows > 0) {
            echo "<script>alert('Username sudah tersedia')</script>";
        } else {
            $sql = mysqli_query($this->koneksi, "INSERT INTO petugas (`nama_petugas`,`username`,`password`,`telp`,`level`) VALUES ('$nama_petugas', '$username', '$password', '$telp', '$level')");
            return $sql;
        }
    }
    public function edit_petugas($id)
    {
        $data = $this->getPetugasBy($id);
        $nama_petugas = $_POST['nama_petugas'];
        $username = $_POST['username'];
        $password_lama = $_POST['password_lama'];
        $password_baru = $_POST['password_baru'];
        $telp = $_POST['telp'];
        $level = $_POST['level'];

        if ($password_lama == '' && $password_baru == '') {
            $sql1 = mysqli_query($this->koneksi, "UPDATE `petugas` SET `nama_petugas`='$nama_petugas', `username`='$username', `telp`='$telp', `level`='$level' WHERE id_petugas='$id'");
            return $sql1;
        } else {
            if ($password_lama == $data['password']) {
                $password = $password_baru;
                $sql2 = mysqli_query($this->koneksi, "UPDATE `petugas` SET 
                                                        `nama_petugas`='$nama_petugas', `username`='$username', `password`='$password' `telp`='$telp', `level`='$level' WHERE id_petugas='$id'");
                return $sql2;
            }
        }
    }
    public function hapus_petugas($id)
    {
        $data = mysqli_query($this->koneksi, "DELETE FROM petugas WHERE id_petugas='$id'");
        return $data;
    }
    // SELESAI CRUD PETUGAS

    public function tampil_user()
    {
        $data = mysqli_query($this->koneksi, "SELECT * FROM masyarakat");
        if ($data->num_rows > 0) {
            while ($d = $data->fetch_assoc()) {
                $hasil[] = $d;
            }
        } else {
            $hasil = [];
        }
        return $hasil;
    }

    // PENGADUAN HALAMAN ADMIN
    public function tampil_pengaduan()
    {
        $data = mysqli_query($this->koneksi, "SELECT * FROM pengaduan INNER JOIN masyarakat using(nik) WHERE status='proses' or status='selesai'");
        if ($data->num_rows > 0) {
            while ($d = $data->fetch_assoc()) {
                $hasil[] = $d;
            }
        } else {
            $hasil = [];
        }
        return $hasil;
    }

    public function hapus_pengaduan($id)
    {
        $data = mysqli_query($this->koneksi, "DELETE FROM pengaduan WHERE id_pengaduan='$id'");
        return $data;
    }

    // SELECT DETAIL PENGADUAN
    public function detail($id)
    {
        $data = mysqli_query($this->koneksi, "SELECT * FROM pengaduan INNER JOIN masyarakat using(nik) WHERE id_pengaduan='$id'");
        if ($data->num_rows > 0) {
            while ($d = $data->fetch_assoc()) {
                $hasil = $d;
            }
        } else {
            $hasil = [];
        }
        return $hasil;
    }

    // SELECT TANGGAPAN
    public function tanggapan($id)
    {
        $data = mysqli_query($this->koneksi, "SELECT * FROM tanggapan WHERE id_pengaduan='$id'");
        if ($data->num_rows > 0) {
            while ($d = $data->fetch_assoc()) {
                $hasil = $d;
            }
        } else {
            $hasil = [];
        }
        return $hasil;
    }

    // PROSES TANGGAP
    public function tanggap($id)
    {
        $id_petugas = $_SESSION['id_petugas'];
        $date = date('Y-m-d');
        $tanggapan = $_POST['tanggapan'];

        $sql1 = mysqli_query($this->koneksi, "UPDATE pengaduan set status='selesai' WHERE id_pengaduan='$id'");

        $sql = mysqli_query($this->koneksi, "INSERT INTO tanggapan (`id_pengaduan`,`tgl_tanggapan`,`tanggapan`,`id_petugas`) VALUES ('$id', '$date', '$tanggapan', '$id_petugas')");
        return $sql;
    }

    public function tampil_verifikasi()
    {
        $data = mysqli_query($this->koneksi, "SELECT * FROM pengaduan INNER JOIN masyarakat using(nik) WHERE status='0'");
        if ($data->num_rows > 0) {
            while ($d = $data->fetch_assoc()) {
                $hasil[] = $d;
            }
        } else {
            $hasil = [];
        }
        return $hasil;
    }

    public function verifikasi($id)
    {
        $sql = mysqli_query($this->koneksi, "UPDATE pengaduan set status='proses' WHERE id_pengaduan='$id'");
        return $sql;
    }

    public function tampil_tanggapan()
    {
        $data = mysqli_query($this->koneksi, "SELECT * FROM tanggapan 
                                                INNER JOIN pengaduan using(id_pengaduan)
                                                INNER JOIN masyarakat using(nik)
                                                INNER JOIN petugas using(id_petugas)");
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
