<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = htmlspecialchars($_POST['nama'], ENT_QUOTES, 'UTF-8');
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_telp = htmlspecialchars($_POST['no_telp'], ENT_QUOTES, 'UTF-8');
    $jabatan_id = (int) $_POST['jabatan_id'];
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $foto_profil = htmlspecialchars($_POST['foto_profil'], ENT_QUOTES, 'UTF-8');

    // Validasi sederhana untuk URL gambar
    if (filter_var($foto_profil, FILTER_VALIDATE_URL) && @getimagesize($foto_profil)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO pegawai (nama, alamat, jenis_kelamin, no_telp, jabatan_id, username, password, foto_profil) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nama, '', $jenis_kelamin, $no_telp, $jabatan_id, $username, $password, $foto_profil]);

            echo "Registrasi berhasil!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "URL gambar tidak valid atau tidak dapat diakses.";
    }
}

try {
    $jabatan_stmt = $pdo->query("SELECT id, nama_jabatan FROM jabatan");
    $jabatan = $jabatan_stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<section class="vh-100" style="background-color: #eee;">
  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-12 col-xl-11">
        <div class="card text-black" style="border-radius: 25px;">
          <div class="card-body p-md-5">
            <div class="row justify-content-center">
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                <form class="mx-1 mx-md-4" method="post" action="">

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="text" id="form3Example1c" class="form-control" name="nama" required />
                      <label class="form-label" for="form3Example1c">Nama</label>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-venus-mars fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <select id="form3Example3c" class="form-control" name="jenis_kelamin" required>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                      </select>
                      <label class="form-label" for="form3Example3c">Jenis Kelamin</label>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-phone fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="text" id="form3Example4c" class="form-control" name="no_telp" required />
                      <label class="form-label" for="form3Example4c">Nomor Telepon</label>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-briefcase fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <select id="form3Example4cd" class="form-control" name="jabatan_id" required>
                        <?php foreach ($jabatan as $row): ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['nama_jabatan']); ?></option>
                        <?php endforeach; ?>
                      </select>
                      <label class="form-label" for="form3Example4cd">Jabatan</label>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-user-circle fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="text" id="form3Example4cd" class="form-control" name="username" required />
                      <label class="form-label" for="form3Example4cd">Username</label>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="password" id="form3Example4cd" class="form-control" name="password" required />
                      <label class="form-label" for="form3Example4cd">Password</label>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-image fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="text" id="form3Example4cd" class="form-control" name="foto_profil" required />
                      <label class="form-label" for="form3Example4cd">Link Foto Profil</label>
                    </div>
                  </div>

                  <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <button type="submit" class="btn btn-primary btn-lg">Register</button>
                  </div>

                </form>

              </div>
              <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                <img src="https://i.pinimg.com/736x/bb/02/b7/bb02b743a7bfaf7de4dec54cec5fc416.jpg"
                  class="img-fluid" alt="Sample image">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</body>
</html>
