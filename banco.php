<?php
// conferir se o cpf aceita o numero de digitos certos e o numero de telefone tambem
// se repetir o numero do Cpf na hora do cadastro nao pode continuar o cadastro
$clientes = [];
$contas = [];

// Função principal que exibe o menu de boas-vindas
function menu_principal() {
    print("Bem-vindo ao Banco Branco!\n");
    print("Escolha uma opção:\n");
    print("1 - Acessar conta\n");
    print("2 - Cadastrar-se\n");
    print("3 - Sair\n");

    $opcao = (int) readline("Escolha uma opção: ");

    switch ($opcao) {
        case 1:
            acessar_conta();
            break;
        case 2:
            cadastrar_cliente();
            break;
        case 3:
            print("Obrigado por utilizar o Banco Branco. Até logo!\n");
            break;
        default:
            print("Opção inválida! Tente novamente.\n");
            menu_principal();
            break;
    }
}

// Função para acessar uma conta existente
function acessar_conta() {
    global $clientes;
    $cpf = readline("Digite seu CPF: ");

    // Verifica se o CPF existe no array de clientes
    foreach ($clientes as $cliente) {
        if ($cliente['cpf'] == $cpf) {
            // Encontrou o cliente, agora vamos procurar o número da conta
            $numero_conta = obterNumeroConta($cpf);
            if ($numero_conta) {
                // Passa as informações do cliente para o menu_cliente
                menu_cliente($cliente['nome'], $cliente['cpf'], $cliente['telefone'], $numero_conta);
                return;  // Após chamar o menu_cliente, o código deve parar aqui
            }
        }
    }

    print("CPF não encontrado. Você precisa se cadastrar.\n");
    menu_principal();  
}

// Cadastra novo cliente
function cadastrar_cliente() {
    $nome = readline("Digite seu nome: ");
    $cpf = readline("Digite seu CPF: ");
    
    // Verificar se o CPF já está cadastrado
    global $clientes;
    foreach ($clientes as $cliente) {
        if ($cliente['cpf'] == $cpf) {
            print("CPF já existente. Confira os dígitos.\n");
            menu_principal();
            return;
        }
    }

    $telefone = readline("Digite seu telefone: ");

    // Chama a função forma_cadastro após cadastrar o cliente
    forma_cadastro($nome, $cpf, $telefone);
}

// Função para cadastrar o cliente no array
function forma_cadastro($nome, $cpf, $telefone) {
    global $clientes;
    $cliente = [
        "nome" => $nome,
        "cpf" => $cpf,
        "telefone" => $telefone
    ];
    $clientes[] = $cliente;

    // Criação de conta bancária para o cliente
    $numero_conta = cadastrarConta($cpf);

    print(" \n Uma conta foi criada para você.\n");
    print(" Número da conta: $numero_conta\n");

    // Após cadastrar, o menu_cliente é chamado para o primeiro acesso
    menu_cliente($nome, $cpf, $telefone, $numero_conta);
}

// Cadastra conta bancária
function cadastrarConta($cpf_cliente) {
    global $contas;
    $conta = [
        "numeroConta" => uniqid(),
        "cpfCliente" => $cpf_cliente,
        "saldo" => 0,
        "primeiro_acesso" => true 
    ];
    $contas[] = $conta;
    return $conta['numeroConta']; 
}

// Função para obter o número da conta de um cliente baseado no CPF
function obterNumeroConta($cpf_cliente) {
    global $contas;
    foreach ($contas as $conta) {
        if ($conta['cpfCliente'] == $cpf_cliente) {
            return $conta['numeroConta'];
        }
    }
    return null;
}

// Função para o menu do cliente cadastrado (Agora inclui primeiro acesso)
function menu_cliente($nome_cliente, $cpf_cliente, $telefone_cliente, $numero_conta) {
    global $contas;

    // Verifica se é o primeiro acesso, se for, solicita o depósito inicial
    foreach ($contas as &$conta) {
        if ($conta['cpfCliente'] == $cpf_cliente) {
            if ($conta['primeiro_acesso']) {
                print("Seu primeiro acesso,por favor,faça um depósito inicial: ");
                $quantia = (float) readline();
                depositar($conta, $numero_conta, $quantia);
                $conta['primeiro_acesso'] = false; // Marca como não primeiro acesso
            }
            break; // Saímos do loop após encontrar a conta correspondente
        }
    }

    // Exibe o menu de operações sem a saudação
    while (true) {
        print("Escolha uma opção:\n");
        print("1 - Depositar\n");
        print("2 - Sacar\n");
        print("3 - Consultar saldo\n");
        print("4 - Sair\n");

        $opcao = (int) readline("Escolha uma opção: ");
        switch ($opcao) {
            case 1:
                $quantia = (float) readline("Informe a quantia a ser depositada: ");
                depositar($conta, $numero_conta, $quantia);
                break;
            case 2:
                $quantia_saque = (float) readline("Informe o valor a ser sacado: ");
                sacar($conta, $numero_conta, $quantia_saque);
                break;
            case 3:
                consultarSaldo($conta, $numero_conta); // Agora irá apenas consultar o saldo se a conta for válida
                break;
            case 4:
                print("Obrigado por utilizar o Banco Branco. Até logo!\n");
                return; // Retorna ao menu principal
            default:
                print("Opção inválida! Tente novamente.\n");
                break;
        }
    }
}

// Função para fazer o depósito
function depositar(&$conta, $numeroConta, $quantia) {
    if ($conta['numeroConta'] == $numeroConta) {
        $conta['saldo'] += $quantia;
        print("Depósito de R$ $quantia realizado com sucesso na conta $numeroConta.\n");
    }
}

// Função para sacar dinheiro
function sacar(&$conta, $numeroConta, $quantia_saque) {
    if ($conta['numeroConta'] == $numeroConta) {
        if ($conta['saldo'] >= $quantia_saque) {
            $conta['saldo'] -= $quantia_saque;
            print("Saque de R$ $quantia_saque realizado com sucesso na conta $numeroConta.\n");
        } else {
            print("Saldo insuficiente para realizar o saque de R$ $quantia_saque.\n");
        }
    }
}

// Função para consultar o saldo
function consultarSaldo($conta, $numeroConta) {
    if ($conta['numeroConta'] == $numeroConta) {
        print("O saldo da conta $numeroConta é de R$ {$conta['saldo']}.\n");
    }
}

menu_principal(); // Chama a função principal para iniciar o processo
?>
