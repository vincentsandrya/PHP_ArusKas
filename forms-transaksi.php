<?php include "header.php";?>

<?php

if(isset($_POST['submitPemasukkan']))
{
  $inputJenisTrans = 1;
  if(isset($_REQUEST['inputNominal']))
    $inputNominal=$_REQUEST['inputNominal'];
  if(isset($_REQUEST['inputTanggalTrans']))
    $inputTanggalTrans=$_REQUEST['inputTanggalTrans'];
  if(isset($_REQUEST['inputKategori']))
    $inputKategori=$_REQUEST['inputKategori'];
  if(isset($_REQUEST['inputPembayaran']))
    $inputPembayaran=$_REQUEST['inputPembayaran'];
  if(isset($_REQUEST['inputCatatan']))
    $inputCatatan=$_REQUEST['inputCatatan'];

  mysqli_query($connection, "INSERT INTO `transaksi`(`jenisTransaksiID`, `nominal`, `tanggalTrans`, `kategoriID`, `metodePembayaranID`, `catatan`) VALUES('$inputJenisTrans','$inputNominal','$inputTanggalTrans','$inputKategori','$inputPembayaran','$inputCatatan')");
}

if(isset($_POST['submitPengeluaran']))
{
  $inputJenisTrans = 2;
  if(isset($_REQUEST['inputNominalPengeluaran']))
    $inputNominalPengeluaran = -1 * $_REQUEST['inputNominalPengeluaran'];
  if(isset($_REQUEST['inputTanggalTransPengeluaran']))
    $inputTanggalTransPengeluaran=$_REQUEST['inputTanggalTransPengeluaran'];
  if(isset($_REQUEST['inputKategoriPengeluaran']))
    $inputKategoriPengeluaran=$_REQUEST['inputKategoriPengeluaran'];
  if(isset($_REQUEST['inputPembayaranPengeluaran']))
    $inputPembayaranPengeluaran=$_REQUEST['inputPembayaranPengeluaran'];
  if(isset($_REQUEST['inputCatatanPengeluaran']))
    $inputCatatanPengeluaran=$_REQUEST['inputCatatanPengeluaran'];

  mysqli_query($connection, "INSERT INTO `transaksi`(`jenisTransaksiID`, `nominal`, `tanggalTrans`, `kategoriID`, `metodePembayaranID`, `catatan`) VALUES('$inputJenisTrans','$inputNominalPengeluaran','$inputTanggalTransPengeluaran','$inputKategoriPengeluaran','$inputPembayaranPengeluaran','$inputCatatanPengeluaran')");
}

$sqlQueryKategoriPemasukkan = mysqli_query($connection, "SELECT kategoriID , kategoriName from kategori where jenisTransaksiID = 1");
$sqlQueryKategoriPengeluaran = mysqli_query($connection, "SELECT kategoriID , kategoriName from kategori where jenisTransaksiID = 2");
$sqlQueryMetodePembayaran1 = mysqli_query($connection, "SELECT metodePembayaranID, metodePembayaranName from metodepembayaran");
$sqlQueryMetodePembayaran2 = mysqli_query($connection, "SELECT metodePembayaranID, metodePembayaranName from metodepembayaran");

?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Form Transaksi</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item">Forms</li>
        <li class="breadcrumb-item active">Transaksi</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Transaksi</h5>

        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
          <li class="nav-item flex-fill" role="presentation">
            <button class="nav-link w-100 active" id="pemasukkan-tab" data-bs-toggle="tab" data-bs-target="#presentation-justified" type="button" role="tab" aria-controls="pemasukkan" aria-selected="true">Pemasukkan</button>
          </li>
          <li class="nav-item flex-fill" role="presentation">
            <button class="nav-link w-100" id="Pengeluaran-tab" data-bs-toggle="tab" data-bs-target="#Pengeluaran-justified" type="button" role="tab" aria-controls="Pengeluaran" aria-selected="false">Pengeluaran</button>
          </li>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
          <!-- pemasukkan start -->
          <div class="tab-pane fade show active" id="presentation-justified" role="tabpanel" aria-labelledby="presentation-tab">

            <!-- General Form Elements -->
            <form method="POST" class="row g-3">

              <div class="col-12">
                <label for="inputNumber" class="form-label">Nominal</label>
                <input type="number" class="form-control" id="inputNominal" name="inputNominal" required>
              </div>

              <div class="col-12">
                <label class="form-label">Tanggal Transaksi</label>
                <input type="date" value=
                "<?php echo (new DateTime())->format('Y-m-d'); ?>" 
                class="form-control" id="inputTanggalTrans" name="inputTanggalTrans" required>
              </div>

              <div class="col-12">
                <label class="form-label">Kategori</label>
                <select class="form-select" aria-label="Default select example" id="inputKategori" name="inputKategori" required>
                  <?php
                    // var_dump($sqlQuery);
                  while($rowKategori = mysqli_fetch_array($sqlQueryKategoriPemasukkan))
                  {
                    // var_dump($rowKategori);
                    ?>
                    <option value="<?php echo $rowKategori["kategoriID"]?>">
                      <?php echo $rowKategori["kategoriName"]?>
                    </option>
                    <?php
                  }
                  ?>
                </select>
              </div>   

              <div class="col-12">
                <label class="form-label">Metode Pembayaran</label>
                <select class="form-select" aria-label="Default select example" id="inputPembayaran" name="inputPembayaran" required>
                  <?php
                    // var_dump($sqlQuery);
                  while($rowMetodePembayaran = mysqli_fetch_array($sqlQueryMetodePembayaran1))
                  {
                    // var_dump($rowKategori);
                    ?>
                    <option value="<?php echo $rowMetodePembayaran["metodePembayaranID"]?>">
                      <?php echo $rowMetodePembayaran["metodePembayaranName"]?>
                    </option>
                    <?php
                  }
                  ?>
                </select>
              </div>

              <div class="col-12">
                <label class="form-label">Catatan</label>
                <input type="text" class="form-control" id="inputCatatan" name="inputCatatan">
              </div>

              <div class="text-center">
                <button type="submit" name="submitPemasukkan" id="submitPemasukkan" class="btn btn-primary">Submit</button>
              </div>
            </form><!-- End General Form Elements -->
          </div>
          <!-- pemasukkan end -->
          <!-- pengeluaran start -->
          <div class="tab-pane fade" id="Pengeluaran-justified" role="tabpanel" aria-labelledby="Pengeluaran-tab">

            <!-- General Form Elements -->
            <form method="POST" class="row g-3">

              <div class="col-12">
                <label for="inputNumber" class="form-label">Nominal</label>
                <input type="number" class="form-control" id="inputNominalPengeluaran" name="inputNominalPengeluaran" required>
              </div>

              <div class="col-12">
                <label class="form-label">Tanggal Transaksi</label>
                <input type="date" value=
                "<?php echo (new DateTime())->format('Y-m-d'); ?>" 
                class="form-control" id="inputTanggalTransPengeluaran" name="inputTanggalTransPengeluaran" required>
              </div>

              <div class="col-12">
                <label class="form-label">Kategori</label>
                <select class="form-select" aria-label="Default select example" id="inputKategoriPengeluaran" name="inputKategoriPengeluaran" required>
                  <?php
                    // var_dump($sqlQuery);
                  while($rowKategori = mysqli_fetch_array($sqlQueryKategoriPengeluaran))
                  {
                    // var_dump($rowKategori);
                    ?>
                    <option value="<?php echo $rowKategori["KategoriID"]?>">
                      <?php echo $rowKategori["kategoriName"]?>
                    </option>
                    <?php
                  }
                  ?>
                </select>
              </div>

              <div class="col-12">
                <label class="form-label">Metode Pembayaran</label>
                <select class="form-select" aria-label="Default select example" id="inputPembayaranPengeluaran" name="inputPembayaranPengeluaran" required>
                  <?php
                    // var_dump($sqlQuery);
                  while($rowMetodePembayaran = mysqli_fetch_array($sqlQueryMetodePembayaran2))
                  {
                    // var_dump($rowKategori);
                    ?>
                    <option value="<?php echo $rowMetodePembayaran["metodePembayaranID"]?>">
                      <?php echo $rowMetodePembayaran["metodePembayaranName"]?>
                    </option>
                    <?php
                  }
                  ?>
                </select>
              </div>

              <div class="col-12">
                <label class="form-label">Catatan</label>
                <input type="text" class="form-control" id="inputCatatanPengeluaran" name="inputCatatanPengeluaran">
              </div>

              <div class="text-center">
                <button type="submit" name="submitPengeluaran" id="submitPengeluaran" class="btn btn-primary">Submit</button>
              </div>
            </form><!-- End General Form Elements -->
          </div>
          <!-- pengeluaran end -->
        </div><!-- End Default Tabs -->
      </div>
    </div>
  </div>

</main><!-- End #main -->

<?php include "footer.php";?>