<?php
	// Enkripsi data sesi
	function encrypt($data, $key) {
		$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
		$encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
		return base64_encode($encrypted . '::' . $iv);
	}
	
	function decrypt($data, $key) {
		list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
		return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
	}
	
	class SecureDatabaseSessionHandler implements SessionHandlerInterface {
		private $db;
		private $key;
	
		public function __construct($key) {
			$this->key = $key;
			$this->db = new PDO('mysql:host=localhost;dbname=stockbuku', 'root', '');
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	
		public function open($savePath, $sessionName): bool {
			return true;
		}
	
		public function close(): bool {
			return true;
		}
	
		public function read($id): string|false {
			$stmt = $this->db->prepare('SELECT data FROM sessions WHERE id = :id LIMIT 1');
			$stmt->bindParam(':id', $id, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result ? decrypt($result['data'], $this->key) : '';
		}
	
		public function write($id, $data): bool {
			$encrypted_data = encrypt($data, $this->key);
			$stmt = $this->db->prepare('REPLACE INTO sessions (id, data, last_access) VALUES (:id, :data, NOW())');
			$stmt->bindParam(':id', $id, PDO::PARAM_STR);
			$stmt->bindParam(':data', $encrypted_data, PDO::PARAM_STR);
			return $stmt->execute();
		}
	
		public function destroy($id): bool {
			$stmt = $this->db->prepare('DELETE FROM sessions WHERE id = :id');
			$stmt->bindParam(':id', $id, PDO::PARAM_STR);
			return $stmt->execute();
		}
	
		public function gc($maxlifetime): int|false {
			$stmt = $this->db->prepare('DELETE FROM sessions WHERE last_access < NOW() - INTERVAL :maxlifetime SECOND');
			$stmt->bindParam(':maxlifetime', $maxlifetime, PDO::PARAM_INT);
			return $stmt->execute();
		}
	}
	
	// Set secure session handler
	session_set_save_handler(new SecureDatabaseSessionHandler('your-encryption-key'), true);
	
	// Start the session
	session_start();
	
	// Durasi sesi dalam detik
	$session_duration = 600; // 10 menit
	
	// Memeriksa waktu aktivitas terakhir
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $session_duration)) {
		session_unset();
		session_destroy();
		session_start();
	}
	
	// Memperbarui waktu aktivitas terakhir
	$_SESSION['LAST_ACTIVITY'] = time();
	
	// Menyimpan IP address pengguna saat sesi dimulai
	if (!isset($_SESSION['IP_ADDRESS'])) {
		$_SESSION['IP_ADDRESS'] = $_SERVER['REMOTE_ADDR'];
	}
	
	// Memeriksa apakah IP address berubah
	if ($_SESSION['IP_ADDRESS'] !== $_SERVER['REMOTE_ADDR']) {
		session_unset();
		session_destroy();
		session_start();
	}
	
	// Create a database connection
	$conn = new mysqli("localhost", "root", "", "stockbuku");
	
	// Check for errors and display them
	if ($conn->connect_error) {
		logError("Connection failed: " . $conn->connect_error);
		exit;
	}
	
	// Enable error reporting and display errors
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	// Tambahan keamanan: CSRF protection
	function validateCSRFToken($token)
	{
		if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
			logError("Invalid CSRF token");
			exit;
		}
	}
	
	// Tambahan keamanan: Input filtering
	function filterInput($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	// Fungsi untuk menampilkan pesan kesalahan menggunakan SweetAlert
	function showErrorMessage($message, $redirectURL)
	{
		echo '<script>
				document.addEventListener("DOMContentLoaded", function() {
					Swal.fire({
						icon: "error",
						title: "Oops...",
						text: "'.$message.'",
						showConfirmButton: true,
						timer: 900
					}).then(function() {
						window.location.href = "'.$redirectURL.'";
					});
				});
			</script>';
	}
	
	// Fungsi untuk menampilkan pesan sukses menggunakan SweetAlert
	function showSuccessMessage($message, $redirectURL)
	{
		echo '<script>
				document.addEventListener("DOMContentLoaded", function() {
					Swal.fire({
						icon: "success",
						title: "Success",
						text: "'.$message.'",
						showConfirmButton: true,
						timer: 900
					}).then(function() {
						window.location.href = "'.$redirectURL.'";
					});
				});
			</script>';
	}
	
	// Log errors to a file
	function logError($message)
	{
		error_log($message, 3, 'error.log');
	}
	
	// Token CSRF protection
	if (empty($_SESSION['csrf_token'])) {
		$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
	}
	
	// Memverifikasi token CSRF
	function verify_csrf_token($token) {
		return hash_equals($_SESSION['csrf_token'], $token);
	}
	
	// Fungsi untuk menghindari XSS
	function escapeHTML($data) {
		return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
	}
	

	

	//Menambah Buku
	if (isset($_POST['addnewbuku'])) {
		$judulbuku = $_POST['judulbuku'];
        $penulis = $_POST['penulis'];
		$harga = $_POST['harga'];
        $stock = $_POST['stock'];
        $penerbit = $_POST['penerbit'];
        $tahun_terbit = $_POST['tahun_terbit'];
        $genre_buku = $_POST['genre_buku'];
        $idb = $_POST['idbuku'];

		//soal gambar
		$allowed_extension = array('png','jpg','jpeg');
		$nama = $_FILES['file']['name']; //ngambil nama gambar
		$dot = explode('.', $nama);
		$ekstensi = strtolower(end($dot)); //ngambil exstensinya
		$ukuran = $_FILES['file']['size']; //ngambil size filenya
		$file_tmp = $_FILES['file']['tmp_name']; //ngambil lokasi filenya

		//penamaan file -> enkripsi
		$image = md5(uniqid($nama, true) . time()) . '.' . $ekstensi; //menggabungkan nama file yg dienkripsi dgn ekstensinya

		//validasi udah ada atau belum
		$cek = mysqli_query($conn, "select * from stock where judulbuku='$judulbuku'");
		$hitung = mysqli_num_rows($cek);

		if ($hitung < 1) {
			//jika belum ada

			//proses upload gambar
			if (in_array($ekstensi, $allowed_extension) === true) {
				//validasi ukuran filenya
				if ($ukuran < 15000000) {
					move_uploaded_file($file_tmp, '/opt/lampp/htdocs/stockbuku/images/' . $image);

					$addtotable = mysqli_query($conn, "insert into stock (judulbuku, penulis, harga, stock, penerbit, tahun_terbit, genre_buku, image) values('$judulbuku','$penulis', '$harga', '$stock','$penerbit','$tahun_terbit','$genre_buku','$image')");
					if ($addtotable) {
						showSuccessMessage("Gambar berhasil diunggah!", "index.php");
					} else {
						showErrorMessage("Gambar tidak berhasil diunggah!", "index.php");
					}
				} else {
					showErrorMessage("Ukuran file terlalu besar! (Max: 15MB)", "index.php");
				}
			} else {
				showErrorMessage("Ekstensi file tidak didukung!", "index.php");
			}
		} else {
			showErrorMessage("Judul buku sudah ada!", "index.php");
		}
	}

	//menambah buku masuk
	if (isset($_POST['bukumasuk'])) {
		$bukunya = $_POST['bukunya'];
		$distributor = $_POST['distributor'];
		$qty = $_POST['qty'];

		$cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbuku='$bukunya'");
		$ambildatanya = mysqli_fetch_array($cekstocksekarang);

		$stocksekarang = $ambildatanya['stock'];
		$tambahkanstocksekarangdenganquantity = $stocksekarang + $qty;

		$addtomasuk = mysqli_query($conn, "INSERT INTO masuk (idbuku, distributor, qty) VALUES('$bukunya','$distributor','$qty') ");
		$updatestockmasuk = mysqli_query($conn, "UPDATE stock SET stock='$tambahkanstocksekarangdenganquantity' WHERE idbuku='$bukunya'");
		if ($addtomasuk && $updatestockmasuk) {
			showSuccessMessage("Buku Masuk berhasil ditambahkan", "masuk.php");
		} else {
			showErrorMessage("Gagal menambahkan buku masuk", "masuk.php");
		}
	}

	// Menambah buku keluar
	if (isset($_POST['addbukukeluar'])) {
		// Pastikan semua data yang diperlukan sudah tersedia
		if (isset($_POST['bukunya'], $_POST['harga'], $_POST['penerima'], $_POST['qty'])) {
			$bukunya = $_POST['bukunya'];
			$harga = $_POST['harga'];
			$penerima = $_POST['penerima'];
			$qty = $_POST['qty'];

			// Mengambil data stok buku yang dipilih
			$cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbuku='$bukunya'");
			if ($cekstocksekarang) {
				$ambildatanya = mysqli_fetch_array($cekstocksekarang);
				$stocksekarang = $ambildatanya['stock'];

				// Memeriksa apakah stok mencukupi
				if ($stocksekarang >= $qty) {
					// Jika stok mencukupi
					$tambahkanstocksekarangdenganquantity = $stocksekarang - $qty;

					// Menambahkan data buku keluar
					$addtokeluar = mysqli_query($conn, "INSERT INTO keluar (idbuku, harga, penerima, qty) VALUES('$bukunya', '$harga', '$penerima', '$qty')");
					$updatestockmasuk = false;

					if ($addtokeluar) {
						// Mengupdate stok buku di tabel 'stock'
						$updatestockmasuk = mysqli_query($conn, "UPDATE stock SET stock='$tambahkanstocksekarangdenganquantity' WHERE idbuku='$bukunya'");
					}

					if ($updatestockmasuk) {
						showSuccessMessage("Buku keluar berhasil ditambahkan", "keluar.php");
					} else {
						showErrorMessage("Gagal menambahkan buku keluar", "keluar.php");
					}
				} else {
					// Jika stok tidak mencukupi
					showErrorMessage("Stok saat ini tidak mencukupi", "keluar.php");
				}
			} else {
				// Jika query gagal dieksekusi
				showErrorMessage("Gagal mengambil data stok buku", "keluar.php");
			}
		} else {
			// Jika ada data yang kurang
			showErrorMessage("Data yang diperlukan tidak lengkap", "keluar.php");
		}
	}

	//update info buku
	if (isset($_POST['updatebuku'])) {
		$idb = $_POST['idb'];
		$judulbuku = $_POST['judulbuku'];
		$penerbit = $_POST['penerbit'];
		$tahun_terbit = $_POST['tahun_terbit'];
		$genre_buku = $_POST['genre_buku'];
		$penulis = $_POST['penulis'];
		$harga = $_POST['harga'];
	
		// Image handling
		$allowed_extension = array('png', 'jpg', 'jpeg', 'heic');
		$nama = $_FILES['file']['name']; // get the file name
		$dot = explode('.', $nama);
		$ekstensi = strtolower(end($dot)); // get the file extension
		$ukuran = $_FILES['file']['size']; // get the file size
		$file_tmp = $_FILES['file']['tmp_name']; // get the temp file location
	
		// Generate unique file name
		$image = md5(uniqid($nama, true) . time()) . '.' . $ekstensi; // generate unique file name with extension
	
		if ($ukuran == 0) {
			// If no file uploaded
			$update = $conn->prepare("UPDATE stock SET judulbuku=?, penerbit=?, tahun_terbit=?, genre_buku=?, penulis=?, harga=? WHERE idbuku=?");
			$update->bind_param("ssisssi", $judulbuku, $penerbit, $tahun_terbit, $genre_buku, $penulis, $harga, $idb);
			if ($update->execute()) {
				showSuccessMessage("Data buku berhasil diperbarui", "index.php");
			} else {
				showErrorMessage("Gagal memperbarui data buku", "index.php");
			}
		} else {
			// If file is uploaded
			if (move_uploaded_file($file_tmp, '/opt/lampp/htdocs/stockbuku/images/' . $image)) {
				$update = $conn->prepare("UPDATE stock SET judulbuku=?, penerbit=?, tahun_terbit=?, genre_buku=?, penulis=?, harga=?, image=? WHERE idbuku=?");
				$update->bind_param("ssissssi", $judulbuku, $penerbit, $tahun_terbit, $genre_buku, $penulis, $harga, $image, $idb);
				if ($update->execute()) {
					showSuccessMessage("Data buku berhasil diperbarui", "index.php");
				} else {
					showErrorMessage("Gagal memperbarui data buku", "index.php");
				}
			} else {
				showErrorMessage("Gagal mengunggah gambar. Pastikan direktori memiliki izin yang tepat.", "index.php");
			}
		}
	}
	
	
	

	//hapus buku dari stock
	if (isset($_POST['hapusbuku'])) {
		$idb = $_POST['idb']; //idbuku
		
		$gambar = mysqli_query($conn, "select * from stock where idbuku='$idb'");
		$get = mysqli_fetch_array($gambar);
		$img = '/opt/lampp/htdocs/stockbuku/images/' . $get['image'];
		unlink($img);
		
		$hapus = mysqli_query($conn, "delete from stock where idbuku='$idb'");
		if ($hapus) {
			showSuccessMessage("Data buku berhasil dihapus", "index.php");
		} else {
			showErrorMessage("Gagal menghapus data buku", "index.php");
		}
	}

	//mengubah data buku masuk
	if (isset($_POST['updatebukumasuk'])) {
		$idb = $_POST['idb'];
		$idm = $_POST['idm'];
		$penulis = $_POST['keterangan'];
		$qty = $_POST['qty'];
		
		$lihatstock = mysqli_query($conn,"SELECT * FROM stock WHERE idbuku='$idb'");
		$stocknya = mysqli_fetch_array($lihatstock);
		$stockskrg = $stocknnya['stock'];
		
		$qtyskrg = mysqli_query($conn,"SELECT * FROM masuk WHERE idmasuk='$idm'");
		$qtynya = mysqli_fetch_array($qtyskrg);
		$qtyskrg = $qtynya['qty'];
		
		if ($qty>$qtyskrg) {
			$selisih = $qty-$qtyskrg;
			$kurangin = $stockskrg + $selisih;
			$kurangistocknya = mysqli_query($conn,"UPDATE stock SET stock='$kurangin' WHERE idbuku='$idb'");
			$updatenya = mysqli_query($conn,"UPDATE masuk SET qty='$qty', keterangan='$penulis' WHERE idmasuk='$idm'");
			
			if ($kurangistocknya&&$updatenya) {
				showSuccessMessage("Data buku masuk berhasil diperbarui", "masuk.php");
			} else {
				showErrorMessage("Gagal memperbarui data buku masuk", "masuk.php");
			}
		} else {
			$selisih = $qtyskrg-$qty;
			$kurangin = $stockskrg - $selisih;
			$kurangistocknya = mysqli_query($conn,"UPDATE stock SET stock='$kurangin' WHERE idbuku='$idb'");
			$updatenya = mysqli_query($conn,"UPDATE masuk SET qty='$qty', keterangan='$penulis' WHERE idmasuk='$idm'");
			
			if ($kurangistocknya&&$updatenya) {
				showSuccessMessage("Data buku masuk berhasil diperbarui", "masuk.php");
			} else {
				showErrorMessage("Gagal memperbarui data buku masuk", "masuk.php");
			}
		}
	}

	//menghapus buku masuk
	if (isset($_POST['hapusbukumasuk'])) {
		$idb = $_POST['idb'];
		$qty = $_POST['kty'];
		$idm = $_POST['idm'];
		
		$getdatastock = mysqli_query($conn,"SELECT * FROM stock WHERE idbuku='$idb'");
		$data = mysqli_fetch_array($getdatastock);
		$stok = $data['stock'];
		
		$selisih = $stok-$qty;
		
		$update = mysqli_query($conn,"UPDATE stock SET stock='$selisih' WHERE idbuku='$idb'");
		$hapusdata = mysqli_query($conn,"DELETE FROM masuk WHERE idmasuk='$idm'");
		
		if ($update&&$hapusdata) {
			showSuccessMessage("Data buku masuk berhasil dihapus", "masuk.php");
		} else {
			showErrorMessage("Gagal menghapus data buku masuk", "masuk.php");
		}
	}

	//Mengubah data buku keluar
	if (isset($_POST['updatebukukeluar'])) {
		$idb = $_POST['idb'];
		$idk = $_POST['idk'];
		$penerima = $_POST['penerima'];
		$harga = $_POST['harga'];
		$qty = $_POST['qty']; //qty baru inputan user
		
		//mengambil stok buku saat ini
		$lihatstock = mysqli_query($conn, "select * from stock where idbuku='$idb'");
		$stocknya = mysqli_fetch_array($lihatstock);
		$stockskrg = $stocknya['stock'];

		//qty buku keluar saat ini
		$qtyskrg = mysqli_query($conn, "select * from keluar where idkeluar='$idk'");
		$qtynya = mysqli_fetch_array($qtyskrg);
		$qtyskrg = $qtynya['qty'];
		
		if ($qty > $qtyskrg) {
			$selisih = $qty - $qtyskrg;
			$kurangin = $stockskrg - $selisih;
			
			if ($selisih <= $stockskrg) {
				$kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbuku='$idb'");
				$updatenya = mysqli_query($conn, "update keluar set qty='$qty', penerima='$penerima', harga='$harga' where idkeluar='$idk'");
				if ($kurangistocknya && $updatenya) {
					showSuccessMessage("Data buku keluar berhasil diperbarui", "keluar.php");
				} else {
					showErrorMessage("Gagal memperbarui data buku keluar", "keluar.php");
				}
			} else {
				showErrorMessage("Stock tidak mencukupi", "keluar.php");
			}
		} else {
			$selisih = $qtyskrg - $qty;
			$kurangin = $stockskrg + $selisih;
			$kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbuku='$idb'");
			$updatenya = mysqli_query($conn, "update keluar set qty='$qty', penerima='$penerima', harga='$harga' where idkeluar='$idk'");
			if ($kurangistocknya && $updatenya) {
				showSuccessMessage("Data buku keluar berhasil diperbarui", "keluar.php");
			} else {
				showErrorMessage("Gagal memperbarui data buku keluar", "keluar.php");
			}
		}
	}

	//menghapus buku keluar
	if (isset($_POST['hapusbukukeluar'])) {
		$idb = $_POST['idb'];
		$qty = $_POST['kty'];
		$idk = $_POST['idk'];
		
		$getdatastock = mysqli_query($conn,"SELECT * FROM stock WHERE idbuku='$idb'");
		$data = mysqli_fetch_array($getdatastock);
		$stok = $data['stock'];
		
		$selisih = $stok+$qty;
		
		$update = mysqli_query($conn,"UPDATE stock SET stock='$selisih' WHERE idbuku='$idb'");
		$hapusdata = mysqli_query($conn,"DELETE FROM keluar WHERE idkeluar='$idk'");
		
		if ($update&&$hapusdata) {
			showSuccessMessage("Data buku keluar berhasil dihapus", "keluar.php");
		} else {
			showErrorMessage("Gagal menghapus data buku keluar", "keluar.php");
		}
	}

	
	// Mengedit data admin
	if (isset($_POST['updateadmin'])) {
		$id = $_POST['id'];
		$first_namebaru = $_POST['first_name'];
		$lastnamebaru = $_POST['last_name'];
		$emailbaru = $_POST['emailadmin'];
		$passwordbaru = $_POST['passwordbaru'];
		
		// Buat query untuk mengupdate data
		if (empty($passwordbaru)) {
			// Jika password tidak diubah
			$query = "UPDATE register SET first_name=?, last_name=?, email=? WHERE idregister=?";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("sssi", $first_namebaru, $lastnamebaru, $emailbaru, $id);
		} else {
			// Jika password diubah
			$passwordbaru = password_hash($passwordbaru, PASSWORD_DEFAULT);
			$query = "UPDATE register SET first_name=?, last_name=?, email=?, password=? WHERE idregister=?";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("ssssi", $first_namebaru, $lastnamebaru, $emailbaru, $passwordbaru, $id);
		}

		if ($stmt->execute()) {
			showSuccessMessage("Admin berhasil diperbarui", "admin.php");
		} else {
			showErrorMessage("Gagal memperbarui admin", "admin.php");
		}
	}


	// Menambah data admin baru
	if (isset($_POST['addnewadmin'])) {
		$first_name = $_POST['first_name'];
		$lastname = $_POST['last_name'];
		$email = $_POST['email'];
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

		$query = "INSERT INTO register (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("ssss", $first_name, $lastname, $email, $password);

		if ($stmt->execute()) {
			showSuccessMessage("Admin berhasil ditambahkan", "admin.php");
		} else {
			showErrorMessage("Gagal menambahkan admin", "admin.php");
		}
	}


	// Menghapus data admin
	if (isset($_POST['hapusadmin'])) {
		$id = $_POST['id'];
		
		$query = "DELETE FROM register WHERE idregister=?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("i", $id);

		if ($stmt->execute()) {
			showSuccessMessage("Admin berhasil dihapus", "admin.php");
		} else {
			showSuccessMessage("Gagal menghapus admin", "admin.php");
		}
	}

	
	
	// Function to calculate fine based on delay
	function calculateFine($dueDate, $returnDate) {
		$dueDate = new DateTime($dueDate);
		$returnDate = new DateTime($returnDate);
		$interval = $dueDate->diff($returnDate);
		$daysLate = $interval->days;

		// If return date is before or on due date, no fine
		if ($returnDate <= $dueDate) {
			return [0, 0]; // [daysLate, fineAmount]
		}

		$finePerDay = 1000; // Example fine amount per day
		$fineAmount = $daysLate * $finePerDay;

		return [$daysLate, $fineAmount];
	}

	// meminjam buku
	if (isset($_POST['pinjam'])) {
		$bukunya = $_POST['bukunya'];
		$qty = $_POST['qty'];
		$penerima = $_POST['penerima'];
		$tanggal_kembali = $_POST['tanggal_kembali']; // Get the selected return date from the form

		// Get current stock
		$stock_saat_ini = mysqli_query($conn, "SELECT * FROM stock WHERE idbuku='$bukunya'");
		$stock_nya = mysqli_fetch_array($stock_saat_ini);
		$stock = $stock_nya['stock'];

		// Reduce stock
		$new_stock = $stock - $qty;

		// Convert the selected return date to a valid date format
		$tanggal_kembali = date('Y-m-d', strtotime($tanggal_kembali));
		$tanggal_pinjam = date('Y-m-d'); // Current date

		// Insert into peminjaman table
		$insertpinjam = mysqli_query($conn, "INSERT INTO peminjaman (idbuku, qty, peminjam, tanggal_pinjam, tanggal_kembali, status) VALUES ('$bukunya', '$qty', '$penerima', '$tanggal_pinjam', '$tanggal_kembali', 'Dipinjam')");

		// Reduce stock in stock table
		$kurangistock = mysqli_query($conn, "UPDATE stock SET stock='$new_stock' WHERE idbuku='$bukunya'");

		if ($insertpinjam && $kurangistock) {
			showSuccessMessage("Berhasil meminjam buku", "peminjaman.php");
		} else {
			showErrorMessage("Gagal meminjam buku", "peminjaman.php");
		}
	}

	// menyelesaikan pinjaman
	if (isset($_POST['bukukembali'])) {
		$idp = $_POST['idpeminjaman'];
		$idbuku = $_POST['idbuku'];
		$tanggal_kembali = date('Y-m-d'); // Current date

		// Update status to 'Kembali' and set the return date
		$update_status = mysqli_query($conn, "UPDATE peminjaman SET status='Kembali', tanggal_kembali='$tanggal_kembali' WHERE idpeminjaman='$idp'");

		// Get current stock
		$stock_saat_ini = mysqli_query($conn, "SELECT * FROM stock WHERE idbuku='$idbuku'");
		$stock_nya = mysqli_fetch_array($stock_saat_ini);
		$stock = $stock_nya['stock'];

		// Get quantity from peminjaman
		$stock_saat_ini1 = mysqli_query($conn, "SELECT * FROM peminjaman WHERE idpeminjaman='$idp'");
		$stock_nya1 = mysqli_fetch_array($stock_saat_ini1);
		$qty = $stock_nya1['qty'];

		// Calculate fine
		$original_due_date = $stock_nya1['tanggal_kembali'];
		list($daysLate, $fineAmount) = calculateFine($original_due_date, $tanggal_kembali);

		// Update the fine amount in the database
		$update_denda = mysqli_query($conn, "UPDATE peminjaman SET denda='$fineAmount' WHERE idpeminjaman='$idp'");

		// Return the stock
		$new_stock = $qty + $stock;
		$kembalikan_stock = mysqli_query($conn, "UPDATE stock SET stock='$new_stock' WHERE idbuku='$idbuku'");

		if ($update_status && $kembalikan_stock && $update_denda) {
			if ($daysLate > 0) {
				showSuccessMessage("Buku telah kembali. Terlambat $daysLate hari. Denda: Rp. $fineAmount", "peminjaman.php");
			} else {
				showSuccessMessage("Buku telah kembali tepat waktu.", "peminjaman.php");
			}
		} else {
			showErrorMessage("Gagal mengembalikan buku", "peminjaman.php");
		}
	}






?>
