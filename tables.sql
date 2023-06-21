-- SQLite
CREATE TABLE customers(
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	first_name TEXT NOT NULL,
	last_name TEXT NOT NULL
);

CREATE TABLE carts(
    id INTEGER PRIMARY KEY AUTOINCREMENT, 
    customer INTEGER NOT NULL,
    FOREIGN KEY(customer) REFERENCES customers(id)
  );
  
CREATE TABLE items(
    id INTEGER PRIMARY KEY AUTOINCREMENT, 
    name   TEXT NOT NULL,
    quantity    INTEGER NOT NULL,
    price       INTEGER NOT NULL
  );

CREATE TABLE carts_items(
    id INTEGER PRIMARY KEY AUTOINCREMENT, 
    cart INTEGER NOT NULL,
    item INTEGER NOT NULL,
    FOREIGN KEY(cart) REFERENCES carts(id),
    FOREIGN KEY(item) REFERENCES items(id)
  );

CREATE TABLE addresses(
    id INTEGER PRIMARY KEY AUTOINCREMENT, 
    line_1   TEXT NOT NULL,
    line_2   TEXT,
    city     TEXT NOT NULL,
    state    TEXT NOT NULL,
    zip      TEXT,
    customer INTEGER NOT NULL,
    FOREIGN KEY(customer) REFERENCES customers(id)
  );

CREATE TABLE carts_addresses(
    id INTEGER PRIMARY KEY AUTOINCREMENT, 
    cart INTEGER NOT NULL,
    address INTEGER NOT NULL,
    FOREIGN KEY(cart) REFERENCES carts(id),
    FOREIGN KEY(address) REFERENCES addresses(id)
  );