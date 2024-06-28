<?php
    require 'function.php';
    require 'cek.php';

    // Aktifkan tampilan error dan laporan kesalahan PHP
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
        <title>Stock Buku</title>
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

            a{
                text-decoration:none;
                color:black;
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">Stock Buku</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0"></form>
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
                        <h1 class="mt-4">Stock Buku</h1>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                  <!-- Button to Open the Modal -->
                                  <button type="button" class="button-17" role="button" data-toggle="modal" data-target="#myModal">
                                    Tambah Buku
                                  </button>
                                  <a href="export.php" class="button-17" role="button">Export Data</a>
                            </div>
                            <div class="card-body">

                                <?php
                                    $ambildatastock = mysqli_query($conn,"SELECT * FROM stock WHERE stock < 1");
                                    while ($fetch=mysqli_fetch_array($ambildatastock)) {
                                          $buku = $fetch['judulbuku'];
                                        
                                ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Maaf!</strong> Stock <?=$buku;?> Telah Habis.
                                </div>
                                <?php  
                                    }
                                ?>

                                <div class="table-responsive">
                                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Gambar</th>
                                                <th>Judul Buku</th>
                                                <th>Penerbit</th>
                                                <th>Tahun Terbit</th>
                                                <th>Genre Buku</th>
                                                <th>Penulis</th>
                                                <th>Harga</th>
                                                <th>Stock</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                                $ambilsemuadatastock = mysqli_query($conn,"SELECT * FROM stock");
                                                $i = 1;
                                                while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                                    $judulbuku = $data['judulbuku'];
                                                    $penulis = $data['penulis'];
                                                    $harga = $data['harga'];
                                                    $stock = $data['stock'];
                                                    $penerbit = $data['penerbit'];
                                                    $tahun_terbit = $data['tahun_terbit'];
                                                    $genre_buku = $data['genre_buku'];
                                                    $idb = $data['idbuku'];

                                                    // cek gambar ada atau tidak
                                                    $gambar = $data ['image']; //ambil barang
                                                    if ($gambar==null) {
                                                        // Jika tidak ada gambar
                                                        $img = 'No Photo';
                                                    } else {
                                                        //Jika gambar ada
                                                        $img = '<img src="images/'.$gambar.'" class="zoomable">';
                                                    }
                                                
                                            ?>

                                            <tr>

                                            <td><?= $i++; ?></td>
                                            <td><?= $img; ?></td>
                                            <td><strong><a href="detail.php?id=<?= $idb; ?>"><?= $judulbuku; ?></a></strong></td>
                                            <td><?= $penerbit; ?></td>
                                            <td><?= $tahun_terbit; ?></td>
                                            <td><?= $genre_buku; ?></td>
                                            <td><?= $penulis; ?></td>
                                            <td><?= formatHargaIDR($harga); ?></td>
                                            <td><?= $stock; ?></td>
                                                <td>
                                                    <button type="button" class="button-17" role="button" data-toggle="modal" data-target="#edit<?=$idb;?>">
                                                        Edit
                                                    </button>
                                                    <input type="hidden" name="idbukuyangmaudihapus" value="<?=$idb;?>">
                                                    <button type="button" class="button-17" role="button" data-toggle="modal" data-target="#delete<?=$idb;?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?=$idb;?>">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Buku</h4>
                                                            <button type="button" class="button-17" role="button" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        
                                                        <!-- Modal body -->
                                                        <form method="post" enctype="multipart/form-data"> 
                                                            <div class="modal-body">
                                                                <input type="text" name="judulbuku" value="<?=$judulbuku;?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="penerbit" value="<?=$penerbit;?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="tahun_terbit" value="<?=$tahun_terbit;?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="genre_buku" value="<?=$genre_buku;?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="penulis" value="<?=$penulis;?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="harga" value="<?=$harga;?>" class="form-control" required>
                                                                <br>
                                                                <input type="file" name="file" class="form-control">
                                                                <br>
                                                                <input type="hidden" name="idb" value="<?=$idb;?>">
                                                                <button type="submit" class="button-17" role="button" name="updatebuku">Edit</button>
                                                            </div>
                                                        </form>
                                                        
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="delete<?=$idb;?>">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Buku</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        
                                                        <!-- Modal body -->
                                                        <form method="post"> 
                                                            <div class="modal-body">
                                                                Apakah anda yakin ingin menghapus <?=$judulbuku;?>?
                                                                <input type="hidden" name="idb" value="<?=$idb;?>">
                                                                <br>
                                                                <br>
                                                                <button type="submit" class="button-17" role="button" name="hapusbuku">Delete</button>
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
              <h4 class="modal-title">Tambah Buku</h4>
              <button type="button" class="button-17" role="button" data-dismiss="modal">&times;</button>            </div>
            
            <!-- Modal body -->
            <form method="post" enctype="multipart/form-data"> 
                <div class="modal-body">
                    <input type="text" name="judulbuku" placeholder="Judul Buku" class="form-control" required>
                    <br>
                    
                    <input type="text" name="penerbit" placeholder="Penerbit" class="form-control" required>
                    <br>
                    <input type="text" name="tahun_terbit" placeholder="Tahun Terbit" class="form-control" required>
                    <br>
                    <input type="text" name="genre_buku" placeholder="Genre Buku" class="form-control" required>
                    <br>
                    <input type="text" name="penulis" placeholder="Penulis" class="form-control" required>
                    <br>
                    <input type="text" name="harga" placeholder="Harga" class="form-control" required>
                    <br>
                    <input type="number" name="stock" placeholder="Stock" class="form-control" required>
                    <br>
                    <input type="file" name="file" class="form-control">
                    <br>
                    <button type="submit" class="button-17" role="button" name="addnewbuku">Tambah Buku</button>
                </div>
            </form>
            
          </div>
        </div>
    
    </div>

</html>
