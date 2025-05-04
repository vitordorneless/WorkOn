<?php
$ponteiro = fopen ("123.txt","r");
while (!feof ($ponteiro)) {
  $txt = $txt.fgets($ponteiro,4096);
}
fclose ($ponteiro);


$registro = explode("SEQ ", $txt);
$tamanho = sizeof($registro);
echo $registro[1];

//nome
$pos = strripos($registro[1], "COD:00 NOME:");
$nome = substr($registro[1], $pos+12, 100);
$registro_nome = explode("DT.NASC:", $nome);
$nome = $registro_nome[0];


//critica
$pos_critica = strripos($registro[1], "=====>");
$critica = substr($registro[1], $pos_critica+6, 100);

//certificado
$pos_certificado = strripos($registro[1], "CERTIFICADO:");
$certificado = substr($registro[1], $pos_certificado+12, 100);
$registro_certificado = explode("=====>", $certificado);
$certificado = $registro_certificado[0];

//subfatura
$pos_sub = strripos($registro[1], "SUBF:");
$sub = substr($registro[1], $pos_sub+5, 100);
$registro_sub = explode("CERTIFICADO:", $sub);
$sub = $registro_sub[0];



echo "<br><br><b>Tamanho:</b>";
echo $tamanho;
echo "<br><br><b>Nome:</b>";
echo $nome;
echo "<br><br><b>Critica:</b>";
echo $critica;
echo "<br><br><b>Certificado:</b>";
echo $certificado;
echo "<br><br><b>Sub:</b>";
echo $sub;



?>