<?php
require 'function.php';
require 'cek.php';

// Aktifkan tampilan error dan laporan kesalahan PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Kelola Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="admin.php">Admin</a>
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
                    <h1 class="mt-4">Kelola Admin</h1>
                    
                    <div class="card mb-4">
                        <div class="card-header">
                              <!-- Button to Open the Modal -->
                              <button type="button" class="button-17" role="button" data-toggle="modal" data-target="#myModal">
                                Tambah Admin
                              </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                            $ambilsemuadataadmin = mysqli_query($conn,"SELECT * FROM register");
                                            $i = 1;
                                            while ($data = mysqli_fetch_array($ambilsemuadataadmin)) {
                                                $first_name = $data['first_name'];
                                                $last_name = $data['last_name'];
                                                $email = $data['email'];
                                                $idregister = $data['idregister'];
                                            
                                        ?>

                                        <tr>

                                            <td><?=$i++;?></td>
                                            <td><?=$first_name;?></td>
                                            <td><?=$last_name;?></td>
                                            <td><?=$email;?></td>
                                            <td>
                                                <button type="button" class="button-17" role="button" data-toggle="modal" data-target="#edit<?=$idregister;?>">
                                                    Edit
                                                </button>
                                                <button type="button" class="button-17" role="button" data-toggle="modal" data-target="#delete<?=$idregister;?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                          <div class="modal fade" id="edit<?=$idregister;?>">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                              
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                  <h4 class="modal-title">Edit Admin</h4>
                                                  <button type="button" class="button-17" role="button" data-dismiss="modal">&times;</button>
                                                </div>
                                                
                                                <!-- Modal body -->
                                                <form method="post"> 
                                                    <div class="modal-body">
                                                        <input type="text" name="first_name" value="<?=$first_name;?>" class="form-control" placeholder="First Name" required>
                                                        <br>
                                                        <input type="text" name="last_name" value="<?=$last_name;?>" class="form-control" placeholder="Last Name" required>
                                                        <br>
                                                        <input type="email" name="emailadmin" value="<?=$email;?>" class="form-control" placeholder="Email" required>
                                                        <br>
                                                        <input type="password" name="passwordbaru" value="<?=$email;?>" class="form-control" placeholder="Password">
                                                        <br>
                                                        <input type="hidden" name="id" value="<?=$idregister;?>">
                                                        <button type="submit" class="button-17" role="button" name="updateadmin">Edit</button>
                                                    </div>
                                                </form>
                                              </div>
                                            </div>
                                          </div>


                                        <!-- Delete Modal -->
                                          <div class="modal fade" id="delete<?=$idregister;?>">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                              
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                  <h4 class="modal-title">Hapus Admin?</h4>
                                                  <button type="button" class="button-17" role="button" data-dismiss="modal">&times;</button>
                                                </div>
                                                
                                                <!-- Modal body -->
                                                <form method="post"> 
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus <?=$email;?>?
                                                        <input type="hidden" name="id" value="<?=$idregister;?>">
                                                        <br>
                                                        <br>
                                                        <button type="submit" class="button-17" role="button" name="hapusadmin">Hapus</button>
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
            
        </div>
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
            
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Admin</h4>
                <button type="button" class="button-17" role="button" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <input type="text" name="first_name" placeholder="First Name" class="form-control" required>
                    <br>
                    <input type="text" name="last_name" placeholder="Last Name" class="form-control" required>
                    <br>
                    <input type="email" name="email" placeholder="Email" class="form-control" required>
                    <br>
                    <input type="password" name="password" placeholder="Password" class="form-control" required>
                    <br>
                    <button type="submit" class="button-17" role="button" name="addnewadmin">Submit</button>
                </div>
            </form>
            
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/datatables-demo.js"></script>
</body>
</html>
