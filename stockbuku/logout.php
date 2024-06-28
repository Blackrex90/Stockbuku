<?php  
    // Mulai sesi
	session_start();
	
	// Hapus semua data sesi
	session_unset();
	
	// Hancurkan sesi
	session_destroy();
	
	// Redirect ke halaman login dengan pesan logout
	header('location:login.php');
?>
