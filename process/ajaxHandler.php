<?php

include_once __DIR__ . '/../bootstrap/init.php';

if (!isAjaxRequest()) {
    dd("Invalid Request!");
}

if (!isset($_POST['action']) || empty($_POST['action'])) {
    dd("Invalid Action!");
}

switch ($_POST['action']) {
    case "addFolder":
        if (!isset($_POST['folderName']) || strlen($_POST['folderName']) < 3) {
            echo "نام فولدر باید بیشتر از 2 حرف باشد";
            exit();
        }
        echo addFolder($_POST['folderName']);
        break;

    case "addTask":
        $folderId = $_POST['folderId'];
        $taskTitle = $_POST['taskTitle'];
        if (!isset($folderId) || empty($folderId)) {
            echo "فولدر را انتخاب کنید";
            exit();
        }
        if (!isset($taskTitle) || strlen($taskTitle) < 3) {
            echo "عنوان تسک باید بزرگتر از 2 حرف باشد";
            exit();
        }
        echo addTask($taskTitle, $folderId);
        break;

    case "doneSwitch":
        $taskId = $_POST['taskId'];
        if (!isset($taskId) || !is_numeric($taskId)) {
            echo "آیدی تسک معتبر نیست";
            exit();
        }
        doneSwitch($taskId);
        break;

    default:
        dd('Invalid Action');
}