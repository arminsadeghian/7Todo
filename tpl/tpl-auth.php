<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>7Todo Authentication</title>
    <link rel="stylesheet" href="<?= siteUrl('assets/css/auth.css') ?>">
</head>
<body>
<!-- partial:index.partial.html -->
<div id="background">
    <div id="panel-box">
        <div class="panel">
            <div class="auth-form on" id="login">
                <div id="form-title">Login</div>
                <form action="<?= siteUrl('auth.php?action=login') ?>" method="POST">
                    <input name="email" type="email" required="required" placeholder="Email"/>
                    <input name="password" type="password" required="required" placeholder="Password"/>
                    <button type="submit" name="submit">Log In</button>
                </form>
            </div>
            <div class="auth-form" id="signup">
                <div id="form-title">Register</div>
                <form action="<?= siteUrl('auth.php?action=register') ?>" method="POST">
                    <input name="name" type="text" required="required" placeholder="Name"/>
                    <input name="email" type="email" required="required" placeholder="Email"/>
                    <input name="password" type="password" required="required" placeholder="Password"/>
                    <button type="submit" name="submit">Sign Up</button>
                </form>
            </div>
        </div>
        <div class="panel">
            <div id="switch">Sign Up</div>
            <div id="image-overlay"></div>
            <div id="image-side"></div>
        </div>
    </div>
</div>
<!-- partial -->
<script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
<script>
    $('#switch').click(function () {
        $(this).text(function (i, text) {
            return text === "Sign Up" ? "Log In" : "Sign Up";
        });
        $('#login').toggleClass("on");
        $('#signup').toggleClass("on");
        $(this).toggleClass("two");
        $('#background').toggleClass("two");
        $('#image-overlay').toggleClass("two");
    })
</script>
</body>
</html>
