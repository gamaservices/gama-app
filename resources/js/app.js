import "./bootstrap";

// ==== Animate on Scroll Initialize  ==== //
AOS.init();

// ==== GSAP Animations ==== //
// ==== LOGO  ==== //
gsap.from(".logo", {
    opacity: 0,
    y: -10,
    delay: 0.2,
    duration: 0.5,
});
// ==== MAIN HEADING  ==== //
gsap.from(".main-heading", {
    opacity: 0,
    y: -50,
    delay: 1,
    duration: 1,
});
// ==== INFO TEXT ==== //
gsap.from(".info-text", {
    opacity: 0,
    y: 20,
    delay: 0.8,
    duration: 1,
});
// ==== CTA BUTTONS ==== //
gsap.from(".btn_wrapper", {
    opacity: 0,
    x: -100,
    delay: 0.8,
    duration: 1,
});
// ==== TEAM IMAGE ==== //
gsap.from(".team_img_wrapper img", {
    opacity: 0,
    y: 20,
    delay: 1,
    duration: 1,
});
// ==== SLOGAN ==== //
gsap.from(".slogan", {
    opacity: 0,
    y: 20,
    delay: 0.8,
    duration: 1,
});
