<?php

use function PHPSTORM_META\type;

require 'MatrixCalculator.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['action'])) {
        echo json_encode(['success' => false, 'error' => 'Відсутній тип операції']);
    }
    try {
        $action = $_POST['action'];
        
        switch ($action) {
            case 'generate_forms':
                echo json_encode(generateFormsRequest());
                break;
            case 'calculate':
                echo json_encode(calculateRequest());
                break;
            default:
                throw new Exception("Невідома дія");
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Некоректний запит']);
}

function generateFormsRequest(): array {
    $rowsA = intval($_POST['rowsA'] ?? 0);
    $colsA = intval($_POST['colsA'] ?? 0);
    
    $rowsB = intval($_POST['rowsB'] ?? 0);
    $colsB = intval($_POST['colsB'] ?? 0);

    $resultsA = validateSizes($rowsA, $colsA);
    if (!$resultsA['success']) {
        $resultsA['error'] = "Матриця A: " . $resultsA['error'];
        return $resultsA;
    }

    $resultsB = validateSizes($rowsB, $colsB);
    if (!$resultsB['success']) {
        $resultsB['error'] = "Матриця B: " . $resultsB['error'];
        return $resultsB;
    }
    
    $matrixA = array_map(fn() => array_map(fn() => rand(-100, 100), range(1, $colsA)), range(1, $rowsA));
    $matrixB = array_map(fn() => array_map(fn() => rand(-100, 100), range(1, $colsB)), range(1, $rowsB));
    
    return ['success' => true, 'matrixA' => $matrixA, 'matrixB' => $matrixB];
}

function calculateRequest(): array {
    $matrixA = json_decode($_POST['matrixA']);
    $rowsA = intval($_POST['rowsA'] ?? 0);
    $colsA = intval($_POST['colsA'] ?? 0);
    
    $matrixB = json_decode($_POST['matrixB']);
    $rowsB = intval($_POST['rowsB'] ?? 0);
    $colsB = intval($_POST['colsB'] ?? 0);

    $operation = $_POST['operation'] ?? '';

    // return [
    //     'matrixA' => $matrixA,
    //     'matrixA_isarray' => is_array($matrixA),
    //     'rowsA' => $rowsA,
    //     'colsA' => $colsA,
    //     'matrixB' => $matrixB,
    //     'matrixB_isarray' => is_array($matrixB),
    //     'rowsB' => $rowsB,
    //     'colsB' => $colsB,
    //     'operation' => $operation,
    //     'operation_in_array' => in_array($operation, ["add", "sub", "mult", "transpA", "transpB"])
    // ];

    if (!in_array($operation, ["add", "sub", "mult", "transpA", "transpB"])) {
        return ['success' => false, 'error' => "Невідома операція"];
    }

    // return [
    //     'matrixA' => $matrixA,
    //     'rowsA' => $rowsA,
    //     'colsA' => $colsA,
    //     'matrixB' => $matrixB,
    //     'rowsB' => $rowsB,
    //     'colsB' => $colsB,
    // ];
    $matrixCalculator = new MatrixCalculator($matrixA, $rowsA, $colsA, $matrixB, $rowsB, $colsB);

    try {
        return [
            'success' => true,
            'result' => performOperation($matrixCalculator, $operation)
        ];
    }
    catch (Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage(),
            'matrixA' => $matrixCalculator->getMatrixA(),
            'rowsA' => $matrixCalculator->getRowsA(),
            'colsA' => $matrixCalculator->getColsA(),
            'matrixB' => $matrixCalculator->getMatrixB(),
            'rowsB' => $matrixCalculator->getRowsB(),
            'colsB' => $matrixCalculator->getColsB(),
        ];
    }
}


function validateSizes(int $rows, int $cols, int $min = 1, int $max = 10): array {
    if($min > $rows) {
        return ['success' => false, 'error' => "Кількість рядків не може бути меншою за {$min}"];
    }

    if($min > $cols) {
        return ['success' => false, 'error' => "Кількість стовпців не може бути меншою за {$min}"];
    }

    if($max < $rows) {
        return ['success' => false, 'error' => "Кількість рядків не може бути більшою за {$max}"];
    }
    
    if($max < $cols) {
        return ['success' => false, 'error' => "Кількість стовпців не може бути більшою за {$max}"];
    }

    return ['success' => true, 'rows' => $rows, 'cols' => $cols];
}

function compareSizes(int $rowsA, int $colsA, int $rowsB, int $colsB) {
    if ($rowsA != $rowsB || $colsA != $colsB) {
        return ['success' => false, 'error' => "Матриці мають бути одного розміру"];
    }

    return ['success' => true, 'rowsA' => $rowsA, 'colsA' => $colsA, 'rowsB' => $rowsB, 'colsB' => $colsB];
}

function performOperation(MatrixCalculator $matrixCalc, string $operation): array {
    $result = [];

    if ($operation == "add") {
        $result = $matrixCalc->add();
    }
    elseif ($operation == "sub") {
        $result = $matrixCalc->subtract();
    }
    elseif ($operation == "mult") {
        $result = $matrixCalc->multiply();
    }
    elseif ($operation == "transpA") {
        $result = $matrixCalc->transposeA();
    }
    elseif ($operation == "transpB") {
        $result = $matrixCalc->transposeB();
    }

    return $result;
}