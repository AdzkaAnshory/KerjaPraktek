<?php
header('Content-Type: application/json');

include "../net/koneksi.php";

    $response["status"] = 1;

    $password = md5(strip_tags($_POST['password']));
    $username = strip_tags($_POST['email']);

    $query = "SELECT * FROM tb_admin WHERE email= '$username' AND password='$password'";
    $get = mysqli_query($conn,$query) or die(mysqli_error($conn));

    if(mysqli_num_rows($get) == 1){
        session_start();
        $data = mysqli_fetch_array($get);
        $_SESSION['username'] = $username;
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['id'] = $data['id'];

        $response["message"] = "Login Berhasil";

        echo json_encode($response);
    } else {
        $response["status"] = 0;
        $response["message"] = "Email dan Password tidak cocok";
        echo json_encode($response);
    }
