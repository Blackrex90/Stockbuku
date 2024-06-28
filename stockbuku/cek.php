<?php  
    // Periksa apakah sesi sudah dimulai
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Cek apakah pengguna sudah login
    if (isset($_SESSION['log'])) {
        // Pengguna sudah login, lanjutkan ke halaman selanjutnya
    } else {
        // Pengguna belum login
        if (isset($_POST['register'])) {
            // Pengguna mengklik tombol register
            header('location: register.php'); // Arahkan pengguna ke halaman register
            exit(); // Hentikan eksekusi skrip setelah pengalihan
        } else {
            // Pengguna belum login dan belum mengklik tombol register
            header('location: login.php'); // Arahkan pengguna ke halaman login
            exit(); // Hentikan eksekusi skrip setelah pengalihan
        }
    }
    
    
?>
