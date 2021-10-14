<?php
/**
 * Created by PhpStorm.
 * User: radhs
 * Date: 9/8/2018
 * Time: 2:23 PM
 */

session_start();
$id_admin = $_SESSION["id"];
include "../net/koneksi.php";

if (isset($_GET["load"])) { loadData($conn); }
if (isset($_GET["load_sales_gudang"])) { load_sales_gudang($conn); }
if (isset($_GET["tambah"])) { tambah($conn, $id_admin); }
if (isset($_GET["ubah"])) { ubah($conn); }
if (isset($_GET["hapus"])) { hapus($conn); }

function tambah($conn, $id_admin) {
    $response["status"] = 1;

    $kode = $_POST["kode"];
    $nama = $_POST["nama"];
    $id_sales = $_POST["sales"];
    $id_gudang = $_POST["gudang"];
    $stok = $_POST["stok"];
    $penyusun = $_POST["penyusun"];
    $kategori = $_POST['kategori'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];

    $query_insert = "INSERT INTO tb_barang (kode, judul, penyusun, kategori, stok, harga_beli, harga_jual, id_sales, id_gudang, add_by) VALUES 
                    ('$kode', '$nama', '$penyusun', '$kategori', '$stok', '$harga_beli', '$harga_jual', '$id_sales', '$id_gudang', '$id_admin')";
    $insert = mysqli_query($conn,$query_insert) or die(mysqli_error($conn));

    if($insert) {
        loadData($conn);
    } else {
        $response["status"] = 0;
        $response["msg"] = "Gagal menambah barang";

        echo json_encode($response);
    }
}

function ubah($conn) {
    $response["status"] = 1;

    $id = $_POST["id"];
    $kode = $_POST["kode"];
    $nama = addslashes($_POST["nama"]);
    $penyusun = $_POST["penyusun"];
    $kategori = $_POST['kategori'];
    $stok = $_POST["stok"];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $id_sales = $_POST["sales"];
    $id_gudang = $_POST["gudang"];

    $query = "UPDATE tb_barang SET kode='$kode', judul='$nama', penyusun='$penyusun', kategori='$kategori', stok='$stok', harga_beli='$harga_beli', harga_jual='$harga_jual', id_sales='$id_sales', id_gudang='$id_gudang' WHERE id = $id";
    $update = mysqli_query($conn,$query) or die(mysqli_error($conn));

    if($update) {
        loadData($conn);
    } else {
        $response["status"] = 0;
        $response["msg"] = "Gagal mengubah barang";

        echo json_encode($response);
    }
}

function hapus($conn) {
    $response["status"] = 1;

    $id = $_POST["id"];

    $query = "UPDATE tb_barang SET deleted=0 WHERE id = $id";
    $update = mysqli_query($conn,$query) or die(mysqli_error($conn));

    if($update) {
        loadData($conn);
    } else {
        $response["status"] = 0;
        $response["msg"] = "Gagal menambah barang";

        echo json_encode($response);
    }
}

function loadData($conn) {
    $response["status"] = 1;

    $query = "SELECT a.*, b.penerbit, d.nama as nama_gudang
                    FROM tb_barang a 
                    LEFT JOIN tb_sales b ON a.id_sales = b.id 
                    LEFT JOIN tb_gudang d ON a.id_gudang = d.id 
                    WHERE a.deleted = 1 ";

    $get = mysqli_query($conn,$query) or die(mysqli_error($conn));

    $data = array();

    if ($get->num_rows > 0) {
        while ($r = $get->fetch_assoc()) {
            array_push($data, $r);
        }

        $response["data"] = $data;

        echo json_encode($response);
    } else {
        $response["status"] = 0;
    }

}

function load_sales_gudang($conn) {
    $response["status"] = 1;

    $get_sales = mysqli_query($conn,"SELECT * FROM tb_sales WHERE deleted = 1 ") or die(mysqli_error($conn));
    $get_gudang = mysqli_query($conn,"SELECT * FROM tb_gudang WHERE deleted = 1 ") or die(mysqli_error($conn));

    $data_sales = array();
    $data_gudang = array();

    //Push data sales
    while ($r = $get_sales->fetch_assoc()) {
        array_push($data_sales, $r);
    }

    //Push data gudang
    while ($g = $get_gudang->fetch_assoc()) {
        array_push($data_gudang, $g);
    }

    $response["sales"] = $data_sales;
    $response["gudang"] = $data_gudang;

    echo json_encode($response);
}