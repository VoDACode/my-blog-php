(() => {
    const imageBoxes = document.querySelectorAll('.image-container > div');
    const images = document.querySelectorAll('.image-container > div > img');
    const selectedImage = document.querySelector('.selected-image > img');
    const imageBox = document.querySelector('.image-container');

    selectedImage.setAttribute('data-index', 0);
    selectedImage.src = images[0].src;
    imageBoxes[0].setAttribute('selected', true);
    for(let i = 0; i < imageBoxes.length; i++) {
        imageBoxes[i].setAttribute('data-index', i);
        imageBoxes[i].addEventListener('click', () => {
            imageBoxes[i].setAttribute('selected', true);
            const image = imageBoxes[i].querySelector('img');
            const lastIndex = selectedImage.getAttribute('data-index');
            if(lastIndex !== null && lastIndex > -1) {
                imageBoxes[lastIndex].removeAttribute('selected');
            }
            selectedImage.src = image.src;
            selectedImage.setAttribute('data-index', imageBoxes[i].getAttribute('data-index'));
            imageBoxes[i].setAttribute('selected', true);
        });

        images[i].addEventListener('keydown', (e) => {
            console.log(e.keyCode);
            if(e.keyCode === 13) {
                images[i].click();
            }else if(e.keyCode === 37) {
                const prev = images[i].previousElementSibling;
                if(prev !== null) {
                    prev.click();
                }
            }else if(e.keyCode === 39) {
                const next = images[i].nextElementSibling;
                if(next !== null) {
                    next.click();
                }
            }
        });
    }
})();