<?php

require __DIR__ . '/bootstrap/init.php';

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    logout();
    redirect('auth.php');
}

if (!isUserLoggedIn()) {
    redirect('auth.php');
}

// delete folder
if (isset($_GET['delete_folder']) && is_numeric($_GET['delete_folder'])) {
    deleteFolder($_GET['delete_folder']);
}

// delete task
if (isset($_GET['delete_task']) && is_numeric($_GET['delete_task'])) {
    deleteTask($_GET['delete_task']);
}

$currentUserId = getCurrentUserIdByToken();

$userInfo = getLoggedInUserInfo($currentUserId);

$userInfo->profileImage = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($userInfo->email)));

$folders = getAllFolders();

$tasks = getAllTasks();

require __DIR__ . '/tpl/tpl-index.php';
