<!-- C:\xampp\htdocs\pwl07018\pwlxxxxx\editDosen.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Sistem Informasi Akademik :: Edit Data Dosen</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/styleku.css">
    <script src="bootstrap/jquery/3.3.1/jquery-3.3.1.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
</head>
<body>
    <?php
    require "fungsi.php";
    require "head.html";
    
    $npp = $_GET['kode'];
    $sql = "SELECT * FROM dosen WHERE npp = '$npp'";
    $qry = mysqli_query($koneksi, $sql);
    $row = mysqli_fetch_assoc($qry);
    ?>
    
    <div class="utama">
        <h2 class="mb-3 text-center">EDIT DATA DOSEN</h2>            
        <form method="post" action="sv_editDosen.php">
            <div class="form-group">
                <label for="npp">NPP:</label>
                <input class="form-control-ku col-md-3" type="text" name="npp" id="npp" 
                       value="<?php echo htmlspecialchars($row['npp']); ?>" readonly>
                <input type="hidden" name="npp" value="<?php echo htmlspecialchars($row['npp']); ?>">
            </div>
            
            <div class="form-group">
                <label for="nama">Nama dosen:</label>
                <input class="form-control" type="text" name="nama" id="nama" 
                       value="<?php echo htmlspecialchars($row['namadosen']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="homebase">Homebase:</label>
                <select class="form-control" name="homebase" id="homebase" required>
                    <?php
                    $arrhobe = array('A11', 'A12', 'A14', 'A15', 'A16', 'A17', 'A22', 'A24', 'P31');
                    foreach ($arrhobe as $hb) {
                        $selected = ($hb == $row['homebase']) ? 'selected' : '';
                        echo "<option value='$hb' $selected>$hb</option>";
                    }
                    ?>                  
                </select>
            </div>                
            
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Simpan</button>
                <a href="javascript:history.back()" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>