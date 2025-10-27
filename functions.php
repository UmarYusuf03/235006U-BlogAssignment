<?php
require_once './config.php';


function findUserByEmail($email)
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM user WHERE email = ?');
    $stmt->execute([$email]);
    return $stmt->fetch();
}


function findUserById($id)
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM user WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch();
}


function getAllPosts()
{
    global $pdo;
    $stmt = $pdo->query('SELECT p.*, u.username FROM blogpost p JOIN user u ON p.user_id = u.id ORDER BY p.created_at DESC');
    return $stmt->fetchAll();
}


function getPost($id)
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT p.*, u.username FROM blogpost p JOIN user u ON p.user_id = u.id WHERE p.id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch();
}


function createPost($user_id, $title, $content)
{
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO blogpost (user_id, title, content) VALUES (?, ?, ?)');
    return $stmt->execute([$user_id, $title, $content]);
}


function updatePost($id, $title, $content)
{
    global $pdo;
    $stmt = $pdo->prepare('UPDATE blogpost SET title = ?, content = ? WHERE id = ?');
    return $stmt->execute([$title, $content, $id]);
}


function deletePost($id)
{
    global $pdo;
    $stmt = $pdo->prepare('DELETE FROM blogpost WHERE id = ?');
    return $stmt->execute([$id]);
}
