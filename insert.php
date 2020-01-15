<?php require_once('conn.php');

ini_set("max_execution_time", 180);
set_time_limit(180);

$arrayProduct = array("Camiseta", "Shorts", "Sapato");
$IDs = "";

for ($j=0; $j <= 20; $j++) {
  for ($i=1; $i <= 31; $i++) {
	$querySQL = "INSERT INTO bvzfdagnfqepipz70gyw.Sales(dateSale, productSale, price) VALUES";// (1, '2019-12-09 00:00:00', 'Sapato', 90.50)
	shuffle($arrayProduct);
	$hora = colocaZero(rand(0, 23));
	$segundos = colocaZero(($i + rand(0, 25)));
	$price = colocaZero(rand(20, 1500)).".".colocaZero(rand(0, 99));

	$querySQL .= "('2019-12-".$i." ".$hora.":".colocaZero($i).":".$segundos."', '".$arrayProduct[0]."', ".$price.")";

	$query = $pdo->prepare($querySQL);
    $query->execute();

    if($query->rowCount()){
      $idItem = $pdo->lastInsertId();
      $IDs .= $idItem.", ";

	}else{
	  echo "Query que não funcionou:<br />".$querySQL."<br /><br />";
	}


	//echo $querySQL.";<br />";
	//echo ."<br />";
  }
}

if($IDs <> ''){
	echo "IDs inseridos: ".substr($IDs, 0, -2)."<br />";
}

?>