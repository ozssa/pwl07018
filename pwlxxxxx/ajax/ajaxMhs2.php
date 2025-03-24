<?php
require "../fungsi.php";
require "../head.html";

$keyword = $_GET["keyword"] ?? '';
$jmlDataPerHal = 5;

// Query pencarian
$sql = "SELECT * FROM mhs 
        WHERE nim LIKE '%$keyword%' 
        OR nama LIKE '%$keyword%' 
        OR email LIKE '%$keyword%'";
$qry = mysqli_query($koneksi, $sql);
$jmlData = mysqli_num_rows($qry);
$jmlHal = ceil($jmlData / $jmlDataPerHal);

$halAktif = $_GET['hal'] ?? 1;
$awalData = ($jmlDataPerHal * $halAktif) - $jmlDataPerHal;

// Query dengan pagination
$sql = "SELECT * FROM mhs 
        WHERE nim LIKE '%$keyword%' 
        OR nama LIKE '%$keyword%' 
        OR email LIKE '%$keyword%' 
        LIMIT $awalData, $jmlDataPerHal";
$hasil = mysqli_query($koneksi, $sql);
?>

<div class="main-content">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Data Mahasiswa</h5>
                <form method="get" class="d-flex gap-2">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" class="form-control" name="keyword" 
                               placeholder="Cari mahasiswa..." value="<?= htmlspecialchars($keyword) ?>">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th width="50">No</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th width="100">Foto</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($hasil) > 0): ?>
                                <?php $no = $awalData + 1; ?>
                                <?php while($row = mysqli_fetch_assoc($hasil)): ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= htmlspecialchars($row['nim']) ?></td>
                                        <td><?= htmlspecialchars($row['nama']) ?></td>
                                        <td><?= htmlspecialchars($row['email']) ?></td>
                                        <td class="text-center">
                                            <img src="<?= 'foto/'.$row['foto'] ?>" 
                                                 class="img-thumbnail" 
                                                 style="height: 50px; object-fit: cover;">
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="editMhs.php?kode=<?= $row['id'] ?>" 
                                                   class="btn btn-sm btn-warning" 
                                                   title="Edit" 
                                                   data-bs-toggle="tooltip">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="hpsMhs.php?kode=<?= $row['id'] ?>" 
                                                   class="btn btn-sm btn-danger" 
                                                   title="Hapus"
                                                   data-bs-toggle="tooltip"
                                                   onclick="return confirm('Yakin menghapus data ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $no++; ?>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="bi bi-database-exclamation" style="font-size: 3rem;"></i>
                                        <p class="mt-2 mb-0">Tidak ada data ditemukan</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if($jmlHal > 1): ?>
                <nav class="mt-4">
                    <ul class="pagination justify-content-center pagination-sm">
                        <?php for($i = 1; $i <= $jmlHal; $i++): ?>
                            <li class="page-item <?= $i == $halAktif ? 'active' : '' ?>">
                                <a class="page-link" href="?keyword=<?= $keyword ?>&hal=<?= $i ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
            
            <div class="card-footer text-muted small d-flex justify-content-between">
                <div>Total Data: <?= number_format($jmlData, 0, ',', '.') ?></div>
                <div>Halaman <?= $halAktif ?> dari <?= $jmlHal ?></div>
            </div>
        </div>
    </div>
</div>

<script>
    // Aktifkan tooltip Bootstrap
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
</script>

</body>
</html>