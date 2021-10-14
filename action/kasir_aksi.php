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

if (isset($_GET["cari"])) { cariBuku($conn); }
if (isset($_GET["tambah_keranjang"])) { tambah_keranjang($conn, $id_admin); }
if (isset($_GET["clear_keranjang"])) { clear_keranjang($conn, $id_admin); }
if (isset($_GET["get_keranjang"])) { loadKeranjang($conn, $id_admin); }
if (isset($_GET["hapus"])) { hapus($conn, $id_admin); }
if (isset($_GET["bayar"])) { bayar($conn, $id_admin); }

function cariBuku($conn) {
    $response["status"] = 1;

    $kode = $_POST['kode_buku'];

    if ($kode != "") {
        $query = "SELECT * FROM tb_barang WHERE kode = '$kode'";
        $get = mysqli_query($conn,$query) or die(mysqli_error($conn));

        if(mysqli_num_rows($get) > 0) {
            $data = mysqli_fetch_object($get);

            $response["msg"] = "Data ditemukan";
            $response["data"] = $data;

            echo json_encode($response);
        } else {
            $response["status"] = 0;
            $response["msg"] = "Data tidak ditemukan";

            echo json_encode($response);
        }
    }  else {
        $response["status"] = 0;
        $response["msg"] = "Kode buku harus diisi";

        echo json_encode($response);
    }
}

function hapus($conn, $id_admin) {
    $response["status"] = 1;

    $id = $_POST["id"];

    $query = "DELETE FROM tb_keranjang WHERE id = $id";
    $hapus = mysqli_query($conn,$query);

    if($hapus) {
        loadKeranjang($conn, $id_admin);
    } else {
        $response["status"] = 0;
        $response["msg"] = "Gagal menghapus item";

        echo json_encode($response);
    }
}

function clear_keranjang($conn, $id_admin) {
    mysqli_query($conn, "TRUNCATE TABLE tb_keranjang");
    loadKeranjang($conn, $id_admin);
}

function tambah_keranjang($conn, $id_admin) {
    $response["status"] = 1;

    $id_buku = $_POST["id_buku"];
    $diskon = isset($_POST["diskon"]) ? $_POST["diskon"] : 0;
    $stok = $_POST["jumlah_stok"];
    $kode = $_POST['kode_buku'];

    if ($kode != "") {
        $query_cek = mysqli_query($conn, "SELECT * FROM tb_keranjang WHERE id_admin = '$id_admin' AND id_barang = '$id_buku'");

        if ($query_cek->num_rows > 0) {
            $query_update = mysqli_query($conn, "UPDATE tb_keranjang SET jumlah=jumlah+$stok, diskon='$diskon' WHERE id_admin = '$id_admin' AND id_barang = '$id_buku'");
            if ($query_update) {

                loadKeranjang($conn, $id_admin);
            }
        } else {
            $query_insert = "INSERT INTO tb_keranjang (id_admin, id_barang, diskon, jumlah) VALUES ('$id_admin', '$id_buku', '$diskon', '$stok')";
            $insert = mysqli_query($conn,$query_insert) or die(mysqli_error($conn));

            if($insert) {
                loadKeranjang($conn, $id_admin);
            } else {
                $response["status"] = 0;
                $response["msg"] = "Gagal menambah barang";

                echo json_encode($response);
            }
        }

    } else {
        $response["status"] = 0;
        $response["msg"] = "Kode buku harus diisi";

        echo json_encode($response);
    }
}

function loadKeranjang($conn, $id_admin) {
    $response["status"] = 1;

    $query_buku = "SELECT a.*, b.kode, b.judul, b.harga_jual FROM tb_keranjang a LEFT JOIN tb_barang b ON a.id_barang = b.id WHERE a.id_admin = '$id_admin'";
    $get_buku = mysqli_query($conn,$query_buku);

    $lits = array();

    if ($get_buku->num_rows > 0) {
        while ($r = $get_buku->fetch_assoc()) {
            array_push($lits, $r);
        }

        $response["data"] = $lits;
        $response["msg"] = "Berhasil menambahkan barang";

        echo json_encode($response);
    } else {
        $response["status"] = 0;
        $response["msg"] = "Keranjang Kosong";

        echo json_encode($response);
    }
}

function bayar($conn, $id_admin) {
    $response["status"] = 1;

    $date = new DateTime('now');
    $inv = "INV-".$date->format('ymdHiss');

//    print_r($_POST);die;

    $id_pelanggan = $_POST["pelanggan"];
    $metode = $_POST["metode"];
    $tunai = $_POST["tunai"];
    $kembalian = $_POST["kembalian"];
    $jumlah_harga= $_POST["total_harga"];
    $jumlah_total = $_POST["total_stok"];

    //INSERT TB ORDER
    $query_insert_oder = "INSERT INTO tb_penjualan (id_pelanggan, invoice, total, harga, metode, tunai, kembalian) 
                      VALUES ('$id_pelanggan', '$inv', '$jumlah_total', '$jumlah_harga', '$metode', '$tunai', '$kembalian')";

    $insert_order = mysqli_query($conn,$query_insert_oder) or die(mysqli_error($conn));

    if ($insert_order) {
        $last_order_id = $conn->insert_id;

        //Move from cart to order table
        $query_cart = "SELECT a.*, b.kode, b.judul, b.harga_jual FROM tb_keranjang a LEFT JOIN tb_barang b ON a.id_barang = b.id WHERE a.id_admin = '$id_admin'";
        $get_cart = mysqli_query($conn,$query_cart);

        if ($get_cart->num_rows > 0) {
            while($row = $get_cart->fetch_assoc()) {
                $diskon = $row["diskon"] / 100;
                $sub_harga = $row["harga_jual"] * $row["jumlah"];
                $total_harga = $sub_harga - ($sub_harga*$diskon);

                $id_barang = $row["id_barang"];
                $diskon2 = $row["diskon"];
                $jumlah_total = $row["jumlah"];
                $harga = $row["harga_jual"];

                $query_move_tb = "INSERT INTO tb_penjualan_detail (id_penjualan, id_barang, jumlah, harga, diskon, total) 
                      VALUES ('$last_order_id', '$id_barang', '$jumlah_total', '$harga', '$diskon2', '$total_harga')";

                $query_kurang_stok = "UPDATE tb_barang SET stok = stok-$jumlah_total WHERE id =$id_barang";

                $insert_move = mysqli_query($conn,$query_move_tb) or die(mysqli_error($conn));
                $update_stok = mysqli_query($conn,$query_kurang_stok) or die(mysqli_error($conn));
            }
        }

        $response["id_order"] = $last_order_id;
        $response["msg"] = "Pembayaran Sukses";

        echo json_encode($response);
    }


}