<?php
/*
	CRUD con SQLite3, PDO y PHP
	parzibyte.me
*/
include_once "SQLiteConnection.php";

$definicionTabla = "CREATE TABLE IF NOT EXISTS customers(
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	first_name TEXT NOT NULL,
	last_name TEXT NOT NULL
);";
#Podemos usar $baseDeDatos porque incluimos el archivo que la crea
$resultado = $pdo->exec($definicionTabla);

$definicionTabla = "CREATE TABLE carts(
    id INTEGER PRIMARY KEY AUTOINCREMENT, 
    customer INTEGER NOT NULL,
    FOREIGN KEY(customer) REFERENCES customers(id)
  );";

$resultado = $pdo->exec($definicionTabla);

$definicionTabla = "CREATE TABLE items(
    id INTEGER PRIMARY KEY AUTOINCREMENT, 
    item_name   TEXT NOT NULL,
    quantity    INTEGER NOT NULL,
    price       INTEGER NOT NULL,
    cart        INTEGER NOT NULL,
    FOREIGN KEY(cart) REFERENCES carts(id)
  );";

$resultado = $pdo->exec($definicionTabla);


$definicionTabla = "CREATE TABLE addresses(
    id INTEGER PRIMARY KEY AUTOINCREMENT, 
    line_1   TEXT NOT NULL,
    line_2   TEXT,
    city      TEXT NOT NULL,
    state_name    TEXT NOT NULL,
    zip     TEXT NOT NULL,
    FOREIGN KEY(customer) REFERENCES customers(id)
  );";

$definicionTabla = "CREATE TABLE carts_addresses(
    id INTEGER PRIMARY KEY AUTOINCREMENT, 
    cart INTEGER NOT NULL,
    address INTEGER NOT NULL,
    FOREIGN KEY(cart) REFERENCES carts(id),
    FOREIGN KEY(address) REFERENCES addresses(id)
  );";

$resultado = $pdo->exec($definicionTabla);

echo "Tablas creadas correctamente";

?>