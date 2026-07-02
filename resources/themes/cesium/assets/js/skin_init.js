try {
    






    async function getCape() {
        const response = await fetch("https://api.capes.dev/load/" + document.getElementById("skin_container").getAttribute("data-name"));
        var data = await response.json();
        if (data.minecraft.imageUrl != null) {
            cape_data = data.minecraft.imageUrl;
        } else if (data.optifine != null) {
            cape_data = data.optifine.imageUrl;
        } else {
            cape_data = '';
        }
        return cape_data;
    }

    // Calling that async function
    getCape().then((capeUrl) => {



                let skinViewer = new skinview3d.SkinViewer({
                    canvas: document.getElementById("skin_container"),
                    width: 300,
                    height: 300,
                    model: "Default",
                    skin: "https://minotar.net/skin/" + document.getElementById("skin_container").getAttribute("data-name"),
                    cape: capeUrl,
                });
                skinViewer.fov = 20;
                skinViewer.zoom = 0.7;
                skinViewer.animation = new skinview3d.WalkingAnimation();
                skinViewer.animation.speed = 0.3;
                skinViewer.autoRotate = true;
                skinViewer.animation.paused = false;
                skinViewer.nameTag = new skinview3d.NameTagObject(document.getElementById("skin_container").getAttribute("data-name"), { textStyle: "white" });
                document.getElementById("skin_container").addEventListener("click", function() {
                    skinViewer.animation.paused = !skinViewer.animation.paused;
                    skinViewer.autoRotate = false;
                });


    });

} catch (err) {}

try {

    skin_1 = "https://minotar.net/skin/" + document.getElementById("skin_vote_1").getAttribute("data-name");
    if (document.getElementById("skin_vote_1").getAttribute("data-name") == "?") {
        skin_1 = "https://minotar.net/skin/connor4312";
    }
        let skinViewer_vote_1 = new skinview3d.SkinViewer({
            canvas: document.getElementById("skin_vote_1"),
            width: 90,
            height: 120,
            model: "Default",
            skin: skin_1,
            enableControls: false,
        });
        skinViewer_vote_1.fov = 50;
        skinViewer_vote_1.zoom = 0.7;
        skinViewer_vote_1.camera.rotation.x = 0;
        skinViewer_vote_1.camera.rotation.y = 0;
        skinViewer_vote_1.camera.rotation.z = 0;
        skinViewer_vote_1.camera.position.x = 20.5;
        skinViewer_vote_1.camera.position.y = 22.0;
        skinViewer_vote_1.camera.position.z = 42.0;
        skinViewer_vote_1.animation = new skinview3d.WalkingAnimation();
        skinViewer_vote_1.animation.speed = 0.5;
        skinViewer_vote_1.nameTag = new skinview3d.NameTagObject(document.getElementById("skin_vote_1").getAttribute("data-name"), { textStyle: "white" });
        
        document.getElementById("skin_vote_1").classList.remove("hidden");
    } catch (err) {}
    try {
        skin_2 = "https://minotar.net/skin/" + document.getElementById("skin_vote_2").getAttribute("data-name");
        if (document.getElementById("skin_vote_2").getAttribute("data-name") == "?") {
            skin_2 = "https://minotar.net/skin/connor4312";
        }
        let skinViewer_vote_2 = new skinview3d.SkinViewer({
            canvas: document.getElementById("skin_vote_2"),
            width: 90,
            height: 120,
            model: "Default",
            skin: skin_2,
            enableControls: false,
        });
        skinViewer_vote_2.fov = 50;
        skinViewer_vote_2.zoom = 0.7;
        skinViewer_vote_2.camera.rotation.x = 0;
        skinViewer_vote_2.camera.rotation.y = 0;
        skinViewer_vote_2.camera.rotation.z = 0;
        skinViewer_vote_2.camera.position.x = 20.5;
        skinViewer_vote_2.camera.position.y = 22.0;
        skinViewer_vote_2.camera.position.z = 42.0;
        skinViewer_vote_2.animation = new skinview3d.WalkingAnimation();
        skinViewer_vote_2.animation.speed = 0.5;
        skinViewer_vote_2.nameTag = new skinview3d.NameTagObject(document.getElementById("skin_vote_2").getAttribute("data-name"), { textStyle: "white" });

        document.getElementById("skin_vote_2").classList.remove("hidden");
    } catch (err) {}
    try {
        skin_3 = "https://minotar.net/skin/" + document.getElementById("skin_vote_3").getAttribute("data-name");
        if (document.getElementById("skin_vote_3").getAttribute("data-name") == "?") {
            skin_3 = "https://minotar.net/skin/connor4312";
        }
        let skinViewer_vote_3 = new skinview3d.SkinViewer({
            canvas: document.getElementById("skin_vote_3"),
            width: 90,
            height: 120,
            model: "Default",
            skin: skin_3,
            enableControls: false,
        });
        skinViewer_vote_3.fov = 50;
        skinViewer_vote_3.zoom = 0.7;
        skinViewer_vote_3.camera.rotation.x = 0;
        skinViewer_vote_3.camera.rotation.y = 0;
        skinViewer_vote_3.camera.rotation.z = 0;
        skinViewer_vote_3.camera.position.x = 20.5;
        skinViewer_vote_3.camera.position.y = 22.0;
        skinViewer_vote_3.camera.position.z = 42.0;
        skinViewer_vote_3.animation = new skinview3d.WalkingAnimation();
        skinViewer_vote_3.animation.speed = 0.5;
        skinViewer_vote_3.nameTag = new skinview3d.NameTagObject(document.getElementById("skin_vote_3").getAttribute("data-name"), { textStyle: "white" });

        document.getElementById("skin_vote_3").classList.remove("hidden");

    } catch (err) {}