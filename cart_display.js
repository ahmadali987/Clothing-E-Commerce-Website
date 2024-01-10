function updateQuantity(index, action) {
    // Send an AJAX request to update the quantity in the session
    // Replace 'YOUR_PHP_SCRIPT_URL' with the actual URL that handles quantity updates
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_quantity.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Quantity updated successfully, update the displayed quantity
                var quantitySpan = document.getElementById('quantity_' + index);
                var currentQuantity = parseInt(quantitySpan.textContent);

                if (action === 'increase') {
                    quantitySpan.textContent = currentQuantity + 1;
                } else if (action === 'decrease' && currentQuantity > 1) {
                    quantitySpan.textContent = currentQuantity - 1;
                }
            } else {
                // Handle errors if any
                console.error('Error: ' + xhr.status);
            }
        }
    };

    // Prepare data to send to PHP script
    var data = 'index=' + index + '&action=' + action;
    xhr.send(data);
}

function removeItem(index) {
    if (confirm('Are you sure you want to remove this item from the cart?')) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'remove_product.php?index=' + index, true);
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    window.location.reload(); // Reload the page after successful removal
                } else {
                    console.error('Error: ' + xhr.status);
                }
            }
        };

        xhr.send();
    }
}