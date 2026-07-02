
<script defer data-cfasync="false">
    window.addEventListener("DOMContentLoaded", async (event) => {
        "use strict";
        function discordAPI() {
            let discord_key = "{{theme_config('settings.discord.id') ?? '1025845189115400303'}}";
            let url = 'https://discordapp.com/api/guilds/' + discord_key + '/embed.json';
            let discordList_count = document.getElementById('discordCount');
            var init = {
                method: 'GET',
                mode: 'cors',
                cache: 'reload'
            }
            fetch(url, init).then(function (response) {
                response.json().then(function (d) {
                    discordList_count.innerText = d.presence_count;
                })
            }).catch(function (err) {
                discordList_count.innerText = 'ERROR';
                console.log("Error, please config 'discord_key' in this theme config. ("+err+")");
            })
        }
        discordAPI();
    })
</script>
