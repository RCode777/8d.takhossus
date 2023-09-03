<?php
session_start();
require "conn.php";
if (isset($_POST["submit"])) {
    $namaAdmin = $_POST["nama"];
    $passwordAdmin = $_POST["password"];

    if ($namaAdmin == "admin8d" && $passwordAdmin == "admin8d") {
        $_SESSION["admin"] = true;
        header("Location: dashboard.php");
    } else {
        $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Failed!</strong> Email atau password anda salah
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
    <title>8D Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        .container-form {
            display: flex;
            justify-content: center;
            align-items: center !important;
            max-width: 330px;
            padding: 1rem;
        }
    </style>
</head>

<body class="d-flex align-items-center py-4">
    <div class="container-form w-100 m-auto">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <?php
                if (isset($alert)) {
                    echo $alert;
                }
                ?>
                <h5 class="card-title">Login Admin</h5>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Username</label>
                        <input type="text" name="nama" class="form-control" id="nama" autocomplete="off" placeholder="Nama">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>