<?php
    if (!isset($_COOKIE['user'])) {
        // nu sunt logat 
        header("Location: ../login/login.php");
    }

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

    function getLessExpensiveFood($limit) {
        $sql = "SELECT nume, pret FROM mancare ORDER BY pret ASC LIMIT $limit";
        $cerere = DB::get_connnection()->prepare($sql);
        $cerere->execute();
        $data = $cerere->fetchAll();
        return json_encode($data);
    }
    
    echo getLessExpensiveFood(15);
?>