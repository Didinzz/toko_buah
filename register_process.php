<?php
session_start();
include 'koneksi.php'; // Koneksi ke database

header('Content-Type: application/json');

// Pastikan data dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Ambil data dari form dan lakukan sanitasi
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $role = 'user'; // Set role sebagai 'user' secara default

  // Hash password
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Periksa apakah username atau email sudah ada di database
  $stmt_check = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
  $stmt_check->bind_param("ss", $username, $email);
  $stmt_check->execute();
  $result_check = $stmt_check->get_result();

  if ($result_check->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "Username atau email sudah terdaftar!"]);
    exit();
  }

  // Jika username dan email belum ada, masukkan data ke dalam database
  $stmt_insert = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
  $stmt_insert->bind_param("ssss", $username, $email, $hashed_password, $role);

  if ($stmt_insert->execute()) {
    echo json_encode(["status" => "success", "message" => "Registrasi berhasil! Silakan login."]);
    exit();
  } else {
    echo json_encode(["status" => "error", "message" => "Terjadi kesalahan saat melakukan registrasi: " . $stmt_insert->error]);
    exit();
  }

  // Tutup statement
  $stmt_check->close();
  $stmt_insert->close();
}

// Tutup koneksi
$conn->close();
