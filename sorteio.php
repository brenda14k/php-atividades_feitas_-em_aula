<?php
 print("Quantas dezenas deseja comprar? ");
$nun_sorteado = [];
 $numero_dezenas = [];

for ($i=0; $i <6; $i++) { 
    
    $sorteado = rand (1,60);
for ($j=0; $j <6 ; $j++) { 
    
    if ($nun_sorteado [j] == $sorteado ) {
        stop;
    }else{
        $nun_sorteado[] = $sorteado;
    }
    
    
    
}
   
print ("$sorteado \n");
}


