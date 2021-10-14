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
if (isset($_GET["tambah"])) { tambah($conn, $id_admin); }
if (isset($_GET["detail"])) { loadDetail($conn); }
if (isset($_GET["cariInv"])) { cariInvoice($conn, $_POST["invoice"]); }
if (isset($_GET["doRetur"])) { doRetur($conn, $_POST["content"], $id_admin); }

function tambah($conn, $id_admin) {
    $response["status"] = 1;

    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $hp = $_POST["hp"];
    $alamat = $_POST['alamat'];

    $query_insert = "INSERT INTO tb_penjualan (nama, tlp, email, alamat, add_by) VALUES ('$nama', '$hp', '$email', '$alamat', '$id_admin')";
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
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $hp = $_POST["hp"];
    $alamat = $_POST['alamat'];

    $query = "UPDATE tb_penjualan SET nama='$nama', tlp='$hp', email='$email', alamat='$alamat' WHERE id = $id";
    $update = mysqli_query($conn,$query) or die(mysqli_error($conn));

    if($update) {
        loadData($conn);
    } else {
        $response["status"] = 0;
        $response["msg"] = "Gagal menambah barang";

        echo json_encode($response);
    }
}

function hapus($conn) {
    $response["status"] = 1;

    $id = $_POST["id"];

    $query = "UPDATE tb_penjualan SET deleted=0 WHERE id = $id";
    $update = mysqli_query($conn,$query) or die(mysqli_error($conn));

    if($update) {
        loadData($conn);
    } else {
        $response["status"] = 0;
        $response["msg"] = "Gagal mengubah penjualan";

        echo json_encode($response);
    }
}

function loadData($conn) {
    $response["status"] = 1;

    $query = "SELECT a.*, b.nama as pelanggan FROM tb_penjualan a LEFT JOIN tb_pelanggan b ON a.id_pelanggan = b.id";
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

function loadDetail($conn) {
    $response["status"] = 1;
    $id = $_POST["id"];

    $query = "SELECT a.*, b.judul as barang FROM tb_penjualan_detail a LEFT JOIN tb_barang b ON a.id_barang = b.id WHERE a.id_penjualan = $id";
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

function cariInvoice($conn, $invoice) {
    $response["status"] = 1;

    $query = "SELECT a.*, b.judul as barang FROM tb_penjualan_detail a LEFT JOIN tb_barang b ON a.id_barang = b.id LEFT JOIN tb_penjualan c ON c.id = a.id_penjualan WHERE c.invoice = 'INV-$invoice'";
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

function doRetur($conn, $content, $id_admin) {
    $content = explode("#", $content);

    $id_barang = $content[0];
    $id_penjualan = $content[1];
    $jumlah = $content[2];

    $query_insert = "INSERT INTO tb_retur (id_penjualan, id_barang, jumlah, id_admin) VALUES ('$id_penjualan', '$id_barang', '$jumlah', '$id_admin')";
    $insert = mysqli_query($conn,$query_insert) or die(mysqli_error($conn));

    if($insert) {
        $response["status"] = 1;
        echo json_encode($response);
    } else {
        $response["status"] = 0;
        $response["msg"] = "Gagal meretur barang";

        echo json_encode($response);
    }
}