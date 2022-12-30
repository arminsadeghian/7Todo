<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $app->app_name ?></title>
    <link rel="stylesheet" href="<?= siteUrl('assets/css/style.css'); ?>">
</head>
<body>
<div class="page">
    <div class="pageHeader">
        <a style="color: #FFF" href="<?= siteUrl(); ?>">
            <div class="title">Dashboard</div>
        </a>
        <div class="userPanel">
            <a class="logout" href="<?= siteUrl('?action=logout') ?>">
                <i class="fa fa-sign-out"></i>
            </a>
            <span class="username"><?= $userInfo->email ?? 'Unknown' ?></span>
            <img style="border-radius: 50%" src="<?= $userInfo->profileImage ?>" width="40" height="40"/>
        </div>
    </div>
    <div class="main">
        <div class="nav">
            <div class="menu">
                <div class="title">Folders</div>
                <ul class="folder-list">

                    <a href="<?= siteUrl() ?>" style="text-decoration: none">
                        <li class="<?= isset($_GET['folder_id']) ? '' : 'active' ?>">
                            <i class="fa fa-folder"></i>
                            All
                        </li>
                    </a>

                    <?php foreach ($folders as $folder): ?>

                        <li class="<?= isset($_GET['folder_id']) && $_GET['folder_id'] == $folder->id ? 'active' : '' ?>">
                            <a style="text-decoration: none;" href="<?= siteUrl("?folder_id=$folder->id") ?>">
                                <i class="fa fa-folder"></i><?= $folder->name ?>
                            </a>
                            <a style="text-decoration: none;float: right;"
                               href="<?= siteUrl("?delete_folder=$folder->id") ?>">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </li>

                    <?php endforeach; ?>

                </ul>
                <input style="width: 60%" placeholder="Add New Folder" id="addFolderInput"/>
                <button id="addFolderBtn">+</button>
            </div>
        </div>
        <div class="view">
            <div class="viewHeader">
                <div class="title">
                    <input style="width: 500px; height: 35px; padding: 0 10px;"
                           placeholder="<?= !isset($_GET['folder_id']) ? 'Please Select Folder' : 'Write task title and press enter' ?>"
                           id="addTaskInput" <?= !isset($_GET['folder_id']) ? 'disabled' : '' ?>/>
                </div>
            </div>
            <div class="content">
                <div class="list">

                    <ul>
                        <?php if (sizeof($tasks)): ?>
                            <?php foreach ($tasks as $task): ?>
                                <li class="<?= $task->is_done ? 'checked' : '' ?>">
                                    <input class="isDone" data-taskId="<?= $task->id ?>"
                                           type="checkbox" <?= $task->is_done ? 'checked' : '' ?> >
                                    <span><?= $task->title ?></span>
                                    <div class="info">
                                        <span style="margin-right: 20px;"><?= $task->created_at ?></span>
                                        <a href="<?= siteUrl("?delete_task=$task->id") ?>">
                                            <i style="cursor: pointer" class="fa fa-trash-o"></i>
                                        </a>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>No Task Here</li>
                        <?php endif; ?>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= siteUrl('assets/js/jquery-3.6.3.min.js'); ?>"></script>
<script>
    $(document).ready(function () {

        /* Add Folder */
        $('#addFolderBtn').click(function () {
            let input = $('input#addFolderInput');
            $.ajax({
                url: "process/ajaxHandler.php",
                method: "post",
                data: {
                    action: "addFolder",
                    folderName: input.val()
                },
                success: function (response) {
                    if (response == '1') {
                        $('<li><a href="#" style="text-decoration: none;color: #465d68;"><i class="fa fa-folder"></i>' + input.val() + '</a></li>').appendTo('ul.folder-list');
                        // $("<span>AAAAAAAAA</span>").appendTo("ul.folder-list");
                    } else {
                        alert(response);
                    }
                },
            });
        });

        /* Add Task */
        $('#addTaskInput').on('keypress', function (e) {
            if (e.which == 13) {
                $.ajax({
                    url: "process/ajaxHandler.php",
                    method: "post",
                    data: {
                        action: "addTask",
                        taskTitle: $('#addTaskInput').val(),
                        folderId: <?= $_GET['folder_id'] ?? 0 ?>
                    },
                    success: function (response) {
                        if (response == '1') {
                            location.reload();
                        } else {
                            alert(response);
                        }
                    }
                    ,
                })
                ;
            }
        });

        /* isDone */
        $('.isDone').click(function (e) {
            let taskId = $(this).attr('data-taskId');
            // alert(taskId);
            $.ajax({
                url: "process/ajaxHandler.php",
                method: "post",
                data: {
                    action: "doneSwitch",
                    taskId: taskId,
                },
                success: function (response) {
                    location.reload();
                },
            });
        });

    });
</script>

</body>
</html>