import './bootstrap';

import Alpine from 'alpinejs'

import Swiper from 'swiper';

window.Alpine = Alpine

Alpine.start()


var swiper = new Swiper(".bannerSwiper", {
    cssMode: true,
    loop: true,
    speed: 1000,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    mousewheel: true,
    keyboard: true,
});

var swiper2 = new Swiper(".brandSwiper", {
    slidesPerView: 2,
    spaceBetween: 12,
    loop: true,
    mousewheel: true,
    breakpoints: {
        375: {
            slidesPerView: 3,
            spaceBetween: 12,
        },
        640: {
            slidesPerView: 4,
            spaceBetween: 12,
        },
        768: {
            slidesPerView: 5,
            spaceBetween: 18,
        },
        1024: {
            slidesPerView: 6,
            spaceBetween: 24,
        },
        1500: {
            slidesPerView: 6,
            spaceBetween: 106,
        }
    },
});

var swiper3 = new Swiper(".topCategoriesSwiper", {
    slidesPerView: 1,
    spaceBetween: 12,
    centeredSlides: true,
    loop: true,
    navigation: {
        nextEl: ".categoriesSwiper-button-next",
        prevEl: ".categoriesSwiper-button-prev",
    },
    breakpoints: {
        640: {
            slidesPerView: 2,
            spaceBetween: 12,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 18,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 24,
        },
    },
});

var swiper4 = new Swiper(".featureSwiper", {
    slidesPerView: 1,
    spaceBetween: 24,
    loop: true,
    navigation: {
        nextEl: ".featureSwiper-button-next",
        prevEl: ".featureSwiper-button-prev",
    },
    breakpoints: {
        480: {
            slidesPerView: 2,
            spaceBetween: 12,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 18,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 24,
        },
    },
});

var swiper5 = new Swiper(".recentSwiper", {
    slidesPerView: 1,
    spaceBetween: 24,
    loop: true,
    navigation: {
        nextEl: ".recentSwiper-button-next",
        prevEl: ".recentSwiper-button-prev",
    },
    breakpoints: {
        480: {
            slidesPerView: 2,
            spaceBetween: 12,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 18,
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 24,
        },
    },
});


//testimonials Slider

var swiper6 = new Swiper(".testimonialSwiper", {
    slidesPerView: 1,
    spaceBetween: 0,
    loop: true,
    navigation: {
        nextEl: ".testimonials-button-next",
        prevEl: ".testimonials-button-prev",
    },
    breakpoints: {
        1024: {
            slidesPerView: 2,
            spaceBetween: 24,
        },
    },
});


var galleryThumbs = new Swiper(".gallery-thumbs", {
    freeMode: true,
    slidesPerView: 3,
    loop: true,
    navigation: {
        nextEl: '.gallery-button-next',
        prevEl: '.gallery-button-prev',
    },
    watchOverflow: true,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
    direction: 'vertical'
});

var galleryMain = new Swiper(".gallery-main", {
    mousewheel: true,
    loop: true,
    navigation: {
        nextEl: '.gallery-button-next',
        prevEl: '.gallery-button-prev',
    },
    thumbs: {
        swiper: galleryThumbs
    }
});

galleryMain.on('slideChangeTransitionStart', function () {
    galleryThumbs.slideTo(galleryMain.activeIndex);
});

galleryThumbs.on('transitionStart', function () {
    galleryMain.slideTo(galleryThumbs.activeIndex);
});


//dropdown on  click //


var menuBtn = document.getElementById('hamburger-btn');
var menuBtnClose = document.getElementById('hamburger-btn-close');
var navMenu = document.getElementById('nav-menu')
var overlay = document.getElementById('overlay')

menuBtn.addEventListener('click', () => {
    navMenu.classList.add('open')
    overlay.classList.add('open')
})
menuBtnClose.addEventListener('click', () => {
    navMenu.classList.remove('open')
    overlay.classList.remove('open')
})
overlay.addEventListener('click', () => {
    navMenu.classList.remove('open')
    overlay.classList.remove('open')
})


// tab js
const tabs = document.querySelectorAll(".tabs");
const tab = document.querySelectorAll(".tab");
const panel = document.querySelectorAll(".tab-content");

function onTabClick(event) {

    // deactivate existing active tabs and panel

    for (let i = 0; i < tab.length; i++) {
        tab[i].classList.remove("active");
    }

    for (let i = 0; i < panel.length; i++) {
        panel[i].classList.remove("active");
    }


    // activate new tabs and panel
    event.target.classList.add('active');
    let classString = event.target.getAttribute('data-target');
    console.log(classString);
    if (classString === 'panel-1' || classString === 'panel-2') {
        document.getElementById('panels').getElementsByClassName(classString)[0].classList.add("active");
    }
    if (classString === 'tab-1' || classString === 'tab-2') {
        document.getElementById('accTabs').getElementsByClassName(classString)[0].classList.add("active");
    }
}

for (let i = 0; i < tab.length; i++) {
    tab[i].addEventListener('click', onTabClick, false);
}
