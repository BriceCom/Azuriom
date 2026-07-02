document.addEventListener('DOMContentLoaded', function () {
    const slider = document.querySelector('.posts__slider');

    if(slider){
        let isDown = false;
        let startX;
        let scrollLeft;
        let isDragging = false;

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
        });
    }
});
