<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "booking";
$sql_file   = "database/booking.sql";

// Mencoba koneksi ke database server
$conn = mysqli_connect($servername, $username, $password);

// Check koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
echo "Koneksi berhasil";

// Membuat database
$sql = "CREATE DATABASE $dbname COLLATE latin1_swedish_ci";
if (mysqli_query($conn, $sql)) {
    echo "Database $dbname berhasil dibuat dengan tipe collation latin1_swedish_ci";
} else {
    echo "Error membuat database: " . mysqli_error($conn);
}

// Membuka koneksi baru ke database baru yang dibuat
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check koneksi
if (!$conn) {
    die("Koneksi ke database $dbname gagal: " . mysqli_connect_error());
}
echo "Koneksi ke database $dbname berhasil";

// Baca file SQL
$sql = file_get_contents($sql_file);

// Jalankan perintah SQL
if (mysqli_multi_query($conn, $sql)) {
    echo "Import data berhasil";
} else {
    echo "Error import data: " . mysqli_error($conn);
}

mysqli_close($conn);
