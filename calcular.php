<?php
// Avisa o navegador que a resposta é JSON (e não HTML)
header("Content-Type: application/json; charset=utf-8");

$v1 = $_GET["a"] ?? "";
$v2 = $_GET["b"] ?? "";
$op = $_GET["op"] ?? "";

// Valida se a e b são números
if (!is_numeric($v1) || !is_numeric($v2)) {
    echo json_encode(["sucesso" => false, "erro" => "Informe números válidos em a e b."]);
    exit;
}

$v1 = (float) $v1;
$v2 = (float) $v2;

// Faz o cálculo de acordo com o operador
switch ($op) {
    case "+":
        $result = $v1 + $v2;
        break;
    case "-":
        $result = $v1 - $v2;
        break;
    case "*":
        $result = $v1 * $v2;
        break;
    case "/":
        if ($v2 == 0) {
            echo json_encode(["sucesso" => false, "erro" => "Não é possível dividir por zero."]);
            exit;
        }
        $result = $v1 / $v2;
        break;
    default:
        echo json_encode(["sucesso" => false, "erro" => "Operador inválido. Use +, -, * ou /."]);
        exit;
}

// Devolve o resultado em JSON
echo json_encode([
    "sucesso"   => true,
    "a"         => $v1,
    "b"         => $v2,
    "op"        => $op,
    "resultado" => round($result, 10)
]);
?>
