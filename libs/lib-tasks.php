<?php

function addFolder(string $folderName): int
{
    global $pdo;
    $currentUserId = getCurrentUserIdByToken();
    $sql = "INSERT INTO folders (name, user_id) VALUES (:folder_name, :user_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':folder_name' => $folderName,
        ':user_id' => $currentUserId
    ]);
    return $stmt->rowCount();
}

function getAllFolders(): bool|array
{
    global $pdo;
    $currentUserId = getCurrentUserIdByToken();
    $sql = "SELECT * FROM folders WHERE user_id = {$currentUserId}";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $records;
}

function deleteFolder(int $folderId): int
{
    global $pdo;
    $currentUserId = getCurrentUserIdByToken();
    $sql = "DELETE FROM folders WHERE id = {$folderId} AND user_id = {$currentUserId}";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->rowCount();
}

function addTask(string $taskTitle, int $folderId): int
{
    global $pdo;
    $currentUserId = getCurrentUserIdByToken();
    $sql = "INSERT INTO tasks (title, user_id, folder_id) VALUES (:taskTitle, :user_id, :folder_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':taskTitle' => $taskTitle,
        ':user_id' => $currentUserId,
        ':folder_id' => $folderId
    ]);
    return $stmt->rowCount();
}

function getAllTasks(): bool|array
{
    global $pdo;
    $currentUserId = getCurrentUserIdByToken();

    $folder = $_GET['folder_id'] ?? null;
    $folderCondition = "";
    if (isset($folder) && is_numeric($folder)) {
        $folderCondition = " AND folder_id = $folder";
    }

    $sql = "SELECT * FROM tasks WHERE user_id = {$currentUserId} {$folderCondition} ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $records;
}

function deleteTask(int $taskId): int
{
    global $pdo;
    $currentUserId = getCurrentUserIdByToken();
    $sql = "DELETE FROM tasks WHERE id = {$taskId} AND user_id = {$currentUserId}";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->rowCount();
}

function doneSwitch(int $taskId): int
{
    global $pdo;
    $currentUserId = getCurrentUserIdByToken();
    $sql = "UPDATE tasks SET is_done = 1 - is_done WHERE user_id = :user_id AND id = :task_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':task_id' => $taskId,
        ':user_id' => $currentUserId,
    ]);
    return $stmt->rowCount();
}
