let type_timeout;
let posts;
let data;
const formSearch = document.querySelector('#input-search');
const searchInput = document.querySelector('[data-toggle="search"]');
const searchResults = document.querySelector(".search-results");
const searchClose = document.querySelector("#search-close");

document.querySelector('[data-toggle="search-content"]').classList.add('hide')
document.querySelector('#app').addEventListener('click', function (e) {
    if (e.target.type !== 'input') {
        document.querySelector('[data-toggle="search-content"]').classList.add('hide')
    }
})

function loadPosts() {
    axios({
        url: '../api/posts',
        method: 'GET',

    }).then(function (result) {
        posts = result.data;

        posts.forEach((e) => {
            e.pageType = "post"
        })

        pages.forEach(e => {
                e.pageType = "page"
        })

        wikis.forEach(e => {
            e.pageType = "wiki"
        })

        console.log(wikis)

        data = posts.concat(pages, wikis)
    })
}

loadPosts()


function getPostByKeyword(keyword) {
    let i = 0;
    let min_one_post = false

    document.querySelector('[data-toggle="search-content"]').innerHTML = ""
    data.forEach(function (value, key) {
        let post = value
        let post_added = false

        let link = `/news/${post.slug}`;
        let icon = "newspaper h2";

        if (post.pageType === "page") {
            link = `/${post.slug}`;
            icon = "card-text h2";
        } else if (post.pageType === "wiki") {
            link = `/wiki/${post.category.slug}/${post.slug}`;
            icon = "journal-bookmark h3";
        }

        Object.entries(value).forEach(([key1, value2]) => {
            if (value2.toString().toLowerCase().includes(keyword.toLowerCase())) {
                post_added = true
                min_one_post = true
            }
        })

        if (post_added) {
            if (i < 5) {
                searchResults.classList.add('show')

                let el = `
                <a href="${link}" class="d-flex align-items-center gap-3 py-2 search-item">
                   <i class="bi bi-${icon} ${post.pageType === 'wiki' ? 'm-0':''}"></i>
                   <div>
                       <b class="fw-bold mb-1 color-2 h6">${post.title}</b>
                       <p class="mb-0 lheight-normal text-sm text-clip-2">${post.description || ""}</p>
                   </div>
                   <i class="bi bi-arrow-right ms-auto"></i>
               </a>
            `
                document.querySelector('[data-toggle="search-content"]').insertAdjacentHTML('beforeend', el)
                i++;
            }
        }
    })
    if (!min_one_post) {
        let el = `<p class="text-color-4 mb-0 text-center mt-2">Aucun résultat</p>`
        document.querySelector('[data-toggle="search-content"]').insertAdjacentHTML('beforeend', el)
    }
}

searchInput.addEventListener('input', function () {
    let input_val = this.value

    if (input_val.trim().length !== 0) {
        document.querySelector('[data-toggle="search-content"]').classList.remove('hide')
    } else {
        document.querySelector('[data-toggle="search-content"]').classList.add('hide')
        searchResults.classList.remove('show')
    }

    if (posts) {
        if (type_timeout) {
            clearTimeout(type_timeout);
        }

        type_timeout = setTimeout(function () {
            getPostByKeyword(input_val)
            type_timeout = false;
        }, 200)
    }
})


searchClose.addEventListener('click', function () {
    document.querySelector('[data-toggle="search-content"]').classList.add('hide')
    searchResults.classList.remove('show')
})


formSearch.addEventListener('submit', (e) => {
    e.preventDefault()
    window.location.href = `/search?q=${searchInput.value}`
})
