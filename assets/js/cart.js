let amount = document.getElementById('amount');
let products = document.querySelectorAll('.product');

products.forEach(p => {
    amount.innerText = parseFloat(amount.innerText) + parseFloat(p.querySelector('.product-price').innerText);
})