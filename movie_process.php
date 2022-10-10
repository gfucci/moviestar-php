<?php

    require_once("globals.php");
    require_once("db.php");
    require_once("models/Message.php");
    require_once("models/Movie.php");
    require_once("dao/MovieDAO.php");
    require_once("dao/UserDAO.php");

    $userDao = new UserDAO($conn, $BASE_URL);
    $movieDao = new MovieDAO($conn, $BASE_URL);
    $message = new Message($BASE_URL);

    //resgata o form
    $type = filter_input(INPUT_POST, "type");

    //resgata os dados do usuário
    $userData = $userDao->verifyToken(true);

    if ($type === "create") {

        //resgatar os dados do form
        $title = filter_input(INPUT_POST, "title");
        $description = filter_input(INPUT_POST, "description");
        $category = filter_input(INPUT_POST, "category");
        $trailer = filter_input(INPUT_POST, "trailer");
        $length = filter_input(INPUT_POST, "length");

        $movie = new Movie();

        //validação de dados
        if (!empty($title) && !empty($category) && !empty($description)) {

            $movie->title = $title;
            $movie->description = $description;
            $movie->category = $category;
            $movie->trailer = $trailer;
            $movie->length = $length;
            $movie->users_id = $userData->id;

            //upload de imagem do filme
            if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

                $image = $_FILES["image"];
                $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
                $jpgArray = ["image/jpeg", "image/jpg"];

                //checar o tipo da image
                if (in_array($image["type"], $imageTypes)) {

                    //chegar se é jpg
                    if(in_array($image["type"], $jpgArray)) {

                        $imageFile = imagecreatefromjpeg($image["tmp_name"]);

                    } else {

                        $imageFile = imagecreatefrompng($image["tmp_name"]);
                    }

                    //gerando o nome da image
                    $imageName = $movie->imageGenerateName();

                    imagejpeg($imageFile, "./img/movies/" . $imageName, 100);

                    $movie->image = $imageName;
                    
                } else {

                    $message->setMessage("Tipo de imagem incorreto", "error", "back");
                    die;
                }

            }

            $movieDao->create($movie);

        } else {

            $message->setMessage("Adicione no mínimo o título, descrição e categoria", "error", "back");
            die;
        }



    } else if ($type === "update") {

        $title = filter_input(INPUT_POST, "title");
        $description = filter_input(INPUT_POST, "description");
        $length = filter_input(INPUT_POST, "title");
        $category = filter_input(INPUT_POST, "category");
        $trailer = filter_input(INPUT_POST, "trailer");
        $id = filter_input(INPUT_POST, "id");

        $movieData = $movieDao->findById($id);  

        if ($movieData) {

            //echo "primeiro if"; exit;

            if ($movieData->users_id === $userData->id) {

                if (!empty($title) && !empty($category) && !empty($description)) {

                    //echo "terceiro if"; exit;

                    $movieData->title = $title;
                    $movieData->description = $description;
                    $movieData->length = $length;
                    $movieData->category = $category;
                    $movieData->trailer = $trailer;

                    if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

                        $image = $_FILES["image"];
                        $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
                        $jpgArray = ["image/jpeg", "image/jpg"];
        
                        //checar o tipo da image
                        if (in_array($image["type"], $imageTypes)) {
        
                            //chegar se é jpg
                            if(in_array($image["type"], $jpgArray)) {
        
                                $imageFile = imagecreatefromjpeg($image["tmp_name"]);
        
                            } else {
        
                                $imageFile = imagecreatefrompng($image["tmp_name"]);
                            }
        
                            //gerando o nome da image
                            $movie = new Movie();
                            $imageName = $movie->imageGenerateName();
        
                            imagejpeg($imageFile, "./img/movies/" . $imageName, 100);
        
                            $movieData->image = $imageName;
                            
                        } else {
        
                            $message->setMessage("Tipo de imagem incorreto", "error", "back");
                            die;
                        }
        
                    }

                    $movieDao->update($movieData);

                } else {

                    $message->setMessage("Adicione pelo menos título, categoria e descrição", "error", "back");
                    die;
                }

            } else {

                $message->setMessage("Algo deu errado", "error");
                die;
            }

        } else {

            $message->setMessage("Algo deu errado", "error");
            die;
        }


    } else if ($type === "delete") {

        $id = filter_input(INPUT_POST, "id");

        $movie = $movieDao->findById($id);

        if ($movie) {

            if ($movie->users_id === $userData->id) {

                $movieDao->destroy($movie->id);

            } else {

                $message->setMessage("Algo deu errado", "error");
                die;
            }
            

        } else {

            $message->setMessage("Algo deu errado", "error");
            die;
        }

    } else {

        $message->setMessage("Algo deu errado", "error");
        die;
    }