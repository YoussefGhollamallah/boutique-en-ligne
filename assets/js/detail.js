function changeQuantity(amount) {
    var input = document.getElementById('quantite');
    var currentValue = parseInt(input.value);
    var newValue = currentValue + amount;
    if (newValue >= parseInt(input.min) && newValue <= parseInt(input.max)) {
        input.value = newValue;
    }
}