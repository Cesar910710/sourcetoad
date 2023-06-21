<?php
	class Customers
	{

        private $pdo;
   
        public function __construct() {
            $this->pdo = new PDO('sqlite:mydb.db');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //include "SQLiteConnection.php";
        }
        public function createCustomer($post)
		{
            // include "SQLiteConnection.php";
            if (empty($_POST["first_name"])) {
                exit("Faltan uno o más datos"); #Terminar el script definitivamente
            }
            
            if (empty($_POST["last_name"])) {
                exit("Faltan uno o más datos"); #Terminar el script definitivamente
            }
            if (empty($_POST["line_1"])) {
                exit("Faltan uno o más datos"); #Terminar el script definitivamente
            }
            
            if (empty($_POST["line_2"])) {
                exit("Faltan uno o más datos"); #Terminar el script definitivamente
            }

            if (empty($_POST["city"])) {
                exit("Faltan uno o más datos"); #Terminar el script definitivamente
            }

            if (empty($_POST["state"])) {
                exit("Faltan uno o más datos"); #Terminar el script definitivamente
            }

            if (empty($_POST["zip"])) {
                exit("Faltan uno o más datos"); #Terminar el script definitivamente
            }
            
            try {
                $sql = "INSERT INTO customers(first_name, last_name) VALUES (:first_name, :last_name)";
                $stmt= $this->pdo->prepare($sql);
                //print_r($stmt);
                $stmt->bindParam(":first_name", $_POST["first_name"]);
                $stmt->bindParam(":last_name", $_POST["last_name"]);
                $stmt->execute();
            } catch (Exception $e) {
                die("Oh noes! There's an error in the query! .$e");
            }
            //print_r('respuesta: '.$this->pdo->lastInsertId());
            if($stmt == true){
                echo "Customer save ok!";
                $customerid = $this->pdo->lastInsertId();
                try {
                    $sql = "INSERT INTO addresses(line_1, line_2, city, state, zip, customer) VALUES (:line_1, :line_2, :city, :state, :zip, :customer)";
                    $stmt= $this->pdo->prepare($sql);
                    $stmt->bindParam(":line_1", $_POST["line_1"], PDO::PARAM_STR);
                    $stmt->bindParam(":line_2", $_POST["line_2"], PDO::PARAM_STR);
                    $stmt->bindParam(":city", $_POST["city"], PDO::PARAM_STR);
                    $stmt->bindParam(":state", $_POST["state"], PDO::PARAM_STR);
                    $stmt->bindParam(":zip", $_POST["zip"],PDO::PARAM_STR);
                    $stmt->bindParam(":customer ",$customerid, PDO::PARAM_INT);
                    $stmt->execute();
                } catch (Exception $e) {
                    die("Oh noes! There's an error in the query! .$e");
                }
                if($stmt == true){
                    echo "Address save ok!";
                    echo '<br><a href="practice3.php">See Customers</a>';
                }else{
                    echo "Lo siento, ocurrió un error";
                }
            }else{
                echo "Lo siento, ocurrió un error";
            }
            

		}
        public function getAllCustomer(){
            //include "SQLiteConnection.php";
            $resultado = $this->pdo->query("SELECT * FROM customers;");
            $customers = $resultado->fetchAll(PDO::FETCH_OBJ);
            return $customers;
        }
        public function getAllaItems(){
            $resultado = $this->pdo->query("SELECT * FROM items;");
            $items = $resultado->fetchAll(PDO::FETCH_OBJ);
            return $items;
        }
		public function getCustomer($get){
            if (empty($_GET["id"])) {
                exit("No hay id");
            }
            
            $sentencia = $this->pdo->prepare("SELECT * FROM customers WHERE id = :id LIMIT 1;");
            $sentencia->bindParam(":id", $_GET["id"]);
            $sentencia->execute();
            $customer = $sentencia->fetch(PDO::FETCH_OBJ);
            print_r($customer);
            if ($customer == FALSE) { #Si no existe ningún registro con ese id
                exit("No hay ningún videojuego con ese ID");
            }else{
                return $customer;
            }
        }

        public function CreateCart($id){
            //include "SQLiteConnection.php";

            if (empty($id)) {
                exit("No hay id");
            }

            $sentencia = $this->pdo->prepare(
                "SELECT cu.id AS cusid,
                adds.id AS addsid
                FROM customers cu
                INNER JOIN addresses adds ON adds.customer = cu.id
                WHERE cu.id = :id 
                LIMIT 1;");

            $sentencia->bindParam(":id", $id);
            $sentencia->execute();
            $customer = $sentencia->fetch(PDO::FETCH_OBJ);
            print_r($customer);
            if ($customer === FALSE) { #Si no existe ningún registro con ese id
                exit("No hay ningún customer con ese ID");
            }

            try {
                $sql = "INSERT INTO carts (customer) VALUES (:customer)";
                $stmt= $this->pdo->prepare($sql);
                $stmt->bindParam(":customer", $customer->cusid);
                $stmt->execute();
            } catch (Exception $e) {
                die("Oh noes! There's an error in the query! .$e");
            }
            print_r('respuesta: '.$this->pdo->lastInsertId());
            if($stmt == true){
                echo "Cart registrado correctamente";
                $cart = $this->pdo->lastInsertId();
            }else{
                echo "Lo siento, ocurrió un error";
            }
            try {
                $sql = "INSERT INTO carts_addresses (cart, address) VALUES (:cart, :address)";
                $stmt= $this->pdo->prepare($sql);
                $stmt->bindParam(":cart", $cart);
                $stmt->bindParam(":address", $customer->addsid);
                $stmt->execute();
            } catch (Exception $e) {
                die("Oh noes! There's an error in the query! .$e");
            }
            $items = $this->getAllaItems();
            $data = [
                "cart" => $cart,
                "items" => $items
            ];
            return $data;
        }

        public function getCustomerCarts($id){
            //include "SQLiteConnection.php";
            echo('getCustomerCarts id: '.$id);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT
                    cu.first_name AS Customer,
                    ca.id AS Cart,
                    it.name AS ItemName,
                    it.quantity AS ItemQuanty,
                    it.price AS ItemPrice,
                    COUNT(cait.item) AS NumItems,
                    SUM(it.price) AS SubTotal,
                    adds.line_1 AS AddsLine,
                    adds.city AS City,
                    adds.state AS AddsState
                    FROM
                    customers cu
                    INNER JOIN addresses adds ON adds.customer = cu.id
                    INNER JOIN carts ca ON ca.customer = cu.id
                    INNER JOIN carts_items cait ON cait.cart = ca.id
                    INNER JOIN items it ON it.id = cait.item
                    WHERE
                    cu.id = :id
                    GROUP BY
                    cait.cart,
                    cait.item;";
            $sentencia = $this->pdo->prepare($sql);
            $sentencia->bindParam(":id", $id, PDO::PARAM_INT);
            $sentencia->execute();
            $carts = $sentencia->fetchAll(PDO::FETCH_OBJ);
            return $carts;
        }

        public function createCartItem($cartid,$items,$custoid){
            if (empty($cartid) || empty($items))  {
                exit("No hay ids en createCartItem");
            }
            // echo "creacteCartItem cartid: ".$cartid.'<br/>'."items: ".$items[0].'<br/>'."custoid: ".$custoid.'<br/>';
            $add = $this->addItemToCart($cartid, $items);
            if($add){
            $allitems = $this->getAllaItems();
                foreach($items as $itemsel){
                    foreach($allitems as $theitem){
                        echo " theitem: ".$theitem->id;
                        if($itemsel == $theitem->id){
                    
                                $quantity = $theitem->quantity - 1;                    
                                try{
                                    $sentencia = $this->pdo->prepare("UPDATE items 
                                        SET quantity = :quantity
                                        WHERE id = :id");
                                    
                                    $sentencia->bindParam(":id", $theitem->id);
                                    $sentencia->bindParam(":quantity", $quantity);
                                    $resultado = $sentencia->execute();
                                } catch (Exception $e) {
                                    die("Oh noes! There's an error in the query! .$e");
                                }
                                                    if($resultado == true){
                                    echo "Item quantity actualizado correctamente";
                                }else{
                                    echo "Lo siento, ocurrió un error";
                                }
                            
                        }
                    }
                }
            }
            $carts = $this->getCustomerCarts($custoid);
            return $carts;
        }
        
    
        public function addItemToCart($cartid, $itemsid){
            //include "SQLiteConnection.php";
            foreach($itemsid as $itemid ){                
                echo "addItemToCart cartid and itemid: ".$cartid." - ".$itemid;
                try {
                    $sql = "INSERT INTO carts_items (cart, item) VALUES (:cart, :item)";
                    $stmt= $this->pdo->prepare($sql);
                    $stmt->bindParam(":cart", $cartid);
                    $stmt->bindParam(":item", $itemid);
                    $stmt->execute();
                } catch (Exception $e) {
                    die("Oh noes! There's an error in the query! .$e");
                }
                if($stmt == true){
                    echo "Itemm added to cart oK";
                    $res = true;
                }else{
                    echo "Lo siento, ocurrió un error";
                }
            }
            if($res){
                echo "Itemms added to cart welll";
                return true;
            }

        }
        public function getItemById($itemid){
            //include "SQLiteConnection.php";
            $sentencia = $this->pdo->prepare("SELECT * FROM items WHERE id = :id LIMIT 1;");
            $sentencia->bindParam(":id", $itemid, PDO::PARAM_INT);
            $sentencia->execute();
            echo "\nPDOStatement::errorCode(): ";
            print $sentencia->errorCode();
            $item = $sentencia->fetch(PDO::FETCH_OBJ);
            print_r("item returned getItemID: ".$item);
            return $item;
        }

    }
?>