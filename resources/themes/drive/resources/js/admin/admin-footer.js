// Saved pill
const triggerPillList = document.querySelectorAll('#config-pills [data-config-pill]');

triggerPillList.forEach(triggerEl => {
    const pillTrigger = bootstrap.Tab.getOrCreateInstance(triggerEl);

    triggerEl.addEventListener('click', event => {
        event.preventDefault();
        pillTrigger.show();

        const dataSet = triggerEl.dataset.configPill;
        localStorage.setItem('admin-active-pill', dataSet);
        history.replaceState(null, null, '#' + dataSet);
    });
});

const savedPill = localStorage.getItem('admin-active-pill') || window.location.hash.replace('#', '');

if (savedPill) {
    triggerPill(savedPill)
} else {
    triggerPill("pill-settings")
}


// Function to trigger a specific pill
function triggerPill(pill) {
    const elem = document.querySelector(`#config-pills [data-config-pill="${pill}"]`);
    if (elem) {
        const pillTrigger = bootstrap.Tab.getOrCreateInstance(elem);
        pillTrigger.show();
    }
}


// Function when click on
const advancedModeButtons = document.querySelectorAll('[data-bs-target="#pill-premium"]');

advancedModeButtons.forEach(button => {
    button.addEventListener('click', function () {
        triggerPill('pill-premium');
    });
});


// Form : set the index of the inputs
document.getElementById('configForm').addEventListener('submit', function (e) {
    document.querySelectorAll('[data-listInput="true"]').forEach(function (elm) {
        let i = 0;

        elm.querySelectorAll('.input-group').forEach(function (el) {
            el.querySelectorAll('input').forEach(function (input) {
                input.name = input.name.replace('{index}', i.toString());
            });

            i++;
        });
    });

});
