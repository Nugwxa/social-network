<?php
class DB {
        private static function connect() {
                $pdo = new PDO('mysql:host=127.0.0.1;dbname=SocialNetwork;charset=utf8', 'root', '');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
        }
        public static function query($query, $params = array()) {
                $statement = self::connect()->prepare($query);
                $statement->execute($params);
                if (explode(' ', $query)[0] == 'SELECT') {
                $data = $statement->fetchAll();
                return $data;
                }
        }
        //This is a good start, but you should add extra functions here either in this class of in a class between this and the application layer.
        //These functions can be Select, Delete, Insert and Update, they should take parameters and genarate a suitable SQL statement.
        //This way you will have very few SQL staements all around your caode and it will be easier to read and update.
}