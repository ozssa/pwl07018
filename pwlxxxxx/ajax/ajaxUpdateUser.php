<?php
require "../koneksi.php";
require "../fungsi.php";
require "../head.html"; // Ini akan menampilkan menu dan membuka <div class="content">

// Ambil data dari database
$sql = "SELECT * FROM user";
$hasil = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
?>

<h2 class="text-center">Daftar Pengguna</h2>
<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>No.</th>
            <th>Username</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($hasil)) {
            echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['status']}</td>
                    <td>
                        <a href='editUser.php?id={$row['iduser']}' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='hpsUser.php?id={$row['iduser']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                    </td>
                  </tr>";
            $no++;
        }
        ?>
    </tbody>
</table>

</div> <!-- Tutup div.content dari head.html -->
</body>
</html>
