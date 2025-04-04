<!-- index1.php -->
<?php 
session_start();

if(isset($_SESSION['username'])){
  header("location:homeadmin.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login Sistem</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/styleku.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-5 col-lg-4">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title text-center mb-0 py-2">
                            <i class="bi bi-lock-fill me-2"></i>LOGIN SISTEM
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <form method="post" action="" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" class="form-control" id="username" name="username" 
                                           required autofocus>
                                    <div class="invalid-feedback">
                                        Harap masukkan username
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="passw" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                                    <input type="password" class="form-control" id="passw" name="passw" required>
                                    <div class="invalid-feedback">
                                        Harap masukkan password
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary py-2">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center text-muted small">
                        Sistem Informasi Akademik &copy; <?= date('Y') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['username'])){
        require "fungsi.php";
        $username = $_POST['username'];
        $passw = md5($_POST['passw']);
        $sql = "SELECT * FROM user WHERE username='$username' AND password='$passw'";
        $hasil = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
        
        if (mysqli_affected_rows($koneksi) > 0){
            $_SESSION['username'] = $username;
            header("location:homeadmin.php");
        } else {
            echo '<div class="position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 1100">
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Login gagal!</strong> Username atau password salah.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                  </div>';
        }
    }
    ?>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form validation
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
        
        // Auto dismiss alert after 5 seconds
        const alert = document.querySelector('.alert');
        if (alert) {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        }
    </script>
</body>
</html>