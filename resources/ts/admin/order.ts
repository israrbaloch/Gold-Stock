import { addCommas, removeFormat } from "../exchange/utils";

declare const productOrder: any;
declare const products: any[];
declare const currencies: { [key: string]: any };
declare const metals: { [key: string]: any };
declare const currentProducts: any[];
declare const shippingOptions: any[];

$(function () {
    $('#currency').on('change', onCurrencyChange);
    $('#shipping_option').on('change', onShippingChange);

    $('#add-product').on('click', () => {
        addProduct();
    });

    if (currentProducts && currentProducts.length > 0) {
        currentProducts.forEach((product: any) => {
            addProduct();
            const tr = $('#products-table tr').last();
            tr.find('select').val(product.id);
            tr.find('input[name="type[]"]').val(product.type);
            tr.find('input[name="weight[]"]').val(product.weight);
            tr.find('input[name="price[]"]').val(product.price);
            tr.find('input[name="quantity[]"]').val(product.quantity);
            tr.find('.total').val(product.total);
        });
        calculate();
    } else {
        addProduct();
    }
})

function addProduct() {
    const productsTable = $('#products-table');
    const tr = document.createElement('tr');
    const index = productsTable.find('tr').length.toString();
    tr.dataset.index = index;

    const productTD = document.createElement('td');
    const select = document.createElement('select');
    select.name = 'product_id[]';
    select.className = 'form-control';
    select.dataset.type = 'product';
    select.onchange = onSelectedProduct;
    select.dataset.index = index;


    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.innerText = 'Select Product';
    select.appendChild(defaultOption);
    products.forEach((product: any) => {
        const option = document.createElement('option');
        option.value = product.id;
        option.innerText = product.name;
        option.dataset.price = product.price;
        select.appendChild(option);
    });
    productTD.appendChild(select);
    tr.appendChild(productTD);


    const typeTD = document.createElement('td');
    const typeInput = document.createElement('input');
    typeInput.type = 'text';
    typeInput.name = 'type[]';
    typeInput.className = 'form-control';
    typeInput.disabled = true;
    typeTD.appendChild(typeInput);
    tr.appendChild(typeTD);

    const weightTD = document.createElement('td');
    const weightInput = document.createElement('input');
    weightInput.type = 'text';
    weightInput.name = 'weight[]';
    weightInput.className = 'form-control';
    weightInput.disabled = true;
    weightTD.appendChild(weightInput);
    tr.appendChild(weightTD);

    const priceTD = document.createElement('td');
    const priceInput = document.createElement('input');
    priceInput.type = 'text';
    priceInput.name = 'price[]';
    priceInput.className = 'form-control';
    priceInput.onchange = onCurrencyChange;
    priceInput.dataset.type = 'price';
    priceTD.appendChild(priceInput);
    tr.appendChild(priceTD);


    const quantityTD = document.createElement('td');
    const quantityInput = document.createElement('input');
    quantityInput.type = 'number';
    quantityInput.name = 'quantity[]';
    quantityInput.min = '1';
    quantityInput.value = '1';
    quantityInput.className = 'form-control';
    quantityInput.style.width = '75px';
    quantityInput.dataset.index = index;
    quantityInput.dataset.type = 'quantity';
    quantityInput.step = '1';
    quantityInput.onchange = onQuantityChange;
    quantityTD.appendChild(quantityInput);
    tr.appendChild(quantityTD);


    const totalTD = document.createElement('td');
    const totalInput = document.createElement('input');
    totalInput.type = 'text';
    totalInput.name = 'total[]';
    totalInput.className = 'form-control total';
    totalInput.disabled = true;
    totalTD.appendChild(totalInput);
    tr.appendChild(totalTD);

    const removeTD = document.createElement('td');
    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.className = 'btn btn-danger';
    removeButton.innerText = 'x';
    removeButton.onclick = () => {
        removeProduct({ target: { dataset: { index } } });
    };
    removeTD.appendChild(removeButton);
    tr.appendChild(removeTD);

    productsTable.append(tr);
}

function removeProduct(event: any) {
    if (!confirm('Are you sure you want to remove this product?')) {
        return;
    }
    const productsTable = $('#products-table');
    if (productsTable.find('tr').length > 1) {
        const index = event.target.dataset.index;
        $(`#products-table tr[data-index="${index}"]`).remove();
        calculate();
    }
}

function onSelectedProduct(event: any) {
    const index = event.target?.dataset?.index;
    calculate(false, Number(index));
}

function onQuantityChange(event: any) {
    // set integer value
    event.target.value = Math.floor(Number(event.target.value)).
        toString().replace(/[^0-9]/g, '');

    calculate();
}

function onCurrencyChange(event: any) {
    calculate();
}

function onShippingChange(event: any) {
    calculate();
}

function calculate(original = true, _index?: number) {
    $('#products-table tr').each((index, _tr) => {
        const tr = $(_tr);
        const productId = tr.find('select').val();

        const product = products.find((product: any) => product.id == productId);
        if (!product) {
            return;
        }

        const totalTD = tr.find('.total');
        const quantity = Number(tr.find('input[name="quantity[]"]').val());
        const price = removeFormat(tr.find('input[name="price[]"]').val() as string);

        if (!original && _index == index) {

            const _currency = $('#currency').val() as string;
            const currency = currencies[_currency.toLowerCase()];
            let metalPrice;
            switch (product.metal_id) {
                case 1183:
                    // gold
                    metalPrice = metals['gold'].value;
                    break;
                case 1677:
                    // silver
                    metalPrice = metals['silver'].value;
                    break;
                case 1681:
                    // platinum
                    metalPrice = metals['platinum'].value;
                    break;
                case 1682:
                    // palladium
                    metalPrice = metals['palladium'].value;
                    break;
            }

            const priceInput = tr.find('input[name="price[]"]');
            priceInput.val(product.weight_oz * metalPrice * currency.value);

            totalTD.val('$' + addCommas(product.weight_oz * quantity * metalPrice * currency.value));
        } else {
            totalTD.val('$' + addCommas(quantity * price));
        }

        const typeInput = tr.find('input[name="type[]"]');
        typeInput.val(product.type);

        const weightInput = tr.find('input[name="weight[]"]');
        weightInput.val(product.weight);

    })

    let tableTotalText = $('#subtotal').text(); // Initial value is a string
    let tableTotal = 0; // Declare explicitly as a number
    
    if (tableTotalText) {
        tableTotal = parseFloat(tableTotalText.replace(/,/g, '').replace('$', ''));
        if (isNaN(tableTotal)) {
            console.error('Invalid table total value:', tableTotal);
            tableTotal = 0; // Fallback to 0 if invalid
        }
    } else {
        console.error('Subtotal element not found or empty');
        tableTotal = 0; // Fallback to 0 if not found
    }    
    
    // $('#products-table tr').each((index, tr) => {
    //     tableTotal += Number(($(tr).find('.total').val() as string).replace(/,/g, '').replace('$', ''));
    // });

    const shippingOption = Number($('#shipping_option').val());

    const shipping = shippingOptions.find((option: any) => option.id == shippingOption);

    const shippingPrice = shipping && tableTotal < shipping.free_from ? 0 : shipping.price;

    $('#shipping_service').val(addCommas(shippingPrice));

    // .shipping_service_fee
    $('.shipping_service_fee').text('$' + addCommas(shippingPrice));

    tableTotal += shippingPrice;

    // grandTotal
    $('#grandTotal').text(addCommas(tableTotal));

    const deposit = Number((Math.floor(tableTotal * 0.1 * 100) / 100).toFixed(2));
    $('#deposit').val('$' + addCommas(deposit));

    const fee = Number((Math.floor(deposit * 0.0375 * 100) / 100).toFixed(2));
    $('#fee').val('$' + addCommas(fee));

    const total = tableTotal + fee;
    $('#total').val('$' + addCommas(total));

    const outstanding = total - productOrder.payed;
    $('#outstanding').val('$' + addCommas(outstanding));


}