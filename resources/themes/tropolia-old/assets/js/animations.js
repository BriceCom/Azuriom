

// Get animate elements
const animateAttr = (value) => `[data-animate="${value}"]`;

// ScrollTrigger container
const [scrollContainer] = utils.$('#app');

const navAnime = {
    y: [
        { from: '-50px', ease: 'linear' },
        { to: '0', ease: 'outElastic' }
    ],
    opacity: [
        { from: 0, ease: 'linear' },
        { to: 1, ease: 'inOutElastic' }
    ],
    delay: stagger(100),
    duration: 350,
};

const headerLogo = {
    opacity: [
        { from: 0, ease: 'linear' },
        { to: 1, ease: 'linear', duration: 0 }
    ],
    y: [
        { from: '100px', ease: 'linear' },
        { to: '0', ease: 'linear' }
    ],
    delay: 350,
    duration: 450,
};

const headerLogoScale = {
    scale: [
        { to: 1.12, ease: 'linear', duration: 300 },
        { to: 1, ease: "outElastic", duration: 1000 }
    ],
    delay: 800,
    duration: 1300,
};

const heroBtn = {
    y: [
        { from: '-60px', ease: 'linear' },
        { to: '0px', ease: 'linear' },
    ],
    opacity: [
        { from: 0, ease: 'linear' },
        { to: 1, ease: 'inOutElastic' }
    ],
    delay: 1200,
};

const heroConnected = {
    y: [
        { from: '-50px', ease: 'linear' },
        { to: '0px', ease: 'inOutElastic' },
    ],
    opacity: [
        { from: 0, ease: 'linear' },
        { to: 1, ease: 'inOutElastic' }
    ],
    delay: 1500,
};

const heroArrow = {
    y: [
        { from: '-4%', ease: 'linear' },
        { to: '0%', ease: 'inElastic' },
    ],
    opacity: [
        { from: 0, ease: 'linear' },
        { to: 1, ease: 'inOutElastic' }
    ],
    delay: 2000,
};

const heroArrowBounce = {
    translateY: [0, 17, 0],
    duration: 1000,
    easing: 'easeOutBounce',
    loop: true,
    delay: 1300,
};


// animation text writing
const getText = document.querySelector(animateAttr("input-ip"));
const text = getText.getAttribute("data-value");
const container = getText;

let index = 0;

function typeWriter() {
    if (index < text.length) {
        container.innerHTML += text.charAt(index);
        index++;
        setTimeout(typeWriter, 150); // Attente entre chaque lettre
    }
}

// Animation ScrollTrigger
const inputIp = {
    autoplay: onScroll({
        target: document.querySelector(animateAttr("input-ip")),
        scrollContainer,
    }),
    onComplete: () => {
        typeWriter();
    },
};

// Exécution des animations si l'élément "#plug" n'existe pas
if (!document.querySelector('#plug')) {
    animate(animateAttr("navlink-anime"), navAnime);
    animate(animateAttr("header-logo"), headerLogo);
    animate(animateAttr("header-logo"), headerLogoScale);
    animate(animateAttr("hero-btn"), heroBtn);
    animate(animateAttr("hero-arrow"), heroArrow);
    animate(animateAttr("hero-arrow"), heroArrowBounce);
    animate(animateAttr("hero-connected"), heroConnected);
}

animate(animateAttr("input-ip"), inputIp);
