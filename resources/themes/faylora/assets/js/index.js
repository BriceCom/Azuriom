const apiUrl = "https://api.minetools.eu/ping/play.faylora.fr/25565";
const playerCountDisplay = document.querySelector("#player-count");
const playerCountDisplay_ip = document.querySelector("#player-count-ip");
const playerCountDisplay_footer = document.querySelector("#player-count-footer");
// Fonction permettant de récupérer le nombre de joueurs à partir de l'API Minetools.
async function fetchPlayers() {
    try { // On essaie de récupérer la réponse de l'API.
        const response = await fetch(apiUrl); // On récupère la réponse de l'API.
        const data = await response.json(); // On récupère les données de l'API.
        // On s'assure toujours de mettre un try afin de ne pas avoir d'erreur si l'élement n'est pas présente sur la page.
        try {
            playerCountDisplay.innerHTML = `${data.players.online}`;
        } catch (error) {};
        try {
            playerCountDisplay_ip.innerHTML = `${data.players.online}`;
        } catch (error) {};
        try {
            playerCountDisplay_footer.innerHTML = `${data.players.online}`;
        } catch (error) {};
    } catch (error) {
        try {
            playerCountDisplay.innerHTML = `0`;
        } catch (error) {}; // Si une erreur survient, on affiche 0 pour la card.
        try {
            playerCountDisplay_ip.innerHTML = `0`;
        } catch (error) {}; // Si une erreur survient, on affiche 0 pour l'ip.
        try {
            playerCountDisplay_footer.innerHTML = `0`;
        } catch (error) {}; // Si une erreur survient, on affiche 0 pour le footer.
    }
}
fetchPlayers() // Appel de la fonction fetchPlayers au chargement de la page.
// Appel de la fonction fetchPlayers toutes les 30 secondes
setInterval(fetchPlayers, 30000);

function copyIP() {
    // Obtenir la référence de l'input
    var copyText = document.getElementById("ip");

    // Sélectionner le texte de l'input
    copyText.select();
    copyText.setSelectionRange(0, 99999); // Pour mobiles

    // Copier le texte sélectionné
    navigator.clipboard.writeText(copyText.value);
}

const usernameInput = document.getElementById('username');
const avatarImg = document.getElementById('avatar');
const defaultAvatar = 'https://minotar.net/avatar/Steve';


function updateAvatar(username) {
    if (avatarImg) {
        if (username.length > 0) {
            fetch(`https://minotar.net/avatar/${username}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Le pseudo est invalide');
                }
                return response.blob();
            })
            .then(blob => {
                const imageUrl = URL.createObjectURL(blob);
                avatarImg.src = imageUrl;
            })
            .catch(error => {
                console.error(error);
                avatarImg.src = defaultAvatar;
            });
        } else {
            avatarImg.src = defaultAvatar;
        }
    }
}

updateAvatar('');

if (usernameInput) {
    usernameInput.addEventListener('input', () => {
        const username = usernameInput.value;
        updateAvatar(username);
    });
}

function getMinecraftSkin() {

  try {
    let playerName = document.getElementById("player-name").textContent;
    const apiUrl = `https://mineskin.eu/armor/body/${playerName}`;

    fetch(apiUrl)
        .then(response => {
            // Vérification de la réponse de l'API
            if (!response.ok) {
                throw new Error('Erreur lors de la récupération du skin');
            }
            // Conversion de la réponse en image
            return response.blob();
        })
        .then(blob => {
            // Conversion du blob en URL d'image
            const imgUrl = URL.createObjectURL(blob);
            // Utilisation de l'URL pour afficher l'image dans l'élément avec l'id spécifié
            try {
              const imgElement = document.getElementById('minecraft-skin');
              imgElement.src = imgUrl;
            } catch (error) { }
        })
        .catch(error => {
            console.error(error);
        });
  } catch (error) { }

}

getMinecraftSkin()

function discord_embed() {
var discord_key = "1455970575490224283";
var usersDiscord = document.querySelector('.brm-usersDiscord');
if (usersDiscord && discord_key.length) {
    window.onerror = function(msg, url, ln) {
        return (msg === "Impossible de trouver la classe.");
    };
    fetch('https://discordapp.com/api/guilds/' + discord_key + '/embed.json')
        .then(function(response) {
            return response.json(); // On récupère les données de l'API
        })
        .then(function(data) {
            var presenceCount = data.presence_count; // Nombre de membres en ligne
            document.querySelector('.brm-presenceCount').innerHTML = presenceCount;
            var members = data.members;
            usersDiscord.innerHTML = '';
            members.forEach(function(member) {
                var avatarUrl = member.avatar_url; // Avatar Discord
                var username = member.username; // Pseudo Discord
                var status = member.status; // Statut: online, idle, dnd, offline
                var discriminator = member.discriminator; // Tag Discord
                var statusColor = 'steel-50';
                switch (status) {
                    case 'online':
                        statusColor = 'forest'; // Vert
                        break;
                    case 'idle':
                        statusColor = 'primary'; // Orange
                        break;
                    case 'dnd':
                        statusColor = 'danger'; // Rouge
                        break;
                }
                var userDiv = document.createElement('div'); // Création d'un élément div qui va stocket la card du membre Discord
                userDiv.classList.add('w-full'); // Ajout de la classe w-full à l'élément pour qu'il prenne toute la largeur
                userDiv.classList.add('overflow-hidden'); // Ajout de la classe overflow-hidden à l'élément pour éviter les débordements
                userDiv.innerHTML = '<div class="relative w-full p-2.5 rounded-xl flex items-center bg-steel-300 hover:bg-steel-200"> <div class="w-8 h-8"> <div class="relative w-8 h-8"> <img src="' + avatarUrl + '" alt="' + username + '" class="w-full h-full rounded-full overflow-hidden"> <div class="absolute flex justify-center items-center w-3 h-3 bottom-0 right-0 bg-' + statusColor + ' border-2 border-steel-300 rounded-full"> </div></div></div><div class="w-32 flex flex-col ml-4"> <div class=" w-32 h-4 text-current leading-none flex items-center"><span class="h-5 truncate text-white text-xs font-semibold">' + username + '</span></div><div class="w-full flex justify-start text-xs text-steel-50 text-xs font-medium truncate">#' + discriminator + '</div></div></div>';
                usersDiscord.appendChild(userDiv); // Ajout de la card du membre Discord à l'élément avec l'id usersDiscord
            });
        })
        .catch(function(error) {
            console.error(error);
        });
}}

discord_embed()
