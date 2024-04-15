
  //************************ */
/*
  // Contador para generar IDs únicos
let rowCount = 1;
let newPriceId = '';
// Agregar nueva fila al hacer clic en el botón
document.getElementById("add-row").addEventListener('click', function () {
    var lastRow = document.getElementById('tablaProductos').querySelector('tbody tr:last-child');
    var newRow = lastRow.cloneNode(true);

    // Incrementar el contador y generar un nuevo ID único para el campo de precio
    rowCount++;
    let newPriceId = 'price' + rowCount;
    newRow.querySelector('#price').id = newPriceId;

    // Limpiar los valores de los inputs en la nueva fila
    newRow.querySelectorAll('input').forEach(function (input) {
        input.value = '';
    });

    document.getElementById('tablaProductos').querySelector('tbody').appendChild(newRow);
});
*/
// Agregar nueva fila al hacer clic en el botón
document.getElementById("add-row").addEventListener('click', function () {
    var lastRow = document.getElementById('tablaProductos').querySelector('tbody tr:last-child');
    var newRow = lastRow.cloneNode(true);

    // Limpiar los valores de los inputs en la nueva fila
    newRow.querySelectorAll('input').forEach(function (input) {
        input.value = '';
    });

    document.getElementById('tablaProductos').querySelector('tbody').appendChild(newRow);
});

// Eliminar fila al hacer clic en el botón
document.getElementById('tablaProductos').addEventListener('click', function (e) {
    if (e.target.classList.contains("delete-row")) {
        e.preventDefault();
        e.target.closest('tr').remove();
        calculateTotal(); // Recalcular totales al eliminar una fila
    }
});

// Eliminar fila al hacer clic en el botón
document.getElementById('tablaProductos').addEventListener('click', function (e) {
    if (e.target.classList.contains("delete-row")) {
        e.preventDefault();
        e.target.closest('tr').remove();
        calculateTotal(); // Recalcular totales al eliminar una fila
    }
});
// Calcular subtotal al cambiar la cantidad o el precio unitario
document.getElementById('tablaProductos').addEventListener('change', function (e) {
    if (e.target.classList.contains('calculate')) {
        updateTotals(e.target);
        calculateTotal();
    }
});

// Calcular totales al cargar la página
// calculateTotal();

// Crear factura al hacer clic en el botón
document.getElementById("create-invoice").addEventListener('click', function () {
    createInvoice();
});


function updateTotals(elem) {
var tr = elem.closest('tr'),
    quantity = tr.querySelector('[data-name="invoice_product_qty"]').value,
    price = tr.querySelector('[data-name="invoice_product_price"]').value,
    isPercent = tr.querySelector('[data-name="invoice_product_discount"]').value.indexOf('%') > -1,
    percent = tr.querySelector('[data-name="invoice_product_discount"]').value.replace('%', '').trim(),
    subtotal = parseInt(quantity) * parseFloat(price);

if (percent && !isNaN(percent) && percent !== 0) {
    if (isPercent) {
        subtotal = subtotal - ((parseFloat(percent) / 100) * subtotal);
    } else {
        subtotal = subtotal - parseFloat(percent);
    }
} else {
    tr.querySelector('[data-name="invoice_product_discount"]').value = '';
}

tr.querySelector('.calculate-sub').value = isNaN(subtotal) ? '0.00' : subtotal.toFixed(2);
}

function calculateTotal() {
let grandTotal = 0;
let totalDiscount = 0;  // Agrega esta línea para declarar la variable
let vatRate = 0.16; // Porcentaje de IVA

document.querySelectorAll('#tablaProductos tbody tr').forEach(function (row) {
    let c_sbt = parseFloat(row.querySelector('.calculate-sub').value),
        quantity = parseInt(row.querySelector('[data-name="invoice_product_qty"]').value),
        price = parseFloat(row.querySelector('[data-name="invoice_product_price"]').value) || 0,
        subtotal = quantity * price;

    //grandTotal += parseFloat(c_sbt);
   // disc += subtotal - parseFloat(c_sbt);
   grandTotal += isNaN(c_sbt) ? 0 : c_sbt;
let discountInput = row.querySelector('[data-name="invoice_product_discount"]');
let isPercent = discountInput.value.indexOf('%') > -1;
let percent = discountInput.value.replace('%', '').trim();

if (isPercent && !isNaN(percent) && percent !== 0) {
totalDiscount += (parseFloat(percent) / 100) * subtotal;
}
    
     
});

// Obtener el valor del IVA del campo de entrada
// let vat = parseFloat(document.getElementById('invoice-vat-input').value) || 0;
let vat = grandTotal * vatRate;


// VAT, DISCOUNT, SHIPPING, TOTAL, SUBTOTAL:
let subT = parseFloat(grandTotal),
//finalTotal = parseFloat(grandTotal);
finalTotal = (grandTotal + vat) - totalDiscount;

console.log(totalDiscount);
document.querySelector('.invoice-discount').textContent = isNaN(totalDiscount) ? '0.00' : totalDiscount.toFixed(2);
document.querySelector('.invoice-sub-total').textContent = isNaN(subT) ? '0.00' : subT.toFixed(2);


// Agregar el IVA al total final
//finalTotal += vat;
document.querySelector('.invoice-total').textContent = isNaN(finalTotal) ? '0.00' : finalTotal.toFixed(2);
document.querySelector('.invoice-vat').textContent = isNaN(vat) ? '0.00' : vat.toFixed(2);

}

