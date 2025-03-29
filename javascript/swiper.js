const swiper = new Swiper('.main-swiper', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,

    // Enable auto-scroll
    autoplay: {
        delay: 9000, // 9 seconds per slide
        disableOnInteraction: false, // Keeps autoplay running even when user interacts
    },

    // If we need pagination
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },

    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    // And if we need scrollbar
    scrollbar: {
        el: '.swiper-scrollbar',
    },
});

console.log("hello world");
var swiper2 = new Swiper(".card-swiper", {
    effect: "cards",
    grabCursor: true,
    autoplay: {
        delay: 3000, // Adjust delay time (in milliseconds)
        disableOnInteraction: false, // Ensures autoplay continues after user interaction
    },
});