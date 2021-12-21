<?php 

session_start();

$_SESSION['autorizado'] = false;

$msg = ""; 

$email ="";


if( isset($_POST['email']) && isset($_POST['password']) ){

  if($_POST['email'] ==""){
    $msg.= "Debes ingresar el correo electrónico <br>";
  }

  if($_POST['password'] ==""){
    $msg.= "Debes ingresar la contraseña <br>";
  }

  
  $email = strip_tags($_POST['email']);
  $password = sha1(strip_tags($_POST['password']));

  include "functions/functions.php";

  $query = $conn->query("SELECT * FROM `users` WHERE `user_email` = '".$email."' AND  `user_password` = '".$password."' ");
  $usuarios = $query->fetch_all(MYSQLI_ASSOC);
  
  $cantidad = count($usuarios);

  if ($cantidad == 1){

    $_SESSION['autorizado'] = true;
    $_SESSION['user_id'] = $usuarios[0]['user_id'];
    $_SESSION['user_email'] = $usuarios[0]['user_email'];
    $_SESSION['user_name'] = $usuarios[0]['user_name'];
    $_SESSION['user_last_login'] = $usuarios[0]['user_last_login'];

    $hoy = date ( "Y-m-d H:i:s" );
    $query = $conn->query("UPDATE `users` SET `user_last_login` = '".$hoy."' WHERE `user_email` =  '".$email."' ");
    $msg .= "Has iniciado sesión exitosamente";
    echo '<meta http-equiv="refresh" content="1; url=principal.php">';
  }else{
    $msg .= "Datos incorrectos";
    $_SESSION['autorizado'] = false;
  }

}

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LT | Inicia sesión</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">

 
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="css/styles.css">

  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
<div class="login-logo">
    <a href=""><img src="img/LogoLearningTube.png" alt="Logo"></a>
</div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Inicia sesión</p>

      <form action="login.php" method="post">
        <div class="input-group mb-3">
        <input type="email" name="email" class="form-control" placeholder="Correo electrónico" value="<?php echo $email ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
        <input type="password" name="password" class="form-control" placeholder="Contraseña">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
          </div>
          <!-- /.col -->
        </div>
        <div style= "color:blue;">
            <?php echo $msg; ?>
          </div>
      </form>

      <p class="mb-1">
        <a href="#">¿Olvidaste tu contraseña?</a>
      </p>
      <p class="mb-0">
        ¿No tienes una cuenta? <a href="register.php" class="text-center">Regístrate</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
