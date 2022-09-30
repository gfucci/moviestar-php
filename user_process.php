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

      //upload de imagem

      if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

        /*print_r($_FILES["image"]); 
        echo "<br> <br>";
        print_r($_FILES["image"]["tmp_name"]);
        exit;*/

        $image = $_FILES["image"];
        $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
        $jpgArray = ["image/jpeg", "image/jpg"];

        /*print_r($image); 
        echo "<br> <br>";
        print_r($imageTypes);
        //exit;
        echo "<br> <br>";*/

        /*echo in_array($image["type"], $imageTypes);
        exit;*/

        if(in_array($image["type"], $imageTypes)) {

          /*print_r($image["type"]); 
          echo "<br> <br>";
          print_r($imageTypes);
          exit;*/

          /*print_r($image); 
          echo "<br> <br>";
          print_r($jpgArray);
          exit;*/

          if (in_array($image["type"], $jpgArray)) {

            /*print_r($image["type"]); 
            echo "<br> <br>";
            print_r($jpgArray);
            echo "<br> <br>";
            echo $image["tmp_name"];
            exit;*/

            $imageFile = imagecreate($image["tmp_name"]);

          } else {

            $imageFile = imagecreatefrompng($image["tmp_name"]);
          }

        } else {

          $message->setMessage("Tipo inválido", "error", "back");
          die;
        }

        $imageName = $user->imageGenerateName();

        imagejpeg($imageFile, "./img/users/" . $imageName, 100);

        $userData->image = $imageName;

      } 

      $userDao->update($userData, true);

    //muda a senha do usuario
    } else if ($type === "changepassword") {

      $userData = $userDao->verifyToken(false);

      $password = filter_input(INPUT_POST, "password");
      $confirmPassword = filter_input(INPUT_POST, "confirmpassword");

      if ($password == $confirmPassword) {

        $updatePassword = $userData->generatePassword($password);

        $userData->password = $updatePassword;

        $userDao->changePassword($userData);

      } else {

        $message->setMessage("As senhas não são iguais! Tente novamente", "error", "back");
        die;
      }

    } else {

      $message->setMessage("Informações inválidas", "error");
    }
