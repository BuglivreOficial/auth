<?php
header("Content-type: application/json");

require_once("helpers.php");

//VERIFICAR SE O METODO DE REQUISICAO É POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo json_encode([
        'status' => false,
        'error' => 'Método não permitido',
        'date' => date('Y-m-d H:i:s')
    ]);
    exit;
}

//VERIFICAR SE OS CAMPOS EXISTEM
$errors = field_exist(['username', 'email', 'password']);
if (!empty($errors)) {
    echo json_encode([
        'status' => false,
        'error' => $errors,
        'date' => date('Y-m-d H:i:s')   
    ]);
    exit;
}

//VERIFICAR SE O NOME DE USUÁRIO E VÁLIDO
$errors = validateUsername($_POST['username']);
if (!empty($errors)) {
    echo json_encode([
        'status'=> false,
        'error'=> $errors, 
        'date'=> date('Y-m-d H:i:s')
    ]);
    exit;
}

//VERIFICAR SE O EMAIL É VÁLIDO
$errors = validateEmail($_POST['email']);
if (!empty($errors)) {
    echo json_encode([
        'status' => false,
        'error' => $errors,
        'date' => date('Y-m-d H:i:s')
    ]);
    exit;
}

//VERIFICAR SE A SENHA É VÁLIDA
$errors = validatePassword($_POST['password']);
if (!empty($errors)) {
    echo json_encode([
        'status' => false,
        'error' => $errors,
        'date' => date('Y-m-d H:i:s')
    ]);
    exit;
}

echo json_encode([
    'status' => true,
    'success' => 'Cadastro realizado com sucesso!',
    'date' => date('Y-m-d H:i:s')
]);
exit;
