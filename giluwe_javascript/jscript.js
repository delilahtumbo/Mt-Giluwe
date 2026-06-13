let searchBtn = document.querySelector('#search-btn');
let searchBar = document.querySelector('.search-bar-container');
let formBtn   = document.querySelector('#book_now');
let bookform  = document.querySelector('.form_container');
let formclose = document.querySelector('#form-close');
let menu      = document.querySelector('#menu-bar');
let navbar    = document.querySelector('.navbar');
let imageBtn  = document.querySelectorAll('.img-btn');

window.onscroll = () => {
    if (searchBtn) searchBtn.classList.remove('fa-times');
    if (searchBar) searchBar.classList.remove('active');
    if (menu)      menu.classList.remove('fa-times');
    if (navbar)    navbar.classList.remove('active');
};

if (menu) {
    menu.addEventListener('click', () => {
        menu.classList.toggle('fa-times');
        navbar.classList.toggle('active');
    });
}

if (searchBtn) {
    searchBtn.addEventListener('click', () => {
        searchBtn.classList.toggle('fa-times');
        searchBar.classList.toggle('active');
    });
}

if (formBtn) {
    formBtn.addEventListener('click', () => {
        if (bookform)  bookform.classList.add('active');
        if (formclose) formclose.classList.remove('active');
    });
}

/* ── Home image slider ───────────────────────────────── */
if (imageBtn.length > 0) {
    let currentHomeSlide = 0;
    const homeImg = document.querySelector('#image-slider');

    function setHomeSlide(index) {
        document.querySelector('.controls .active').classList.remove('active');
        imageBtn[index].classList.add('active');

        if (homeImg) {
            homeImg.style.opacity = '0';
            setTimeout(() => {
                homeImg.src = imageBtn[index].getAttribute('data-src');
                homeImg.style.opacity = '1';
            }, 350);
        }

        currentHomeSlide = index;
    }

    if (homeImg) homeImg.style.transition = 'opacity .35s ease';

    imageBtn.forEach((btn, i) => {
        btn.addEventListener('click', () => setHomeSlide(i));
    });

    setInterval(() => {
        setHomeSlide((currentHomeSlide + 1) % imageBtn.length);
    }, 4000);
}

/* ── Others section — manual dot navigation, 3-column ── */
const othersDots   = document.querySelectorAll('.others-dot');
const othersGroups = document.querySelectorAll('.others-group');

if (othersDots.length > 0) {
    othersDots.forEach((dot, i) => {
        dot.addEventListener('click', () => {
            document.querySelector('.others-dot.active').classList.remove('active');
            document.querySelector('.others-group.active').classList.remove('active');
            dot.classList.add('active');
            othersGroups[i].classList.add('active');
        });
    });
}

/* ── Swiper (keep for any remaining instances) ───────── */
if (document.querySelector('.slideshow-container')) {
    new Swiper('.slideshow-container', {
        spaceBetween: 20,
        loop: false,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        breakpoints: {
            640:  { slidesPerView: 1 },
            768:  { slidesPerView: 2 },
            1024: { slidesPerView: 2 },
        },
    });
}
