<?php
// problema na linha 73 e quando acessa a conta de nova nao aparece o nome do cliente
$clientes = [];
$contas = [];

function menu_principal() {
print ("\n");
    print("Bem-vindo ao MB!\n");
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
            print("Obrigado por utilizar o MB. Até logo!\n");
            break;
        default:
            print("Opção inválida! Tente novamente.\n");
            menu_principal();
            break;
    }
}

function acessar_conta() {
    global $clientes;
    global $contas;
    
    
    // print_r($clientes);
    // print_r($clientes);
    
    // die();
    
    $cpf = readline("Digite seu CPF: ");
    
    if (!CPF_Valido($cpf)) {
        print("\nCPF inválido! Tente novamente.\n");
        menu_principal();
        return;
    }

    // Verifica se o CPF existe no array de clientes
    $cliente_encontrado = false;
    $cliente = null; // Variável para armazenar o cliente encontrado
    foreach ($clientes as $cliente) {
        if ($cliente['cpf'] == $cpf) {
            $cliente_encontrado = true;
            $cliente = $clientes;
            break;
        }
    }
    
    if (!$cliente_encontrado) {
        print("\nCPF não encontrado. Tente novamente.\n");
        menu_principal();
        return;
    }

    // Se o cliente foi encontrado, obtém o número da conta
    $numero_conta = obterNumeroConta($cpf);
    if ($numero_conta) {

        menu_cliente($cliente['nome'], $cliente['cpf'], $cliente['telefone'], $numero_conta);
    } else {
        print("\nErro ao acessar a conta. Tente novamente.\n");
        menu_principal();
    }
}

function cadastrar_cliente() {
    global $clientes;

    $nome = readline("Digite seu nome: ");
    $cpf = readline("Digite seu CPF: ");
    
    if (!CPF_Valido($cpf)) {
        print("\nCPF inválido! Tente novamente.\n");
        menu_principal();
        return;
    }
    
    // Verificar se o CPF já está cadastrado
    foreach ($clientes as $cliente) {
        if ($cliente['cpf'] == $cpf) {
            print("\nCPF já existente. Confira os dígitos.\n");
            menu_principal();
            return;
        }
    }

    $telefone = readline("Digite seu telefone: ");
    
    forma_cadastro($nome, $cpf, $telefone);
}

// cadastra o cliente no array
function forma_cadastro($nome, $cpf, $telefone) {
    global $clientes;
    $cliente = [
        "nome" => $nome,
        "cpf" => $cpf,
        "telefone" => $telefone
    ];
    $clientes[] = $cliente;

    
    $numero_conta = cadastrarConta($cpf);

    print("\nUma conta foi criada para você.\n");
    print("\nNúmero da conta: $numero_conta\n");

    // primeiro acesso
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

// Função para o menu do cliente cadastrado 
function menu_cliente($nome_cliente, $cpf_cliente, $telefone_cliente, $numero_conta) {
    global $contas;

    
    foreach ($contas as &$conta) {
        if ($conta['cpfCliente'] == $cpf_cliente) {
            if ($conta['primeiro_acesso']) {
                print("\nEsse é seu primeiro acesso, faça um depósito inicial: ");
                $quantia = (float) readline();
                depositar($conta, $numero_conta, $quantia);
                $conta['primeiro_acesso'] = false; 
            }
            break; 
        }
    }

    // Exibe o menu de operações 
    while (true) {
        print("\nBem-vindo, $nome_cliente!\n");
        print("Escolha uma opção:\n");
        print("1 - Depositar\n");
        print("2 - Sacar\n");
        print("3 - Consultar saldo\n");
        print("4 - Voltar para o menu\n");
        print("5 - Sair\n");

        $opcao = (int) readline("\n Escolha uma opção: ");
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
                consultarSaldo($conta, $numero_conta); 
                break;
            case 4 :
                menu_principal();
                print ("\n");
            case 5:
                print("Obrigado por utilizar o MB. Até logo!\n");
                return;
            default:
                print("Opção inválida! Tente novamente.\n");
                break;
        }
    }
}

function depositar(&$conta, $numeroConta, $quantia) {
    if (!is_numeric($quantia) || $quantia <= 0) {
        print("Não é permitido realizar depósitos com valores negativos ou zero.\n");
        return; 
    }

    if ($conta['numeroConta'] == $numeroConta) {
        $conta['saldo'] += $quantia; 
        print("Depósito de R$ $quantia realizado com sucesso na conta $numeroConta.\n");
    } else {
        print("Número da conta não encontrado.\n");
    }
}

function sacar(&$conta, $numeroConta, $quantia_saque) {
    if ($conta['numeroConta'] == $numeroConta) {
        if ($quantia_saque < 0) {
            print("Não é permitido realizar saques com valores negativos.\n");
        } elseif ($conta['saldo'] >= $quantia_saque) {
            $conta['saldo'] -= $quantia_saque;
            print("Saque de R$ $quantia_saque realizado com sucesso na conta $numeroConta.\n");
        } else {
            print("Saldo insuficiente para realizar o saque de R$ $quantia_saque.\n");
        }
    }
}

function consultarSaldo($conta, $numeroConta) {
    if ($conta['numeroConta'] == $numeroConta) {
        print("O saldo da conta $numeroConta é de R$ {$conta['saldo']}.\n");
    }
}

function CPF_Valido($cpf = null): bool {
    if (strlen($cpf) != 11) {
        return false;
    }
    
    $soma = 0;
    for ($i = 0; $i < 9; $i++) {
        $soma += $cpf[$i] * (10 - $i);
    }
    $valor = (int)($soma / 11);
    $resto = $soma % 11;

    if ($resto < 2) {
        $digito1 = 0;
    } else {
        $digito1 = 11 - $resto;
    }

    if ($digito1 != $cpf[9]) {
        return false;
    }

    $soma = 0;
    for ($i = 0; $i < 10; $i++) {
        $soma += $cpf[$i] * (11 - $i);
    }
    $resto = $soma % 11;

    if ($resto < 2) {
        $digito2 = 0;
    } else {
        $digito2 = 11 - $resto;
    }

    if ($digito2 != $cpf[10]) {
        return false;
    }

    return true;
   
}

menu_principal(); 