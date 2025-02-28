<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tips.GG Test</title>
    <link rel="stylesheet" href="styles.css"/>
</head>
<body>
    <h1>Матричний калькулятор</h1>
    <form id="matricesForm">
        <div>
            <p>Введіть розміри матриці А:</p>
            <label>
                Кількість рядків:
                <input type="number" id="rowsA" name="rowsA" min="1" max="10" value="1" required/>
            </label>
            <label>
                Кількість стовпців:
                <input type="number" id="colsA" name="colsA" min="1" max="10" value="1" required/>
            </label>
        </div>
        <div>
            <p>Введіть розміри матриці B:</p>
            <label>
                Кількість рядків:
                <input type="number" id="rowsB" name="rowsB" min="1" max="10" value="1" required/>
            </label>
            <label>
                Кількість стовпців:
                <input type="number" id="colsB" name="colsB" min="1" max="10" value="1" required/>
            </label>
        </div>
        <div>
            <label>
                <p>Виберіть операцію:
                    <select id="operation">
                        <option value="add">Додавання</option>
                        <option value="sub">Віднімання</option>
                        <option value="mult">Множення</option>
                        <option value="transpA">Транспонування матриці A</option>
                        <option value="transpB">Транспонування матриці B</option>
                    </select>
                </p>
            </label>
        </div>
        <button type="button" onclick="generateForms()">Згенерувати форми</button>
        
        <div id='matrixAInputs'></div>
        <div id='matrixBInputs'></div>
        <button type="button" onclick="calculate()" id="calcButton" hidden>Обчислити</button>
        <div id='results'></div>
        <button type="button" onclick="formReset()" id="resetButton">Очистити</button>
    </form>
    <script src='script.js'></script>
</body>
</html>