document.querySelectorAll('input[type="number"]').forEach(input => {
    input.addEventListener('input', () => {
        const min = parseFloat(input.min);
        const max = parseFloat(input.max);
        const value = parseFloat(input.value);
        
        if (!isNaN(min) && value < min) input.value = min;
        if (!isNaN(max) && value > max) input.value = max;
    });
});

const rowsAInput = document.getElementById('rowsA');
const colsAInput = document.getElementById('colsA');
let rowsA;
let colsA;

const rowsBInput = document.getElementById('rowsB');
const colsBInput = document.getElementById('colsB');
let rowsB;
let colsB;

const operationInput = document.getElementById('operation');
let operation;


function sendRequest(action, data, callback) {
    fetch('process.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({ 'action': action, ...data })
    })
    .then(response => response.json())
    .then(result => callback(result))
    .catch(error => console.error('Помилка:', error));
}


function generateForms() {
    rowsA = rowsAInput.value;
    colsA = colsAInput.value;
    
    rowsB = rowsBInput.value;
    colsB = colsBInput.value;

    operation = operationInput.value;

    sendRequest('generate_forms', {
        'rowsA': rowsA,
        'colsA': colsA,
        'rowsB': rowsB,
        'colsB': colsB,
        'operation': operation,
    }, function(response) {
        console.log("generateForms_response:", response);

        if (response.success) {
            showCalculateForm(response.matrixA, response.matrixB)
        }
        else {
            alert(response.error);
        }
    })
}

function calculate() {
    operation = operationInput.value;

    matrixA = fillMatrix('matrixA[][]', rowsA, colsA);
    matrixB = fillMatrix('matrixB[][]', rowsB, colsB);

    sendRequest('calculate', {
        'matrixA': JSON.stringify(matrixA),
        'rowsA': rowsA,
        'colsA': colsA,
        'matrixB': JSON.stringify(matrixB),
        'rowsB': rowsB,
        'colsB': colsB,
        'operation': operation
    }, function(response) {
        console.log('calculate_response:', response)
        if (response.success) {
            showResults(response.result)
        }
        else {
            alert(response.error)
        }
    })
}

function formReset() {
    document.getElementById('matricesInputs').classList.add('hide');
    document.getElementById('results').parentElement.classList.add('hide');

    document.getElementById('matrixAInputs').innerHTML = "";
    document.getElementById('matrixBInputs').innerHTML = "";
    
    document.getElementById('calcButton').hidden = true;
    rowsAInput.disabled = colsAInput.disabled = rowsBInput.disabled = colsBInput.disabled = false;
    
    document.getElementById('results').innerHTML = "";

    rowsAInput.value = colsAInput.value = rowsBInput.value = colsBInput.value = 1;
    operationInput.value = 'add';
}



function showCalculateForm(matrixA, matrixB) {
    document.getElementById('matricesInputs').classList.remove('hide');
    document.getElementById('matrixAInputs').innerHTML = generateMatrixInputs(matrixA, "A");
    document.getElementById('matrixBInputs').innerHTML = generateMatrixInputs(matrixB, "B");
    
    document.getElementById('calcButton').hidden = false;
    rowsAInput.disabled = colsAInput.disabled = rowsBInput.disabled = colsBInput.disabled = true;
}

function generateMatrixInputs(matrix, type) {
    let rows = matrix.length
    let cols = matrix[0].length

    let html = `<h3>Матриця ${type}</h3>`;
    html += '<table>';
    html += '<tr><td/>'

    for (let i = 0; i < cols; i++) {
        html += `<td class='index'>#${i + 1}</td>`;
    }

    html += '</tr>';

    for (let i = 0; i < rows; i++) {
        html += `<tr><td class='index'>#${i + 1}</td>`;
        for (let j = 0; j < cols; j++) {
            html += `<td><input type='number' name='matrix${type}[][]' value=${matrix[i][j]} required></td>`;
        }
        html += '</tr>';
    }
    html += '</table>';
    return html;
}

function fillMatrix(name, rows, cols) {
    let inputs = document.getElementsByName(name);

    let matrix = []
    for (let i = 0; i < rows; i++) {
        matrix[i] = []
        for (let j = 0; j < cols; j++) {
            matrix[i][j] = inputs[i * cols + j].value
        }
    }

    return matrix;
}

function showResults(matrix) {
    let rows = matrix.length
    let cols = matrix[0].length

    let html = `<h3>Результат операції</h3>`;
    html += '<table>';
    html += '<tr><td/>'

    for (let i = 0; i < cols; i++) {
        html += `<td class='index'>#${i + 1}</td>`;
    }

    html += '</tr>';

    for (let i = 0; i < rows; i++) {
        html += `<tr><td class='index'>#${i + 1}</td>`;
        for (let j = 0; j < cols; j++) {
            html += `<td>${matrix[i][j]}</td>`;
        }
        html += '</tr>';
    }
    html += '</table>';
    
    document.getElementById('results').innerHTML = html;
    document.getElementById('results').parentElement.classList.remove('hide');
}
