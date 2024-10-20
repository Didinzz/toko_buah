<?php
session_start();

// Cek apakah session email tidak ada atau jika role bukan admin
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
  header('Location: auth.php'); // Gunakan huruf kapital untuk 'Location'
  exit();
}
?>
<!doctype html>
<html
  lang="en"
  class="light-style layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="./assets/"
  data-template="vertical-menu-template-free"
  data-style="light">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Dashboard Admin</title>
  <meta name="description" content="" />
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="./assets/img/favicon/favicon.ico" />
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="./assets/vendor/fonts/remixicon/remixicon.css" />
  <link rel="stylesheet" href="./assets/vendor/libs/node-waves/node-waves.css" />
  <link rel="stylesheet" href="./assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="./assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="./assets/css/demo.css" />
  <link rel="stylesheet" href="./assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="./assets/vendor/libs/apex-charts/apex-charts.css" />
  <script src="./assets/vendor/js/helpers.js"></script>
  <script src="./assets/js/config.js"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- cdn sweetalert -->
  <!-- SweetAlert CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <style>
    .btn-glow-danger {
      box-shadow: 0 0 10px 2px rgba(234, 84, 85, 0.5) !important;
    }

    .btn-glow-warning:hover {
      box-shadow: none !important;
    }

    .btn-glow-danger {
      box-shadow: 0 0 10px 2px rgba(234, 84, 85, 0.5) !important;
    }

    .btn-glow-warning:hover {
      box-shadow: none !important;
    }

    #layout-menu {
      z-index: 100;
      /* Pastikan ini tidak lebih tinggi dari SweetAlert */
    }

    .swal2-container {
      z-index: 200;
      /* Pastikan SweetAlert memiliki z-index yang lebih tinggi */
    }
  </style>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- sidebar -->
      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme shadow-lg">
        <div class="app-brand demo">
          <a class="app-brand-link">
            <span class="app-brand-logo demo me-1">
            </span>
            <span class="app-brand-text demo menu-text fw-semibold ms-2">Selamat Datang</span>
          </a>

        </div>

        <div class="menu-inner-shadow"></div>
        <ul class="menu-inner py-1">
          <!-- Dashboards -->
          <li class="menu-item">
            <a class="menu-link" role="button" id="dashboard">
              <i class="menu-icon tf-icons ri-home-smile-line"></i>
              <div data-i18n="Dashboards">Dashboards</div>
            </a>
          </li>

          <!-- Forms & Tables -->
          <li class="menu-header fw-medium mt-4"><span class="menu-header-text">Forms &amp; Tables</span></li>
          <!-- Tables -->
          <li class="menu-item">
            <a class="menu-link" id="tabelBuah" role="button">
              <i class="menu-icon tf-icons ri-table-alt-line"></i>
              <div data-i18n="Tables">Tables</div>
            </a>
          </li>

          <li class="menu-header fw-medium mt-4"><span class="menu-header-text">Logout</span></li>

          <li class="menu-item">
            <div class="d-grid px-4 pt-2 pb-1 glow">
              <a class="btn btn-danger btn-glow-danger d-flex text-white" id="logoutButton">
                <small class="align-middle">Logout</small>
                <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
              </a>
            </div>
          </li>

      </aside>


      <div class="layout-page">
        <div class="content-wrapper" id="content">
          <!-- Content -->
        </div>
      </div>
      <!-- <div class="content-backdrop fade"></div>/ -->
    </div>
  </div>
  <div class="layout-overlay layout-menu-toggle"></div>

  <!-- / Layout wrapper -->
  <!-- Core JS -->
  <script>
    function loadContent() {
      let lastContent = localStorage.getItem('lastContent'); //mengambil content terakhir dan disimpan didlaam localstorage
      if (lastContent) {
        $('#content').load(lastContent); //memuat konten sesuai content terakhir
      } else {
        $('#content').load('dashboard/dashboard_content.php'); //jika tidak ada content terakhir maka load dashboard
      }
    }
    // memanggil fungsi loadContent saat halaman pertama kali dimuat
    $(document).ready(function() {
      loadContent();
    })

    // fungsi untuk menyimpan content terakhir ke localstorage dan memuat conetn tersebut
    function loadAndSaveContent(url) {
      $('#content').load(url);
      localStorage.setItem('lastContent', url);
    }
    // load dashboardContent
    $('#dashboard').click(function() {
      loadAndSaveContent('dashboard/dashboard_content.php');
    })
    $('#tabelBuah').click(function() {
      loadAndSaveContent('data_buah/tabel_buah.php');
    })
    // Fungsi untuk logout dengan konfirmasi SweetAlert
    $('#logoutButton').click(function() {
      // sweet alert
      Swal.fire({
        title: 'Are you sure?',
        text: "Apakah anda yakin ingin logout?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, log out!'
      }).then((result) => {
        if (result.isConfirmed) {

          Swal.fire(
            'Logout!',
            'Anda telah berhasil logout.',
            'success'
          ).then((result) => {
            if (result.isConfirmed) {
              localStorage.removeItem('lastContent')
              window.location.href = 'logout.php';
            }
          })
        }
      })
    })
  </script>

  <!-- SweetAlert JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- build:js assets/vendor/js/core.js -->
  <script src="./assets/vendor/libs/jquery/jquery.js"></script>
  <script src="./assets/vendor/libs/popper/popper.js"></script>
  <script src="./assets/vendor/js/bootstrap.js"></script>
  <script src="./assets/vendor/libs/node-waves/node-waves.js"></script>
  <script src="./assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="./assets/vendor/js/menu.js"></script>
  <!-- endbuild -->
  <!-- Vendors JS -->
  <script src="./assets/vendor/libs/apex-charts/apexcharts.js"></script>
  <!-- Main JS -->
  <script src="./assets/js/main.js"></script>
  <!-- Page JS -->
  <script src="./assets/js/dashboards-analytics.js"></script>
  <!-- Place this tag before closing body tag for github widget button. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>