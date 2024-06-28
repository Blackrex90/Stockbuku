<?php 
    require 'function.php';
    require 'cek.php';
?>
<html>
<head>
  <title>Buku Keluar</title>
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
			<h2>Buku Keluar</h2>
				<div class="data-tables datatable-dark">
					
					<table class="table table-hover" id="mauexport" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Judul Buku</th>
                                                <th>Jumlah</th>
                                                <th>Penerima</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                                $ambilsemuadatastock = mysqli_query($conn,"SELECT * FROM keluar k, stock s WHERE s.idbuku = k.idbuku");
                                                while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                                    $idk = $data['idkeluar'];
                                                    $idb = $data['idbuku'];
                                                    $tanggal = $data['tanggal'];
                                                    $judulbuku = $data['judulbuku'];
                                                    $qty = $data['qty'];
                                                    $penerima = $data['penerima'];
                                                
                                            ?>

                                            <tr>

                                                <td><?php echo $tanggal;?></td>
                                                <td><?php echo $judulbuku;?></td>
                                                <td><?php echo $qty;?></td>
                                                <td><?php echo $penerima;?></td>
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