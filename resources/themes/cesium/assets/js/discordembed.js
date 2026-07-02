


try {

  
  async function fetchDiscordMembersAndInitializeSwiper() {
    const apiUrl = 'https://discordapp.com/api/guilds/' + document.getElementById('discord_embed').getAttribute('data-discordguild') + '/embed.json';
    try {
        const response = await fetch(apiUrl);
        if (response.ok) {
            const data = await response.json();
            const members = data.members;
            const swiper1_div = document.querySelector('.discord-1 .swiper-wrapper');
            const swiper2_div = document.querySelector('.discord-2 .swiper-wrapper');
            const discordCount = document.getElementById('discord_count');
            discordCount.innerHTML = data.presence_count;
            let liste_membres1 = members.slice(0, Math.floor(members.length / 2));
            let liste_membres2 = members.slice(Math.floor(members.length / 2), members.length);
            liste_membres1.forEach((member) => {
                const avatarUrl = member.avatar_url;
                const username = member.username;
                const status = member.status;
                const slide = document.createElement('div');
                slide.classList.add('swiper-slide');
                slide.style.width = 'auto';
                const memberMainContainer = document.createElement('div');
                memberMainContainer.classList.add('p-1');
                const memberContainer = document.createElement('div');
                memberContainer.classList.add('relative');
                const avatarImg = document.createElement('img');
                avatarImg.classList.add('absolute', 'z-50', 'mx-auto', 'text-transparent', 'rounded-lg', 'shadow-xl', 'h-11');
                avatarImg.src = avatarUrl;
                avatarImg.loading = 'lazy';
                avatarImg.alt = 'Avatar de ' + username;
                const statusSpan = document.createElement('span');
                statusSpan.classList.add('-top-[0.2rem]', '-right-[0.3rem]', 'absolute', 'z-50', 'border-4', 'border-steel-300', 'rounded-full', 'bg-steel-300');
                if (status === 'online') {
                    const statusImg = document.createElement('img');
                    statusImg.classList.add('w-[0.6m]', 'h-[0.6em]');
                    statusImg.loading = 'lazy';
                    statusImg.src = './assets/themes/cesium/static/online.png';
                    statusSpan.appendChild(statusImg);
                } else if (status === 'idle') {
                    const statusImg = document.createElement('img');
                    statusImg.classList.add('w-[0.6m]', 'h-[0.6em]');
                    statusImg.loading = 'lazy';
                    statusImg.src = './assets/themes/cesium/static/idle.png';
                    statusSpan.appendChild(statusImg);
                } else if (status === 'dnd') {
                    const statusImg = document.createElement('img');
                    statusImg.classList.add('w-[0.6m]', 'h-[0.6em]');
                    statusImg.loading = 'lazy';
                    statusImg.src = './assets/themes/cesium/static/dnd.png';
                    statusSpan.appendChild(statusImg);
                }
                const memberBlock = document.createElement('div');
                memberBlock.classList.add('flex', 'items-center', 'justify-center', 'rounded-lg', 'w-11', 'h-11', 'bg-steel-200');
                const loader = document.createElement('div');
                loader.classList.add('flex', 'items-center', 'justify-center', 'w-11', 'h-11', 'rounded-lg', 'bg-steel-300');
                const loaderSvg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                loaderSvg.classList.add('animate-spin', 'h-3.5', 'w-3.5', 'text-white', 'mx-auto', 'flex');
                loaderSvg.setAttribute('viewBox', '0 0 24 24');
                loaderSvg.setAttribute('fill', 'none');
                loaderSvg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
                const loaderCircle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
                loaderCircle.classList.add('opacity-25');
                loaderCircle.setAttribute('cx', '12');
                loaderCircle.setAttribute('cy', '12');
                loaderCircle.setAttribute('r', '10');
                loaderCircle.setAttribute('stroke', 'currentColor');
                loaderCircle.setAttribute('stroke-width', '4');
                const loaderPath = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                loaderPath.classList.add('opacity-75');
                loaderPath.setAttribute('fill', 'currentColor');
                loaderPath.setAttribute('d', 'M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z');
                loaderSvg.appendChild(loaderCircle);
                loaderSvg.appendChild(loaderPath);
                loader.appendChild(loaderSvg);
                memberBlock.appendChild(avatarImg);
                memberBlock.appendChild(loader);
                memberBlock.appendChild(statusSpan);
                memberContainer.appendChild(memberBlock);
                memberMainContainer.appendChild(memberContainer);
                slide.appendChild(memberMainContainer);
                swiper1_div.appendChild(slide);
            });
            liste_membres2.forEach((member) => {
                const avatarUrl = member.avatar_url;
                const username = member.username;
                const status = member.status;
                const slide = document.createElement('div');
                slide.classList.add('swiper-slide');
                slide.style.width = 'auto';
                const memberMainContainer = document.createElement('div');
                memberMainContainer.classList.add('p-1');
                const memberContainer = document.createElement('div');
                memberContainer.classList.add('relative');
                const avatarImg = document.createElement('img');
                avatarImg.classList.add('absolute', 'z-50', 'mx-auto', 'text-transparent', 'rounded-lg', 'shadow-xl', 'h-11');
                avatarImg.src = avatarUrl;
                avatarImg.loading = 'lazy';
                avatarImg.alt = 'Avatar de ' + username;
                const statusSpan = document.createElement('span');
                statusSpan.classList.add('-top-[0.2rem]', '-right-[0.3rem]', 'absolute', 'z-50', 'border-4', 'border-steel-300', 'rounded-full', 'bg-steel-300');
                if (status === 'online') {
                    const statusImg = document.createElement('img');
                    statusImg.classList.add('w-[0.6m]', 'h-[0.6em]');
                    statusImg.loading = 'lazy';
                    statusImg.src = './assets/themes/cesium/static/online.png';
                    statusSpan.appendChild(statusImg);
                } else if (status === 'idle') {
                    const statusImg = document.createElement('img');
                    statusImg.classList.add('w-[0.6m]', 'h-[0.6em]');
                    statusImg.loading = 'lazy';
                    statusImg.src = './assets/themes/cesium/static/idle.png';
                    statusSpan.appendChild(statusImg);
                } else if (status === 'dnd') {
                    const statusImg = document.createElement('img');
                    statusImg.classList.add('w-[0.6m]', 'h-[0.6em]');
                    statusImg.loading = 'lazy';
                    statusImg.src = './assets/themes/cesium/static/dnd.png';
                    statusSpan.appendChild(statusImg);
                }
                const memberBlock = document.createElement('div');
                memberBlock.classList.add('flex', 'items-center', 'justify-center', 'rounded-lg', 'w-11', 'h-11', 'bg-steel-200');
                const loader = document.createElement('div');
                loader.classList.add('flex', 'items-center', 'justify-center', 'w-11', 'h-11', 'rounded-lg', 'bg-steel-300');
                const loaderSvg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                loaderSvg.classList.add('animate-spin', 'h-3.5', 'w-3.5', 'text-white', 'mx-auto', 'flex');
                loaderSvg.setAttribute('viewBox', '0 0 24 24');
                loaderSvg.setAttribute('fill', 'none');
                loaderSvg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
                const loaderCircle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
                loaderCircle.classList.add('opacity-25');
                loaderCircle.setAttribute('cx', '12');
                loaderCircle.setAttribute('cy', '12');
                loaderCircle.setAttribute('r', '10');
                loaderCircle.setAttribute('stroke', 'currentColor');
                loaderCircle.setAttribute('stroke-width', '4');
                const loaderPath = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                loaderPath.classList.add('opacity-75');
                loaderPath.setAttribute('fill', 'currentColor');
                loaderPath.setAttribute('d', 'M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z');
                loaderSvg.appendChild(loaderCircle);
                loaderSvg.appendChild(loaderPath);
                loader.appendChild(loaderSvg);

                memberBlock.appendChild(avatarImg);
                memberBlock.appendChild(loader);
                memberBlock.appendChild(statusSpan);
                memberContainer.appendChild(memberBlock);
                memberMainContainer.appendChild(memberContainer);
                slide.appendChild(memberMainContainer);
                swiper2_div.appendChild(slide);
            });
            const swiper1 = new Swiper('.discord-1', {
                lazyPreloadPrevNext: 4,
                autoplay: {
                    delay: 1,
                },
                spaceBetween: 0,
                centeredSlides: true,
                speed: 5000,
                loop: true,
                slidesPerView: 'auto',
                allowTouchMove: false,
                disableOnInteraction: true

            });
            const swiper2 = new Swiper('.discord-2', {
                lazyPreloadPrevNext: 4,
                autoplay: {
                    delay: 1,
                    reverseDirection: true,

                },
                spaceBetween: 0,
                centeredSlides: true,
                speed: 5000,
                loop: true,
                loopedSlides: liste_membres2.length,
                slidesPerView: 'auto',
                allowTouchMove: false,
                disableOnInteraction: true
            });
        } else {
            if (response.status === 403) {
                console.error('Le widget Discord n\'est pas activé. Veuillez l\'activer dans les paramètres de votre serveur Discord.');
            } else if (response.status === 404) {
                console.error('Le serveur Discord n\'a pas été trouvé. Veuillez vérifier à nouveau l\'id de votre serveur Discord.');
            } else {
                console.error('Une erreur c\'est produite lors de la récupération des membres discord ' + response.status);
            }
        }
    } catch (error) {
        console.error('Une erreur c\'est produite lors de la récupération des membres discord : ' + error);
    }
}
fetchDiscordMembersAndInitializeSwiper();
async function fetchMinecraftMembersConnected() {
    const apiUrl = 'https://api.mcsrvstat.us/3/mc.hypixel.net';

    try {
        const response = await fetch(apiUrl);
        if (response.ok) {
            const PlayersCount = document.getElementById('players_count');
            const data = await response.json();
            const players = data.players.online;
            PlayersCount.innerHTML = players + ' joueurs';
        } else {
            console.response('Une erreur c\'est produite lors de la récupération des membres connectés au serveur Minecraft ' + response.status);
        }
    } catch (error) {
        console.error('Une erreur s\'est produite lors de la récupération des membres connectés au serveur Minecraft : ' + error);
    }
}

fetchMinecraftMembersConnected();
setInterval(function() {
    fetchMinecraftMembersConnected();
}, 60000);

fetchDiscordMembersAndInitializeSwiper();
} catch (err) {}