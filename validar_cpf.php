<?php
$cpf = "111444777-35";

validaCPF($cpf);
function validaCPF($cpf = null):bool{
    
$soma = 0;

for ($i= 0; $i <9 ; $i++) { 
$soma += $cpf[$i]*(10-$i);
}
$valor = (int) ( $soma/11);
$resto = $soma%11;

if ($resto < 2) {
    $digito1= 0;
 } else {
    $digito1 = 11-$resto;
    }
    if ($digito1!= $cpf[10]) {
        return false;
    }

print"Valor:$valor resto:$resto \n";
return true;
}
