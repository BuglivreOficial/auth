<?php

//VERIFICAR SE OS CAMPOS EXISTEM
function field_exist(string|array $field): array
{
    $errors = [];
    if (is_array($field)) {
        foreach ($field as $value)
            if (!isset($_POST[$value]))
                $errors[$value] = $value . ' é obrigatório';
    } else {
        if (!isset($_POST[$field]))
            $errors[$field] = $field . ' é obrigatório';
    }
    return $errors;
}

function validateUsername (string $username): array
{
    $errors = [];
    if (strlen($username) < 3)
        $errors['username'] = 'Nome de usuário deve ter pelo menos 3 caracteres';
    return $errors;
}

function validateEmail(string $email): array
{
    $errors = [];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors['email'] = 'Email invalido';
    return $errors;
}

function validatePassword(string $password): array
{
    $errors = [];
    if (strlen($password) < 6)
        $errors['password'] = 'Senha deve ter pelo menos 6 caracteres';
    return $errors;
}