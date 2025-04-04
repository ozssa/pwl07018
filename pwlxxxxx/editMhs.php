<!-- C:\xampp\htdocs\pwl07018\pwlxxxxx\editDosen.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Sistem Informasi Akademik :: Edit Data Mahasiswa</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styleku.css">
    <script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    <?php
    require "fungsi.php";
    require "head.html";
    
    $id = $_GET['kode'];
    $sql = "SELECT * FROM mhs WHERE id = '$id'";
    $qry = mysqli_query($koneksi, $sql);
    $row = mysqli_fetch_assoc($qry);
    
    // Default foto jika tidak ada
    $foto = !empty($row['foto']) ? $row['foto'] : 'default.jpg';
    ?>
    
    <div class="utama">
        <h2 class="mb-4 text-center">EDIT DATA MAHASISWA</h2>    
        <div class="row">
            <div class="col-md-3 text-center mb-4">
                <img class="rounded img-thumbnail" src="foto/<?php echo htmlspecialchars($foto); ?>" 
                     alt="Foto <?php echo htmlspecialchars($row['nama']); ?>"
                     style="max-width: 200px; height: auto;">
                <div class="mt-2">
                    <a href="gantiFotoMhs.php?id=<?php echo htmlspecialchars($row['id']); ?>" 
                       class="btn btn-sm btn-outline-secondary">
                        Ganti Foto
                    </a>
                </div>    
            </div>
            
            <div class="col-md-9">
                <form method="post" action="sv_editMhs.php">
                    <div class="form-group row">
                        <label for="nim" class="col-sm-2 col-form-label">NIM:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="nim" id="nim" 
                                   value="<?php echo htmlspecialchars($row['nim']); ?>" readonly>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="nama" id="nama" 
                                   value="<?php echo htmlspecialchars($row['nama']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="email" name="email" id="email" 
                                   value="<?php echo htmlspecialchars($row['email']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-sm-10 offset-sm-2">
                            <button class="btn btn-primary mr-2" type="submit" id="submit">
                                Simpan Perubahan
                            </button>
                            <a href="javascript:history.back()" class="btn btn-outline-secondary">
                                Kembali
                            </a>
                        </div>
                    </div>
                    
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                </form>
            </div>
        </div>
    </div>
</body>
</html>