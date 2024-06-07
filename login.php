<?php
include "inc/koneksi.php";
   
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Abata</title>
  <link rel="icon" href="assets/img/logo.png">
  <link href="https://fonts.googleapis.com/css?family=Raleway:400,700&display=swap" rel="stylesheet">
  <link href="assets/css/bootstrap.css" rel="stylesheet" />
  <link href="assets/css/font-awesome.css" rel="stylesheet" />
  <link href="assets/css/custom.css" rel="stylesheet" />
  <style>
    body {
      background-color: #92bdde;
      font-family: 'Raleway', sans-serif;
    }

    .login-container {
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
      padding: 40px;
      max-width: 400px;
      margin: 0 auto;
      margin-top: 100px;
    }

    .login-container h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #0077b6;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
    }

    .login-container .form-control {
      border-radius: 20px;
      padding: 10px 20px;
      border: 1px solid #0077b6;
    }

    .login-container .btn-primary {
      background-color: #0077b6;
      border: none;
      border-radius: 20px;
      padding: 10px 20px;
      transition: background-color 0.3s ease;
    }

    .login-container .btn-primary:hover {
      background-color: #005a8c;
    }

    .login-container .input-group-addon {
      background-color: #0077b6;
      border: none;
      border-radius: 20px 0 0 20px;
      color: #fff;
      padding: 10px 20px;
    }

    .copyright {
      text-align: center;
      margin-top: 30px;
      color: #333;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Aplikasi Pembayaran Tagihan Air</h2>
    <form action="" method="POST" enctype="multipart/form-data">
      <div class="form-group input-group">
        <span class="input-group-addon"><i class="fa fa-user"></i></span>
        <input type="text" class="form-control" placeholder="Masukkan Username" name="username" required autofocus/>
      </div>
      <div class="form-group input-group">
        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
        <input type="password" class="form-control" placeholder="Masukkan Password" name="password" required/>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block" name="btnLogin" title="Masuk Sistem">Login</button>
      </div>
    </form>
  </div>
  <div class="copyright">
    Copyright &copy; pampinos 2024
  </div>

  <script src="assets/js/jquery-1.10.2.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/jquery.metisMenu.js"></script>
  <script src="assets/js/custom.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</body>
</html>


<?php 
		if (isset($_POST['btnLogin'])) {  
            $sql_login = "SELECT * FROM tb_user WHERE username='".$_POST['username']."' AND password='".$_POST['password']."'";
			$query_login = mysqli_query($koneksi, $sql_login);
			$data_login = mysqli_fetch_array($query_login,MYSQLI_BOTH);
            $jumlah_login = mysqli_num_rows($query_login);
        

            if ($jumlah_login ==1 ){
                session_start();
                $_SESSION["ses_id"]=$data_login["id_user"];
                $_SESSION["ses_nama"]=$data_login["nama_user"];
                $_SESSION["ses_username"]=$data_login["username"];
                $_SESSION["ses_password"]=$data_login["password"];
                $_SESSION["ses_level"]=$data_login["level"];
                $_SESSION["ses_rek"]=$data_login["no_rek"];

                echo "<script>
                        Swal.fire({title: 'Login Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.value) {
                                window.location = 'http://localhost/pamtempino';
                            }
                        })</script>";
			}else{
			    echo "<script>
                        Swal.fire({title: 'Login Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.value) {
                                window.location = 'login';
                            }
                        })</script>";
            }
        }
			
