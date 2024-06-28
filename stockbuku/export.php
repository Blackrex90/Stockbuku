<?php 
    require 'function.php';
    require 'cek.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Stock Buku</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <h2>Stock Buku</h2>
        <div class="data-tables datatable-aqua">
            <table class="table table-hover" id="mauexport" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Penerbit</th>
                        <th>Tahun Terbit</th>
                        <th>Genre Buku</th>
                        <th>Penulis</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM stock");
                    $i = 1;
                    while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                    ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><i class="fas fa-book"></i> <?= $data['judulbuku']; ?></td>
                            <td><i class="fas fa-building"></i> <?= $data['penerbit']; ?></td>
                            <td><i class="fas fa-calendar"></i> <?= $data['tahun_terbit']; ?></td>
                            <td><i class="fas fa-tags"></i> <?= $data['genre_buku']; ?></td>
                            <td><i class="fas fa-user"></i> <?= $data['penulis']; ?></td>
                            <td><i class="fas fa-boxes"></i> <?= $data['stock']; ?></td>
                        </tr>
                    <?php  
                    };
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $(document).ready(function() {
            $('#mauexport').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel', 'pdf', 'print'
                ]
            });

            // Tambahkan event click untuk tombol print
            $('#mauexport').on('click', '.buttons-print', function() {
                Swal.fire(
                    'Print',
                    'Data sedang diprint...',
                    'success'
                );
            });

            // Tambahkan event click untuk tombol lainnya seperti csv, excel, dan pdf
            $('#mauexport').on('click', '.buttons-csv, .buttons-excel, .buttons-pdf', function() {
                Swal.fire(
                    'Export',
                    'Data sedang diexport...',
                    'success'
                );
            });
        });
    </script>
</body>
</html>
