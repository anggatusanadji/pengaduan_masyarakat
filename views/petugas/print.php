<?php
session_start();
require_once '../../init.php';

$db2 = new Petugas();
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

<body>
    <div class="container">
        <br>
        <h3 class="text-center m-3">Pengaduan Masyarakat</h3>

        <table id="example1" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pengadu</th>
                    <th>Laporan</th>
                    <th>Tanggapan</th>
                    <th>Tanggal Ditanggapi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($db2->tampil_tanggapan() as $tmpl_data) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $tmpl_data['nama'] ?></td>
                        <td><?= $tmpl_data['isi_laporan'] ?></td>
                        <td><?= $tmpl_data['tanggapan'] ?></td>
                        <td><?= date('d M Y', strtotime($tmpl_data['tgl_tanggapan'])) ?></td>
                        <td><?= $tmpl_data['status'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

<script>
    window.print()
</script>

</html>