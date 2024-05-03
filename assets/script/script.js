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

document.querySelectorAll('#filter-buttons button').forEach(button => {
    button.addEventListener('click', async () => {
        try {
            const valueType = button.getAttribute('data-type');
            const response = await fetch('planet/filter/' + valueType);
            if (!response.ok) {
                throw new Error('Error fetching data');
            }
            const planets = await response.json();

            let html = '';
            planets.forEach(planet => {
                html += `
                    <div class="galery">
                        <img src="/uploads/images/planets/${planet.image}" alt="image ${planet.name}" class="galeryImg">
                        <div class="galeryLink">
                            <a href="/planet/${planet.id}" class="brunoAce">See ${planet.name}</a>
                        </div>
                    </div>
                `;
            });

            const gallery = document.querySelector('#planetsGalery');
            gallery.innerHTML = html;
        } catch (error) {
            console.error('Error fetching planets:', error);
        }
    });
});

document.querySelectorAll('#filter-buttons-lifeform button').forEach(button => {
    button.addEventListener('click', async () => {
        try {
            const valueType = button.getAttribute('data-type');
            const response = await fetch('filter/' + valueType);
            if (!response.ok) {
                throw new Error('Error fetching data');
            }
            const lifeforms = await response.json();

            let html = '';
            lifeforms.forEach(lifeform => {
                html += `
                    <div class="galery">
                        <img src="/uploads/images/lifeform/${lifeform.image}" alt="image ${lifeform.name}" class="galeryImg">
                        <div class="galeryLink">
                            <a href="/lifeform/${lifeform.id}" class="brunoAce">See ${lifeform.name}</a>
                        </div>
                    </div>
                `;
            });

            const gallery = document.querySelector('#lifeformsGalery');
            gallery.innerHTML = html;
        } catch (error) {
            console.error('Error fetching planets:', error);
            if ('status' in response) {
                console.error('Status:', response.status);
                console.error('Status Text:', response.statusText);
            }
        }
    });
});