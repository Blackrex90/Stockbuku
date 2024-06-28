<?php
    require 'function.php'; // Sesuaikan dengan lokasi file function.php Anda

    if (isset($_GET['id'])) {
        $idBuku = $_GET['id'];
        $query = "SELECT harga FROM stock WHERE idbuku = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $idBuku);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo $row['harga'];
        } else {
            echo "Harga tidak tersedia";
        }
        $stmt->close();
    } else {
        echo "ID buku tidak ditemukan";
    }
?>
