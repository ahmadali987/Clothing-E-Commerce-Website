document.addEventListener('DOMContentLoaded', function() {
    const cartIcon = document.querySelector('.icon-cart');
    const cartCount = cartIcon.querySelector('span');
    const sidebar = document.querySelector('.cartTab');
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    let cartItems = [];

    // Function to update the cart count
    function updateCartCount() {
        let totalCount = 0;
        cartItems.forEach(item => {
            totalCount += item.quantity;
        });
        cartCount.textContent = totalCount;
    }

    // Function to add an item to the cart
    function addToCart(productId, title, price) {
        const existingItem = cartItems.find(item => item.productId === productId);

        if (existingItem) {
            existingItem.quantity++;
        } else {
            cartItems.push({ productId, title, price, quantity: 1 });
        }

        updateCartCount();
        displayCartItems();
        saveCartItems(); // Save cart items to local storage
    }

    // Function to decrease the quantity of an item in the cart
    function decreaseQuantity(productId) {
        const existingItem = cartItems.find(item => item.productId === productId);

        if (existingItem && existingItem.quantity > 1) {
            existingItem.quantity--;
            updateCartCount();
            displayCartItems();
            saveCartItems(); // Save updated cart items to local storage
        }
    }

    // Function to increase the quantity of an item in the cart
    function increaseQuantity(productId) {
        const existingItem = cartItems.find(item => item.productId === productId);

        if (existingItem) {
            existingItem.quantity++;
            updateCartCount();
            displayCartItems();
            saveCartItems(); // Save updated cart items to local storage
        }
    }

    // Display cart items with +/- buttons
    function displayCartItems() {
        const listCart = document.querySelector('.listCart');
        listCart.innerHTML = '';

        cartItems.forEach(item => {
            const cartItem = document.createElement('div');
            cartItem.innerHTML = `
                <div>${item.title} - Quantity: ${item.quantity}</div>
                <button class="decrease" data-product-id="${item.productId}">-</button>
                <button class="increase" data-product-id="${item.productId}">+</button>
            `;
            listCart.appendChild(cartItem);

            const decreaseButton = cartItem.querySelector('.decrease');
            const increaseButton = cartItem.querySelector('.increase');

            decreaseButton.addEventListener('click', function() {
                decreaseQuantity(item.productId);
            });

            increaseButton.addEventListener('click', function() {
                increaseQuantity(item.productId);
            });
        });
    }

    // Load cart items from local storage
    function loadCartItems() {
        const storedCart = localStorage.getItem('cartItems');
        if (storedCart) {
            cartItems = JSON.parse(storedCart);
            updateCartCount();
            displayCartItems();
        }
    }

    // Save cart items to local storage
    function saveCartItems() {
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
    }

    // Load cart items when the page loads
    loadCartItems();

    // Add event listeners to the 'Add to Cart' buttons
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productElement = this.parentElement;
            const productId = this.getAttribute('data-product-id');
            const title = productElement.querySelector('h3').textContent;
            const price = parseFloat(productElement.querySelector('p').textContent.split('$')[1]);

            addToCart(productId, title, price);
        });
    });

    // Function to toggle the sidebar
    function toggleSidebar() {
        sidebar.classList.toggle('show');
    }

    // Event listener for clicking the cart icon
    cartIcon.addEventListener('click', function() {
        toggleSidebar();
    });

    // Event listener for clicking the close button in the sidebar
    const closeButton = document.querySelector('.close');
    closeButton.addEventListener('click', function() {
        toggleSidebar();
    });

    
});
