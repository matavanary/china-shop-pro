// Main JavaScript for China Shop Pro

// Cart functionality
class CartManager {
    constructor() {
        this.updateCartCount();
    }
    
    addToCart(productId, quantity = 1) {
        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', quantity);
        
        fetch('?page=cart&action=add', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                this.updateCartCount();
                this.showNotification('Product added to cart!', 'success');
            } else {
                this.showNotification('Failed to add product to cart', 'error');
            }
        })
        .catch(error => {
            this.showNotification('An error occurred', 'error');
        });
    }
    
    updateCartCount() {
        fetch('?page=cart&action=count')
        .then(response => response.json())
        .then(data => {
            const cartBadge = document.querySelector('.cart-count');
            if (cartBadge) {
                cartBadge.textContent = data.count;
                cartBadge.classList.add('cart-badge');
                setTimeout(() => cartBadge.classList.remove('cart-badge'), 500);
            }
        })
        .catch(error => console.error('Error updating cart count:', error));
    }
    
    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} fixed top-4 right-4 z-50 max-w-sm`;
        notification.innerHTML = `
            <div class="flex items-center">
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-lg">×</button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
}

// Initialize cart manager
const cartManager = new CartManager();

// Mobile menu toggle
function toggleMobileMenu() {
    const menu = document.querySelector('.mobile-menu');
    if (menu) {
        menu.classList.toggle('active');
    }
}

// Product image gallery
function changeMainImage(imageUrl) {
    const mainImage = document.querySelector('#main-product-image');
    if (mainImage) {
        mainImage.src = imageUrl;
    }
}

// Quantity controls
function updateQuantity(input, change) {
    const currentValue = parseInt(input.value) || 1;
    const newValue = Math.max(1, currentValue + change);
    input.value = newValue;
}

// Form validation
function validateCheckoutForm() {
    const requiredFields = [
        'billing_first_name', 'billing_last_name', 'billing_email',
        'billing_phone', 'billing_address_1', 'billing_city',
        'billing_state', 'billing_postal_code', 'billing_country'
    ];
    
    let isValid = true;
    const errors = [];
    
    requiredFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field && !field.value.trim()) {
            isValid = false;
            errors.push(`${fieldName.replace('billing_', '').replace('_', ' ')} is required`);
            field.classList.add('border-red-500');
        } else if (field) {
            field.classList.remove('border-red-500');
        }
    });
    
    // Email validation
    const emailField = document.querySelector('[name="billing_email"]');
    if (emailField && emailField.value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailField.value)) {
            isValid = false;
            errors.push('Please enter a valid email address');
            emailField.classList.add('border-red-500');
        }
    }
    
    if (!isValid) {
        cartManager.showNotification(errors.join(', '), 'error');
    }
    
    return isValid;
}

// Same as billing address toggle
function toggleSameAddress() {
    const sameAsBilling = document.querySelector('#same_as_billing');
    const shippingFields = document.querySelectorAll('[name^="shipping_"]');
    const billingFields = document.querySelectorAll('[name^="billing_"]');
    
    if (sameAsBilling && sameAsBilling.checked) {
        billingFields.forEach(field => {
            const shippingFieldName = field.name.replace('billing_', 'shipping_');
            const shippingField = document.querySelector(`[name="${shippingFieldName}"]`);
            if (shippingField) {
                shippingField.value = field.value;
                shippingField.disabled = true;
            }
        });
    } else {
        shippingFields.forEach(field => {
            field.disabled = false;
        });
    }
}

// Initialize functions when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add to cart buttons
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const quantityInput = document.querySelector('#quantity');
            const quantity = quantityInput ? parseInt(quantityInput.value) : 1;
            
            cartManager.addToCart(productId, quantity);
        });
    });
    
    // Quantity controls
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const change = this.classList.contains('quantity-plus') ? 1 : -1;
            updateQuantity(input, change);
        });
    });
    
    // Same as billing address checkbox
    const sameAsBilling = document.querySelector('#same_as_billing');
    if (sameAsBilling) {
        sameAsBilling.addEventListener('change', toggleSameAddress);
    }
    
    // Form submission
    const checkoutForm = document.querySelector('#checkout-form');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            if (!validateCheckoutForm()) {
                e.preventDefault();
            }
        });
    }
    
    // Close notifications on click
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('notification-close')) {
            e.target.closest('.alert').remove();
        }
    });
});