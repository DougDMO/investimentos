<?php

require_once "config.php";

$sql = new Sql();

$url = 'http://www.fundamentus.com.br/resultado.php';


$conteudoSite = file_get_contents($url);

$DOM = new DOMDocument;
@$DOM->loadHTML($conteudoSite);
$XPath = new DomXPath($DOM);

$linha = array();

$headers = array();

for ($j = 1; $j <= 21; $j++) {

    $titulo = $XPath->query('//*[@id="resultado"]/thead/tr/th[' . $j . ']/a');

    foreach ($titulo as $tit) {

        $headers[$j] = "[".$tit->nodeValue."]";

    }
}

$sqlcol = (implode(",",$headers));

$sqlval="";
$sqlinter="";

for ($i = 1; $i <= 886; $i++) {

    $sqlinter="";

    for ($c = 1; $c <=count($headers); $c++) {

        $divs = $XPath->query('//*[@id="resultado"]/tbody/tr[' . $i . ']/td[' . $c . ']');

        foreach ($divs as $div) {

            $linha[$headers[$c]] = [$div->nodeValue];

            $sqlinter = $sqlinter . "'" . $div->nodeValue . "'";

        }
    }

    $sqlinter = str_replace("''","','",$sqlinter);
    $sqlval = $sqlval . "(".$sqlinter.")";

}
$sqlval = str_replace(")(","),(",$sqlval);

$string = "INSERT INTO papeis ($sqlcol) VALUES $sqlval;";
//echo $string;
$sql->query($string);
echo "Done";