    <?php


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
            
            $nome = readline("Informe seu nome para o ranking: ");
            ranking($nome,$tentativas);
            
            }else{
                print("Ahh,você errou! Não era o número $chute.\n");
                if ($chute > $sorteado){
                    print("O chute foi muito alto!\n");
                }else{
                    print("O chute foi muito baixo!\n");
                }
            }
            
    } while ($chute != $sorteado);

    function ranking ($nome, $quantidade_jogadas){
        
        // lê os dados que já estão no arquivo
        $json = file_get_contents("ranking.json");
        
        // transforma ou decodifica 
        $ranking = json_decode($json,true);
        
        $jogada = [
            "nome" => $nome,
            "jogadas" => $quantidade_jogadas
        ];
        
    $ranking[] = $jogada;
    
    //transforma os dados para o formato json
    
    $json = json_encode($ranking,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    //salva um dado em um arquivo
    file_put_contents("ranking.json",$json);

    }
