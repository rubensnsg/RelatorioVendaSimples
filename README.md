# RelatorioVendaSimples
Relatório para PHP para tabela de vendas simples, com opção de filtro por período e por tipo do produto com impressão em pdf da tabela de resultados e google chart quando mais de um dia com resultados.

Criei estes arquivos para um processo seletivo cujo teste era em PHP para o cargo de Analista/Programador Pleno

  Este projeto utiliza as seguintes tecnologias
    PHP v. 7.2.13

    Jquery v. 3.4.1
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <!--Pooper--><script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    Bootstrap v. 4.3.1
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    FontAwesome v. 5.6.3
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous" />

    Google Fonts
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    Bootstrap-material-datetimepicker(Com algumas alterações no css)
      Projeto https://github.com/T00rk/bootstrap-material-datetimepicker
      Script <script src="https://cdn.jsdelivr.net/gh/djibe/bootstrap-material-datetimepicker@83a10c38ee94dd27fd946ea137af6667c65a738f/js/bootstrap-material-datetimepicker-bs4.min.js"></script>
      Css <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/djibe/bootstrap-material-datetimepicker@6659d24c7d2a9c782dc2058dcf4267603934c863/css/bootstrap-material-datetimepicker-bs4.min.css" />

      Este projeto para funcionar corretamente precisa do download da biblioteca abaixo
        Momentjs v. 2.24.0
        <script src="https://cdn.jsdelivr.net/gh/moment/moment@develop/min/moment-with-locales.min.js"></script>

        Além de Google Material Icon Font que já chamava no projeto

    Google Charts
      https://developers.google.com/chart/interactive/docs

    Javascript(Para botão imprimir printar somente a tabela com resultados)


  Também conta com um script simples para popular a tabela, além de arquivos "Create Table" e um "Insert" SQL pronto, caso não queira rodar o script PHP para popular a tabela.
    CreateTable.sql (Para inserir a tabela Sales)
    Sales_homol_data.sql (Para inserir conteúdo na table Sales)
    insert.php (Para popular randomicamente a table Sales)
    
  IMAGENS(E FAVICON) MERAMENTE ILUSTRATIVAS
  
  Estrutura do layout desenvolvido por Márcio Gastalle Cavalheiro
  Para contato utilize o site http://www.inventarte.com.br/
