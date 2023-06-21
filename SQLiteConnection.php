<?php
namespace db;

use PDO;

$pdo = new PDO('sqlite:mydb.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//print_r($pdo);
// $pdo = new PDO('sqlite:mydb.db');

// $sta = $pdo->query("SELECT * FROM products");

// $rows = $sta->fetchAll(PDO::FETCH_ASSOC);

// print_r($rows);
//echo($pdo);

// class SQLiteConnection {
//     /**
//      * PDO instance
//      * @var type 
//      */
//    // private $pdo;

//     /**
//      * return in instance of the PDO object that connects to the SQLite database
//      * @return PDO
//      */
//     public function connect() {
//         //echo('putoosss'.$this->pdo);
//     // if ($this->pdo == null) {
//         $pdo = new PDO('sqlite:'. __DIR__ .'mydb.db');
//         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
//         $sta = $pdo->query("SELECT * FROM products");

//         $rows = $sta->fetchAll(PDO::FETCH_ASSOC);
//     // }
//         //echo($this->pdo);
//         print_r($rows);
//         //return $rows;
//     }
// }
//$pdo = new PDO('sqlite;mydb.db')

?>