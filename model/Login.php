<?php

class Login extends Koneksi
{
    private $koneksi;
    public function __construct()
    {
        $this->koneksi = $this->conn();
    }

    public function login()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql1 = mysqli_query($this->koneksi, "SELECT * FROM masyarakat WHERE username = '$username' and password = '$password'");
        $sql2 = mysqli_query($this->koneksi, "SELECT * FROM petugas WHERE username = '$username' and password = '$password'");

        if ($sql1->num_rows > 0) {
            $data = $sql1->fetch_assoc();
            $_SESSION['login'] = true;
            $_SESSION['username'] = $data['username'];
            $_SESSION['nik'] = $data['nik'];
            header('location:views/masyarakat');
        }

        if ($sql2->num_rows > 0) {
            $data = $sql2->fetch_assoc();
            if ($data['level'] == 'admin') {
                $_SESSION['login'] = true;
                $_SESSION['username'] = $data['username'];
                $_SESSION['id_petugas'] = $data['id_petugas'];
                $_SESSION['level'] = $data['level'];
                header('location:views/petugas');
            } elseif ($data['level'] == 'petugas') {
                $_SESSION['login'] = true;
                $_SESSION['username'] = $data['username'];
                $_SESSION['id_petugas'] = $data['id_petugas'];
                $_SESSION['level'] = $data['level'];
                header('location:views/petugas');
            }
        } else {
            echo "<script>alert('Login Gagal!')</script>";
        }
    }

    public function getSesi()
    {
        return $_SESSION['login'];
    }

    public function logout()
    {
        session_start();
        $_SESSION['login'] = false;
        session_destroy();
    }

    public function register()
    {
        $nik = $_POST['nik'];
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];
        $telp = $_POST['telp'];

        $sql = mysqli_query($this->koneksi, "SELECT * FROM masyarakat WHERE username='$username' or nik='$nik'");

        if ($sql->num_rows > 0) {
            echo "<script>alert('Username atau nik sudah ada')</script>";
        } else {
            if ($password1 == $password2) {
                $password = $password2;
                $data = mysqli_query($this->koneksi, "CALL register('$nik','$nama','$username','$password','$telp')"); // CALL PROCEDURE REGISTER
                return $data;
            } else {
                echo "<script>alert('Konfirmasi password tidak sama')</script>";
            }
        }
    }
}
