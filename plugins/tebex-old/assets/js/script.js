// Tebex Shop Integration with Shop Plugin
var modalWrap = null;

// API endpoint
const api = route('tebex.api.buy');

// Show the product details modal
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">${cancel}</button>
                        <button type="button" class="btn btn-primary modal-success-btn" data-bs-dismiss="modal">${buy} (${price})</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    modalWrap.querySelector('.modal-success-btn').onclick = function() {
        // Ask for the username
        Swal.fire({
            title: title,
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off',
                min: 3,
            },
            inputPlaceholder: 'Steve',
            showCancelButton: true,
            reverseButtons: true,
            inputValue: pseudo || '',
            confirmButtonText: buy,
            cancelButtonText: cancel,
            showLoaderOnConfirm: true,
            inputValidator: (value) => {
                if (value.length < 3) {
                    return errorUser;
                }
            },
            preConfirm: (username) => {
                return fetch(api, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        username: username,
                        package_id: product_id,
                        quantity: 1
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.json();
                })
                .catch(error => {
                    Swal.showValidationMessage(`Oups! ${error.message}`);
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to the shop plugin's cart page
                window.location.href = result.value.redirect_url;
            }
        });
    };

    document.body.append(modalWrap);

    var modal = new bootstrap.Modal(modalWrap.querySelector('.modal'));
    modal.show();
};
