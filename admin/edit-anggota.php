<?php
require "conn.php";
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: index.php");
}

$id = $_GET["id"];
$data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM anggota WHERE id='$id'"));

function upload()
{
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    if ($error === 4) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Failed!</strong> Tidak ada gambar yang dipilih
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        return false;
    }

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Failed!</strong> Yang anda upload bukan gambar
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        return false;
    }
    if ($ukuranFile > 1000000) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Failed!</strong> Ukuran gambar terlalu besar
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        return false;
    }
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, '../img/' . $namaFileBaru);

    return $namaFileBaru;
}

if (isset($_POST["submit"])) {
    $id = $_POST["id"];
    $nama = $_POST["nama"];
    $jabatan = $_POST["jabatan"];
    $medsos = $_POST["medsos"];
    $gambarLama = $_POST["gambarLama"];

    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }


    $query = mysqli_query($conn, "UPDATE anggota SET nama = '$nama', jabatan = '$jabatan', foto = '$gambar', medsos = '$medsos' WHERE id = '$id'");

    if ($query) {
        $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Data berhasil di update, silahkan <a href="anggota.php">Kembali</a>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    } else {
        $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Failed!</strong> Data gagal di update
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin 8d</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <section id="banner">
        <div class="container">
            <?php
            if (isset($alert)) {
                echo $alert;
            }
            ?>
            <h1>Edit data <?= $data["nama"]; ?></h1>
            <br>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $data["id"]; ?>">
                <input type="hidden" name="gambarLama" value="<?= $data["foto"]; ?>">
                <input type="text" name="nama" placeholder="Nama" class="form-control" value="<?= $data["nama"]; ?>">
                <br>
                <input type="text" name="jabatan" placeholder="Jabatan" class="form-control" value="<?= $data["jabatan"]; ?>">
                <br>
                <input type="file" name="gambar" id="gambar" class="form-control">
                <br>
                <img src="../img/<?= $data["foto"]; ?>" alt="" style="width: 130px;" class="rounded-circle">
                <br>
                <br>
                <input type="text" name="medsos" placeholder="Link Instagram / WA" class="form-control" value="<?= $data["medsos"]; ?>">
                <br>
                <button type="submit" name="submit" class="btn btn-primary">Ubah Data</button>
            </form>

        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>