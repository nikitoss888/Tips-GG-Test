<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tips.GG Test</title>
    <link rel="stylesheet" href="styles.css"/>
</head>
<body class="flex flex-column">
    <header>
        <h1>Матричний калькулятор</h1>
    </header>
    <main>
        <form id="matricesForm">
            <div class="flex flex-column">
                <div class="flex flex-row">
                    <div class="flex flex-column">
                        <h3>Розміри матриці А:</h3>
                        <div>
                            <label>
                                Рядків:
                                <input type="number" id="rowsA" name="rowsA"
                                    min="1" max="10" value="1" required/>
                            </label>
                            <label>
                                Стовпців:
                                <input type="number" id="colsA" name="colsA"
                                    min="1" max="10" value="1" required/>
                            </label>
                        </div>
                    </div>
                    <div>
                        <h3>Розміри матриці B:</h3>
                        <label>
                            Рядків:
                            <input type="number" id="rowsB" name="rowsB"
                                min="1" max="10" value="1" required/>
                        </label>
                        <label>
                            Стовпців:
                            <input type="number" id="colsB" name="colsB"
                                min="1" max="10" value="1" required/>
                        </label>
                    </div>
                </div>
                <button type="button" onclick="generateForms()">Згенерувати матриці</button>
                
                <div id="matricesInputs" class="flex flex-row hide">
                    <div id='matrixAInputs' class="flex flex-column"></div>
                    <div id='matrixBInputs' class="flex flex-column"></div>
                </div>

                <label class="flex flex-column">
                    <h3>Операція:</h3>
                    <select id="operation">
                        <option value="add">Додавання</option>
                        <option value="sub">Віднімання</option>
                        <option value="mult">Множення</option>
                        <option value="transpA">Транспонування матриці A</option>
                        <option value="transpB">Транспонування матриці B</option>
                    </select>
                </label>

                <div class="flex flex-row buttons">
                    <button type="button" onclick="calculate()" id="calcButton" hidden>Обчислити</button>
                    <button type="button" onclick="formReset()" id="resetButton">Очистити</button>
                </div>

                <div class="flex flex-row hide">
                    <div id='results' class="flex flex-column"></div>
                </div>
            </div>
        </form>
    </main>
    <footer class="flex flex-row">
        <p>&copy; Oleksiichuk Mykyta</p>
        <p>
            Github:
            <a href="https://github.com/nikitoss888/Tips-GG-Test">nikitoss888/Tips-GG-Test</a>
        </p>
        <p>26 Feb - 01 March 2025</p>
    </footer>
    <script src='script.js'></script>
</body>
</html>
