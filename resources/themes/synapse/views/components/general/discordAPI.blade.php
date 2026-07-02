@php($onlyCounter = $onlyCounter ?? false)

<script defer data-cfasync="false">
    window.addEventListener("DOMContentLoaded", async (event) => {
        "use strict";

        function discordAPI() {
            let discord_key = "{{theme_config('settings.discord.id') ?? '1025845189115400303'}}";
            let url = 'https://discordapp.com/api/guilds/' + discord_key + '/embed.json';
            @if(!$onlyCounter)
                let discordList = document.querySelector('.discord-list');
            @endif
            let discordList_count = document.querySelectorAll('.discord-list_count');
            var init = {
                method: 'GET',
                mode: 'cors',
                cache: 'reload'
            }
            fetch(url, init).then(function (response) {
                @if(!$onlyCounter)
                    if (response.status != 200) {
                        discordList.style.height = "auto";
                        discordList.innerHTML = "Error, please config 'block > discord > id' in this theme config. ("+response+")";
                        return
                    }
                @endif
                response.json().then(function (d) {
                    discordList_count.forEach(function(e) {
                        e.innerText.includes('{online}') ? e.innerText = e.innerText.replace('{online}', d.presence_count):'';
                    });
                    @if(!$onlyCounter)
                        d.members.sort((a,b)=> (a.status>b.status)*2-1).forEach(function (m) {
                            discordList.insertAdjacentHTML('afterbegin', `
                            <li class="d-flex align-items-center gap-2 my-2">
                                <div class="position-relative rounded-circle" style="background: url('${m.avatar_url}') center / cover no-repeat;width: 25px;height: 25px">
                                    <span class="position-absolute bottom-0 end-0 rounded-circle discord-status-${m.status}" style="width: 6px;height: 6px"></span>
                                </div>
                                <span class="ms-1 text-sm">
                                ${m.username}
                                </span>
                            </li>
                        `);
                        })
                    @endif
                })
            }).catch(function (err) {
                @if(!$onlyCounter)
                    discordList.style.height = "auto";
                    discordList.innerHTML = "Error, please config 'discord_key' in this theme config. ("+err+")";
                    discordList_count.parentElement.innerHTML = "X";
                @endif
            })
        }
        discordAPI();
    })
</script>
