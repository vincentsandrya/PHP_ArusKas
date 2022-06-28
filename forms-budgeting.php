<?php include "header.php";?>

<?php

if(date ('Y/m/26') > date('Y/m/d'))
  $StartDate = date ('Y/m/26', strtotime(date("Y-m-d"). ' - 1 months'));
else
  $StartDate = date ('Y/m/26');

$sqlQueryBudgeting = mysqli_query($connection, 
  "SELECT c.KategoriName as CategoryName, b.Amount as LimitAmount, sum(ifnull(d.nominal,0)) *-1 as Used, b.Amount + sum(ifnull(d.nominal,0)) as Rest, round(((b.Amount + sum(ifnull(d.nominal,0))) / b.Amount * 100),0) as sisaPrcntg 
  FROM (
  SELECT EffectiveDate, BudgetingHeaderID 
  from budgetingheader 
  order by EffectiveDate DESC
  LIMIT 1) 
  as a
  JOIN budgetingdetail b on a.BudgetingHeaderID = b.BudgetingHeaderID
  JOIN kategori c on b.KategoriID = c.KategoriID
  left join transaksi d on c.KategoriID = d.KategoriID and d.tanggalTrans >= '$StartDate'
  group by c.KategoriName, b.Amount
  ORDER BY b.Amount DESC"
);
?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Form Budgeting</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item">Forms</li>
        <li class="breadcrumb-item active">Budgeting</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Budgeting</h5>

        <!-- Budgeting Transaction Start -->
        <div class="col-12">
          <div class="card recent-sales overflow-auto">

            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Budgeting Transaction <span>| This Month </span> </h5>

              <table class="table table-borderless datatable">
                <thead>
                  <tr>
                    <th scope="col">Category</th>
                    <th scope="col">Limit</th>
                    <th scope="col">Used</th>
                    <th scope="col">Rest</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  while ($row = mysqli_fetch_array($sqlQueryBudgeting))
                  {
                    ?>
                    <tr>
                      <th scope="row"><?php echo $row["CategoryName"] ?></th>
                      <td style="text-align:right;"><a href="#" class="text-primary"><?php echo $row["LimitAmount"] ?></a></td>
                      <td style="text-align:right;"><?php echo $row["Used"] ?></td>
                      <td style="text-align:right;"><?php echo $row["Rest"] ?>
                      <br/><?php echo $row["sisaPrcntg"] ?>%</td>
                    </tr>
                    <?php 
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div><!-- Recent Transaction End -->


      </div>
    </div>
  </div>

</main><!-- End #main -->

<?php include "footer.php";?>