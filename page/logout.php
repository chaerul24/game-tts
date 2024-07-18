<?php
session_start();
if($_SESSION['user']){
    session_destroy();
    echo '<script>alert("Logout berhasil");</script>';
    header('Location: http://localhost');
} else {
   header('Location: http://localhost'); 
}