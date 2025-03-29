const menuToggle = document.getElementById('menuToggle');
const navLinks = document.getElementById('navLinks');
const actualLinks = document.getElementsByClassName('actual-links');
const menuBar2 = document.getElementById('menu-bar2');
const menuBar1 = document.getElementsByClassName('menu-bar1'); // Collection
const menuBar3 = document.getElementsByClassName('menu-bar3'); // Collection

if (menuToggle && navLinks && menuBar2) {
    menuToggle.addEventListener('click', () => {
        menuToggle.classList.toggle('active');
        navLinks.classList.toggle('active');
        menuBar2.classList.toggle('active');

        // Loop through menuBar1 & menuBar3 collections and apply toggle
        for (let i = 0; i < menuBar1.length; i++) {
            menuBar1[i].classList.toggle('active');
        }

        for (let i = 0; i < menuBar3.length; i++) {
            menuBar3[i].classList.toggle('active');
        }

        // Loop through actualLinks collection and apply toggle
        for (let i = 0; i < actualLinks.length; i++) {
            actualLinks[i].classList.toggle('active');
        }

        console.log("Keep going !");
    });
}


// Swiper Initialization (Only if elements exist)
if (document.querySelector('.main-swiper')) {
    const swiper = new Swiper('.main-swiper', {
        direction: 'horizontal',
        loop: true,
        autoplay: {
            delay: 9000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        scrollbar: {
            el: '.swiper-scrollbar',
        },
    });
}

if (document.querySelector('.card-swiper')) {
    var swiper2 = new Swiper(".card-swiper", {
        effect: "cards",
        grabCursor: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
    });
}

// Update Year (Only if #year exists)
const yearElement = document.getElementById("year");
if (yearElement) {
    yearElement.textContent = new Date().getFullYear();
}

// Slide-Up Animation
document.addEventListener("DOMContentLoaded", function () {
    const elements = document.querySelectorAll(".slide-up");

    if (elements.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("show");
                } else {
                    entry.target.classList.remove("show");
                }
            });
        }, { threshold: 0.1 });

        elements.forEach((el) => observer.observe(el));
    }
});

console.log("Hello world");
