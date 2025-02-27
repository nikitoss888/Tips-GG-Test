<?php
class MatrixCalculator {
    private array $matrixA;
    private array $matrixB;

    private int $rowsA;
    private int $rowsB;
    private int $colsA;
    private int $colsB;

    public function __construct(
        array $matrixA,
        int $rowsA,
        int $colsA,
        array $matrixB,
        int $rowsB,
        int $colsB)
    {
        $this->setMatrixA($matrixA, $rowsA, $colsA);
        $this->setMatrixB($matrixB, $rowsB, $colsB);
    }

    private function validateMatrix(array $matrix, int $rows, int $cols): array {
        $result = [true, ""];

        if(count($matrix) !== $rows) {
            return [false, "Кількість рядків не відповідає заданій"];
        }

        $rowNum = 1;
        foreach ($matrix as $row) {
            if (!is_array($row)) {
                $result = [false, "Рядок {$rowNum} має бути масивом чисел"];
                break;
            }

            if (count($row) !== $cols) {
                $result = [false, "Кількість стовпців у рядку {$rowNum} не відповідає заданій"];
                break;
            }

            if (!array_reduce($row, fn($carry, $item) => $carry && is_numeric($item), true)) {
                $result = [false, "У рядку {$rowNum} присутні відмінні від чисел значення"];
                break;
            }
            
            $rowNum++;
        }

        return $result;
    }

    public function setMatrixA(array $matrixA, int $rowsA, int $colsA): void {
        $results = $this->validateMatrix($matrixA, $rowsA, $colsA);

        if (!$results[0]) {
            throw new Exception("Матриця A: " . $results[1]);
        }
        
        $this->matrixA = $matrixA;
        $this->rowsA = $rowsA;
        $this->colsA = $colsA;
    }

    public function setMatrixB(array $matrixB, int $rowsB, int $colsB): void {
        $results = $this->validateMatrix($matrixB, $rowsB, $colsB);

        if (!$results[0]) {
            throw new Exception("Матриця B: " . $results[1]);
        }

        $this->matrixB = $matrixB;
        $this->rowsB = $rowsB;
        $this->colsB = $colsB;
    }

    public function getMatrixA(): array {
        return $this->matrixA;
    }

    public function getMatrixB(): array {
        return $this->matrixB;
    }

    public function getRowsA(): int {
        return $this->rowsA;
    }

    public function getColsA(): int {
        return $this->colsA;
    }

    public function getRowsB(): int {
        return $this->rowsB;
    }

    public function getColsB(): int {
        return $this->colsB;
    }

    private function checkSizes() {
        if ($this->rowsA !== $this->rowsB || $this->colsA !== $this->colsB) {
            throw new Exception("Матриці мають різні розміри");
        }
    }

    public function add(): array {
        $this->checkSizes();

        $result = [];
        for ($i = 0; $i < $this->rowsA; $i++) {
            for ($j = 0; $j < $this->colsA; $j++) {
                $result[$i][$j] = $this->matrixA[$i][$j] + $this->matrixB[$i][$j];
            }
        }

        return $result;
    }

    public function subtract(): array {
        $this->checkSizes();

        $result = [];
        for ($i = 0; $i < $this->rowsA; $i++) {
            for ($j = 0; $j < $this->colsA; $j++) {
                $result[$i][$j] = $this->matrixA[$i][$j] - $this->matrixB[$i][$j];
            }
        }

        return $result;
    }

    public function multiply(): array {
        if ($this->colsA !== $this->rowsB) {
            throw new Exception(
                "Кількість стовпців матриці A ({$this->colsA})
                має дорівнювати кількості рядків матриці B ({$this->rowsB})");
        }

        $result = array_fill(0, $this->rowsA, array_fill(0, $this->colsB, 0));

        for ($i = 0; $i < $this->rowsA; $i++) {
            for ($j = 0; $j < $this->colsB; $j++) {
                for ($k = 0; $k < $this->colsA; $k++) {
                    $result[$i][$j] += $this->matrixA[$i][$k] * $this->matrixB[$k][$j];
                }
            }
        }

        return $result;
    }

    public function transposeA(): array {
        return $this->transpose($this->matrixA, $this->rowsA, $this->colsA);
    }

    public function transposeB(): array {
        return $this->transpose($this->matrixB, $this->rowsB, $this->colsB);
    }

    private function transpose(array $matrix, int $rows, int $cols): array {
        $result = [];

        for ($i = 0; $i < $cols; $i++) {
            for ($j = 0; $j < $rows; $j++) {
                $result[$i][$j] = $matrix[$j][$i];
            }
        }
        
        return $result;
    }
}
