<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "chart_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if(!$conn){
    die("koneksi gagal : ".mysqli_connect_error());
}


$query  = "SELECT jurusan, COUNT(*) AS jml_mahasiswa FROM mahasiswa GROUP BY jurusan";
$result = mysqli_query($conn, $query);

$jurusan = array();
$jumlah = array();

while($row = mysqli_fetch_assoc($result)){
    $jurusan[] = $row['jurusan'];
    $jumlah[]  = $row['jml_mahasiswa'];
}
?>