<?php 

session_start();

if (empty($_SESSION['autorizado'])) {
  echo "Debes iniciar sesión primero";
  echo '<meta http-equiv="refresh" content="0; url=login.php">';
  die();
}

require_once "functions/functions.php";

getPhoto();

$msg = "";
$msg2= "";


if (isset($_POST['updatePhoto'])) {  //Botón actualizar imagen

if ($_FILES){
    $profile_image = $_FILES;
    $msg = savePhoto($profile_image);
    unset($_FILES["profile_image"]);
    }

}


if (isset($_POST['deletePhoto'])) {  //Botón borrar imagen

  if ($_FILES){
      $msg = deletePhoto();
      }
  
  }


if (isset($_POST['updatePassword'])) {

  if( isset($_POST['new_password']) && isset($_POST['new_password_repeat'])) {

    $password = strip_tags($_POST['new_password']);
    $repeat_password = strip_tags($_POST['new_password_repeat']);
  
    if ($password != $repeat_password){
      $msg2.="Las claves no coinciden <br>";
    }else if (strlen($password)<8){
      $msg2.="La clave debe tener al menos 8 caracteres <br>";
    }else{
      $password = sha1($password);
      $conn->query("UPDATE `users` SET `user_password`= '".$password."' WHERE `user_id` = '".$_SESSION['user_id']."' ");
      $msg2.="La clave ha sido actualizada correctamente <br>";
    }
  }

}



?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LearningTube</title>

    <link rel="icon" href="img\plantilla\LogoMini.png">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.css">

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    
    <!--datables CSS básico-->
    <link rel="stylesheet" type="text/css" href="plugins/datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="plugins/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css"> 

    <link rel="stylesheet"  type="text/css" href=" plugins/datatables-responsive/css/responsive.bootstrap4.css"> 

    <link rel="stylesheet"  type="text/css" href="plugins/sweetalert2/sweetalert2.min.css"> 

    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/iCheck/all.css">

    <link rel="stylesheet" href="css/styles.css">

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>

    <!-- datatables JS -->
    <script type="text/javascript" src="plugins/datatables/datatables.js"></script>

    <script type="text/javascript" src="plugins/datatables-responsive/js/dataTables.responsive.js"></script> 

    <!-- SweetAlert JS -->
    <script type="text/javascript" src="plugins/sweetalert2/sweetalert2.all.js"></script> 

    <!-- iCheck 1.0.1 -->
    <script src="plugins/iCheck/icheck.min.js"></script>

</head>

<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->

    <div class="wrapper">

    <?php  
    include "header.php";
    include "sidebar.php";
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Configuración de tu cuenta</h1>
            </div>
            </div>
        </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

        <div class="container-fluid">

            <div class="row d-flex">

            <div class="col-md-6">

                <div class="card card-primary">

                  <div class="card-header with-border">
                    <h3 class="card-title">Cambiar contraseña</h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <form action="config.php" method="POST" role="form">
                    <div class="card-body">
                      <div class="form-group">
                        <label for="newPassword">Nueva clave</label>
                        <input name="new_password" type="password" class="form-control" id="newPasswordRepeat" placeholder="Ingresa la nueva clave">
                      </div>

                      <div class="form-group">
                        <label for="newPasswordRepeat">Repite clave</label>
                        <input name="new_password_repeat" type="password" class="form-control" id="newPasswordRepeat" placeholder="Repite la nueva clave">
                      </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="card-footer">
                      <button type="submit" name="updatePassword" class="btn btn-primary">Cambiar</button>
                    </div>
                    <div style="color:red" class="">
                      <?php if($msg2!=""){
                        echo $msg2;
                      } ?>
                    </div>

                  </form>
                </div>
              </div>
              <!-- ./col -->
              <!-- ./col -->
              <div class="col-md-6">
                <div class="card card-primary">
                  <div class="card-header with-border">
                    <h3 class="card-title">Modifica tu foto de perfil</h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <div class="card-body">

                  <p>Tu foto no debe exceder un peso de 5mb y debe estar en los formatos autorizados: JPG, PNG o JPEG</p>
                  <form  action="config.php" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="profile_image">Imagen</label>
                        <input type="file" name="profile_image" id="profile_image">
                      </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" name="updatePhoto">Actualizar</button>
                      <button type="submit" class="btn btn-primary" name="deletePhoto">Borrar foto actual</button>
                    </div>
                    <div style="color:red" class="">
                      <?php if($msg!=""){
                        echo $msg;
                      } ?>
                    </div>
                  </form>
                </div>
              </div>

            
            </div>
      
        </div><!-- /.container-fluid -->



        
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    </div>



</body>

</html>

