<?php require_once("conn.php");

$dataInicio = date('Y-m-d', strtotime('-6 days'));
$dataHoje = date('Y-m-d');
$dataFim = $dataHoje;
$dataAtual = '';

if(isset($_POST['dataDe']) && $_POST['dataDe'] <> ''){
  if(checkDataBR($_POST['dataDe'])){
    $dataInicio = dataEn($_POST['dataDe']);
  }
}

if(isset($_POST['dataAte']) && $_POST['dataAte'] <> ''){
  if(checkDataBR($_POST['dataAte'])){
    $dataFim = dataEn($_POST['dataAte']);
  }
}


$horaInicio = '00:00:00';
$horaFim = '23:59:59';

$whereClause = " WHERE dateSale BETWEEN '".$dataInicio." ".$horaInicio."' AND '".$dataFim." ".$horaFim."' ";


$arrayProduct = array("Camiseta", "Shorts", "Sapato");

if(isset($_POST['product']) && $_POST['product'] <> '' && in_array($_POST['product'], $arrayProduct)){
  $whereClause .= " AND productSale = '".$_POST['product']."' ";
}


$querySql = $pdo->query("SELECT DATE(dateSale) AS dat, productSale, COUNT(idSale) AS total FROM bvzfdagnfqepipz70gyw.Sales ".$whereClause." GROUP BY DATE(dateSale), productSale ORDER BY DATE(dateSale) ASC");
$queryGrafico = $pdo->query("SELECT DISTINCT(productSale) AS name FROM bvzfdagnfqepipz70gyw.Sales ".$whereClause." ORDER BY productSale ASC");

$arrayResults = array();
$arrayGrafico = array();
$headerGrafico = array();
$chartData = "['Data', ";

  
while ($row = $querySql->fetch(PDO::FETCH_ASSOC)) {
  $arrayResults[] = $row;
  $arrayGrafico[$row['dat']][$row['productSale']] = $row['total'];
}
  
while ($line = $queryGrafico->fetch(PDO::FETCH_ASSOC)) {
  $headerGrafico[] = $line['name'];
  $chartData .= "'".$line['name']."', ";
}

if($chartData <> "['Data', " && count($arrayGrafico) > 1 && count($headerGrafico) > 0 && $dataInicio <> $dataFim){
  $chartData = substr($chartData, 0, -2);
  $chartData .= "], ";

  foreach ($arrayGrafico as $key => $value) {

    $chartData .= "[ '".dataGrafico($key)." ', ";

    foreach ($headerGrafico as $title) {

      if(isset($value[$title])){
        $chartData .= $value[$title].", ";
      }else{
        $chartData .= "0, ";
      }
    }

    $chartData = substr($chartData, 0, -2);
    $chartData .= "], ";
  }

  $chartData = substr($chartData, 0, -2);
}

?>
<!doctype html>
<html lang="pt-br">
<head>
  <?php require_once("head.php"); ?>
</head>

<body>

<?php require_once("header.php"); ?>

<div class="container">
  <div class="row">

    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
      <div class="card mt-4">

        <div id="titulocard" class="card-header">FILTRO</div>

        <div class="card-body" id="form">
          
          <form class="form-inline no-print" id="form-filtro" role="form" method="post">

            <div class="form-group mt-3 col-12 order-1 col-sm-12 col-md-6 order-md-3 col-lg-4 order-lg-1 col-xl-4 order-xl-1">
              <label for="select" class="col-12 col-sm-4 col-form-label" for="product">Produtos</label> 
              <div class="col-12 col-sm-8">
                <select id="select" name="product" id="product" class="form-control">
                  <option value="" selected="selected">Todos</option>
                  <option value="Camiseta" <?php if(isset($_POST['product']) && $_POST['product'] == 'Camiseta'){ ?> selected="selected"<?php } ?>>Camiseta</option>
                  <option value="Shorts" <?php if(isset($_POST['product']) && $_POST['product'] == 'Shorts'){ ?> selected="selected"<?php } ?>>Shorts</option>
                  <option value="Sapato" <?php if(isset($_POST['product']) && $_POST['product'] == 'Sapato'){ ?> selected="selected"<?php } ?>>Sapato</option>
                </select>
              </div>
            </div>

            <div class="form-group mt-3 col-12 order-3 col-sm-12 col-md-6 order-md-1 col-lg-3 order-lg-2 col-xl-3 order-xl-2">
              <label class="col-12 col-sm-4 col-form-label" for="dataDe">&nbsp;Início</label>
              <div class="col-12 col-sm-8">
                <input name="dataDe" type="text" class="form-control date hasDatepicker" id="dataDe" placeholder="dd/mm/aaaa" value="<?php echo dataBR($dataInicio); ?>" data-value="<?php echo dataBR($dataInicio); ?>">
              </div>
            </div>

            <div class="form-group mt-3 col-12 order-5 col-sm-12 col-md-6 order-md-2 col-lg-3 order-lg-3 col-xl-3 order-xl-3">
              <label class="col-12 col-sm-4 col-form-label" for="dataAte">&nbsp;Fim</label>
              <div class="col-12 col-sm-8">
                <input name="dataAte" type="text" class="form-control date hasDatepicker" id="dataAte" placeholder="dd/mm/aaaa" value="<?php echo dataBR($dataFim); ?>" data-value="<?php echo dataBR($dataFim); ?>">
              </div>
            </div>

            <div class="form-group mt-3 col-12 order-12 offset-md-2 col-md-4 order-md-4 offset-lg-0 col-lg-2 order-lg-4 col-xl-1 order-xl-4">
              <button type="submit" id="filtro" class="btn btn-primary btn-block">OK</button>
            </div>

            <!--<div class="form-group mt-3 col-12 order-12 col-md-4 col-lg-2 col-xl-1 order-xl-5">
              <button type="submit" id="filtro" class="btn btn-info btn-block">Baixar</button>
            </div>-->

          </form>

        </div>


      </div>
    </div>


    <div id="grafico" class="col-12 mb-5 mb-lg-0">

      <?php if(count($arrayGrafico) > 1 && $dataInicio <> $dataFim){ ?>
        <div class="card text-center mt-3">

          <div  id= "tituloplan" class="card-header justify-content-between align-items-center" style="padding-left: 3.75rem; padding-right: 1.50rem">
            GRÁFICO
          </div>


          <div class="card-body" style= "margin: 0px auto 0px auto; padding-top: 0">
            <div id="principais" style="height: 280px; font-weight: lighter; color: #8a2be2; font-size: 20px;" class="col-12" ></div>
          </div>

        </div>
      <?php } ?>





      <div class="card text-center mt-4 mb-5">
        <div class="card-header justify-content-between align-items-center"  style="padding: 0.25rem 1.25rem;">
          <div id="print" onclick="printDiv('grafico')" class="badge badge-info pb-1 pt-1 mr-2 float-right no-print" style="margin-top: 0.3rem;">IMPRIMIR &nbsp;<i class="fas fa-print"></i></div>
          TABELA
        </div>

        <div class="card-body" style= "margin: 0px auto 0px auto; padding-top: 0">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Produto</th>
                  <th class="titulo">Data de Venda</th>
                  <th class="titulo"  width="14%">Total</th>
                </tr>
              </thead>
              <tbody>
                <?php if(count($arrayResults) > 0){
                  $totalGeral = 0;
                  $totalAtual = 0;
                  foreach ($arrayResults as $value){
                    if($dataAtual <> $value['dat'] && $dataAtual <> '' && !(isset($_POST['product']) && $_POST['product'] <> '' && in_array($_POST['product'], $arrayProduct))){ ?>
                      <tr>
                        <td colspan="2" class="total-row px-4">Total dia <?php echo dataBR($dataAtual); ?></td>
                        <td width="14%"><?php echo $totalAtual; ?></td>
                      </tr>
                    <?php $totalAtual = 0;
                    }
                    $totalAtual += $value['total'];
                    $totalGeral += $value['total'];
                    $dataAtual = $value['dat']; ?>
                    <tr>
                      <td><?php echo $value['productSale']; ?></td>
                      <td><?php echo dataBR($value['dat']); ?></td>
                      <td width="14%"><?php echo $value['total']; ?></td>
                    </tr>

                  <?php }
                  if($totalAtual <> 0 && !(isset($_POST['product']) && $_POST['product'] <> '' && in_array($_POST['product'], $arrayProduct))){ ?>
                    <tr>
                      <td colspan="2" class="total-row px-4">Total <?php echo dataBR($dataAtual); ?></td>
                      <td width="14%"><?php echo $totalAtual; ?></td>
                    </tr>
                  <?php }
                  if($totalGeral <> 0 && ((isset($_POST['product']) && $_POST['product'] <> '' && in_array($_POST['product'], $arrayProduct)) || $totalGeral <> $totalAtual)){ ?>
                    <tr>
                      <td colspan="2" class="total-geral-row px-4">Total dentro do período pesquisado</td>
                      <td width="14%"><?php echo $totalGeral; ?></td>
                    </tr>
                  <?php }
                }else{ ?>
                  <tr>
                    <td class="py-5 px-2" style="line-height: 20px;" valign="middle" colspan="3" align="center">Sem vendas no período pesquisado.</td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>

  </div>
</div>

<?php

require_once("footer.php");
require_once("scripts.php");

?>

<?php if($chartData <> "['Data', " && count($arrayGrafico) > 1 && count($headerGrafico) > 0 && $dataInicio <> $dataFim) { ?>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        <?php echo $chartData; ?>
      ]);
      /*  ['Year', 'Sales', 'Expenses'],
        ['2004',  1000,      400],
        ['2005',  1170,      460],
        ['2006',  660,       1120],
        ['2007',  1030,      540]
      */

      var options = {
        chartArea: {left: 40, right: 10},
        vAxis: { 
          viewWindow: {
              min:0
          }
        },
        legend: { position: 'bottom' }
      };

      var chart = new google.visualization.LineChart(document.getElementById('principais'));

      chart.draw(data, options);
    }
  </script>

<?php } ?>

</body>
</html>