<?php include "header.php";?>

<?php
if(isset($_POST['submitNewBudgeting']))
{
  if(isset($_REQUEST['inputEffectiveDate']))
    $inputEffectiveDate = $_REQUEST['inputEffectiveDate'];

  if(isset($inputEffectiveDate))
  {
    mysqli_query($connection, "INSERT INTO `budgetingheader`(`EffectiveDate`) VALUES ('$inputEffectiveDate')");

    $sqlQuerySelectMaxBudgetingHeaderID = mysqli_query($connection, "SELECT max(BudgetingHeaderID) as BudgetingHeaderID from budgetingheader where EffectiveDate = '$inputEffectiveDate'");

    $BudgetingHeaderID = mysqli_fetch_array($sqlQuerySelectMaxBudgetingHeaderID)["BudgetingHeaderID"];

    $sqlQueryKategoriPengeluaran2 = mysqli_query($connection, "SELECT kategoriID , kategoriName from kategori where jenisTransaksiID = 2");

    while ($row = mysqli_fetch_array($sqlQueryKategoriPengeluaran2))
    {
      $kategoriID = $row["kategoriID"];

      $inputName = 'inputLimit' . $kategoriID;

      if(isset($_REQUEST[$inputName]))
        $nominal = $_REQUEST[$inputName];

      if(isset($kategoriID) && isset($nominal))
      {
        mysqli_query($connection, "INSERT INTO `budgetingdetail`(`BudgetingHeaderID`, `KategoriID`, `Amount`) VALUES  
          ('$BudgetingHeaderID','$kategoriID','$nominal')");
      }
    }
  }
}

$sqlQueryKategoriPengeluaran = mysqli_query($connection, "SELECT kategoriID , kategoriName from kategori where jenisTransaksiID = 2");

$sqlQueryBudgetingActive = mysqli_query($connection, "SELECT a.EffectiveDate, c.KategoriName , b.Amount as 'limit'
  FROM (
  SELECT EffectiveDate, BudgetingHeaderID 
  from budgetingheader 
  order by EffectiveDate DESC
  LIMIT 1) 
  as a
  JOIN budgetingdetail b on a.BudgetingHeaderID = b.BudgetingHeaderID
  JOIN kategori c on b.KategoriID = c.KategoriID
  group by c.KategoriName, b.Amount
  order by b.amount desc");

$sqlQueryTotalLimit = mysqli_query($connection, "SELECT SUM(b.Amount) as 'totalLimit'
  FROM (
  SELECT EffectiveDate, BudgetingHeaderID 
  from budgetingheader 
  order by EffectiveDate DESC
  LIMIT 1) 
  as a
  JOIN budgetingdetail b on a.BudgetingHeaderID = b.BudgetingHeaderID");

  ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Master Budgeting</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Master</li>
          <li class="breadcrumb-item active">Budgeting</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Budgeting</h5>




          <!-- Default Tabs -->
          <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
              <button class="nav-link w-100 active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1-justified" type="button" role="tab" aria-controls="tab1" aria-selected="true">Budgeting Existing</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
              <button class="nav-link w-100" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2-justified" type="button" role="tab" aria-controls="tab2" aria-selected="false">New Budgeting</button>
            </li>
          </ul>
          <div class="tab-content pt-2" id="myTabjustifiedContent">
            <!-- budgeting existing start -->
            <div class="tab-pane fade show active" id="tab1-justified" role="tabpanel" aria-labelledby="tab1-tab">
              <table class="table table-striped">
                <thead>
                  <tr style="text-align:center;">
                    <th scope="col">Effective Date</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Limit</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  while ($row = mysqli_fetch_array($sqlQueryBudgetingActive))
                  {
                    ?>
                    <tr>
                      <th scope="row"><?php echo $row["EffectiveDate"] ?></th>
                      <td><?php echo $row["KategoriName"] ?></td>
                      <td style="text-align:right;"><?php echo rupiah($row["limit"]) ?></td>
                    </tr>
                    <?php 
                  }
                  ?>
                  <tr style="background-color: aliceblue;">
                    <th scope="row" colspan="2" style="text-align:center;">Total Limit</th>
                    <td style="text-align:right;">
                      <?php echo rupiah(mysqli_fetch_array($sqlQueryTotalLimit)["totalLimit"]) ?>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- budgeting existing end -->
            <!-- new budgeting start -->
            <div class="tab-pane fade" id="tab2-justified" role="tabpanel" aria-labelledby="tab2-tab">

              <!-- General Form Elements -->
              <form method="POST" class="row g-3">

                <div class="col-12">
                  <label class="form-label">Effective Date</label>
                  <input type="date" value=
                  "<?php echo (new DateTime())->format('Y-m-d'); ?>" 
                  class="form-control" id="inputEffectiveDate" name="inputEffectiveDate" required>
                </div>

                <table class="table">
                  <thead>
                    <tr style="text-align:center;">
                      <th scope="col">Category Name</th>
                      <th scope="col">Limit</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    while ($row = mysqli_fetch_array($sqlQueryKategoriPengeluaran))
                    {
                      ?>
                      <tr>
                        <th scope="row"><?php echo $row["kategoriName"] ?></th>
                        <td style="text-align:right;">
                          <input type="number" class="form-control" id="inputLimit" name="inputLimit<?php echo $row["kategoriID"] ?>" placeholder="0" required>
                        </td>
                      </tr>
                      <?php 
                    }
                    ?>
                  </tbody>
                </table>

                <div class="text-center">
                  <button type="submit" name="submitNewBudgeting" id="submitNewBudgeting" class="btn btn-primary">Submit</button>
                </div>
              </form><!-- End General Form Elements -->
            </div>
            <!-- new budgeting end -->
          </div><!-- End Default Tabs -->

        </div>
      </div>
    </div>

  </main><!-- End #main -->

  <?php include "footer.php";?>