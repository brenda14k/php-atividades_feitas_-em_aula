<?php
$cpf = "111444777";

validaCPF($cpf);
function validaCPF($cpf = null):bool{
    
$soma = 0;

for ($i= 0; $i <9 ; $i++) { 
$soma += $cpf[$i]*(10-$i);
}
print $soma%11;
return true;
}