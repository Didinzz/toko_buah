<?php
session_start(); // Memulai sesi
include 'koneksi.php'; // Koneksi ke database

header("Content-Type: application/json");

// Pastikan data dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Ambil username dan password dari form, dan lakukan sanitasi
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  // Cek apakah email ada di database
  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Memeriksa password (jika tanpa hash, langsung cocokkan)
    if (password_verify($password, $user['password'])) {
      // Simpan informasi pengguna ke dalam session
      $_SESSION['email'] = $user['email'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['role'] = $user['role'];

      // Redirect sesuai dengan peran pengguna
      $response = array(
        'status' => 'success',
        'message' => 'Login Berhasil!',
        'redirect' => ($user['role'] === 'admin') ? 'dashboard.php' : 'index.php'
      );
      echo json_encode($response);
      exit();
    } else {
      // Jika password salah
      echo json_encode(array('status' => 'error', 'message' => 'Email atau Passowrd Salah!'));
      exit();
    }
  } else {
    // Jika username tidak ditemukan
    echo json_encode(array('status' => 'error', 'message' => 'Email atau Passowrd Salah!'));
    exit();
  }

  // Tutup statement dan koneksi
  $stmt->close();
}

$conn->close();
