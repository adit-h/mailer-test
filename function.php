<?php

function InsertData($param)
{
    global $pdo;
    // Save data
    $stmt = $pdo->prepare('INSERT INTO subscriber (email, firstname, lastname, status) 
    VALUES (:email, :firstname, :lastname, :status)');
    $stmt->execute($param);
}

function getDataById($val)
{
    global $pdo;
    // query to check email
    $stmt = $pdo->prepare('SELECT * FROM subscriber WHERE id = :id');
    $stmt->execute(['id' => $val]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    return $res;
}

function getDataByEmail($val)
{
    global $pdo;
    // query to check email
    $stmt = $pdo->prepare('SELECT * FROM subscriber WHERE email = :email');
    $stmt->execute(['email' => $val]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    return $res;
}
