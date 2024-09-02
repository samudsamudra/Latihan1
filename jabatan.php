<?php
require 'config.php';

// Proses menambahkan jabatan baru
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_jabatan = htmlspecialchars($_POST['nama_jabatan'], ENT_QUOTES, 'UTF-8');
    $gaji_pokok = (float) $_POST['gaji_pokok'];
    $tunjangan = (float) $_POST['tunjangan'];

    try {
        $stmt = $pdo->prepare("INSERT INTO jabatan (nama_jabatan, gaji_pokok, tunjangan) VALUES (?, ?, ?)");
        $stmt->execute([$nama_jabatan, $gaji_pokok, $tunjangan]);

        echo "Jabatan berhasil ditambahkan!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Ambil daftar jabatan
try {
    $stmt = $pdo->query("SELECT * FROM jabatan");
    $jabatan = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Jabatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
    <h2 class="mb-4">Daftar Jabatan</h2>

    <table class="table align-middle mb-0 bg-white">
      <thead class="bg-light">
        <tr>
          <th>Nama Jabatan</th>
          <th>Gaji Pokok</th>
          <th>Tunjangan</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($jabatan): ?>
            <?php foreach ($jabatan as $row): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['nama_jabatan']); ?></td>
              <td><?php echo htmlspecialchars($row['gaji_pokok']); ?></td>
              <td><?php echo htmlspecialchars($row['tunjangan']); ?></td>
              <td>
                <a href="edit_jabatan.php?id=<?php echo $row['id']; ?>" class="btn btn-link btn-sm btn-rounded">Edit</a>
                <a href="delete_jabatan.php?id=<?php echo $row['id']; ?>" class="btn btn-link btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus jabatan ini?');">Hapus</a>
              </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Belum ada data jabatan.</td>
            </tr>
        <?php endif; ?>
      </tbody>
    </table>

    <h3 class="mt-5">Tambah Jabatan Baru</h3>
    <form method="post" action="">
        <div class="mb-3">
            <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
            <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" required>
        </div>
        <div class="mb-3">
            <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
            <input type="number" class="form-control" id="gaji_pokok" name="gaji_pokok" required>
        </div>
        <div class="mb-3">
            <label for="tunjangan" class="form-label">Tunjangan</label>
            <input type="number" class="form-control" id="tunjangan" name="tunjangan" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Jabatan</button>
    </form>
</div>

</body>
</html>
