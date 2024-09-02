<?php
require 'config.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM pegawai WHERE id = ?");
        $stmt->execute([$id]);
        $pegawai = $stmt->fetch();

        if (!$pegawai) {
            echo "Data pegawai tidak ditemukan!";
            exit();
        }

        // Jika form disubmit
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nama = htmlspecialchars($_POST['nama'], ENT_QUOTES, 'UTF-8');
            $jenis_kelamin = $_POST['jenis_kelamin'];
            $no_telp = htmlspecialchars($_POST['no_telp'], ENT_QUOTES, 'UTF-8');
            $jabatan_id = (int) $_POST['jabatan_id'];
            $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
            $foto_profil = htmlspecialchars($_POST['foto_profil'], ENT_QUOTES, 'UTF-8');

            $stmt = $pdo->prepare("UPDATE pegawai SET nama = ?, jenis_kelamin = ?, no_telp = ?, jabatan_id = ?, username = ?, foto_profil = ? WHERE id = ?");
            $stmt->execute([$nama, $jenis_kelamin, $no_telp, $jabatan_id, $username, $foto_profil, $id]);

            header("Location: tampil_pegawai.php");
            exit();
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    header("Location: tampil_pegawai.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Edit Data Pegawai</h2>
    <form method="post" action="">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($pegawai['nama']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select id="jenis_kelamin" class="form-control" name="jenis_kelamin" required>
                <option value="L" <?php if ($pegawai['jenis_kelamin'] == 'L') echo 'selected'; ?>>Laki-laki</option>
                <option value="P" <?php if ($pegawai['jenis_kelamin'] == 'P') echo 'selected'; ?>>Perempuan</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="no_telp" class="form-label">Nomor Telepon</label>
            <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?php echo htmlspecialchars($pegawai['no_telp']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="jabatan_id" class="form-label">Jabatan</label>
            <select id="jabatan_id" class="form-control" name="jabatan_id" required>
                <?php
                $jabatan_stmt = $pdo->query("SELECT id, nama_jabatan FROM jabatan");
                $jabatan = $jabatan_stmt->fetchAll();
                foreach ($jabatan as $row): ?>
                    <option value="<?php echo $row['id']; ?>" <?php if ($pegawai['jabatan_id'] == $row['id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($row['nama_jabatan']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($pegawai['username']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="foto_profil" class="form-label">Link Foto Profil</label>
            <input type="text" class="form-control" id="foto_profil" name="foto_profil" value="<?php echo htmlspecialchars($pegawai['foto_profil']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

</body>
</html>
