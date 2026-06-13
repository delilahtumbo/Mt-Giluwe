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
}

if (menu) {
    menu.addEventListener('click', ()=>{
        menu.classList.toggle('fa-times');
        navbar.classList.toggle('active');
    });
}

if (searchBtn) {
    searchBtn.addEventListener('click', () =>{
        searchBtn.classList.toggle('fa-times');
        searchBar.classList.toggle('active');
    });
}

if (formBtn) {
    formBtn.addEventListener('click', () =>{
        if (bookform) bookform.classList.add('active');
    });
    formBtn.addEventListener('click', () =>{
        if (formclose) formclose.classList.remove('active');
    });
}

 imageBtn.forEach(btn => 
    {
    btn.addEventListener('click', ()=> {
      document.querySelector('.controls .active').classList.remove('active');
      btn.classList.add('active');
      let src = btn.getAttribute('data-src');
      document.querySelector('#image-slider').src = src;
    });
  });

 
 var swiper = new Swiper(".slideshow-container", {
    spaceBetween:20,
    loop:false,
    autoplay: 
    {
      delay:2500,
      disableOnInteraction:false,
    },
    breakpoints:
    {
      640:
      {
        slidesPerView:1,
      },
      768:
      {
        slidesPerView: 2,
      },
      1024:
      {
       slidesPerView:2,
      },
    },
 });
