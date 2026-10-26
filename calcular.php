<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    header("Content-Type: application/json");

    $json = file_get_contents("php://input");

    $dados = json_decode($json, true);

    $numero1 = $dados["numero1"];
    $numero2 = $dados["numero2"];
    $operacao = $dados["operacao"];

    switch ($operacao) {

        case "soma":
            $resultado = $numero1 + $numero2;
            break;

        case "subtracao":
            $resultado = $numero1 - $numero2;
            break;

        case "multiplicacao":
            $resultado = $numero1 * $numero2;
            break;

        case "divisao":
            if ($numero2 == 0) {
                $resultado = "Divisão por zero!";
            } else {
                $resultado = $numero1 / $numero2;
            }
            break;

        default:
            $resultado = "Operação inválida";
    }

    echo json_encode([
        "resultado" => $resultado
    ]);

    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Calculadora</title>
</head>
<body>

    <h1>Calculadora</h1>

    <input type="number" id="numero1"
           placeholder="Primeiro número">

    <input type="number" id="numero2"
           placeholder="Segundo número">

    <select id="operacao">
        <option value="soma">Somar</option>
        <option value="subtracao">Subtrair</option>
        <option value="multiplicacao">Multiplicar</option>
        <option value="divisao">Dividir</option>
    </select>

    <button onclick="calcular()">Calcular</button>

    <h2 id="resultado"></h2>

    <script>
        function calcular() {

            let campo1 = document.getElementById("numero1").value;
            let campo2 = document.getElementById("numero2").value;

            if (campo1 === "" || campo2 === "") {
                document.getElementById("resultado").innerText =
                    "Preencha os dois números.";
                return;
            }

            let numero1 = Number(campo1);
            let numero2 = Number(campo2);

            let operacao =
                document.getElementById("operacao").value;

            let dados = {
                numero1: numero1,
                numero2: numero2,
                operacao: operacao
            };

            fetch("index.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(dados)
            })
            .then(resposta => resposta.json())
            .then(dados => {
                document.getElementById("resultado").innerText =
                    "Resultado: " + dados.resultado;
            })
            .catch(erro => {
                console.error(erro);
                document.getElementById("resultado").innerText =
                    "Erro ao calcular.";
            });
        }
    </script>

</body>
</html>
