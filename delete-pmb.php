<?php

require ('config/Database.php');

session_start();

if(!isset($_SESSION['username'])) {
   header('Location:index.php');
}

$connect = openConnection();

$id = $_GET['id'];

if(mysqli_query($connect, "DELETE FROM pmb WHERE pmb.id = '$id'")) {
   header('Location:create-pmb.php');
} else {
   header("Location:create-pmb.php?notify=error");
}


// mysqli_query($connect, "UPDATE pmb INNER JOIN pmb_fakultas ON pmb.tahun_penerimaan = pmb_fakultas.tahun_penerimaan
// SET pmb.jumlah_pendaftar = (pmb.jumlah_pendaftar - pmb_fakultas.jumlah_pendaftar) WHERE pmb_fakultas.id ='$id'");


// $var3 = mysqli_query($connect, "SELECT * FROM pmb_fakultas WHERE id ='$id'");
// while ($var1 = mysqli_fetch_object($var3)) {
//    $tahun_penerimaan1 = $var1->tahun_penerimaan;
//    $var2 = mysqli_query($connect, "SELECT pmb.id, pmb.tahun_penerimaan, pmb.jumlah_pendaftar FROM pmb JOIN pmb_fakultas ON pmb.tahun_penerimaan = pmb_fakultas.tahun_penerimaan WHERE pmb_fakultas.tahun_penerimaan = '$tahun_penerimaan1' LIMIT 1");

//    while ($var4 = mysqli_fetch_object($var2)) {
//       $jumlah_pendaftar1 = $var4->jumlah_pendaftar;
//       $idpmb1 = $var4->id;
//       if($jumlah_pendaftar1 <= 0) {
//          mysqli_query($connect, "DELETE FROM pmb WHERE pmb.id = '$idpmb1'");
//       }
//    }
// }

// if (mysqli_query($connect,"delete from pmb_fakultas where id='$id'")) {
//    header('Location:create-pmb.php');
// } else {
//   echo "Error deleting record: " . mysqli_error($conn);
// }

?>
