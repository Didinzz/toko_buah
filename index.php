<?php
session_start();
// Cek apakah session email tidak ada atau jika role bukan admin
if (!isset($_SESSION['email'])) {
  header('Location: auth.php'); // Gunakan huruf kapital untuk 'Location'
  exit();
}
?>

<h1>ini adalah halaman usser</h1>


