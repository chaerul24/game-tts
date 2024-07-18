<?php
// Sertakan file konfigurasi database untuk membuat koneksi
require('../db/config.database.php');

// Mulai sesi untuk mengelola data sesi pengguna
session_start();

// Periksa apakah 'email' dan 'password' sudah diatur dalam permintaan POST
if(isset($_POST['email']) && isset($_POST['password'])){
    // Ambil data POST dan simpan ke dalam variabel
    $email = $_POST['email'];
    $pass = $_POST['password'];

    // Periksa apakah 'email' atau 'password' kosong
    if(empty($email) || empty($pass)){
        // Beri respons dengan JSON yang menunjukkan bahwa formulir tidak lengkap
        echo json_encode(array(
            'status' => 400,
            'message' => 'Form ada yang kosong!'
        ));
    } else {
        // Siapkan pernyataan SQL untuk memilih data pengguna berdasarkan email yang diberikan
        $login = $con->prepare("SELECT * FROM tbl_users WHERE email = ?");
        // Kaitkan parameter email ke pernyataan SQL
        $login->bind_param('s', $email);

        // Eksekusi pernyataan yang sudah disiapkan
        if($login->execute()){
            // Dapatkan hasil dari query
            $re = $login->get_result();
            // Periksa apakah ada pengguna yang ditemukan dengan email yang diberikan
            if($re->num_rows != 0){
                // Ambil baris data pengguna
                $row = $re->fetch_assoc();
                // Verifikasi password yang diberikan dengan hash password yang tersimpan di database
                if(password_verify($pass, $row['password'])){
                    // Jika password benar, simpan nama pengguna di sesi
                    $_SESSION['user'] = $row['nama'];
                    // Redirect pengguna ke halaman index
                    header("Location: ../page/index.php");
                } else {
                    // Jika password salah, beri respons dengan JSON
                    echo json_encode(array(
                        'status' => 500,
                        'message' => 'Password salah!'
                    ));
                }
            } else {
                // Jika tidak ada pengguna dengan email tersebut, beri respons dengan JSON
                echo json_encode(array(
                    'status' => 404,
                    'message' => 'Email tidak ditemukan!'
                ));
            }
        } else {
            // Jika eksekusi query gagal, beri respons dengan JSON
            echo json_encode(array(
                'status' => 500,
                'message' => 'Terjadi kesalahan saat memeriksa email!'
            ));
        }
        // Tutup pernyataan prepared
        $login->close();
    }
} else {
    // Jika parameter POST tidak lengkap, beri respons dengan JSON
    echo json_encode(array(
        'status' => 404,
        'message' => 'Parameter tidak lengkap!'
    ));
}
?>
