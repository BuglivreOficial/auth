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

//CONEXÃO COM O BD
$conn = require_once("connection.php");

//VERIFICAR SE O USUÁRIO JÁ EXISTE
$stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
$stmt->bindParam(':username', $_POST['username']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if ($user) {
    echo json_encode([
        'status' => false,
        'error' => 'Nome de usuário já existe',
        'date' => date('Y-m-d H:i:s')
    ]);
    exit;
}

//VERIFICAR SE O EMAIL JÁ EXISTE
$stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
$stmt->bindParam(':email', $_POST['email']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if ($user) {
    echo json_encode([
        'status' => false,
        'error' => 'Email já existe',
        'date' => date('Y-m-d H:i:s')
    ]);
    exit;
}

// Hash password before storing it in the database
$hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Insert new user into database with hashed password
$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
$stmt->bindParam(":username", $_POST["username"]);
$stmt->bindParam(":email", $_POST["email"]);
$stmt->bindParam(":password", $hashed_password);
$stmt->execute();

echo json_encode([
    'status' => true,
    'success' => 'Cadastro realizado com sucesso!',
    'date' => date('Y-m-d H:i:s')
]);
exit;
