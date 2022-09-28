<?php

    require_once("templates/header.php");
    require_once("dao/UserDAO.php");
    require_once("models/User.php");

    $user = new User();

    $userData = $userDao->verifyToken(true);

    $getName = $user->getFullName($userData);

    if ($userData->image == "") {
        $userData->image = "user.png";
    }
    
?>
    <div id="main-container" class="container-fluid">
        <div class="col-md-12">
            <form action="<?= $BASE_URL ?>user_process.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="type" value="update">
                <div class="row">
                    <div class="col-md-4">
                        <h1>
                            <?= $getName ?>
                        </h1>
                        <p class="page-description">Altere seus dados no formulário abaixo:</p>
                        <div class="form-group">
                            <label for="name">Nome:</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="form-control"
                                placeholder="Digie te o seu nome <?= $userData->name ?>"
                            >
                        </div>
                        <div class="form-group">
                            <label for="lastname">Sobrenome:</label>
                            <input 
                                type="text" 
                                name="lastname" 
                                id="lastname" 
                                class="form-control"
                                placeholder="Digie te o seu nome <?= $userData->lastname ?>"
                            >
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input 
                                type="text" 
                                name="email" 
                                id="email" 
                                class="form-control disabled"
                                readonly
                                placeholder="<?= $userData->email ?>"
                            >
                        </div>
                        <input type="submit" class="btn card-btn" value="Alterar">
                    </div>
                    <div class="col-md-4">
                        <div 
                            id="profile-image-container"
                            style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>')"
                        ></div>
                        <div class="form-group">
                            <label for="image">Foto:</label>
                            <input 
                                type="file" 
                                name="image"
                                class="form-control-file"
                                id="image"
                            >
                        </div>
                        <div class="form-group">
                            <label for="bio">bio:</label>
                            <textarea 
                                type="text" 
                                name="bio" 
                                id="bio" 
                                class="form-control"
                                placeholder="Conte mais sobre você"
                                rows="5"
                            ><?= $userData->bio ?></textarea>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row" id="change-password-container">
                <div class="col-md-4">
                    <h2>Altera Senha:</h2>
                    <p class="page-description">Digite a nova senha, e confirme para alterar:</p>
                    <form action="<?= $BASE_URL ?>user_process.php" method="POST">
                        <input type="hidden" name="type" value="changepassword">
                        <div class="form-group">
                            <label for="password">Nova Senha:</label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                class="form-control"
                                placeholder="Digite a sua nova senha"
                            >
                        </div>
                        <div class="form-group">
                            <label for="confirmpassword">Confirme a nova senha:</label>
                            <input 
                                type="password" 
                                name="confirmpassword" 
                                id="confirmpassword" 
                                class="form-control"
                                placeholder="Confirme sua nova senha"
                            >
                        </div>
                        <input type="submit" class="btn card-btn" value="Alterar">
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php

    require_once("templates/footer.php");

?>