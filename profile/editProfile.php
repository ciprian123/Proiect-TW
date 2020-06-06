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
    
    $id = $_COOKIE['id'];
    function updateFirstName($newFirstName, $id) {
        $sql = "UPDATE USERS SET first_name = :newFname WHERE id = :id";
        $cerere = DB::get_connnection()->prepare($sql);
        $cerere->execute([
            ':newFname' => $newFirstName,
            ':id'       => $id
        ]);
    }

    function updateLastName($newLastName, $id) {
        $sql = "UPDATE USERS SET last_name = :newLname WHERE id = :id";
        $cerere = DB::get_connnection()->prepare($sql);
        $cerere->execute([
            ':newLname' => $newLastName,
            ':id'       => $id
        ]);
    }

    function userNameAlreadyExists($username) {
        // verific daca username-ul nu exista deja la alt user inregistrat
        $sql = "SELECT username FROM users WHERE username = :uname";
        $cerere = DB::get_connnection()->prepare($sql);
        $cerere->execute([
            'uname' => $username
        ]);
        return $cerere->rowCount() >= 1;
    }

    function updateUsername($newUsername, $id) {
        if (userNameAlreadyExists($newUsername)) {
            echo '<script language="javascript">';
            echo 'alert("Username already used!")';
            echo '</script>';
            return;
        }
        $sql = "UPDATE USERS SET username = :newUsername WHERE id = :id";
        $cerere = DB::get_connnection()->prepare($sql);
        $cerere->execute([
            ':newUsername' => $newUsername,
            ':id'       => $id
        ]);
    }

    function uploadImage() {
        // iau imaginea incarcata si o introduc in folderul general unde se afla imaginile profilelor. 
        // actualizez noua cale in fisierul general care va fi si calea finala pentru noua poza introdusa
        // returnez noua cale a imaginii in caz de upload cu sucess, altfel returnez ""
        $target_dir  = "assets/thumbnails/";
        $target_file = $target_dir . $_FILES["image_path"]["name"]; 
        
        // daca imaginea e mai mare de 5mb nu o incarc
        if ($_FILES["image_path"]["size"] > 5000000) {
            echo '<script language="javascript">';
            echo 'alert("Image too big. Max file size admitted is 5mb!")';
            echo '</script>';
            return "";
        }

        // mut poza la calea dorita
        if (!move_uploaded_file($_FILES["image_path"]["tmp_name"], $target_file)) {
            echo '<script language="javascript">';
            echo 'alert("There was a problem uploading this file!")';
            echo '</script>';
        }
        return $target_file;
    }

    function updateImage($id) {
        $image_ = uploadImage();
        if ($image_ == "") {
            return;
        }
        // actualizez calea imaginii pentru user
        $sql = "UPDATE USERS SET cale_imagine = :newCaleImagine WHERE id = :id";
        $cerere = DB::get_connnection()->prepare($sql);
        $cerere->execute([
            ':newCaleImagine' => $image_,
            ':id'       => $id
        ]);
    }

    function emailAlreadyExists($email) {
        // verific daca  mailul nu exista deja la alt user inregistrat
        $sql = "SELECT phone_number FROM users WHERE email = :mail";
        $cerere = DB::get_connnection()->prepare($sql);
        $cerere->execute([
            'mail' => $email
        ]);
        // daca exista semnalez o eroare si returnez false
        return $cerere->rowCount() >= 1;
    }


    function updateEmail($newEmail, $id) {
        if (emailAlreadyExists($newEmail)) {
            echo '<script language="javascript">';
            echo 'alert("Email already used!")';
            echo '</script>';
            return;
        }
        $sql = "UPDATE USERS SET email = :newEmail WHERE id = :id";
        $cerere = DB::get_connnection()->prepare($sql);
        $cerere->execute([
            ':newEmail' => $newEmail,
            ':id'       => $id
        ]);
    }

    function updatePassword($newPassword, $id) {
        $sql = "UPDATE USERS SET password = :newPassword WHERE id = :id";
        $cerere = DB::get_connnection()->prepare($sql);
        $cerere->execute([
            ':newPassword' => $newPassword,
            ':id'       => $id
        ]);
    }

    function updatePhoneNumber($newPhoneNumber, $id) {
        $sql = "UPDATE USERS SET phone_number = :newPhoneNumber WHERE id = :id";
        $cerere = DB::get_connnection()->prepare($sql);
        $cerere->execute([
            ':newPhoneNumber' => $newPhoneNumber,
            ':id'       => $id
        ]);
    }

    if (isset($_POST["submit_first_name"])) {
        updateFirstName($_POST["fname"], $id);
    }
    if (isset($_POST["submit_last_name"])) {
        updateLastName($_POST["lname"], $id);
    }
    if (isset($_POST["submit_username"])) {
        updateUsername($_POST["uname"], $id);
    }
    if (isset($_POST["submit_image"])) {
        updateImage($id);
    }
    if (isset($_POST["submit_email"])) {
        updateEmail($_POST["email"], $id);
    }
    if (isset($_POST["submit_password"])) {
        updatePassword($_POST["password"], $id);
    }
    if (isset($_POST["submit_phone_number"])) {
        updatePhoneNumber($_POST["phone-nr"], $id);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="../css/footer.css">
    <link rel="stylesheet" type="text/css" href="../css/profile/editProfile.css">

    <link href="https://fonts.googleapis.com/css?family=Dosis|Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Edit profile</title>
</head>
<body>
    <header class="nav-bar">
        <nav>
            <a id="a1" href="#"><img class="nav-icon" src="../profile/assets/icons/home.png" alt="home-icon">HOME</a>
            <a id="a2" href="#"><img class="nav-icon" src="../profile/assets/icons/trending.png" alt="trending-icon">TRENDING</a>
            <a id="a3" href="#"><img class="nav-icon" src="../profile/assets/icons/about.png" alt="about-icon">ABOUT</a>
            <a id="a4" href="#">LOGIN</a>
        </nav>
    </header>
    <section id="main_section">
        <div class="main-content">
            <h2>Update your profile</h2>
            <br>
            <form class="main_form" id="update_fname" method="POST">
                <input class="required" type="text" id="fname" name="fname" placeholder="Enter new first name..." required>
                <input class="submit-input" type="submit" name="submit_first_name">
            </form>
            <form class="main_form" id="update_lname" method="POST">
                <input class="required" type="text" id="lname" name="lname" placeholder="Enter new last name..." required>
                <input class="submit-input" type="submit" name="submit_last_name">
            </form>
            <form class="main_form" id="update_username" method="POST">
                <input class="required" type="text" id="uname" name="uname" placeholder="Enter new username..." required>
                <input class="submit-input" type="submit" name="submit_username">
            </form>
            <form class="main_form" id="update_image" method="POST" enctype="multipart/form-data">
                <input id="image_path" class="required" type="file" name="image_path" placeholder="Enter new image ..." accept="image/*" required>
                <input class="submit-input" type="submit" name="submit_image">
            </form>
            <form class="main_form" id="update_email" method="POST">
                <input class="required" type="email" id="email" name="email" placeholder="Enter new email..." required>
                <input class="submit-input" type="submit" name="submit_email">
            </form>
            <form class="main_form" id="update_password" method="POST">
                <input class="required" type="password" id="password" name="password" placeholder="Enter your password..." required>
                <input class="submit-input" type="submit" name="submit_password">
            </form>
            <form class="main_form" id="update_phone_numer" method="POST">
                <input class="required" type="text" id="phone-nr" name="phone-nr" placeholder="Enter your phone number..." >
                <input class="submit-input" type="submit" name="submit_phone_number">
            </form>
        </div>
    </section>
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