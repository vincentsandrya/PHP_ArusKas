<!DOCTYPE html>
<html lang="en">

<?php
include "include/config.php";
ob_start();
session_start();
?>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Matriks Keputusan dan Normalisasi</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head >
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark" style="background: #243D25;">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Sistem Pertanian Padi</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="edit.php">Edit Profile</a></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" style="background: #5F7464;" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Home
                            </a>
                            <a class="nav-link" href="padi.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Data Padi
                            </a>
                            <a class="nav-link" href="kriteria.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Data Kriteria & Bobot
                            </a>
                            <a class="nav-link" href="normalisasi.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Matriks Keputusan & Normalisasi
                            </a>
                            <a class="nav-link" href="nilai.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Nilai Preferensi
                            </a>
                        </div>
                    </div>
                   <div class="sb-sidenav-footer text-white" style="background: #243D25; height:48px;">
                        <div class="small">Logged in as:</div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4" style="color: black; text-align: center;">Matriks</h1>

                        <div class="card-header">
                                <h5 style="color: black;">Matriks Keputusan dan Normalisasi</h4>
                        </div>
                        <button type="button" class="btn btn-outline-success btn-sm m-2" data-bs-toggle="modal" data-target="#tambahdata">
                                Tambah Alternatif
                        </button>

                  <div class="table-responsive">
<table class="table table-striped mb-0">
    <caption>Matrik Keputusan(X)</caption>
    <tr>
        <th rowspan='2'>Data</th>
        <th colspan='6'>Kriteria</th>
    </tr>
    <tr>
        <th>C1</th>
        <th>C2</th>
        <th>C3</th>
        <th>C4</th>
        <th>C4</th>
        <th colspan="2">C6</th>
    </tr>
    <?php
$sql = "SELECT
                                    a.padi_id,
                                    b.name,
                                    SUM(IF(a.kriteria_id=1,a.value,0)) AS C1,
                                    SUM(IF(a.kriteria_id=2,a.value,0)) AS C2,
                                    SUM(IF(a.kriteria_id=3,a.value,0)) AS C3,
                                    SUM(IF(a.kriteria_id=4,a.value,0)) AS C4,
                                    SUM(IF(a.kriteria_id=4,a.value,0)) AS C5,
                                    SUM(IF(a.kriteria_id=5,a.value,0)) AS C6
                                    FROM
                                    evaluasi a
                                    JOIN data_padi b USING(padi_id)
                                    GROUP BY a.padi_id
                                    ORDER BY a.padi_id";
// $result = $connection->query($sql);

// VAR_DUMP($result);

// $X = array(1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array(), 6 => array());
// while ($row = $result->fetch_object()) {
//     array_push($X[1], round($row->C1, 2));
//     array_push($X[2], round($row->C2, 2));
//     array_push($X[3], round($row->C3, 2));
//     array_push($X[4], round($row->C4, 2));
//     array_push($X[5], round($row->C5, 2));
//     array_push($X[6], round($row->C6, 2));
//     echo "<tr class='center'>
//             <th>A<sub>{$row->padi_id}</sub> {$row->name}</th>
//             <td>" . round($row->C1, 2) . "</td>
//             <td>" . round($row->C2, 2) . "</td>
//             <td>" . round($row->C3, 2) . "</td>
//             <td>" . round($row->C4, 2) . "</td>
//             <td>" . round($row->C5, 2) . "</td>
//             <td>" . round($row->C6, 2) . "</td>
//             <td>
//             <a href='keputusanhapus.php?id={$row->padi_id}' class='btn btn-danger btn-sm'>Hapus</a>
//             </td>
//           </tr>\n";
// }
// $result->free();

?>
</table>

<table class="table table-striped mb-0">
    <caption>
        Matrik Ternormalisasi (R)
    </caption>
    <tr>
        <th rowspan='2'>Alternatif</th>
        <th colspan='6'>Kriteria</th>
    </tr>
    <tr>
        <th>C1</th>
        <th>C2</th>
        <th>C3</th>
        <th>C4</th>
        <th>C5</th>
        <th>C6</th>
    </tr>
    <?php
$sql = "SELECT
          a.padi_id,
          SUM(
            IF(
              a.kriteria_id =1,
              IF(
                b.atribut='benefit',
                a.value/" . max($X[1]) . ",
                " . min($X[1]) . "/a.value)
              ,0)
              ) AS C1,
          SUM(
            IF(
              a.kriteria_id =2,
              IF(
                b.atribut='benefit',
                a.value/" . max($X[2]) . ",
                " . min($X[2]) . "/a.value)
               ,0)
             ) AS C2,
          SUM(
            IF(
              a.kriteria_id =3,
              IF(
                b.atribut='benefit',
                a.value/" . max($X[3]) . ",
                " . min($X[3]) . "/a.value)
               ,0)
             ) AS C3,
          SUM(
            IF(
              a.kriteria_id =4,
              IF(
                b.atribut='benefit',
                a.value/" . max($X[4]) . ",
                " . min($X[4]) . "/a.value)
               ,0)
             ) AS C4,
          SUM(
            IF(
              a.kriteria_id =5,
              IF(
                b.atribut='benefit',
                a.value/" . max($X[5]) . ",
                " . min($X[5]) . "/a.value)
               ,0)
             ) AS C5,
             SUM(
            IF(
              a.kriteria_id =5,
              IF(
                b.attribute='cost',
                a.value/" . max($X[6]) . ",
                " . min($X[6]) . "/a.value)
               ,0)
             ) AS C5
        FROM
          evasluasi a
          JOIN kriteria b USING(kriteria_id)
        GROUP BY a.padi_id
        ORDER BY a.padi_id
       ";
// $result = $connection->query($sql);
// $R = array();
// while ($row = $result->fetch_object()) {
//     $R[$row->padi_id] = array($row->C1, $row->C2, $row->C3, $row->C4, $row->C5,$row->C6);
//     echo "<tr class='center'>
//             <th>A{$row->padi_id}</th>
//             <td>" . round($row->C1, 2) . "</td>
//             <td>" . round($row->C2, 2) . "</td>
//             <td>" . round($row->C3, 2) . "</td>
//             <td>" . round($row->C4, 2) . "</td>
//             <td>" . round($row->C5, 2) . "</td>
//             <td>" . round($row->C6, 2) . "</td>
//           </tr>\n";
// }
?>
</table>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
   </div>

<div class="modal fade text-left" id="tambahdata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel33">Isi Nilai </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
     
                </main>
                <br>
                <footer class="py-4 bg-light mt-auto" style= "background: #243D25; height: 40px; ">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-center small">
                            <div class="text-muted">Copyright &copy; Teodora Rikie Lam</div>
                        </div>
                    </div>
                </footer>
            </div>
   </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>


    <?php 
    mysqli_close($connection);
    ob_end_flush();
    ?>

</html>
