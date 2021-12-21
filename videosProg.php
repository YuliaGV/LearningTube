<?php 

session_start();

if (empty($_SESSION['autorizado'])) {
  echo "Debes iniciar sesión primero";
  echo '<meta http-equiv="refresh" content="0; url=login.php">';
  die();
}

require_once "functions/functions.php";

getPhoto();

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
                <h1>Videos en la categoría Física</h1>
            </div>
            </div>
        </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">

            <div class="row d-flex">

              <?php  

              $conn = mysqli_connect("localhost","root","Kenway74","bd_learning");

              if ($conn==false){
                  echo "No podemos conectarnos a la base de datos :(";
                  die();
              }

              $user = $_SESSION['user_id'];

              $consultaVideo = $conn->query("SELECT users.user_name, users.user_id, videos.users_user_id, videos.categories_cat_id, videos.video_url, videos.video_title, videos.video_url, videos.video_date, categories.cat_id, categories.cat_name FROM users INNER JOIN videos ON users.user_id = videos.users_user_id INNER JOIN categories ON videos.categories_cat_id = categories.cat_id WHERE categories.cat_name LIKE 'Programacion' OR 'Programming' ");
              
            
              if ($consultaVideo !== false && $consultaVideo->num_rows > 0){
              
              while($video=mysqli_fetch_array($consultaVideo)){

              ?>

                <div class="col-md-3">

                    <div class="card">

                        <div class="card-header">
                            <h3 class="card-title"><?php echo $video['video_title']; ?></h3>
                        </div>

                        <div class="card-body">
                            <video controls width="100%">
                                <source src="<?php echo "video/".$video['video_url']; ?>" type="video/mp4">
                                Tu navegador no está soportando el video
                            </video>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                <p>Categoría: <?php echo $video['cat_name']; ?></p>
                                <p>Autor: <?php echo $video['user_name']; ?></p>
                                <span class="date">Publicado: <?php echo $video['video_date']; ?></span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                          
                  
            <?php } 
            
              }else{
                echo "No hay ningún video en esta categoria";
                }
            ?>



            </div>
      
        </div><!-- /.container-fluid -->



        
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    </div>



</body>

</html>
