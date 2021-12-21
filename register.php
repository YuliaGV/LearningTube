<?php 

$msg = ""; 

$email ="";
$name ="";
$password = "";
$repeatPassword = "";


if( isset($_POST['email']) && isset($_POST['password']) && isset($_POST['repeatPassword']) ){

  if($_POST['email'] ==""){
    $msg.= "Debes ingresar el correo electrónico <br>";
  }

  if($_POST['name'] ==""){
    $msg.= "Debes ingresar un nombre de usuario <br>";
  }

  if($_POST['password'] ==""){
    $msg.= "Debes ingresar la contraseña <br>";
  }

  if($_POST['repeatPassword'] ==""){
    $msg.= "Debes repetir la contraseña <br>";
  }

  $email = strip_tags($_POST['email']);
  $name = strip_tags($_POST['name']);
  $password = strip_tags($_POST['password']);
  $repeatPassword = strip_tags($_POST['repeatPassword']);


  if ($password != $repeatPassword){
    $msg.="Las contraseñas no coinciden <br>";
  }else if (strlen($password)<8){
    $msg.="La contraseña debe tener al menos 8 caracteres <br>";
  }else{


  //Imagen de perfil 

  $revisar = $_FILES["profile_image"]["tmp_name"];

  if($revisar !== ""){

      $pname = rand(1000,10000)."-".$_FILES["profile_image"]["name"];
      $tname = $_FILES["profile_image"]["tmp_name"];
      $uploads_dir = 'img/ProfilePhotos';
      move_uploaded_file($tname, $uploads_dir.'/'.$pname);

  } else {
      $pname = "ProfileImageDefault.PNG";
  }
  

 include "functions/functions.php";

  $ip = $_SERVER['REMOTE_ADDR'];  //Se guarda la IP del usuario


    //Revisar que el correo registrado no esté repetido
  $query = $conn->query("SELECT * FROM `users` WHERE `user_email` = '".$email."' ");
  $usuarios = $query->fetch_all(MYSQLI_ASSOC);

  $cantidad = count($usuarios);

  if ($cantidad == 0){
    $password = sha1($password); //encriptar clave con sha1
    $conn->query("INSERT INTO `users` (`user_email`, `user_name`, `user_photo`, `user_password`, `user_ip`) VALUES ('".$email."', '".$name."', '".$pname."', '".$password."', '".$ip."');");
    $msg.="Tu cuenta ha sido creada, ingresa <a href='login.php'><b>aquí</b></a> <br>";
  }else{
    $msg.="El correo ingresado ya ha sido registrado <br>";
  }

  }
}

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LT | Registro</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition register-page">
<div class="register-box">
<div class="register-logo">
    <a href=""><img src="img/LogoLearningTube.png" alt="Logo"></a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Registro de nuevo usuario</p>

      <form action="register.php" method="post" enctype="multipart/form-data">

        <div class="input-group mb-3">
        <input name="email" type="email" class="form-control" placeholder="Correo electrónico" value="<?php echo $email ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
        <input name="name" type="text" class="form-control" placeholder="Nombre de usuario" value="<?php echo $name ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <label class="control-label">Imagen de perfil (opcional)</label>
          <input class="input-group" type="file" name="profile_image" id="profile_image" accept="image/*" />
        </div>

        <div class="input-group mb-3">
        <input name="password" type="password" class="form-control" placeholder="Contraseña">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
        <input name="repeatPassword" type="password" class="form-control" placeholder="Repite la contraseña">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input name="de_acuerdo" type="checkbox" required> Acepto <a href="https://google.com">términos y condiciones</a>
            </label>
          </div>
        

          <!-- /.col -->
          <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Regístrame</button>
        </div>
        <!-- /.col -->
      </div>
      <div style= "color:blue;">
      <?php echo $msg; ?>
      </div>
    </form>


      <a href="login.php" class="text-center">Ya tengo una cuenta</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
