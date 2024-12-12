<?php
ranking();

$sorteado = rand(1,100);
$tentativas = 0;
do {
    do {
    
        $chute = (int)readline ("Informe um número: ");
        } while(!is_numeric($chute));
        $tentativas++;
        
        if ($chute == $sorteado) {
            print("Parabéns você acertou! \n");
            
        print("Foram necesárias {$tentativas}! \n");
        }else{
            print("Ahh,você errou! Não era o número $chute.\n");
            if ($chute > $sorteado){
                print("O chute foi muito alto!\n");
            }else{
                print("O chute foi muito baixo!\n");
            }
        }
        
} while ($chute != $sorteado);

function ranking (){
    $nome = 'Brenda';
    $tentativas = 6;
    $ranking = [];
    array_push($ranking,"teste");
    array_push($ranking,"teste");
print_r($ranking);
}
