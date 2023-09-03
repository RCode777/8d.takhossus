<?php
require "conn.php";
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: index.php");
}

if (isset($_POST["submit"])) {



    $id = $_POST["id"];
    $quotes = $_POST["quotes"];
    $author = $_POST["author"];

    $query = mysqli_query($conn, "INSERT INTO `quotes` (`id`, `quotes`, `author`) VALUES (NULL, '$quotes', '$author'); ");

    if ($query) {
        $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Quotes berhasil di tambah
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    } else {
        $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Failed!</strong> Quotes gagal di tambah
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
                    <a class="nav-link" href="anggota.php">Anggota</a>
                    <a class="nav-link active" href="quotes.php">Quotes</a>
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
            <h1 class="text-center">Tambah Quotes</h1>
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
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Quotes</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post">
                                <input type="hidden" name="id">
                                <textarea name="quotes" id="quotes" cols="30" rows="10" class="form-control" placeholder="Quotes"></textarea>
                                <br>
                                <input type="text" name="author" placeholder="Pengarang" class="form-control">
                                <br>
                                <button type="submit" name="submit" class="btn btn-primary">Tambah Quotes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <div class="row">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM quotes");
                    while ($data = mysqli_fetch_array($result)) {
                    ?>
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <blockquote class="blockquote mb-0">
                                        <p>"<?= $data["quotes"] ?>"</p>
                                        <footer class="blockquote-footer"><?= $data["author"] ?></footer>
                                    </blockquote>
                                </div>
                                <div class="card-footer">
                                    <a href="edit-quotes.php?id=<?= $data["id"]; ?>" class="btn btn-primary">Edit</a>
                                    <a href="hapus-quotes.php?id=<?= $data["id"]; ?>" onclick="return confirm('Yakin mau hapus data?')" class="btn btn-danger">Hapus</a>
                                </div>
                            </div>

                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>