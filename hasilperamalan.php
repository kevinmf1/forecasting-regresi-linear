<?php

require ('config/Database.php');
require ('libraries/RegresiLinier.php');

error_reporting(0);

session_start();

if(!isset($_SESSION['username'])) {
  header('Location:index.php');
}

$connect = openConnection();

if($tahun = mysqli_query($connect,'select tahun_penerimaan,jumlah_pendaftar from pmb')){
  $arrayTahun = array();
  $arrayJumlah = array();
  while($obj = mysqli_fetch_object($tahun)){

    array_push($arrayTahun,$obj->tahun_penerimaan);
    array_push($arrayJumlah,$obj->jumlah_pendaftar);

  }
}

$regresi = new RegresiLinier($arrayTahun, $arrayJumlah);
$total = count((array)$regresi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forecasting PDT</title>
    <!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js" integrity="sha512-1/RvZTcCDEUjY/CypiMz+iqqtaoQfAITmNSJY17Myp4Ms5mdxPS5UV7iOfdZoxcGhzFbOm6sntTKJppjvuhg4g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css" integrity="sha512-SbiR/eusphKoMVVXysTKG/7VseWii+Y3FdHrt0EpKgpToZeemhqHeZeLWLhJutz/2ut2Vw1uQEj2MbRF+TVBUA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="css/style2.css">
    <script src="js/Chart.min.js"></script>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-success text-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="dashboard.php">Peramalan Jumlah Pengunjung</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="dashboard.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="create-pmb.php">Kelola Data</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="hasilperamalan.php">Hasil Peramalan</a>
          </li>
        </ul>
      </div>
      <a class="btn btn-outline-dark" href="logout.php" role="button">Logout</a>
    </div>
  </nav>

  <div class="jumbotron m-5">    
    <table class="table">

      <!-- Judul Table -->
      <thead>
        <tr>
          <th scope="col">Hari Ke.</th>
          <th scope="col">Jumlah Pengunjung (X)</th>
          <th scope="col">Pengunjung yang belanja (Y)</th>
          <th scope="col">X<sup>2</sup></th>
          <th scope="col">Y<sup>2</sup></th>
          <th scope="col">XY</th>
        </tr>
      </thead>

      <!-- Body Table -->
      <tbody>
        <?php
            $Xr;
            $X2r;
            $Yr;
            $Y2r;
            $XYr;

            $query = mysqli_query($connect,"select * from pmb order by tahun_penerimaan asc");
            $i = 1;

            while($obj = mysqli_fetch_object($query)) {
              ?>

              <tr>
                <th scope="row"><?php echo $i++ ?></th>
                <td><?php echo $obj->tahun_penerimaan ?></td>
                <td><?php echo $obj->jumlah_pendaftar ?></td>
                <td><?php echo ($obj->tahun_penerimaan * $obj->tahun_penerimaan)  ?></td>               
                <td><?php echo ($obj->jumlah_pendaftar * $obj->jumlah_pendaftar) ?></td>
                <td><?php echo ($obj->tahun_penerimaan * $obj->jumlah_pendaftar) ?></td>
              </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr>
          <th scope="row">Total</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tfoot>
    </table>

    <script type="text/javascript">
      function getColumnValues(table, column) {
          const body = table.getElementsByTagName("tbody")[0];
          const rows = [...body.getElementsByTagName("tr")];
          const contents = rows.map(row => row.getElementsByTagName("td")[column].textContent);
          return contents.filter(c => !isNaN(c)).map(c => Number(c));
      }
      
      const sum = arr => arr.reduce((a, b) => a + b, 0);
      const table = document.getElementsByTagName("table")[0];
      const totals = [...table.getElementsByTagName("tfoot")[0].getElementsByTagName("td")];
      for (const [i, cell] of totals.entries()) {
          cell.innerHTML = sum(getColumnValues(table, i));
      }
    </script>

    <div class="mt-4">
      <p>Menghitung Konstanta (a)</p>
      <p>a = <u>(Σy)(Σx²) – (Σx)(Σxy)</u> <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;n(Σx²) – (Σx)²</p>
      <p class="text-danger">a = <?php echo $regresi->a; ?></p>
    </div>

    <div class="mt-4">
      <p>Menghitung Koefisien Regresi (b)</p>
      <p>b = <u>n(Σxy) – (Σx)(Σy)</u><br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; n(Σx²) – (Σx)²</p>
      <p class="text-danger">b = <?php echo $regresi->b; ?></p>
    </div>

    <div class="mt-4">
      <p>Menghitung Model Persamaan Regresi</p>
      <p>Y = a + bX</p>
    </div>

    <?php if(isset($_POST['tahun']) && isset($_POST['tahun2'])) { ?>
    <div class="mt-5">
      <h2>Hasil Peramalan Tahun <?php echo $_POST['tahun']; ?> - <?php echo $_POST['tahun2']; ?></h2>
      <hr>
      <p>Tahun &nbsp;&nbsp;&nbsp;Hasil Forecasting</p>
      <?php 
        $arraytahun = array();
        $arrayforecasting = array();

        $tahun1 = $_POST['tahun'];
        $tahun2 = $_POST['tahun2'];

        for($i=$tahun1; $i <= $tahun2; $i++) {
          array_push($arraytahun, $i);
          array_push($arrayforecasting, $regresi->forecast($i));
          echo $i;
          echo " &nbsp; &nbsp; &nbsp;&nbsp;";
          echo $regresi->forecast($i);
          echo "<br>";
        }
      ?>
    </div>

    <div class="jumbotron mt-5">
      <br>
      <p>Grafik Regresi Linier Peramalan Jumlah yang Belanja</p>
      <canvas id="graph" width=500 height="150"></canvas>
      <script>
          ctx = document.getElementById('graph');
          var chart = new Chart(ctx, {
              type : 'line',
              data: {
                  labels: [<?=implode(",",$arraytahun)?>],
                  datasets: [
                      {
                      label: 'Hasil Regresi Linier',
                      data: [<?=implode(",", $arrayforecasting)?>],
                      backgroundColor: 'rgba(255, 99, 132, 0.2)',
                      borderWidth: 1
                      },
                  ]
              }
          });
      </script>
    </div>

    <?php } else { ?>
    <div class="mt-5">
      <h5>Peramalan</h5>
      <p>Lakukan Peramalan Jumlah yang Belanja (dengan range tertentu)</p>
      <hr>
      <form class="form-inline" action="hasilperamalan.php" method="POST">
        <input type="number" class="form-control mb-3 mr-sm-2" id="inlineFormInputName2" name="tahun" placeholder="Masukkan Jumlah Pengunjung Awal" required>
        <input type="number" class="form-control mb-3 mr-sm-2" id="inlineFormInputName2" name="tahun2" placeholder="Masukkan Jumlah Pengunjung Akhir" required>
        <button type="submit" class="btn btn-primary mb-2">Submit</button>
      </form>
    </div>

    <div class="jumbotron mt-5">
      <br>
      <p>Grafik Regresi Linier Peramalan Jumlah yang Belanja</p>
      <canvas id="graph" width=500 height="150"></canvas>
      <script>
          ctx = document.getElementById('graph');
          var chart = new Chart(ctx, {
              type : 'line',
              data: {
                  labels: [<?=implode(",",$arrayTahun)?>],
                  datasets: [
                      {
                      label: 'Realisasi Pengunjung',
                      data: [<?=implode(",", $arrayJumlah)?>],
                      backgroundColor: 'rgba(12, 199, 132, 0.2)',
                      borderWidth: 1
                      },
                      {
                      label: 'Hasil Regresi Linier',
                      data: [<?=implode(",", $regresi->all)?>],
                      backgroundColor: 'rgba(255, 99, 132, 0.2)',
                      borderWidth: 1
                      },
                  ]
              }
          });
      </script>
    </div>
    <?php } ?>

  </div>
</body>
</html>
