<?php
session_start();
require_once '../../init.php';

$db = new Login();
$db2 = new Petugas();

$id = $_GET['id'];

if (!$db->getSesi()) {
  header('location:../../login.php');
}

$dtl = $db2->detail($id);
$tanggapan = $db2->tanggapan($id);

if ($tanggapan == null) {
  $txt_tanggap = '';
} else {
  $txt_tanggap = $tanggapan['tanggapan'];
}

if (isset($_POST['tanggapi'])) {
  $add = $db2->tanggap($id);
  if ($add == true) {
    echo "<script>
            alert('Laporan berhasil ditanggapi!')
            window.location.href = 'pengaduan.php'
          </script>";
  } else {
    echo "<script>
            alert('Laporan gagal ditanggapi!')
          </script>";
  }
}

if (isset($_GET['logout'])) {
  $db->logout();
  header('location:../../login.php');
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- SEARCH FORM -->
      <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
          <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link">
        <span class="brand-text font-weight-light ml-3">Pengaduan Masyarakat</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="../../assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?= $_SESSION['username'] ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="index.php" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="petugas.php" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Petugas
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="user.php" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Masyarakat
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pengaduan.php" class="nav-link">
                <i class="nav-icon fas fa-envelope"></i>
                <p>
                  Pengaduan
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="tanggapan.php" class="nav-link">
                <i class="nav-icon fas fa-reply"></i>
                <p>
                  Tanggapan
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="?logout" class="nav-link" onclick="return confirm('Yakin ingin logout?')">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>
                  Logout
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid">
          <br>
          <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <h5>Detail Pengaduan</h5>
                  <hr>
                  <div class="form-group text-center">
                    <img src="../../assets/gambar/<?= $dtl['foto'] ?>" width="70%">
                  </div>
                  <div class="form-group">
                    <label class="mt-3" style="margin:0">Nik : </label>
                    <p><?= $dtl['nik'] ?></p>
                  </div>
                  <div class="form-group">
                    <label style="margin:0">Nama : </label>
                    <p><?= $dtl['nama'] ?></p>
                  </div>
                  <div class="form-group">
                    <label style="margin:0">Telp : </label>
                    <p><?= $dtl['telp'] ?></p>
                  </div>
                  <div class="form-group">
                    <label style="margin:0">Tanggal Pengaduan : </label>
                    <p><?= date('d M Y', strtotime($dtl['tgl_pengaduan'])) ?></p>
                  </div>
                  <div class="form-group">
                    <label style="margin:0">Isi Laporan : </label>
                    <p><?= $dtl['isi_laporan'] ?></p>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <div class="col-md-6">
              <div class="card">
                <!-- form start -->
                <form action="" method="POST">
                  <div class="card-body">
                    <h5>Tanggapan</h5>
                    <hr>
                    <div class="form-group">
                      <label for="tanggapan">Tanggapan</label>
                      <textarea id="tanggapan" class="form-control" rows="6" name="tanggapan" <?= $txt_tanggap !== '' ? 'disabled' : '' ?>><?= $txt_tanggap !== '' ? $txt_tanggap : '' ?></textarea>
                    </div>
                    <button type="submit" name="tanggapi" class="btn btn-primary" <?= $txt_tanggap !== '' ? 'hidden' : '' ?>>Submit</button>
                  </div>
                </form>
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>
      </section>
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2021 Pengaduan Masyarakat</strong>
      All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="../../assets/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="../../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables -->
  <script src="../../assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../assets/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../../assets/dist/js/demo.js"></script>
  <!-- page script -->
  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
      });
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
</body>

</html>