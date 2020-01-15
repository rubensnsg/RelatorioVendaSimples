<?php session_start();

header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Sao_Paulo');

//ALTERE DE ACORDO COM OS DADOS DO SITE
$nomeSite = 'Blloag padrão'; //Preencha com o nome do Site.
$enderecoSite = 'blloagpadrao.com.br'; //Preencha com o nome do Site.
$http = 'http://';
$https = 'https://';

/* BANCO DE DADOS - ANTIGO  */
$host_bd = 'bvzfdagnfqepipz70gyw-mysql.services.clever-cloud.com';
$username_bd = 'ufgpsjx1cswrmye3';
$password_bd = 'ZoKM7HXwAaZAgd9ugpTr';
$nome_bd = 'bvzfdagnfqepipz70gyw';


try{
    $pdo = new PDO('mysql:host='.$host_bd.';dbname='.$nome_bd, $username_bd, $password_bd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch(PDOException $e) {
    echo 'Erro no acesso ao banco de dados:<br />' . $e->getMessage();
}

function colocaZero($numero){
  return strlen($numero) > 1 ? $numero : "0".$numero;
}

function dataBR($dataRecebida){
  $strExplode = explode("-", $dataRecebida);
  return $strExplode[2]."/".$strExplode[1]."/".$strExplode[0];
}

function dataGrafico($dataRecebida){
  $meses = array('Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez');
  $strExplode = explode("-", $dataRecebida);
  return $strExplode[2]."/".$meses[($strExplode[1] * 1 - 1)];
}

function dataEn($dataRecebida){
  $strExplode = explode("/", $dataRecebida);
  return $strExplode[2]."-".$strExplode[1]."-".$strExplode[0];
}

function checkDataBR($dataRecebida){ 
  if(strpos($dataRecebida, '/') === false) {
    return false;

  }else{
    $dataExplode = explode("/", $dataRecebida);
    return checkdate($dataExplode[1] ,$dataExplode[0] ,$dataExplode[2]); // int $month , int $day , int $year 
  }
}

function checkDataEN($dataRecebida){ 
  if(strpos($dataRecebida, '-') === false) {
    return false;

  }else{
    $dataExplode = explode("-", $dataRecebida);
    return checkdate($dataExplode[1], $dataExplode[2], $dataExplode[0]); // int $month , int $day , int $year 
  }
}

function trataPesquisa($str) {

  //Array de acentos
  $map = array(
      'á' => 'a',
      'à' => 'a',
      'ã' => 'a',
      'â' => 'a',
      'é' => 'e',
      'ê' => 'e',
      'í' => 'i',
      'ó' => 'o',
      'ô' => 'o',
      'õ' => 'o',
      'ú' => 'u',
      'ü' => 'u',
      'ç' => 'c',
      'Á' => 'A',
      'À' => 'A',
      'Ã' => 'A',
      'Â' => 'A',
      'É' => 'E',
      'Ê' => 'E',
      'Í' => 'I',
      'Ó' => 'O',
      'Ô' => 'O',
      'Õ' => 'O',
      'Ú' => 'U',
      'Ü' => 'U',
      'Ç' => 'C',
      '(' => '',
      ')' => '',
      '"' => ''
  );

  //Array para REGEXP
  $regpx = array(
      'a' => ('(a|A|á|Á|&aacute;|&Aacute;|à|À|&agrave;|&Agrave;|â|Â|&acirc;|&Acirc;|ã|Ã|&atilde;|&Atilde;)'), 
      'A' => ('(a|A|á|Á|&aacute;|&Aacute;|à|À|&agrave;|&Agrave;|â|Â|&acirc;|&Acirc;|ã|Ã|&atilde;|&Atilde;)'), 
      'e' => ('(e|E|é|É|&eacute;|&Eacute;|è|È|&egrave;|&Egrave;|ê|Ê|&ecirc;|&Ecirc;)'), 
      'E' => ('(e|E|é|É|&eacute;|&Eacute;|è|È|&egrave;|&Egrave;|ê|Ê|&ecirc;|&Ecirc;)'), 
      'i' => ('(i|I|í|Í|&iacute;|&Iacute;|ì|Ì|&igrave;|&Igrave;|î|Î|&icirc;|&Icirc;)'), 
      'I' => ('(i|I|í|Í|&iacute;|&Iacute;|ì|Ì|&igrave;|&Igrave;|î|Î|&icirc;|&Icirc;)'), 
      'o' => ('(o|O|ó|Ó|&oacute;|&Oacute;|ò|Ò|&ograve;|&Ograve;|ô|Ô|&ocirc;|&Ocirc;|õ|Õ|&otilde;|&Otilde;)'), 
      'O' => ('(o|O|ó|Ó|&oacute;|&Oacute;|ò|Ò|&ograve;|&Ograve;|ô|Ô|&ocirc;|&Ocirc;|õ|Õ|&otilde;|&Otilde;)'), 
      'u' => ('(u|U|ú|Ú|&uacute;|&Uacute;|ù|Ù|&ugrave;|&Ugrave;|û|Û|&ucirc;|&Ucirc;)'), 
      'U' => ('(u|U|ú|Ú|&uacute;|&Uacute;|ù|Ù|&ugrave;|&Ugrave;|û|Û|&ucirc;|&Ucirc;)'), 
      'ç' => ('(c|C|ç|Ç|&ccedil;|&Ccedil;)'), 
      'c' => ('(c|C|ç|Ç|&ccedil;|&Ccedil;)')
  );

  //Substituindo acentos
  $str = strtr($str, $map);

  //Substituindo vogais e ç para REGEXP
  $str = strtr($str, $regpx);

  //Substituindo espaços em branco
  $str = str_replace(' ', '(.*)', $str); // [[:space:]](.*)

  if(preg_match("/\s*/", $str)){
      $str = preg_replace("/ +/", "(.*)", $str);
  }

  return ($str);

}

function resumo($string,$chars) {
  $trespontos = '';
  if (strlen($string) > $chars) {
    while (substr($string,$chars,1) <> ' ' && ($chars < strlen($string))){
      $chars++;
    }
    $trespontos = "...";
  }
  return substr($string,0,$chars).$trespontos;
} ?>