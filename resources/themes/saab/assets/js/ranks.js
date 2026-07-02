// Thanks to Deluxe theme, I'm not going to re-invent the road
// Sources: https://github.com/bs-community/skinview3d
(function(){
    document.querySelectorAll('[data-rank]').forEach(function(rank){
        let i = rank.getAttribute('data-rank')
        let skinViewer = new skinview3d.SkinViewer({
            canvas: document.querySelector("[data-rank='"+i+"']"),
            width: 50,
            height: 100,
            skin: rank.getAttribute('data-skin-url')
        });

        skinViewer.controls.enableZoom = false;

        // Change camera FOV
        skinViewer.fov = 70;

        // Zoom out
        skinViewer.zoom = 0.8;

        // Rotate the player
        skinViewer.autoRotate = false;

        // Apply an animation
        skinViewer.animation = new skinview3d.IdleAnimation();

        // Set the speed of the animation
        setTimeout(function(){
            skinViewer.animation.speed = 2;
        },i*250)
    })
})()
