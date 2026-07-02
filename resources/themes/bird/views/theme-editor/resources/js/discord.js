
const DISCORD_URL = 'https://discordapp.com/api/guilds/' + window.THEME.discord_key + '/embed.json';
const INIT = {
    method: 'GET',
    mode: 'cors',
    cache: 'reload'
}

fetch(DISCORD_URL, INIT).then(function (response) {
    response.json().then(function (d) {
        window.THEME.discord_online = d.presence_count;
        window.dispatchEvent(new CustomEvent('theme-editor:discord-online-updated', {
            detail: {
                value: d.presence_count
            }
        }));
        updateCounters();

        const ListWrapper = document.querySelectorAll('.discord-list');

        ListWrapper.forEach(function(e) {
            d.members.sort((a,b)=> (a.status>b.status)*2-1).forEach(function (m) {
                e.insertAdjacentHTML('afterbegin', `
                            <li class="d-flex align-items-center gap-2">
                                <div class="position-relative rounded-circle" style="background: url('${m.avatar_url}') center / cover no-repeat;width: 24px;height: 24px">
                                    <span class="position-absolute bottom-0 end-0 rounded-circle bg-${m.status === 'online' ? 'success' : 'warning'}" style="width: 8px;height: 8px"></span>
                                </div>

                                <span class="ms-1 text-xs">
                                    ${m.username}
                                </span>
                            </li>
                        `);
            })
        });
    })
}).catch(function (err) {
    console.log("Error, please config 'discord_key' in this theme config. ("+err+"). Check if you enable the Discord Widget Integration on your Discord server settings.");
})
