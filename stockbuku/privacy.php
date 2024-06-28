<?php 
    require 'function.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Privacy Policy</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <!-- Navbar -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">Stock Buku</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                </div>
            </div>
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
    <!-- Sidebar -->
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
                    <!-- Konten Anda di sini -->
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Privacy Policy</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            <p>
                                Selamat datang di Privacy Policy untuk Stock Buku. Kami sangat menghormati privasi Anda
                                dan berkomitmen untuk melindungi informasi pribadi yang Anda berikan kepada kami. Dokumen ini
                                menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi yang Anda berikan
                                saat menggunakan situs web kami.
                            </p>
                            <p>
                                <strong>Informasi yang Kami Kumpulkan:</strong><br>
                                Kami dapat mengumpulkan informasi pribadi seperti nama, alamat email, dan informasi kontak lainnya
                                yang Anda berikan saat menggunakan layanan kami.
                            </p>
                            <p>
                                <strong>Bagaimana Kami Menggunakan Informasi Anda:</strong><br>
                                Informasi yang kami kumpulkan dapat digunakan untuk mengelola akun Anda, memproses transaksi,
                                dan menyediakan layanan lainnya yang Anda minta. Kami tidak akan membagikan informasi pribadi Anda
                                dengan pihak ketiga tanpa izin Anda.
                            </p>
                            <p>
                                <strong>Keamanan:</strong><br>
                                Kami mengambil langkah-langkah keamanan untuk melindungi informasi pribadi Anda. Namun, perlu
                                diingat bahwa tidak ada metode transmisi atau penyimpanan data secara elektronik yang 100%
                                aman.
                            </p>
                            <p>
                                <strong>Perubahan pada Kebijakan Privasi:</strong><br>
                                Kami dapat memperbarui kebijakan privasi ini dari waktu ke waktu. Setiap perubahan akan diumumkan
                                di situs web kami. Kami menyarankan Anda untuk memeriksa halaman ini secara berkala untuk
                                mengetahui perubahan.
                            </p>
                            <p>
                                Dengan menggunakan situs web kami, Anda menyetujui kebijakan privasi ini.
                            </p>
                        </div>
                    </div>
                </div>
            </main>
            <!-- ... (kode footer tetap sama) ... -->
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
