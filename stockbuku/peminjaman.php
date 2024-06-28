<?php
    require 'function.php';
    require 'cek.php';

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //get data
    //ambil data total
    $get1 = mysqli_query($conn, "SELECT * FROM peminjaman");
    $count1 = mysqli_num_rows($get1); //Menghitung seluruh kolom

    //ambil data peminjaman yang statusnya dipinjam
    $get2 = mysqli_query($conn, "SELECT * FROM peminjaman WHERE status='Dipinjam'");
    $count2 = mysqli_num_rows($get2); //Menghitung seluruh kolom yang statusnya dipinjam

    //ambil data total
    $get3 = mysqli_query($conn, "SELECT * FROM peminjaman WHERE status='Kembali'");
    $count3 = mysqli_num_rows($get3); //Menghitung seluruh kolom yang statusnya kembali
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Peminjaman Buku</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .zoomable {
            width: 50px;
        }
        .zoomable:hover {
            transform: scale(2.5);
            transition: 0.3s ease;
        }
    </style>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand" href="peminjaman.php">Peminjaman Buku</a>
        <!-- Sidebar Toggle Button-->
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        </form>
        <!-- Navbar Right Side-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="admin.php">Kelola Admin</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <!-- Sidebar -->
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <!-- Core Menu Headings -->
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Stock Buku
                        </a>
                        <!-- Submenu -->
                        <div class="nav">
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Buku Masuk
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Buku Keluar
                            </a>
                            <a class="nav-link" href="peminjaman.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Peminjaman Buku
                            </a>
                            <a class="nav-link" href="pendapatan.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                    Hasil Pendapatan
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Peminjaman Buku</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button to Open the Modal -->
                            <button type="button" class="button-17" role="button" data-toggle="modal" data-target="#myModal">
                                Tambah Data Peminjaman
                            </button>
                            <a href="exportpeminjaman.php" class="button-17" role="button">Export Data Peminjaman</a>
                            <br>
                            <div class="row mt-4">
                                <div class="col">
                                    <div class="card bg-info text-white"><h3>Total Data: <?= $count1; ?></h3></div>
                                </div>
                                <div class="col">
                                    <div class="card bg-danger text-white"><h3>Total Dipinjam: <?= $count2; ?></h3></div>
                                </div>
                                <div class="col">
                                    <div class="card bg-success text-white"><h3>Total Kembali: <?= $count3; ?></h3></div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col">
                                    <form method="post" class="form-inline">
                                        <input type="date" name="tgl_mulai" class="form-control">
                                        <input type="date" name="tgl_selesai" class="form-control ml-3">
                                        <button type="submit" name="filter_tgl" class="button-17 ml-3" role="button">Filter</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Tanggal Pinjam</th>
                                            <th>Gambar</th>
                                            <th>Judul Buku</th>
                                            <th>Jumlah</th>
                                            <th>Kepada</th>
                                            <th>Tanggal Kembali</th>
                                            <th>Status</th>
                                            <th>Denda</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if (isset($_POST['filter_tgl'])) {
                                                $mulai = $_POST['tgl_mulai'];
                                                $selesai = $_POST['tgl_selesai'];
                                            
                                                if ($mulai != null || $selesai != null) {
                                                    $ambilsemuadatastock = mysqli_query($conn, "SELECT p.*, s.* FROM peminjaman p JOIN stock s ON s.idbuku = p.idbuku WHERE p.tanggal_pinjam BETWEEN '$mulai' AND DATE_ADD('$selesai', INTERVAL 1 DAY) ORDER BY p.idpeminjaman DESC");
                                                } else {
                                                    $ambilsemuadatastock = mysqli_query($conn, "SELECT p.*, s.* FROM peminjaman p JOIN stock s ON s.idbuku = p.idbuku ORDER BY p.idpeminjaman DESC");
                                                }
                                            } else {
                                                $ambilsemuadatastock = mysqli_query($conn, "SELECT p.*, s.* FROM peminjaman p JOIN stock s ON s.idbuku = p.idbuku ORDER BY p.idpeminjaman DESC");
                                            }
                                            
                                            while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                                $idp = $data['idpeminjaman'];
                                                $idb = $data['idbuku'];
                                                $tanggal_pinjam = $data['tanggal_pinjam'];
                                                $judulbuku = $data['judulbuku'];
                                                $qty = $data['qty'];
                                                $penerima = $data['peminjam'];
                                                $tanggal_kembali = $data['tanggal_kembali'];
                                                $status = $data['status'];
                                                $denda = 0;

                                                if ($status == 'Kembali') {
                                                    list($daysLate, $denda) = calculateFine($tanggal_kembali, date('Y-m-d'));
                                                }

                                                // Check if there is an image
                                                $gambar = $data['image'];
                                                if ($gambar == null) {
                                                    $img = 'No Photo';
                                                } else {
                                                    $img = '<img src="images/' . $gambar . '" class="zoomable">';
                                                }
                                        ?>
                                        <tr>
                                            <td><?= $tanggal_pinjam; ?></td>
                                            <td><?= $img; ?></td>
                                            <td><?= $judulbuku; ?></td>
                                            <td><?= $qty; ?></td>
                                            <td><?= $penerima; ?></td>
                                            <td><?= $tanggal_kembali; ?></td>
                                            <td><?= $status; ?></td>
                                            <td><?= ($denda > 0) ? "Rp. $denda" : "-"; ?></td>
                                            <td>
                                                <?php
                                                    if ($status == 'Dipinjam') {
                                                        echo '<button type="button" class="button-17" role="button" data-toggle="modal" data-target="#edit' . $idp . '">Selesai</button>';
                                                    } else {
                                                        echo 'Buku telah kembali';
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="edit<?= $idp; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Selesaikan</h4>
                                                        <button type="button" class="button-17" role="button" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <!-- Modal Body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Apakah buku ini sudah selesai dipinjam?
                                                            <br>
                                                            <input type="hidden" name="idpeminjaman" value="<?= $idp; ?>">
                                                            <input type="hidden" name="idbuku" value="<?= $idb; ?>">
                                                            <button type="submit" class="button-17" role="button" name="bukukembali">Iya</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted" id="copyright">
                            <!-- JavaScript will add the current year here automatically -->
                        </div>
                        <div>
                            <a href="privacy.php">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var currentYear = new Date().getFullYear();
                            var footerYear = document.getElementById('copyright');
                            footerYear.innerHTML = 'Copyright &copy; ' + currentYear;
                        });
                    </script>
                </div>
            </footer>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/datatables-demo.js"></script>
</body>
<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data Peminjaman</h4>
                <button type="button" class="button-17" role="button" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal Body -->
            <form method="post">
                <div class="modal-body">
                    <select name="bukunya" class="form-control">
                        <?php
                            $ambilsemuadatanya = mysqli_query($conn, "SELECT * FROM stock");
                            while ($fetcharray = mysqli_fetch_array($ambilsemuadatanya)) {
                                $judulbukunya = $fetcharray['judulbuku'];
                                $idbukunya = $fetcharray['idbuku'];
                        ?>
                            <option value="<?= $idbukunya; ?>"><?= $judulbukunya; ?></option>
                        <?php } ?>
                    </select>
                    <br>
                    <input type="number" name="qty" class="form-control" placeholder="Quantity" required>
                    <br>
                    <input type="text" name="penerima" placeholder="Kepada" class="form-control" required>
                    <br>
                    <input type="date" name="tanggal_kembali" class="form-control" required>
                    <br>
                    <button type="submit" class="button-17" role="button" name="pinjam">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
</html>