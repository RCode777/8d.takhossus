<?php
require "conn.php";
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: index.php");
}

$id = $_GET["id"];
$data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM quotes WHERE id='$id'"));

if (isset($_POST["submit"])) {
    $id = $_POST["id"];
    $quotes = $_POST["quotes"];
    $author = $_POST["author"];


    $query = mysqli_query($conn, "UPDATE quotes SET quotes = '$quotes', author = '$author' WHERE id = '$id'");

    if ($query) {
        $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Quotes berhasil di update, silahkan <a href="quotes.php">Kembali</a>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    } else {
        $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Failed!</strong> Quotes gagal di update
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
            <h1>Edit Quotes</h1>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?= $data["id"]; ?>">
                <br><textarea name="quotes" id="quotes" cols="30" rows="10" placeholder="Quotes" class="form-control"><?= $data["quotes"] ?></textarea>
                <br>
                <input type="text" name="author" placeholder="Pengarang" class="form-control" value="<?= $data["author"] ?>">
                <br>
                <button type="submit" name="submit" class="btn btn-primary">Edit Quotes</button>
            </form>

        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>