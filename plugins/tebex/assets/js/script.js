// Learn Template literals: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Template_literals
// Learn about Modal: https://getbootstrap.com/docs/5.0/components/modal/
var modalWrap = null;
/**
 *
 * @param {string} title
 * @param {string} description content of modal body
 * @param {string} yesBtnLabel label of Yes button
 * @param {string} noBtnLabel label of No button
 * @param {string} product_id product id for callback
 * @param {string} price product price
 */

// Function to add an item to the cart
function addToCart(packageId, quantity = 1) {
  // Create cart data with username if it's set
  const cartData = {
    package_id: packageId,
    quantity: quantity
  };

  // If username is set (from modal input or logged in user), include it
  if (pseudo && pseudo.trim() !== '') {
    cartData.username = pseudo.trim();
  }

  fetch(window.cartAddApi, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify(cartData)
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  })
  .then(data => {
    if (data.success) {
      // Update cart badge
      updateCartBadge(data.cart.count);

      // Show success message with bootstrap toast
      showBootstrapToast('Success!', 'Item added to cart.', 'success', true);
    }
  })
  .catch(error => {
    console.error('Error adding to cart:', error);
    // Show error message with bootstrap toast
    showBootstrapToast('Error', 'There was a problem adding this item to your cart.', 'danger');
  });

  // Close the original modal
  var productModal = bootstrap.Modal.getInstance(document.getElementById('exampleModal'));
  if (productModal) {
    productModal.hide();
  }
}

// Function to update the cart badge count
function updateCartBadge(count) {
  const badge = document.getElementById('cart-count-badge');
  if (badge) {
    badge.textContent = count;
    badge.style.display = count > 0 ? 'inline-block' : 'none';
  }
}

// Function to show Bootstrap toasts for notifications
function showBootstrapToast(title, message, type = 'success', withCartButton = false) {
  // Create a unique ID for this toast
  const toastId = 'toast-' + Date.now();

  // Create the toast HTML
  const toastHtml = `
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999">
      <div id="${toastId}" class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body">
            <strong>${title}</strong> ${message}
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        ${withCartButton ?
          `<div class="toast-footer p-2 d-flex justify-content-end">
            <a href="${window.cartShowUrl}" class="btn btn-sm btn-light">View Cart</a>
          </div>` : ''}
      </div>
    </div>
  `;

  // Add the toast to the document
  const toastWrapper = document.createElement('div');
  toastWrapper.innerHTML = toastHtml;
  document.body.appendChild(toastWrapper.firstElementChild);

  // Initialize and show the toast
  const toastEl = document.getElementById(toastId);
  const bsToast = new bootstrap.Toast(toastEl, {
    autohide: true,
    delay: 5000
  });

  bsToast.show();

  // Clean up the toast after it's hidden
  toastEl.addEventListener('hidden.bs.toast', function() {
    toastEl.parentNode.remove();
  });
}

// Initialize cart badge on page load
document.addEventListener('DOMContentLoaded', function() {
  // Fetch cart data to update badge
  fetch(window.cartShowUrl, {
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'Accept': 'application/json'
    }
  })
  .then(response => {
    if (!response.ok) {
      return { cart: { count: 0 } };
    }
    return response.json();
  })
  .then(data => {
    if (data.cart && typeof data.cart.count === 'number') {
      updateCartBadge(data.cart.count);
    }
  })
  .catch(error => {
    console.error('Error fetching cart data:', error);
  });
});

const showModal = (title, description, product_id, price) => {
  if (modalWrap !== null) {
    modalWrap.remove();
  }

  modalWrap = document.createElement('div');
  modalWrap.innerHTML = `
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">${title}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            ${description}
            <div class="mt-3">
              <label for="quantity-input" class="form-label">Quantity</label>
              <div class="input-group">
                <button type="button" class="btn btn-outline-secondary decrease-quantity">-</button>
                <input type="number" class="form-control text-center" id="quantity-input" value="1" min="1" max="99">
                <button type="button" class="btn btn-outline-secondary increase-quantity">+</button>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">${window.cancel}</button>
            <button type="button" class="btn btn-success add-to-cart-btn" data-product-id="${product_id}">${window.addToCartBtnText}</button>
          </div>
        </div>
      </div>
    </div>
  `;

  // Set up quantity controls
  const quantityInput = modalWrap.querySelector('#quantity-input');
  const decreaseBtn = modalWrap.querySelector('.decrease-quantity');
  const increaseBtn = modalWrap.querySelector('.increase-quantity');

  decreaseBtn.addEventListener('click', function() {
    let currentValue = parseInt(quantityInput.value, 10);
    if (currentValue > 1) {
      quantityInput.value = currentValue - 1;
    }
  });

  increaseBtn.addEventListener('click', function() {
    let currentValue = parseInt(quantityInput.value, 10);
    if (currentValue < 99) {
      quantityInput.value = currentValue + 1;
    }
  });

  // Add to Cart functionality
  modalWrap.querySelector('.add-to-cart-btn').onclick = function() {
    const packageId = this.getAttribute('data-product-id');
    const quantity = parseInt(quantityInput.value, 10) || 1;

      // If user is not logged in and no username is set, show modal to ask for username
    if (!pseudo || pseudo.trim() === '') {
      // Use the user modal component
      if (window.showUsernameModal) {
        window.showUsernameModal(packageId, quantity);
      }
    } else {
      // User already has a name, add directly to cart
      addToCart(packageId, quantity);
    }
  };

  // Direct purchase functionality removed as per requirements

  document.body.append(modalWrap);

  var modal = new bootstrap.Modal(modalWrap.querySelector('.modal'));
  modal.show();
}
