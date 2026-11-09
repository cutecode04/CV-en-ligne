/* =========================
   GLOBAL SETTINGS
========================= */

document.addEventListener("DOMContentLoaded", () => {

    /* SMOOTH SCROLL */
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            const targetId = link.getAttribute('href');
            const section = document.querySelector(targetId);
            section.scrollIntoView({ behavior: 'smooth' });
        });
    });

    /* SCROLL REVEAL */
    const revealElements = document.querySelectorAll(`
        .about-container,
        .skill-item,
        .timeline-item,
        .contact-wrapper,
        footer
    `);

    const revealObserver = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("reveal-active");
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });

    revealElements.forEach(el => {
        el.classList.add("reveal");
        revealObserver.observe(el);
    });

    /* BUTTON EFFECT */
    document.querySelectorAll('button, .btn').forEach(btn => {
        btn.addEventListener('click', () => {
            btn.classList.add('btn-click');
            setTimeout(() => btn.classList.remove('btn-click'), 180);
        });
    });

});

/* FORMULAIRE CONTACT */
async function envoyerMessage(e) {
    e.preventDefault();

    const form = document.getElementById("contactForm");
    const formData = new FormData(form);

    const response = await fetch("handlers/contactHandler.php", {
        method: "POST",
        body: formData
    });

    const result = await response.text();
    alert(result);

    // SI ENVOI RÉUSSI → ON VIDE LE FORMULAIRE
    if (response.ok) {
        form.reset();
    }
}
