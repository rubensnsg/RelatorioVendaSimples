CREATE TABLE bvzfdagnfqepipz70gyw.Sales (
	idSale INT(11) NOT NULL,
	dateSale DATETIME NOT NULL,
	productSale varchar(255) NOT NULL,
	price DECIMAL(6, 2) NOT NULL,
	PRIMARY KEY(idSale)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci;
