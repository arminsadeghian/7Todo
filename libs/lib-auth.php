<?php

function getCurrentUserIdByToken()
{
    return getUserIdByToken($_COOKIE['7Todo'])->user_id;
}

function deleteTokenRowByToken(string $token): int
{
    global $pdo;
    $sql = "DELETE FROM tokens WHERE token = :loginToken";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":loginToken" => $token
    ]);
    return $stmt->rowCount();
}

function isUserLoggedIn(): bool
{
    return isset($_COOKIE['7Todo']) ? true : false;
}

function getLoggedInUserInfo(int $userId)
{
    global $pdo;
    $sql = "SELECT * FROM users WHERE id = :userId";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":userId" => $userId
    ]);
    $records = $stmt->fetch(PDO::FETCH_OBJ);
    return $records ?? null;
}

function register(array $userData): bool
{
    global $pdo;
    $passwordHash = password_hash($userData['password'], PASSWORD_BCRYPT);
    $sql = "INSERT INTO users (name,email,password) VALUES (:name,:email,:password);";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $userData['name'],
        ':email' => $userData['email'],
        ':password' => $passwordHash
    ]);
    return $stmt->rowCount() ? true : false;
}

function getUserByEmail(string $email)
{
    global $pdo;
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':email' => $email
    ]);
    $records = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $records[0] ?? null;
}

function createLoginToken(int $userId, string $token): bool
{
    global $pdo;
    $sql = "INSERT INTO tokens (user_id, token, expire_at) VALUES (:user_id, :hashToken, NOW() + INTERVAL 604800 SECOND);";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":user_id" => $userId,
        ":hashToken" => $token
    ]);
    return $stmt->rowCount() ? true : false;
}

function login(string $email, string $password): bool
{
    $user = getUserByEmail($email);
    if (is_null($user)) {
        return false;
    }

    // Check the password
    if (password_verify($password, $user->password)) {
        $token = hash_hmac('sha256', $user->id, bin2hex(random_bytes(32)));
        createLoginToken($user->id, $token);
        setcookie("7Todo", $token, time() + 604800, "/");
        return true;
    }
    return false;
}

function logout()
{
    deleteTokenRowByToken($_COOKIE['7Todo']);
    setcookie("7Todo", "", time() - 604800, "/");
    redirect();
}

function getUserIdByToken(string $token)
{
    global $pdo;
    $sql = "SELECT user_id FROM tokens WHERE token = :loginToken";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':loginToken' => $token
    ]);
    $records = $stmt->fetch(PDO::FETCH_OBJ);
    return $records ?? null;
}

function isUserExists(string $email = null): bool
{
    global $pdo;
    $sql = 'SELECT * FROM users WHERE email = :email';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':email' => $email ?? ''
    ]);
    $record = $stmt->fetch(PDO::FETCH_OBJ);
    return $record ? true : false;
}
