<?php
include 'koneksi.php';

// Function to sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Enhanced NIM validation function
function validateNIM($nim) {
    // Format: XYY.YYYY.ZZZZZ
    // X = Huruf kapital (A-Z)
    // YY = Angka prodi (11-99)
    // YYYY = Tahun (2000-current year+1)
    // ZZZZZ = Nomor unik (00000-99999)
    
    // First check basic pattern
    if (!preg_match('/^([A-Z])(\d{2})\.(\d{4})\.(\d{5})$/', $nim, $matches)) {
        return "Format NIM tidak valid. Harus berupa XYY.YYYY.ZZZZZ (contoh: A12.2023.00001)";
    }
    
    $fakultas = $matches[1];
    $prodi = $matches[2];
    $tahun = $matches[3];
    $nomor = $matches[4];
    
    // Validate faculty code (A-Z)
    if (!ctype_upper($fakultas)) {
        return "Kode fakultas harus huruf kapital (A-Z)";
    }
    
    // Validate program code (11-99)
    if ($prodi < 11 || $prodi > 99) {
        return "Kode prodi harus antara 11-99";
    }
    
    // Validate year (2000 to next year)
    $currentYear = date('Y');
    if ($tahun < 2000 || $tahun > ($currentYear + 1)) {
        return "Tahun harus antara 2000-" . ($currentYear + 1);
    }
    
    // Validate unique number (00000-99999)
    if ($nomor < 0 || $nomor > 99999) {
        return "Nomor unik harus antara 00000-99999";
    }
    
    return true;
}

// Function to validate image file
function validateImage($file) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 2 * 1024 * 1024; // 2MB
    
    // Check if file is an actual image
    $check = getimagesize($file['tmp_name']);
    if ($check === false) {
        return "File is not an image.";
    }
    
    // Check file type
    if (!in_array($file['type'], $allowedTypes)) {
        return "Only JPG, PNG & GIF files are allowed.";
    }
    
    // Check file size
    if ($file['size'] > $maxSize) {
        return "File size must be less than 2MB.";
    }
    
    return true;
}

if (isset($_POST['upload'])) {
    // Sanitize and validate inputs
    $nim = sanitizeInput($_POST['nim']);
    
    // Validate NIM format
    $nimValidation = validateNIM($nim);
    if ($nimValidation !== true) {
        die("❌ " . $nimValidation);
    }
    
    // Check if file was uploaded without errors
    if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
        die("❌ File upload error: " . $_FILES['foto']['error']);
    }
    
    // Validate the image
    $imageValidation = validateImage($_FILES['foto']);
    if ($imageValidation !== true) {
        die("❌ " . $imageValidation);
    }
    
    // Prepare upload directory
    $folder = "profile_pics/";
    if (!file_exists($folder)) {
        mkdir($folder, 0755, true);
    }
    
    // Generate secure filename (replace dots with underscores for safety)
    $safeNIM = str_replace('.', '_', $nim);
    $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    $namaBaru = $safeNIM . "_" . bin2hex(random_bytes(4)) . "." . $ext;
    $lokasiSimpan = $folder . $namaBaru;
    
    // Move uploaded file with error handling
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $lokasiSimpan)) {
        // Use prepared statement to prevent SQL injection
        $query = "UPDATE mhs SET foto_profil=? WHERE nim=?";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "ss", $namaBaru, $nim);
        $result = mysqli_stmt_execute($stmt);
        
        if ($result) {
            $success = "✅ Foto berhasil diupload dan disimpan di database.";
        } else {
            // Delete the uploaded file if DB update fails
            unlink($lokasiSimpan);
            die("❌ Gagal menyimpan ke database: " . mysqli_error($koneksi));
        }
        
        mysqli_stmt_close($stmt);
    } else {
        die("❌ Gagal mengupload file. Pastikan folder tujuan ada dan memiliki izin yang tepat.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Foto Profil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            line-height: 1.6;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="file"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .success {
            color: green;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #e8f5e9;
            border-radius: 4px;
        }
        .error {
            color: red;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #ffebee;
            border-radius: 4px;
        }
        .info {
            color: #555;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <h1>Upload Foto Profil</h1>
    
    <?php if (isset($success)): ?>
        <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <form action="upload_profil.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nim">NIM:</label>
            <input type="text" id="nim" name="nim" required 
                   pattern="[A-Z]\d{2}\.\d{4}\.\d{5}" 
                   title="Format: XYY.YYYY.ZZZZZ (contoh: A12.2023.00001)" 
                   placeholder="Contoh: A12.2023.00001">
            <div class="info">
                Format NIM: <br>
                - Huruf kapital (A-Z) untuk fakultas<br>
                - 2 digit angka (11-99) untuk prodi<br>
                - 4 digit tahun (2000-sekarang+1)<br>
                - 5 digit nomor unik (00000-99999)
            </div>
        </div>
        
        <div class="form-group">
            <label for="foto">Pilih Foto Profil:</label>
            <input type="file" id="foto" name="foto" accept="image/jpeg,image/png,image/gif" required>
            <div class="info">Format: JPG, PNG, atau GIF (maks. 2MB)</div>
        </div>
        
        <button type="submit" name="upload">Upload Foto</button>
    </form>
</body>
</html>