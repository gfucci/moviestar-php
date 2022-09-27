<?php

    require_once("templates/header.php");
    require_once("dao/UserDAO.php");

    $userData = $userDao->verifyToken(true);
    
?>
    <div id="main-container" class="container-fluid">
        <h1>EDITANDO PROFILE</h1>
    </div>
<?php

    require_once("templates/footer.php");

?>