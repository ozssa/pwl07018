<?php
$koneksi = mysqli_connect("localhost","root","","pwlgenap2019-akademik");

 

if (mysqli_connect_errno()){
	echo "Gagal melakukan koneksi ke MySQL: " . mysqli_connect_error();
}

//mysqli_close($koneksi);
?>