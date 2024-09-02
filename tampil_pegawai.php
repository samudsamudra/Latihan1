<?php
require 'config.php';

try {
    $stmt = $pdo->query("SELECT pegawai.*, jabatan.nama_jabatan FROM pegawai JOIN jabatan ON pegawai.jabatan_id = jabatan.id");
    $pegawai = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
    <h2 class="mb-4">Daftar Pegawai</h2>
    <table class="table align-middle mb-0 bg-white">
      <thead class="bg-light">
        <tr>
          <th>Name</th>
          <th>Jabatan</th>
          <th>Nomor Telepon</th>
          <th>ID</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($pegawai): ?>
            <?php foreach ($pegawai as $row): ?>
            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <img
                      src="<?php echo htmlspecialchars($row['foto_profil']); ?>"
                      alt=""
                      style="width: 45px; height: 45px"
                      class="rounded-circle"
                      />
                  <div class="ms-3">
                    <p class="fw-bold mb-1"><?php echo htmlspecialchars($row['nama']); ?></p>
                    <p class="text-muted mb-0"><?php echo htmlspecialchars($row['username']); ?></p>
                  </div>
                </div>
              </td>
              <td>
                <p class="fw-normal mb-1"><?php echo htmlspecialchars($row['nama_jabatan']); ?></p>
              </td>
              <td>
                <p class="fw-normal mb-1"><?php echo htmlspecialchars($row['no_telp']); ?></p>
              </td>
              <td>
                <p class="fw-normal mb-1"><?php echo htmlspecialchars($row['id']); ?></p>
              </td>
              <td>
                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-link btn-sm btn-rounded">Edit</a>
                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-link btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
              </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Belum ada data pegawai.</td>
            </tr>
        <?php endif; ?>
      </tbody>
    </table>
</div>

</body>
</html>
