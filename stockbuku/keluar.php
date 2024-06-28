<?php
    require 'function.php';
    require 'cek.php';

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    function formatHargaIDR($harga) {
        return "Rp " . number_format($harga, 0, ',', '.');
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
        <title>Buku Keluar</title>
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
            <a class="navbar-brand" href="keluar.php">Buku Keluar</a>
            <button class="button-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
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
                        <h1 class="mt-4">Buku Keluar</h1>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="button-17" role="button" data-toggle="modal" data-target="#myModal">
                                    Tambah Buku Keluar
                                </button>
                                <a href="exportkeluar.php" class="button-17" role="button">Export Data Barang Keluar</a>
                                <br>
                                <div class="row mt-4">
                                    <div class="col">
                                        <form method="post" class="form-inline">
                                            <input type="date" name="tgl_mulai" class="form-control">
                                            <input type="date" name="tgl_selesai" class="form-control ml-3">
                                            <button type="submit" name="filter_tgl" class="button-17" role="button">Filter</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Gambar</th>
                                                <th>Judul Buku</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <th>Penerima</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if (isset($_POST['filter_tgl'])) {
                                                    $mulai = $_POST['tgl_mulai'];
                                                    $selesai = $_POST['tgl_selesai'];
    
                                                    if ($mulai != null || $selesai != null) {
                                                        $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM keluar k, stock s WHERE s.idbuku = k.idbuku AND tanggal BETWEEN '$mulai' AND DATE_ADD('$selesai', INTERVAL 1 DAY)");
                                                    } else {
                                                        $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM keluar k, stock s WHERE s.idbuku = k.idbuku");
                                                    }
                                                } else {
                                                    $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM keluar k, stock s WHERE s.idbuku = k.idbuku");
                                                }
                                                
                                                while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                                    $idk = $data['idkeluar'];
                                                    $idb = $data['idbuku'];
                                                    $tanggal = $data['tanggal'];
                                                    $judulbuku = $data['judulbuku'];
                                                    $harga = $data['harga'];
                                                    $qty = $data['qty'];
                                                    $penerima = $data['penerima'];
                                                    
                                                    // cek gambar ada atau tidak
                                                    $gambar = $data ['image']; //ambil barang
                                                    if ($gambar == null) {
                                                        // Jika tidak ada gambar
                                                        $img = 'No Photo';
                                                    } else {
                                                        //Jika gambar ada
                                                        $img = '<img src="images/'.$gambar.'" class="zoomable">';
                                                    }
                                            ?>

                                            <tr>
                                                <td><?=$tanggal;?></td>
                                                <td><?=$img;?></td>
                                                <td><?=$judulbuku;?></td>
                                                <td><?=formatHargaIDR($harga);?></td>
                                                <td><?=$qty;?></td>
                                                <td><?=$penerima;?></td>
                                                <td>
                                                    <button type="button" class="button-17" role="button" data-toggle="modal" data-target="#delete<?=$idk;?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="delete<?=$idk;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Buku Keluar</h4>
                                                            <button type="button" class="button-17" role="button" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <form method="post"> 
                                                            <div class="modal-body">
                                                                Apakah anda yakin ingin menghapus <?=$judulbuku;?>?
                                                                <input type="hidden" name="idb" value="<?=$idb;?>">
                                                                <input type="hidden" name="kty" value="<?=$qty;?>">
                                                                <input type="hidden" name="idk" value="<?=$idk;?>">
                                                                <br>
                                                                <br>
                                                                <button type="submit" class="button-17" role="button" name="hapusbukukeluar">Hapus</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

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
    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Buku Keluar</h4>
                    <button type="button" class="button-17" role="button" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <form method="post"> 
                    <div class="modal-body">
                        <select name="bukunya" id="bukunya" class="form-control" onchange="updateHarga()">
                            <?php  
                                $ambilsemuadatanya = mysqli_query($conn,"SELECT * FROM stock");
                                while ($fetcharray = mysqli_fetch_array($ambilsemuadatanya)) {
                                    $judulbukunya = $fetcharray['judulbuku'];
                                    $idbukunya = $fetcharray['idbuku'];
                            ?>
                            <option value="<?=$idbukunya;?>"><?=$judulbukunya;?></option>
                            <?php
                                }
                            ?>
                        </select>
                        <br>
                        <input type="number" name="harga" id="harga" class="form-control" placeholder="Harga" required readonly>
                        <br>
                        <input type="number" name="qty" class="form-control" placeholder="Quantity" required>
                        <br>
                        <input type="text" name="penerima" placeholder="Penerima" class="form-control" required>
                        <br>
                        <button type="submit" class="button-17" role="button" name="addbukukeluar">Tambah Buku Keluar</button>
                        <script>
                            // Fungsi untuk memperbarui harga berdasarkan pilihan buku
                            function updateHarga() {
                                var selectedBook = document.getElementById("bukunya").value;
                                var hargaInput = document.getElementById("harga");
                                
                                // Kirim permintaan AJAX untuk mendapatkan harga buku
                                var xhr = new XMLHttpRequest();
                                xhr.onreadystatechange = function() {
                                    if (xhr.readyState === XMLHttpRequest.DONE) {
                                        if (xhr.status === 200) {
                                            // Jika permintaan berhasil, isi nilai input harga dengan harga yang diperoleh
                                            hargaInput.value = xhr.responseText;
                                        } else {
                                            // Jika terjadi kesalahan, tampilkan pesan kesalahan
                                            console.error("Error: " + xhr.status);
                                        }
                                    }
                                };
                                xhr.open("GET", "get_harga.php?id=" + selectedBook, true);
                                xhr.send();
                            }

                            // Panggil fungsi updateHarga setiap kali pilihan buku berubah
                            document.getElementById("bukunya").addEventListener("change", updateHarga);
                        </script>
                    </div>
                </form>
            </div>
        </div>
    </div>
</html>
