// =====================================================
// PORTFOLIO JAVASCRIPT
// Aziizah Olifiyan
// =====================================================

document.addEventListener("DOMContentLoaded", () => {

    // =================================================
    // 1. TYPING EFFECT
    // =================================================

    const typingText = document.querySelector(".home-text h2");

    if (typingText) {
        const texts = [
            "Pelajar PPLG | Tech Enthusiast ⭐",
            "Web Development Enthusiast 💻",
            "Learning & Growing Every Day ✨"
        ];

        let textIndex = 0;
        let charIndex = 0;
        let deleting = false;

        function typingEffect() {
            const currentText = texts[textIndex];

            if (!deleting) {
                typingText.textContent = currentText.substring(0, charIndex + 1);
                charIndex++;

                if (charIndex === currentText.length) {
                    deleting = true;
                    setTimeout(typingEffect, 1800);
                    return;
                }
            } else {
                typingText.textContent = currentText.substring(0, charIndex - 1);
                charIndex--;

                if (charIndex === 0) {
                    deleting = false;
                    textIndex = (textIndex + 1) % texts.length;
                }
            }

            setTimeout(typingEffect, deleting ? 50 : 90);
        }

        typingEffect();
    }


    // =================================================
    // 2. SCROLL REVEAL ANIMATION
    // =================================================

    const revealElements = document.querySelectorAll(
        ".section-title, .about-content, .about-skills-center-container, " +
        ".activity-card, .sertifikat-card, .project-card, " +
        ".contact-content"
    );

    revealElements.forEach((element) => {
        element.style.opacity = "0";
        element.style.transform = "translateY(40px)";
        element.style.transition = "opacity 0.8s ease, transform 0.8s ease";
    });

    const revealObserver = new IntersectionObserver(
        (entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = "1";
                    entry.target.style.transform = "translateY(0)";

                    observer.unobserve(entry.target);
                }
            });
        },
        {
            threshold: 0.15
        }
    );

    revealElements.forEach((element) => {
        revealObserver.observe(element);
    });


    // =================================================
    // 3. ACTIVE NAVBAR
    // =================================================

    const sections = document.querySelectorAll("section[id]");
    const navLinks = document.querySelectorAll(".nav-menu a");

    function updateActiveNav() {
        let currentSection = "";

        sections.forEach((section) => {
            const sectionTop = section.offsetTop - 180;
            const sectionHeight = section.offsetHeight;

            if (
                window.scrollY >= sectionTop &&
                window.scrollY < sectionTop + sectionHeight
            ) {
                currentSection = section.getAttribute("id");
            }
        });

        navLinks.forEach((link) => {
            link.classList.remove("active");

            const href = link.getAttribute("href");

            if (href === `#${currentSection}`) {
                link.classList.add("active");
            }
        });
    }

    window.addEventListener("scroll", updateActiveNav);
    updateActiveNav();


    // =================================================
    // 4. NAVBAR BACKGROUND SAAT SCROLL
    // =================================================

    const navbar = document.querySelector(".navbar");

    function navbarScroll() {
        if (!navbar) return;

        if (window.scrollY > 50) {
            navbar.classList.add("scrolled");
        } else {
            navbar.classList.remove("scrolled");
        }
    }

    window.addEventListener("scroll", navbarScroll);
    navbarScroll();


    // =================================================
    // 5. SKILL BAR ANIMATION
    // =================================================

    const skillProgress = document.querySelectorAll(".skill-progress");

    skillProgress.forEach((bar) => {
        const finalWidth = getComputedStyle(bar).width;

        bar.style.width = "0";
        bar.style.transition = "width 1.5s ease";

        bar.dataset.width = finalWidth;
    });

    const aboutSection = document.querySelector("#about");

    if (aboutSection) {
        const skillObserver = new IntersectionObserver(
            (entries, observer) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {

                        skillProgress.forEach((bar, index) => {
                            setTimeout(() => {
                                bar.style.width = bar.dataset.width;
                            }, index * 200);
                        });

                        observer.unobserve(entry.target);
                    }
                });
            },
            {
                threshold: 0.2
            }
        );

        skillObserver.observe(aboutSection);
    }


    // =================================================
    // 6. BACK TO TOP BUTTON
    // =================================================

    const backToTop = document.createElement("button");

    backToTop.innerHTML = "↑";
    backToTop.className = "back-to-top";
    backToTop.setAttribute("aria-label", "Back to top");

    document.body.appendChild(backToTop);

    window.addEventListener("scroll", () => {

        if (window.scrollY > 500) {
            backToTop.classList.add("show");
        } else {
            backToTop.classList.remove("show");
        }

    });

    backToTop.addEventListener("click", () => {

        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });

    });


    // =================================================
    // 7. SMOOTH SCROLL NAVBAR
    // =================================================

    navLinks.forEach((link) => {

        link.addEventListener("click", (event) => {

            const targetId = link.getAttribute("href");

            if (!targetId.startsWith("#")) return;

            const target = document.querySelector(targetId);

            if (!target) return;

            event.preventDefault();

            const headerHeight = document.querySelector("header")
                ? document.querySelector("header").offsetHeight
                : 0;

            const targetPosition =
                target.offsetTop - headerHeight - 20;

            window.scrollTo({
                top: targetPosition,
                behavior: "smooth"
            });

        });

    });


    


    // =================================================
    // 9. CONTACT ICON HOVER EFFECT
    // =================================================

    const contactIcons = document.querySelectorAll(".contact-icon");

    contactIcons.forEach((icon) => {

        icon.addEventListener("mouseenter", () => {
            icon.style.transform = "translateY(-8px) scale(1.05)";
        });

        icon.addEventListener("mouseleave", () => {
            icon.style.transform = "";
        });

    });


    // =================================================
    // 10. FOOTER YEAR OTOMATIS
    // =================================================

    const footerText = document.querySelector("footer p");

    if (footerText) {
        const currentYear = new Date().getFullYear();

        footerText.innerHTML =
            `© ${currentYear} Jijaa Olipiyan. All Rights Reserved.`;
    }


    // =================================================
    // 11. PAGE LOADING EFFECT
    // =================================================

    document.body.classList.add("page-loaded");

// =================================================
    // 12. SMOOTH HOVER EFFECT UNTUK KARTU AKTIVITAS
    // =================================================

    const activityCards = document.querySelectorAll(".activity-card");

    activityCards.forEach((card) => {
        card.addEventListener("mouseenter", () => {
            card.style.transform = "translateY(-10px)";
        });

        card.addEventListener("mouseleave", () => {
            card.style.transform = "translateY(0)";
        });
    });
});

// =================================================
    // 13. ANIMASI PINDAH HALAMAN
    // =================================================
document.addEventListener("DOMContentLoaded", () => {
    const links = document.querySelectorAll(".nav-menu a, .home-buttons a, .project-btn");

    links.forEach(link => {
        link.addEventListener("click", function (e) {
            const targetUrl = this.getAttribute("href");

            // Pastikan link menuju halaman HTML lain
            if (targetUrl && targetUrl.endsWith(".html")) {
                e.preventDefault(); // Mencegah pindah halaman instan
                
                // Tambahkan kelas fade-out agar halaman memudar lembut
                document.body.classList.add("fade-out");

                // Tunggu 300ms (0.3 detik), lalu pindah halaman
                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 300);
            }
        });
    });

    function openProjectImage(button) {

    // Ambil kartu project tempat tombol berada
    const card = button.closest(".project-card");

    // Ambil gambar yang sudah tampil di kartu
    const image = card.querySelector(".project-image img");

    // Ambil popup
    const modal = document.getElementById("projectModal");

    // Ambil gambar di dalam popup
    const preview = document.getElementById("projectPreview");

    if (!image || !modal || !preview) {
        return;
    }

    // Masukkan gambar kartu ke popup
    preview.src = image.src;

    // Tampilkan popup
    modal.classList.add("show");
}


function closeProjectImage() {

    const modal = document.getElementById("projectModal");

    if (modal) {
        modal.classList.remove("show");
    }
}


// Klik area luar gambar
document.addEventListener("click", function(event) {

    const modal = document.getElementById("projectModal");

    if (event.target === modal) {
        closeProjectImage();
    }

});


// Tekan ESC
document.addEventListener("keydown", function(event) {

    if (event.key === "Escape") {
        closeProjectImage();
    }

});
});
