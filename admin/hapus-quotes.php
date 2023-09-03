<?php
include "conn.php";
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: index.php");
}
$id = $_GET["id"];

if (hapus($id) > 0) {
    echo "
                  <script>
                    alert('Quotes berhasil dihapus!');
                    document.location.href = 'quotes.php'
                  </script>   
                  ";
} else {
    echo "
                  <script>
                    alert('Quotes gagal dihapus');
                  </script>   
                  ";
}
function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM quotes WHERE id = $id");
    return mysqli_affected_rows($conn);
}
