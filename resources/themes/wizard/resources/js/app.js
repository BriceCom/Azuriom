window.addEventListener("DOMContentLoaded", function (event) {
    if (document.querySelector('.address_copy')) {
        document.querySelector('.address_copy').addEventListener('click', function (event) {
            event.preventDefault();
            copyToClipboard(this.dataset.text);
            this.querySelector('.info').innerHTML = '  L\'ip a été copiée   ';

            setTimeout(() => {
                this.querySelector('.info').innerHTML = this.dataset.text;
            }, 3000)
        })
    }

    function copyToClipboard(text) {
        var $temp = document.createElement('input');
        document.querySelector('body').append($temp);
        $temp.value = text
        $temp.select()
        document.execCommand("copy");
        $temp.remove();
    }
})


document.querySelectorAll('.dropdown-toggle').forEach(function (el) {
    let instance = bootstrap.Dropdown.getOrCreateInstance(el);

    el.addEventListener('mouseover', function (ev) {
        instance.show()
    })

    el.addEventListener('mouseout', function (ev) {
        // if target element is children of dropdown
        if (el.contains(ev.target)) {
            return
        }
        instance.hide()
    })

});
