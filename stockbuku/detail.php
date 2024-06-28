<?php
    require 'function.php';
    require 'cek.php';

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    // Dapeting ID barang yang dipassing di halaman sebelumnya
    $idbuku = $_GET['id']; // get id barang
    // Get informasi barang berdasarkan database
    $get = mysqli_query($conn,"SELECT * FROM stock WHERE idbuku='$idbuku'");
    $fetch = mysqli_fetch_assoc($get);
    // set variabel
    $judulbuku = $fetch['judulbuku'];
    $penerbit = $fetch['penerbit'];
    $tahun_terbit = $fetch['tahun_terbit'];
    $genre_buku = $fetch['genre_buku'];
    $penulis = $fetch['penulis'];
    $stock = $fetch['stock'];

    // cek gambar ada atau tidak
    $gambar = $fetch ['image']; //ambil buku
    if ($gambar==null) {
        // Jika tidak ada gambar
        $img = 'No Photo';
    } else {
        //Jika gambar ada
        $img = '<img src="images/'.$gambar.'" class="zoomable">';
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Detail Buku</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <style>
            .zoomable {
                width: 200px;
                height: 200px:
            }
            .zoomable:hover {
                transform: scale(1.2);
                transition: 0.3s ease;
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="detail.php">Detail</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            </form>
            <!-- Navbar-->
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
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                                <a class="nav-link" href="index.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                    Stock Buku
                                </a>
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
                        <h1 class="mt-4">Detail Buku</h1>
                        
                        
                        <div class="card mb-4 mb-4">
                            <div class="card-header">
                                <h2><?=$judulbuku;?></h2>
                                <?=$img;?>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-3"> Penerbit</div>
                                    <div class="col-md-9">: <?=$penerbit;?></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"> Tahun Terbit</div>
                                    <div class="col-md-9">: <?=$tahun_terbit;?></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"> Genre Buku</div>
                                    <div class="col-md-9">: <?=$genre_buku;?></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"> Penulis</div>
                                    <div class="col-md-9">: <?=$penulis;?></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"> Stock</div>
                                    <div class="col-md-9">: <?=$stock;?></div>
                                </div>


                                <br><br><hr>

                                <h3> Buku Masuk</h3>
                                <div class="table-responsive">
                                    <table class="table table-hover" id="bukumasuk" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Distributor</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $ambildatamasuk = mysqli_query($conn,"SELECT * FROM masuk WHERE idbuku='$idbuku'");
                                            $i = 1;
                                            while ($fetch=mysqli_fetch_array($ambildatamasuk)) {
                                                $tanggal = $fetch['tanggal'];
                                                $distributor = $fetch['distributor'];
                                                $quantity = $fetch['qty'];

                                            ?>

                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$tanggal;?></td>
                                                <td><?=$distributor;?></td>
                                                <td><?=$quantity;?></td>
                                            </tr>
                                            
                                            
                                            
                                            <?php  
                                            };
                                            ?>

                                            
                                        </tbody>
                                    </table>
                                </div>


                                <br><br>


                                <h3> Buku Keluar</h3>
                                <div class="table-responsive">
                                    <table class="table table-hover" id="bukukeluar" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Penerima</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $ambildatakeluar = mysqli_query($conn,"SELECT * FROM keluar WHERE idbuku='$idbuku'");
                                            $i = 1;
                                            while ($fetch=mysqli_fetch_array($ambildatakeluar)) {
                                                $tanggal = $fetch['tanggal'];
                                                $penerima = $fetch['penerima'];
                                                $quantity = $fetch['qty'];

                                            ?>

                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$tanggal;?></td>
                                                <td><?=$penerima;?></td>
                                                <td><?=$quantity;?></td>
                                            </tr>
                                            
                                            
                                            
                                            <?php  
                                            };
                                            ?>

                                            
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
                                <!-- JavaScript akan menambahkan tahun saat ini di sini secara otomatis -->
                            </div>
                            <div>
                                <a href="privacy.php">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var currentYear = new Date().getFullYear();
                            var footerYear = document.getElementById('copyright');
                            footerYear.innerHTML = 'Copyright &copy; ' + currentYear;
                        });
                    </script>
                </footer>
            </div>
        </div>
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

</html>