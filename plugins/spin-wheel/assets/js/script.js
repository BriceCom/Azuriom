

function check() {
    document.getElementById('spinPriceText').textContent = spinPrice;
    const spinModal = new bootstrap.Modal(document.getElementById('spinConfirmModal'));
    spinModal.show();

    document.getElementById('confirmSpinBtn').onclick = function() {
        this.disabled = true;
        this.textContent = 'Loading...';

        fetch(play)
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => { throw new Error(text) })
                }
                return response.json()
            })
            .then(data => {
                spinModal.hide();
                startSpin(data.place);
            })
            .catch(error => {
                console.log(error);
                alert(error.message);
                this.disabled = false;
                this.textContent = TextConfirm;
            });
    };
}
