<?php

    require_once("templates/header.php");
    require_once("db.php");
    require_once("globals.php");
    require_once("models/User.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");

    $user = new User();
    $movieDao = new MovieDao($conn, $BASE_URL);
    $userDao = new UserDao($conn, $BASE_URL);
    $message = new Message($BASE_URL);

    //get user id
    $id = filter_input(INPUT_GET, "id");

    //get id if user is logged in
    if (empty($id)) {

        if ($userData) {

            $id = $userData->id;
            
        } else {

            $message->setMessage("Usuário não encontrado", "error");
        }

    //get id if user doesnt logged IN
    } else {

        $userData = $userDao->findById($id);

        if (!$userData) {

            $message->setMessage("Usuário não encontrado", "error");
        }
    }

    //get user name and image
    $getName = $user->getFullName($userData);

    if ($userData->image = "") {

        $userData->image = "user.png";
    }
?>
    <div id="main-container" class="container-fluid">
        
    </div>
<?php

    require_once("templates/footer.php");

?>