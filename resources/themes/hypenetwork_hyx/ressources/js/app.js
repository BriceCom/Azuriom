document.addEventListener('DOMContentLoaded', function () {
    const slider = document.querySelector('.posts__slider');
    let isDown = false;
    let startX;
    let scrollLeft;
    let isDragging = false;
    slider.classList.add('to-right');

    slider.addEventListener('mousedown', (e) => {
        isDown = true;
        isDragging = false;
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });

    slider.addEventListener('mouseleave', () => {
        isDown = false;
        slider.classList.remove('active');
    });

    slider.addEventListener('mouseup', () => {
        isDown = false;
        slider.classList.remove('active');
    });

    slider.addEventListener('mousemove', (e) => {
        if (!isDown) {
            return;
        }else{
            slider.classList.add('active');
        }

        e.preventDefault();
        isDragging = true;

        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 3;
        slider.scrollLeft = scrollLeft - walk;

        if(slider.scrollLeft > 0){
            slider.classList.add('to-left');
        }
        if(slider.scrollLeft === 0){
            slider.classList.remove('to-left');
        }
        if(slider.scrollLeft <= x){
            slider.classList.add('to-right');
        }
        if(slider.scrollLeft ===  (slider.scrollWidth - slider.clientWidth)){
            slider.classList.remove('to-right');
        }
    });
});
