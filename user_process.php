<?php

    require_once("globals.php");
    require_once("db.php");
    require_once("models/Message.php");
    require_once("models/User.php");
    require_once("dao/UserDAO.php");

    $user = new User();

    $userDao = new UserDAO($conn, $BASE_URL);

    $message = new Message($BASE_URL);

    //resgatando o form
    $type = filter_input(INPUT_POST, "type");

    //muda dados do usuario
    if ($type === "update") {

        //resgatando usuario no banco
        $userData = $userDao->verifyToken(false);

        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $bio = filter_input(INPUT_POST, "bio");

        $userData->name = $name;
        $userData->lastname = $lastname;
        $userData->email = $email;
        $userData->bio = $bio;

    // Upload da imagem
    if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
      
        $image = $_FILES["image"];
        $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
        $jpgArray = ["image/jpeg", "image/jpg"];
  
        // Checagem de tipo de imagem
        if(in_array($image["type"], $imageTypes)) {
  
          // Checar se jpg
          if(in_array($image["type"], $jpgArray)) {
  
            $imageFile = imagecreatefromjpeg($image["tmp_name"]);
  
          // Imagem é png
          } else {
  
            $imageFile = imagecreatefrompng($image["tmp_name"]);
  
          }
  
          $imageName = $user->imageGenerateName();
  
          imagepng($imageFile, "./img/users/" . $imageName, 100);
  
          $userData->image = $imageName;
  
        } else {
  
          $message->setMessage("Tipo inválido de imagem, insira png ou jpg!", "error", "back");
  
        }
  
      }

        $userDao->update($userData, true);

    //muda a senha do usuario
    } else if ($type === "changepassword") {

    } else {

        $message->setMessage("Informações inválidas", "error");
    }
