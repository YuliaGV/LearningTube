<?php 

 $conn = mysqli_connect("localhost","root","Kenway74","bd_learning");

if ($conn==false){
    echo "No podemos conectarnos a la base de datos :(";
    die();
}


function savePhoto($profile_image){

    $conn = $GLOBALS['conn'];
  
    $msg = "";


    $uploads_dir = 'img/ProfilePhotos';
    $pname = rand(1000,10000)."-".$_FILES["profile_image"]["name"];
    $tname = $_FILES["profile_image"]["tmp_name"];
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($pname,PATHINFO_EXTENSION));
  

    // Tamaño máximo de la imagen
    if ($profile_image["profile_image"]["size"] > 40000000) {
      $msg .= "La foto no puede exceder el peso permitido: 5mb<br>";
      $uploadOk = 0;
    }
  
    // Formatos autorizados
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      $msg .= "Lo sentimos, solo JPG, JPEG, PNG & GIF está permitido. <br>";
      $uploadOk = 0;
    }
  
    if ($uploadOk == 0) {
      $msg .= "Lo sentimos, la imagen no puedo subirse.<br>";
      // si todo está bien guardamos la imagen
    } else {
      if (move_uploaded_file($tname, $uploads_dir.'/'.$pname)) {
        $msg .= "La imagen  ". basename($profile_image["profile_image"]["name"]). " ha sido subida.";
        $conn->query("UPDATE `users` SET `user_photo`= '".$pname."' WHERE `user_id` = '".$_SESSION['user_id']."' ");
      } else {
        $msg .= "Lo siento, hubo un error a la hora de guardar la imagen.<br>";
      }
    }
    return $msg;

  } 


function getPhoto(){
    //traemos la conexión (global) a un ambito local (dentro de la función);
    $conn = $GLOBALS['conn'];
  
    $consulta = "SELECT `user_photo` FROM `users` WHERE `user_id` = '".$_SESSION['user_id']."'";
    $resultado = $conn->query($consulta);
    $fila = $resultado->fetch_assoc();
    $ruta = "img/ProfilePhotos/".$fila['user_photo'];
    return $ruta;
  }


function deletePhoto(){ 

    $conn = $GLOBALS['conn'];
    $msg = "";

    $actualPhoto = getPhoto(); 
    $newPhoto = "ProfileImageDefault.PNG";
    $conn->query("UPDATE `users` SET `user_photo`= '".$newPhoto."' WHERE `user_id` = '".$_SESSION['user_id']."' ");

    $msg .= "Tu foto ha sido eliminada.<br>";
    return $msg;
}


function saveVideo($video, $title, $category){

    $conn = $GLOBALS['conn'];
    $msg = "";

    $uploads_dir = 'video';
    $pname = rand(1000,10000)."-".$_FILES["video"]["name"];
    $tname = $_FILES["video"]["tmp_name"];
    $uploadOk = 1;
    $videoFileType = strtolower(pathinfo($pname,PATHINFO_EXTENSION));


    $date = date("Y-m-d H:i:s");

    $videoTitle = $title; 

    $author = $_SESSION['user_id'];


    //Buscando el id de la categoría ingresada
    $query = $conn->query("SELECT * FROM `categories` WHERE `cat_name` LIKE '".$category."' ");
    $categories = $query->fetch_all(MYSQLI_ASSOC);
    $cantidad = count($categories);

    if ($cantidad == 1){
      $idCategory = $categories[0]['cat_id'];

    }else{
      $msg .= "Lo sentimos, no hay categorías registradas en el sistema. No podemos procesar tu video";
      $uploadOk = 0;

    }


    // Tamaño máximo del video 
    if ($video["video"]["size"] > 400000000) {
      $msg .= "Lo sentimos, el tamaño máximo de archivo es 50 mb<br>";
      $uploadOk = 0;
    }

    // Formatos autorizados
    if($videoFileType != "mp4" ) {
      $msg .= "Lo sentimos, solo se permite el formato MP4 <br>";
      $uploadOk = 0;
    }

    // Si upload ok es 0 entonces hubo un error
    if ($uploadOk == 0) {
      $msg .= "Lo sentimos, el video puede subirse.<br>";
      // si todo está bien guardamos la imagen
    } else {
      if (move_uploaded_file($tname, $uploads_dir.'/'.$pname)) {
        $msg .= "El video  ". basename($video["video"]["name"]). " ha sido subido.";
        $conn->query("INSERT INTO `videos` (`users_user_id`, `categories_cat_id`, `video_date`, `video_title`, `video_url`) VALUES ('".$author."', '".$idCategory."','".$date."', '".$videoTitle."', '".$pname."');");
      } else {
        $msg .= "Lo siento, hubo un error a la hora de guardar la imagen.<br>";
      }
    }
    return $msg;


}








?>

