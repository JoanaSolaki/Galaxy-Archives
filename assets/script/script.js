document.querySelectorAll('img').forEach(img => {
    img.ondragstart = function() {
        return false;
    };
});

const observation = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
        entry.target.classList.add('animate-animation');
        }
    });
});
    const viewbox = document.querySelectorAll('.animate');
    viewbox.forEach(image => {
    observation.observe(image);
});