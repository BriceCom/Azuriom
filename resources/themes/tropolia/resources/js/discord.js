
let url = 'https://discordapp.com/api/guilds/' + window.THEME.discord_key + '/embed.json';
var init = {
    method: 'GET',
    mode: 'cors',
    cache: 'reload'
}

fetch(url, init).then(function (response) {
    response.json().then(function (d) {
        window.THEME.discord_online = d.presence_count;
        updateCounters();
    })
}).catch(function (err) {
    console.log("Error, please config 'discord_key' in this theme config. ("+err+"). Check if you enable the Discord Widget on your Discord server.");
})
