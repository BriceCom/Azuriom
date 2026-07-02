// Delete field
function deleteField(e) {
    e.parentElement.remove();
}

// Image preview
function showPreview(id) {
    let img = document.getElementById('img-preview-' + id);
    let option = document.getElementById(id);

    if (option.value === '') {
        img.parentNode.style.display = 'none';
    } else {
        if (img.parentNode.style.display === 'none') img.parentNode.style.display = null;
        img.setAttribute('src', window.CONSTANTS.image_url+ '/' + option.value);
    }
}

// Set default value of input color
function inputColorDefaultValue(e, value, config_value) {
    e.previousElementSibling.value != e.value ? e.previousElementSibling.value = e.value : e.previousElementSibling.value = config_value;
}
