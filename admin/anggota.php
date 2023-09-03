<?php
require "conn.php";
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: index.php");
}

if (isset($_POST["submit"])) {

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


    $id = $_POST["id"];
    $nama = $_POST["nama"];
    $jabatan = $_POST["jabatan"];
    $medsos = $_POST["medsos"];
    $gambar = upload();

    $query = mysqli_query($conn, "INSERT INTO `anggota` (`id`, `nama`, `jabatan`, `foto`, `medsos`) VALUES (NULL, '$nama', '$jabatan', '$gambar', '$medsos'); ");

    if ($query) {
        $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Data berhasil di tambah
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    } else {
        $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Failed!</strong> Data gagal di tambah
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
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="#">8d.takhossus</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link" href="dashboard.php">Home</a>
                    <a class="nav-link active" href="anggota.php">Anggota</a>
                    <a class="nav-link" href="quotes.php">Quotes</a>
                    <a class="nav-link" href="gallery.php">Gallery</a>
                </div>
            </div>
        </div>
    </nav>
    <section id="banner">
        <div class="container">
            <?php
            if (isset($alert)) {
                echo $alert;
            }
            ?>
            <h1 class="text-center">Tambah Data Anggota Kelas</h1>
            <br>
            <center>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Tambah Data
                </button>
            </center>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id">
                                <input type="text" name="nama" placeholder="Nama" class="form-control">
                                <br>
                                <input type="text" name="jabatan" placeholder="Jabatan" class="form-control">
                                <br>
                                <input type="file" name="gambar" id="gambar" class="form-control">
                                <br>
                                <input type="text" name="medsos" placeholder="Link Instagram / WA" class="form-control">
                                <br>
                                <button type="submit" name="submit" class="btn btn-primary">Tambah Data</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <div class="row">
                <div class="row row-cols-1 row-cols-md-3 g-4"><?php
                                                                $result = mysqli_query($conn, "SELECT * FROM anggota");
                                                                while ($data = mysqli_fetch_array($result)) {
                                                                ?>
                        <div class="col">

                            <div class="card">
                                <div class="card-body">
                                    <img src="../img/<?= $data["foto"]; ?>" alt="" class="card-img-top rounded-circle" style="width: 150px" />
                                    <h5 class="card-title"><?= $data["nama"]; ?></h5>
                                    <span class="badge bg-primary"><?= $data["jabatan"]; ?></span>
                                    <hr />
                                    <a href="<?= $data["medsos"]; ?>" class="btn btn-success">
                                        <span>Contact</span>
                                    </a>
                                    <br />
                                </div>
                                <div class="card-footer">
                                    <a href="edit-anggota.php?id=<?= $data["id"]; ?>" class="btn btn-primary">Edit</a>
                                    <a href="hapus-anggota.php?id=<?= $data["id"]; ?>" onclick="return confirm('Yakin mau hapus data?')" class="btn btn-danger">Hapus</a>
                                </div>

                            </div>

                        </div> <?php } ?>
                </div>
            </div>

        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>