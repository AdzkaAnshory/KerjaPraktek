<?php
include "net/koneksi.php";
$id = $_GET["id"];
$query = "SELECT a.*, b.judul FROM tb_penjualan_detail a LEFT JOIN tb_barang b ON a.id_barang = b.id WHERE a.id_penjualan = $id ";
$get = mysqli_query($conn,$query);

$query_pembelian = "SELECT * FROM tb_penjualan WHERE id = $id ";
$get_pembelian = mysqli_query($conn,$query_pembelian);
$det = $get_pembelian->fetch_assoc();

$query_pelanggan = "SELECT * FROM tb_pelanggan WHERE id = ".$det["id_pelanggan"];
$get_pelanggan = mysqli_query($conn,$query_pelanggan);
$pel = $get_pelanggan->fetch_assoc();

$date = new DateTime($det["date_add"]);
$waktu = $date->format('d M Y, H:s');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>INVOICE</title>

        <link href="css/style.default.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body onload="window.print()">

    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">

                <h5 class="lg-title mb10">From</h5>
                <img src="images/themeforest.png" class="img-responsive mb10" alt="" />
                <address>
                    <strong>ThemeForest Web Services, Inc.</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    <abbr title="Phone">P:</abbr> (123) 456-7890
                </address>

            </div><!-- col-sm-6 -->

            <div class="col-sm-6 text-right">
                <h5 class="subtitle mb10">Invoice No.</h5>
                <h4 class="text-primary"><?= $det["invoice"] ?></h4>

                <h5 class="subtitle mb10">To</h5>
                <address>
                    <strong><?= $pel["nama"] ?></strong><br>
                    <?= $pel["email"] ?><br>
                    <?= $pel["alamat"] ?><br>
                    </abbr> +62 <?= $pel["tlp"] ?>
                </address>

                <p></p><?= $waktu ?></p>
            </div>
        </div><!-- row -->

        <div class="table-responsive">
            <table class="table table-bordered table-dark table-invoice">
                <thead>
                <tr>
                    <th><center>No</th>
                    <th><center style="width: 400px;">Barang</th>
                    <th><center>Qty</th>
                    <th><center>Harga</th>
                    <th><center>Diskon</th>
                    <th><center>Total Harga</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                if ($get->num_rows > 0) {
                    while($row = $get->fetch_assoc()) {
                        $diskon = $row["diskon"] / 100;
                        $sub_harga = $row["harga"] * $row["jumlah"];
                        $total_harga = $sub_harga - ($sub_harga*$diskon);

                        echo '
                            <tr>
                                <td><center>'.$no.'</td>
                                <td style="text-align: start;">'.$row['judul'].'</td>
                                <td><center>'.$row['jumlah'].'</td>
                                <td><center>Rp'.$row['harga'].'</td>
                                <td><center>'.$row['diskon'].'%</td>
                                <td><center>Rp'.$total_harga.'</td>
                            </tr>
                        ';

                        $no++;
                    }
                }

                ?>


                </tbody>
            </table>
        </div><!-- table-responsive -->

        <table class="table table-total">
            <tbody>
            <tr>
                <td>JUMLAH BARANG:</td>
                <td>x<?= $det["total"] ?></td>
            </tr>
            <tr>
                <td>TOTAL HARGA:</td>
                <td>Rp<?= $det["harga"] ?></td>
            </tr>
            </tbody>
        </table>


    </div><!-- panel-body -->


        <script src="js/jquery-1.11.1.min.js"></script>
        <script src="js/jquery-migrate-1.2.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/modernizr.min.js"></script>
        <script src="js/pace.min.js"></script>
        <script src="js/retina.min.js"></script>
        <script src="js/jquery.cookies.js"></script>

        <script src="js/custom.js"></script>

    </body>
</html>
