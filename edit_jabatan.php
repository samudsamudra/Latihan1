<?php
require 'config.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM jabatan WHERE id = ?");
        $stmt->execute([$id]);
        $jabatan = $stmt->fetch();

        if (!$jabatan) {
            echo "Jabatan tidak ditemukan!";
            exit();
        }

        // Jika form disubmit
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nama_jabatan = htmlspecialchars($_POST['nama_jabatan'], ENT_QUOTES, 'UTF-8');
            $gaji_pokok = (float) $_POST['gaji_pokok'];
            $tunjangan = (float) $_POST['tunjangan'];

            $stmt = $pdo->prepare("UPDATE jabatan SET nama_jabatan = ?, gaji_pokok = ?, tunjangan = ? WHERE id = ?");
            $stmt->execute([$nama_jabatan, $gaji_pokok, $tunjangan, $id]);

            header("Location: jabatan.php");
            exit();
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    header("Location: jabatan.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Jabatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Edit Jabatan</h2>
    <form method="post" action="">
        <div class="mb-3">
            <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
            <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" value="<?php echo htmlspecialchars($jabatan['nama_jabatan']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
            <input type="number" class="form-control" id="gaji_pokok" name="gaji_pokok" value="<?php echo htmlspecialchars($jabatan['gaji_pokok']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="tunjangan" class="form-label">Tunjangan</label>
            <input type="number" class="form-control" id="tunjangan" name="tunjangan" value="<?php echo htmlspecialchars($jabatan['tunjangan']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Jabatan</button>
    </form>
</div>

</body>
</html>
