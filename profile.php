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

    //echo $id; exit;

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

    if ($userData->image == "") {

        $userData->image = "user.png";
    }

    //movies that user added
    $userMovies = $movieDao->getMovieByUserId($id);
?>
    <div id="main-container" class="container-fluid">
        <div class="col-md-8 offset-md-2">
            <div class="row profile-container">
                <div class="col-md-12 about-container">
                    <h1 class="page-title">
                        <?= $getName ?>
                    </h1>
                    <div id="profile-image-container" class="profile-image" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>')"></div>
                    <h3 class="about-tile">Sobre:</h3>
                    <?php if (!empty($userData->bio)): ?>
                        <p class="profile-description"><?= $userData->bio ?></p>
                    <?php else: ?>
                        <p class="profile-description">O usuário não possuí bio</p>
                    <?php endif; ?>
                </div>
                <div class="col-md-12 added-movies-container">
                    <h3>Filmes que enviou:</h3>
                    <div class="movies-container">
                        <?php foreach ($userMovies as $movie): ?>
                            <?php require("templates/movieCard.php"); ?>
                        <?php endforeach; ?>
                        <?php if (count($userMovies) === 0): ?>
                            <p class="empty-list">O usuário ainda não enviou filmes</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php

    require_once("templates/footer.php");

?>