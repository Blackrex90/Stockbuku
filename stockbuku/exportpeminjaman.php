<?php 
    require 'function.php';
    require 'cek.php';
?>
<html>
<head>
  <title>Peminjaman Buku</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
<div class="container">
			<h2>Peminjaman Buku</h2>
				<div class="data-tables datatable-dark">
					
					<table class="table table-hover" id="mauexport" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Tanggal Pinjam</th>
                                                <th>Judul Buku</th>
                                                <th>Jumlah</th>
                                                <th>Kepada</th>
                                                <th>Tanggal Kembali</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                                $ambilsemuadatastock = mysqli_query($conn,"SELECT * FROM peminjaman p, stock s WHERE s.idbuku = p.idbuku");
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
                                                
                                            ?>

                                            <tr>

                                                <td><?php echo $tanggal_pinjam;?></td>
                                                <td><?php echo $judulbuku;?></td>
                                                <td><?php echo $qty;?></td>
                                                <td><?php echo $penerima;?></td>
                                                <td><?php echo $tanggal_kembali;?></td>
                                                <td><?php echo $status;?></td>
                                            </tr>
                                              </div>

                                            <?php  
                                                };

                                            ?>


                                        </tbody>
                                    </table>
					
				</div>
</div>
	
<script>
$(document).ready(function() {
    $('#mauexport').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'csv','excel', 'pdf', 'print'
        ]
    } );
} );

</script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

	

</body>

</html>