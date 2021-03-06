<?php

class DB
{
    private static $db = NULL;
    public static function get_connnection()
    {
        if (is_null(self::$db)) {
            self::$db = new PDO('mysql:host=localhost;dbname=forg_database', 'root', '');
        }
        return self::$db;
    }
}

if (isset($_COOKIE['user'])) {
    header("Location: ../Categories/forg.php");
} else {

    $username = '';
    $password = '';
    if (!empty($_POST)) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username=:uname AND password=:pass";
        $cerere = DB::get_connnection()->prepare($sql);

        $cerere->execute([
            'uname' => $username,
            'pass'  => $password
        ]);
        $row = $cerere->fetch();

        if ($cerere->rowCount() == 1) {
            if ($username == 'admin' && $password == 'admin') {
                header("Location: ../administration_module/admin.php");
            } else {
                header("Location: ../Categories/forg.php");
            }
            $cookie_name = "user";
            $cookie_value = $username;
            setcookie($cookie_name, $cookie_value, time() + 7200, "/"); // 2 ore

            $cookie_name = "id";
            $cookie_value = $row[0];
            setcookie($cookie_name, $cookie_value, time() + 7200, "/");
        } else {
            echo "Nu merge";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=6.0">
    <meta name="description" content="Pagina de logare in aplicatie.">
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="../css/footer.css">
    <link rel="stylesheet" type="text/css" href="../css/login/login.css">
    <link href="https://fonts.googleapis.com/css?family=Dosis|Roboto&display=swap" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Login to FORG</title>
</head>

<body>
    <header class="nav-bar">
        <nav>
            <a id="a1" href="../index.php"><img class="nav-icon" src="../profile/assets/icons/home.png" alt="home-icon">HOME</a>
            <a id="a2" href="../Categories/forg.php"><img class="nav-icon" src="../categories/assets/icons/categories.png" alt="categories-icon">CATEGORIES</a>
            <a id="a3" href="../ContactUs/contactUs.php"><img class="nav-icon" src="../categories/assets/icons/about.png" alt="about-icon">ABOUT</a>
            <a id="a4" href="../signup/sign_up.php"><img class="nav-icon" src="../categories/assets/icons/signup.png" alt="login">SIGN UP</a>
        </nav>
    </header>
    <div class="container">
        <section>
            <div class="main-content main-content-login">
                <h2>Please enter your username and password</h2>
                <form id="main-form" action="" method="POST">
                    <label for="email">Username:</label><br>
                    <input class="required" type="text" id="username" name="username" placeholder="Enter your username..." required><br><br>

                    <label for="password">Password:</label><br>
                    <input class="required" type="password" id="password" name="password" placeholder="Enter your password..." required><br><br>

                    <a id="change_password" href="recovery.php">Forgot/Change password?</a><br>
                    <input id="submit-input" type="submit" name="submit">
                </form>
            </div>
        </section>
    </div>
    <div class="spacer"></div>
    <!-- FOOTER START -->
    <div class="footer">
        <div class="contain">
            <div class="col">
                <h1>&copy; FORG - Made &amp; Designed By Rogoza Calin Andrei, Spantu Theodor Ioan, Ursulean Ciprian</h1>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</body>

</html>