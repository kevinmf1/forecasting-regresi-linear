<?php

require ('config/Database.php');
require ('libraries/RegresiLinier.php');

session_start();

if(!isset($_SESSION['username'])) {
   header('Location:index.php');
}

$connect = openConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forecasting PDT</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css" integrity="sha512-SbiR/eusphKoMVVXysTKG/7VseWii+Y3FdHrt0EpKgpToZeemhqHeZeLWLhJutz/2ut2Vw1uQEj2MbRF+TVBUA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js" integrity="sha512-sJa5KWq3F99QOeijUOm9O+BgDgVtzrWBBagZtjlW7F3I47NO1OaNJvbut+9KOPmjNr4Wb3blU4vQiQdi+Zk6wg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="js/bootstrap.js" ></script>
  <link rel="stylesheet" type="text/css" href="css/style2.css">
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
            <a class="nav-link active" href="create-pmb.php">Kelola Data</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="hasilperamalan.php">Hasil Peramalan</a>
          </li>
        </ul>
      </div>
      <a class="btn btn-outline-dark" href="logout.php" role="button">Logout</a>
    </div>
  </nav>

  <div class="jumbotron m-5">
    <h2>Kelola Data</h2>
    <hr>

    <div class="col-sm-12 d-flex justify-content-between">
      <h4 class="d-flex">Tambah Data</h4>
      <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add New</button>   
      </div>
    </div>

    <?php if (isset($_GET['notify'])) {

        if($_GET['notify'] == 'error') {
          echo "<p class='text-danger'>Tahun Penerimaan dan Fakultas sudah ada<p>";
        } else if($_GET['notify'] == 'error2'){
          echo "<p class='text-danger'>Tahun Penerimaan atau Daya Tampung </p>";
        }

    } ?>
    
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Hari Ke.</th>
          <th scope="col">Jumlah Pengunjung</th>
          <th scope="col">Pengunjung yang belanja</th>
          <th scope="col">Opsi</th>
        </tr>
      </thead>
      <tbody>
        <?php
            $query = mysqli_query($connect,"select * from pmb order by id asc");
            $i = 1;

            while($obj = mysqli_fetch_object($query)) {
              ?>

              <tr>
                <td><?php echo $i++ ?></td>
                <td><?php echo $obj->tahun_penerimaan ?></td>
                <td><?php echo $obj->jumlah_pendaftar ?></td>
                <td>
                  <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModal2<?php echo $obj->id; ?>">Ubah</button>&nbsp;
                  <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#exampleModal3<?php echo $obj->id; ?>">Hapus</button>
                </td>
              </tr>

              <!-- Modal (POP UP) untuk ubah data -->
              <div class="modal fade" id="exampleModal2<?php echo $obj->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                      <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                      <form action="editdata.php" method="post">
                      <input type="hidden" class="form-control mb-2" name="idData" value="<?php echo $obj->id; ?>">
                      <div class="form-group row">
                        <label for="staticEmail" class="col-sm-5 mb-2 col-form-label">Jumlah Pengunjung</label>
                        <div class="col-sm-7">
                          <input type="number" step="1" value="<?php echo $obj->tahun_penerimaan; ?>" class="form-control mb-2" name="tahun" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputPassword" class="col-sm-5 col-form-label">Pengunjung yang berbelanja</label>
                        <div class="col-sm-7">
                          <input type="text" class="form-control" id="inputPassword" name="jumlah" value="<?php echo $obj->jumlah_pendaftar; ?>" required>
                        </div>
                      </div>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <input type="submit" value="Submit" class="btn btn-success">
                    </div>
                  </form>

                  </div>
                </div>
              </div>

              <!-- Modal (POP UP) untuk hapus data -->
              <div class="modal fade" id="exampleModal3<?php echo $obj->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                      <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                      <p>Apakah anda yakin ingin menghapus data ini?</p>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-success" data-dismiss="modal">Tidak</button>
                      <a class="btn btn-danger" href="delete-pmb.php?id=<?php echo $obj->id ?>" role="button">Hapus</a>
                    </div>
                </div>
              </div>

        <?php } ?>


        </tr>
      </tbody>
    </table>
  </div>

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <form action="post-pmb.php" method="post">
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-5 mb-2 col-form-label">Jumlah Pengunjung</label>
            <div class="col-sm-7">
              <input type="number" step="1" class="form-control mb-2" name="tahun" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-5 col-form-label">Pengunjung yang berbelanja</label>
            <div class="col-sm-7">
              <input type="number" class="form-control" id="inputPassword" name="jumlah" required>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <input type="submit" value="Submit" class="btn btn-success">
        </div>
      </form>

      </div>
    </div>
  </div>

</body>
</html>
