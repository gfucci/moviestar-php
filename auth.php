<?php

    require_once("templates/header.php");

?>
    <div id="main-container" class="container-fluid">
        <div class="col-md-12">
            <div class="row" id="auth-row">
                <div class="col-md-4" id="login-container">
                    <h2>Entrar</h2>
                    <form action="" method="POST">
                        <input type="hidden" name="type" value="login">
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                placeholder="Digite o email" 
                                class="form-control"
                            >
                        </div>
                        <div class="form-group">
                            <label for="password">Senha:</label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                placeholder="Digite a senha" 
                                class="form-control"
                            >
                        </div>
                        <input type="submit" value="Entrar" class="btn card-btn">
                    </form>
                </div>
                <div class="col-md-4" id="register-container">
                    <h2>Criar Conta</h2>
                    <form action="" method="POST">
                        <input type="hidden" name="type" value="login">
                        <div class="form-group">
                            <label for="name">Nome:</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                placeholder="Digite o nome" 
                                class="form-control"
                            >  
                        </div>
                        <div class="form-group">
                            <label for="lastname">Sobrenome:</label>
                            <input 
                                type="text" 
                                name="lastname" 
                                id="lastname" 
                                placeholder="Digite o sobrenome" 
                                class="form-control"
                            >  
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                placeholder="Digite o email" 
                                class="form-control"
                            >
                        </div>
                        <div class="form-group">
                            <label for="password">Senha:</label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                placeholder="Digite a senha" 
                                class="form-control"
                            >
                        </div>
                        <div class="form-group">
                            <label for="confirmpassword">Corfirmar a senha:</label>
                            <input 
                                type="password" 
                                name="confirmpassword" 
                                id="confirmpassword" 
                                placeholder="Repita a senha" 
                                class="form-control"
                            >
                        </div>
                        <input type="submit" value="Cadastrar" class="btn card-btn">
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php

    require_once("templates/footer.php");

?>