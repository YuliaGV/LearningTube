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

if (isset($_POST['uploadVideo'])) {  //Botón video

  if ($_FILES){
      $video = $_FILES;
      $title = $_POST['videoTitle'];
      $category = $_POST['videoCategory'];
      $msg = saveVideo($video, $title, $category);
      unset($_FILES["video"]);
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
                <h1>Tus videos</h1>
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
                    <h3 class="card-title">Subir un video</h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <form  action="uploadVideo.php" method="post" enctype="multipart/form-data">
                    <div class="card-body">

                      <p>Tu archivo debe pesar máximo 50mb y debe estar en formato .MP4 </p>

                      <div class="form-group">
                        <label for="video">Selecciona un archivo</label>
                        <input type="file" name="video" id="video">
                      </div>

                      <div class="form-group">
                        <label for="videoTitle">Título del video</label>
                        <input type="text" name="videoTitle" id="videoTitle">
                      </div>

                      <div class="form-group">
                        <p>Selecciona la categoría a la que pertenece tu video:</p>
                        <input type="radio" id="programming" name="videoCategory" value="programacion" checked>
                        <label for="programming">Programación</label><br>
                        <input type="radio" id="math" name="videoCategory" value="matematicas">
                        <label for="math">Matemáticas</label><br>
                        <input type="radio" id="physics" name="videoCategory" value="fisica">
                        <label for="physics">Física</label><br>
                        <input type="radio" id="chemistry" name="videoCategory" value="quimica">
                        <label for="chemistry">Química</label><br>
                      </div>


                    </div>
                    <!-- /.box-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" name="uploadVideo">Subir</button>
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
