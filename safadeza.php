<?php
function safadao (int $dia, int $mes,int $ano ){
    $ano = $ano % 100;
    $safadeza= somatorio ($mes) + ($ano/100)*(50-$dia);
    $anjo = 100-$safadeza;
    print("Você {$anjo}% perfeito, mas aquele {$safadeza}% é não anjo");
    
}
function somatorio(int $mes){
    
    $somatorio = 0;
    for ($i= $mes; $i> 0; $i--){
        $somatorio += $i;
    }
    return  $somatorio;
}
$dia = readline ("Em que dia você nasceu?");
$mes = readline ("Em que mês você nasceu?");
$ano = readline ("Em que ano você nasceu?");

safadao($dia,$mes,$ano);

//resultado do papai
//Em que dia você nasceu?07
//Em que mês você nasceu?03
//Em que ano você nasceu?1981
//Você 59.17% perfeito, mas aquele 40.83% é não anjo
    
    //resultado da mamae
   // Em que dia você nasceu?08
//Em que mês você nasceu?08
//Em que ano você nasceu?1979
//Você 30.82% perfeito, mas aquele 69.18% é não anjo
