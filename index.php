<?php

require_once "config.php";

$regImportacao = new RegistroImportacao();
$ultimoregistro = $regImportacao->getUltimaImportacao();

$regPapeis = new Papeis();
$results = $regPapeis->getPapeis();

?>


</center>


<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>Seu Home de Investimentos</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">


    <link rel="stylesheet" href="css/style.css">


</head>

<body>
<section>
    <!--for demo wrap-->
    <br>
    <h1>Ações</h1>
    <div class="tbl-header">
        <table cellpadding="0" cellspacing="0" border="0">
            <thead>
            <tr>
                <?php
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

                        $headers[$j] = "[" . $tit->nodeValue . "]";

                        echo "<th>$tit->nodeValue</th>";

                    }
                } ?>
            </tr>
            </thead>
        </table>
    </div>
    <div class="tbl-content">
        <table cellpadding="0" cellspacing="0" border="0">
            <tbody>
            <?php

            for ($l = 0; $l < count($results); $l++) {
                echo "<tr>";
                foreach ($results[$l] as $rel) {

                    echo "<td><center>$rel</center></td>";

                }
                echo "</tr>";
            } ?>
            </tbody>
        </table>
    </div>
</section>
<h2>Última atualização: <?php echo $ultimoregistro?></h2>
</body>

<h1>Atualize suas ações !!
    <a href="atualpapeis.php">
        <img border="0" src="imagens/upload.svg" width="50" height="50">

    </a>
</h1>
</html>
