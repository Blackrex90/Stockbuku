<?php
    require 'function.php';

    // Aktifkan tampilan error dan laporan kesalahan PHP
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Inisialisasi pesan error
    $errors = [];

    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Lakukan proses autentikasi
        $query = "SELECT * FROM register WHERE email=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // Verifikasi password menggunakan password_verify
            if (password_verify($password, $row['password'])) {
                // Lakukan pemeriksaan apakah pengguna sudah ada di tabel login
                $login_query = "SELECT * FROM login WHERE email=?";
                $login_stmt = mysqli_prepare($conn, $login_query);
                mysqli_stmt_bind_param($login_stmt, "s", $email);
                mysqli_stmt_execute($login_stmt);
                $login_result = mysqli_stmt_get_result($login_stmt);

                if (!mysqli_fetch_assoc($login_result)) {
                    // Jika pengguna belum ada di tabel login, tambahkan entri baru
                    $insert_query = "INSERT INTO login (username, last_name, email, password) VALUES (?, ?, ?, ?)";
                    $insert_stmt = mysqli_prepare($conn, $insert_query);
                    // Ambil username dan first_name dari tabel register
                    $first_name = $row['first_name'];
                    $last_name = $row['last_name'];
                    mysqli_stmt_bind_param($insert_stmt, "ssss", $first_name, $last_name, $email, $row['password']);
                    mysqli_stmt_execute($insert_stmt);
                }

                // Set session
                $_SESSION['log'] = true;

                // Redirect ke halaman index
                header('location: index.php');
                exit();
            } else {
                // Jika password tidak cocok, tampilkan pesan error
                $errors[] = "Invalid email or password";
            }
        } else {
            // Jika email tidak ditemukan, tampilkan pesan error
            $errors[] = "Invalid email format";
        }
    }

    function validate_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login</title>
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <style>

        /* Kartu login akan muncul dengan efek */
        .card {
            opacity: 0;
            animation: fadeIn 0.5s ease forwards;
        }

        /* Animasi muncul */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <!-- Tambahkan kelas "card" -->
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                <div class="card-body">
                                    <?php if (!empty($errors)) : ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php foreach ($errors as $error) : ?>
                                                <p><?php echo $error; ?></p>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    <form method="post">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputUsernamew">Username</label>
                                            <input class="form-control py-4" name="username" id="inputUsername" type="text" placeholder="Enter Username" required/>
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputLastname">Lastname</label>
                                            <input class="form-control py-4" name="lastname" id="inputLastname" type="text" placeholder="Enter Lastname" required/>
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputEmailAddress">Email</label>
                                            <input class="form-control py-4" name="email" id="inputEmailAddress" type="email" placeholder="Enter email address" required autofocus />
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputPassword">Password</label>
                                            <input class="form-control py-4" name="password" id="inputPassword" type="password" placeholder="Enter password" required/>
                                        </div>
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="button-17" name="login">Login</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center">
                                    <div class="small"><a href="register.php">Need an account? Sign up!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html>