let searchBtn = document.querySelector('#search-btn'); 
let searchBar = document.querySelector('.search-bar-container');
let formBtn = document.querySelector('#book_now'); 
let bookform = document.querySelector('.form_container');
let formclose = document.querySelector('#form-close');
let menu = document.querySelector('#menu-bar');
let navbar = document.querySelector('.navbar');
let imageBtn = document.querySelectorAll('.img-btn');

window.onscroll = () => 
{
    if (searchBtn) searchBtn.classList.remove('fa-times'); 
    if (searchBar) searchBar.classList.remove('active');
    if (menu) menu.classList.remove('fa-times');
    if (navbar) navbar.classList.remove('active');
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
        if (bookform) bookform.classList.add('active');
    });
    formBtn.addEventListener('click', () => {
        if (formclose) formclose.classList.remove('active');
    });
}

/* ── Home image slider ─────────────────────────────── */
if (imageBtn.length > 0) {
    let currentHomeSlide = 0;

    function setHomeSlide(index) {
        document.querySelector('.controls .active').classList.remove('active');
        imageBtn[index].classList.add('active');
        document.querySelector('#image-slider').src = imageBtn[index].getAttribute('data-src');
        currentHomeSlide = index;
    }

    imageBtn.forEach((btn, i) => {
        btn.addEventListener('click', () => setHomeSlide(i));
    });

    setInterval(() => {
        setHomeSlide((currentHomeSlide + 1) % imageBtn.length);
    }, 4000);
}

/* ── Others image slider ───────────────────────────── */
let othersImageBtn = document.querySelectorAll('.others-img-btn');
let othersSlides   = document.querySelectorAll('.others-slide');

if (othersImageBtn.length > 0) {
    let currentOthersSlide = 0;

    function setOthersSlide(index) {
        document.querySelector('.others-img-btn.active').classList.remove('active');
        document.querySelector('.others-slide.active').classList.remove('active');
        othersImageBtn[index].classList.add('active');
        othersSlides[index].classList.add('active');
        document.querySelector('#others-image-slider').src =
            othersImageBtn[index].getAttribute('data-src');
        currentOthersSlide = index;
    }

    othersImageBtn.forEach((btn, i) => {
        btn.addEventListener('click', () => setOthersSlide(i));
    });

    setInterval(() => {
        setOthersSlide((currentOthersSlide + 1) % othersImageBtn.length);
    }, 3500);
}

/* ── Swiper (keep for any remaining instances) ──────── */
if (document.querySelector('.slideshow-container')) {
    new Swiper('.slideshow-container', {
        spaceBetween: 20,
        loop: false,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        breakpoints: {
            640: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 2 },
        },
    });
}
