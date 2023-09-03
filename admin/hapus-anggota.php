<?php
include "conn.php";
session_start();
if (!isset($_SESSION["admin"])) {
  header("Location: index.php");
}
// $idUser = $_GET["id"];
$id = $_GET["id"];

if (hapus($id) > 0) {
  echo "
                  <script>
                    alert('Data berhasil dihapus!');
                    document.location.href = 'anggota.php'
                  </script>   
                  ";
} else {
  echo "
                  <script>
                    alert('Data gagal dihapus');
                  </script>   
                  ";
}
function hapus($id)
{
  global $conn;
  mysqli_query($conn, "DELETE FROM anggota WHERE id = $id");
  return mysqli_affected_rows($conn);
}
