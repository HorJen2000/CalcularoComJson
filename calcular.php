<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['sucesso' => false, 'erro' => 'Método não permitido. Use POST.']);
    exit;
}


$dados = json_decode(file_get_contents('php://input'), true);

if (!is_array($dados)) {
    http_response_code(400);
    echo json_encode(['sucesso' => false, 'erro' => 'JSON inválido.']);
    exit;
}

$num1     = $dados['num1'] ?? null;
$num2     = $dados['num2'] ?? null;
$operacao = $dados['operacao'] ?? '';

if (!is_numeric($num1) || !is_numeric($num2)) {
    http_response_code(400);
    echo json_encode(['sucesso' => false, 'erro' => 'Informe dois números válidos.']);
    exit;
}

$num1 = (float) $num1;
$num2 = (float) $num2;

switch ($operacao) {
    case 'soma':
        $resultado = $num1 + $num2;
        $simbolo = '+';
        break;
    case 'subtracao':
        $resultado = $num1 - $num2;
        $simbolo = '-';
        break;
    case 'multiplicacao':
        $resultado = $num1 * $num2;
        $simbolo = '×';
        break;
    case 'divisao':
        if ($num2 == 0) {
            http_response_code(400);
            echo json_encode(['sucesso' => false, 'erro' => 'Não é possível dividir por zero.']);
            exit;
        }
        $resultado = $num1 / $num2;
        $simbolo = '÷';
        break;
    default:
        http_response_code(400);
        echo json_encode(['sucesso' => false, 'erro' => 'Operação inválida.']);
        exit;
}

echo json_encode([
    'sucesso'   => true,
    'num1'      => $num1,
    'num2'      => $num2,
    'operacao'  => $operacao,
    'expressao' => "$num1 $simbolo $num2",
    'resultado' => $resultado
], JSON_UNESCAPED_UNICODE);

