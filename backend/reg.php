<?php
// Sertakan file konfigurasi database untuk membuat koneksi
require('../db/config.database.php');

// Mulai sesi untuk mengelola data sesi pengguna
session_start();

// Periksa apakah semua parameter yang diperlukan telah diatur dalam permintaan POST
if (isset($_POST['nama']) && isset($_POST['umur']) && isset($_POST['email']) && isset($_POST['pass'])) {
    // Ambil data POST dan simpan ke dalam variabel
    $nama = $con->escape_string($_POST['nama']);
    $umur = intval($con->escape_string($_POST['umur']));
    $email = $con->escape_string($_POST['email']);
    $pass = password_hash($con->escape_string($_POST['pass']), PASSWORD_DEFAULT);

    // Periksa apakah ada kolom yang kosong
    if (empty($nama) || empty($umur) || empty($email) || empty($pass)) {
        // Beri respons dengan JSON yang menunjukkan bahwa formulir tidak lengkap
        echo json_encode(array(
            'status' => 400,
            'message' => 'Form ada yang kosong!'
        ));
        exit(); // Hentikan eksekusi skrip lebih lanjut
    }

    // Siapkan pernyataan SQL untuk memeriksa apakah email sudah ada di database
    $check = $con->prepare("SELECT * FROM tbl_users WHERE email = ?");
    // Kaitkan parameter email ke pernyataan SQL
    $check->bind_param('s', $email);

    // Eksekusi pernyataan yang sudah disiapkan
    if ($check->execute()) {
        // Dapatkan hasil dari query
        $re = $check->get_result();
        // Periksa apakah tidak ada pengguna dengan email tersebut
        if ($re->num_rows == 0) {
            // Siapkan pernyataan SQL untuk memasukkan data pengguna baru
            $create = $con->prepare("INSERT INTO tbl_users (nama, usia, email, password) VALUES (?, ?, ?, ?)");
            // Kaitkan parameter ke pernyataan SQL
            $create->bind_param('siss', $nama, $umur, $email, $pass);

            // Eksekusi pernyataan untuk membuat pengguna baru
            if ($create->execute()) {
                // Simpan nama pengguna di sesi
                $_SESSION['user'] = $nama;
                // Redirect pengguna ke halaman index
                header("Location: ../page/index.php");
            } else {
                // Jika terjadi kesalahan saat eksekusi, beri respons dengan JSON
                echo json_encode(array(
                    'status' => 500,
                    'message' => 'Terjadi kesalahan saat execute!'
                ));
            }
            // Tutup pernyataan prepared untuk membuat pengguna baru
            $create->close();
        } else {
            // Jika email sudah ada, beri respons dengan JSON
            echo json_encode(array(
                'status' => 400,
                'message' => 'Akun sudah ada!'
            ));
        }
    } else {
        // Jika terjadi kesalahan saat memeriksa email, beri respons dengan JSON
        echo json_encode(array(
            'status' => 500,
            'message' => 'Terjadi kesalahan saat memeriksa email!'
        ));
    }
    // Tutup pernyataan prepared untuk memeriksa email
    $check->close();
} else {
    // Jika parameter POST tidak lengkap, beri respons dengan JSON
    echo json_encode(array(
        'status' => 400,
        'message' => 'Data tidak lengkap!'
    ));
}
?>
