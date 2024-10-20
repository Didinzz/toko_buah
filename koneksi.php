<?php
$servername = "localhost";  // atau "127.0.0.1"
$username = "root";         // username database
$password = "";             // password database
$dbname = "toko_buah"; // nama database

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
