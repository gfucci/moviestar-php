<?php

    require_once("db.php");
    require_once("globals.php");
    require_once("models/User.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");
    
    $message = new Message($BASE_URL);

    $userDao = new UserDAO($conn, $BASE_URL);

    //resgatando o tipo de formulário
    $type = filter_input(INPUT_POST, "type");
    
    // Verificação do tipo de formulário
    if ($type === "register") {

        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");
        $confirmPassword = filter_input(INPUT_POST, "confirmpassword");

        //Validações do formulário
        if ($name && $lastname && $email && $password) {

            //Verificar se as senhas são iguais
            if ($password === $confirmPassword) {

                //verifica se já existe o email cadastrado no sistema
                if ($userDao->findByEmail($email) === false) {

                    $user = new User;

                    //criar token e hash da senha
                    $userToken = $user->generateToken();
                    $finalPassword = $user->generateToken($password);

                    $user->name = $name;
                    $user->lastname = $lastname;
                    $user->email = $email;
                    $user->password = $finalPassword;
                    $user->token = $userToken;

                    //logar após o registro
                    $auth = true;

                    $userDao->create($user, $auth);

                } else {

                    //Enviar msg de erro, email já existente
                    $message->setMessage("Usuário ja cadastrado, tente outro e-mail", "error", "back");
                }

            } else {

                //Enviar msg de erro, senhão não iguais
                $message->setMessage("As senhas não correspondem!", "error", "back");
            }

        } else {

            //Enviar uma msg de erro, de dados faltantes
            $message->setMessage("Por favor, preencha todos os campos!", "error", "back");
        }

    } else if ($type === "login") {

    }