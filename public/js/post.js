(() => {

    const filesDropArea = document.querySelector('#files-drop-area');
    const inputFiles = document.querySelector('#input-files');
    const uploadedFileList = document.querySelector('#uploaded-file-list');

    const addImageButton = document.querySelector('#add-image');
    const makePostImgs = document.querySelector('#make-post-imgs');

    const imageViewers = document.querySelectorAll('.imgs');

    for (let i = 0; i < imageViewers.length; i++) {
        const imageViewer = imageViewers[i];

        const imageBoxes = imageViewer.querySelectorAll('.image-container > div');
        const images = imageViewer.querySelectorAll('.image-container > div > img:not(.remove)');
        const selectedImage = imageViewer.querySelector('.selected-image > img:not(.remove)');
        const imageBox = imageViewer.querySelector('.image-container');

        const addEventsForImage = (root, boxes) => {
            const defaultImage = imageViewer.querySelector('.image-container > div:not([disabled])');
            if (defaultImage !== null) {
                defaultImage.setAttribute('selected', true);
                if (defaultImage.querySelector('img:not(.remove)') != null) {
                    selectedImage.src = defaultImage.querySelector('img:not(.remove)').src;
                    const index = Array.from(boxes).indexOf(defaultImage);
                    selectedImage.setAttribute('data-index', index);
                }
            }
            for (let i = 0, k = 0; i < boxes.length; i++, k++) {
                if (boxes[i].getAttribute('disabled') !== null) {
                    continue;
                }
                boxes[i].setAttribute('data-index', i);
                boxes[i].addEventListener('click', (() => {
                    boxes[i].setAttribute('selected', true);
                    const image = boxes[i].querySelector('img:not(.remove)');
                    const lastIndex = selectedImage.getAttribute('data-index');
                    if (lastIndex !== null && lastIndex > -1) {
                        boxes[lastIndex].removeAttribute('selected');
                    }
                    selectedImage.src = image.src;
                    selectedImage.setAttribute('data-index', boxes[i].getAttribute('data-index'));
                    boxes[i].setAttribute('selected', true);
                }).bind(this));
            }
            if (root.getAttribute("edit-mode") != null) {
                for (let i = 0; i < boxes.length; i++) {
                    if (boxes[i].getAttribute('disabled') !== null) {
                        continue;
                    }
                    // Add remove button
                    const remove = document.createElement('div');
                    remove.classList.add('remove');
                    remove.innerHTML = '<img src="/public/img/close.png">';
                    remove.addEventListener('click', () => {
                        imageBox.removeChild(boxes[i]);
                        const index = Array.from(images).indexOf(images[i]);
                        images = [...images.slice(0, index), ...images.slice(index + 1)];
                    });
                    boxes[i].appendChild(remove);
                    // Add change position on queue use mouse move
                    boxes[i].addEventListener('mousedown', (e) => {
                        const index = Array.from(boxes).indexOf(boxes[i]);
                        const mouseDownX = e.pageX;
                        const mouseDownY = e.pageY;
                        const mouseMove = (e) => {
                            const mouseMoveX = e.pageX;
                            const mouseMoveY = e.pageY;
                            if (Math.abs(mouseMoveX - mouseDownX) > 10 || Math.abs(mouseMoveY - mouseDownY) > 10) {
                                const next = boxes[i].nextElementSibling;
                                const prev = boxes[i].previousElementSibling;
                                if (next !== null && next.getAttribute('disabled') === null) {
                                    const nextIndex = Array.from(boxes).indexOf(next);
                                    if (mouseMoveX > mouseDownX) {
                                        imageBox.insertBefore(boxes[i], next.nextElementSibling);
                                        images = [...images.slice(0, index), ...images.slice(index + 1, nextIndex), images[i], ...images.slice(nextIndex + 1)];
                                    }
                                }
                                if (prev !== null && prev.getAttribute('disabled') === null) {
                                    const prevIndex = Array.from(boxes).indexOf(prev);
                                    if (mouseMoveX < mouseDownX) {
                                        imageBox.insertBefore(boxes[i], prev);
                                        images = [...images.slice(0, prevIndex), images[i], ...images.slice(prevIndex, index), ...images.slice(index + 1)];
                                    }
                                }
                            }
                        }
                        const mouseUp = (e) => {
                            document.removeEventListener('mousemove', mouseMove);
                            document.removeEventListener('mouseup', mouseUp);
                        }
                        document.addEventListener('mousemove', mouseMove);
                        document.addEventListener('mouseup', mouseUp);
                        document.addEventListener('mouseleave', mouseUp);
                        document.addEventListener('mouseenter', mouseUp);
                    });
                }
            }
            addImageButton.addEventListener('click', () => {
                inputFiles.click();
            });
        };

        addEventsForImage(imageBox, imageBoxes);

        let observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                addEventsForImage(mutation.target, mutation.target.children);
            });
        });
        observer.observe(imageBox, {
            childList: true
        });
    }


    if (filesDropArea !== null) {

        filesDropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            filesDropArea.classList.add('dragover');
        });

        filesDropArea.addEventListener('dragleave', (e) => {
            e.preventDefault();
            filesDropArea.classList.remove('dragover');
        });

        filesDropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            filesDropArea.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const lastIndex = inputFiles.files.length - 1;
                if (lastIndex > -1) {
                    inputFiles.files = [...inputFiles.files, ...files];
                } else {
                    inputFiles.files = files;
                }
                handleFiles(files);
            }
        });

        filesDropArea.addEventListener('click', () => {
            inputFiles.click();
        });

        inputFiles.addEventListener('change', (e) => {
            const files = e.target.files;
            if (files.length > 0) {
                handleFiles(files);
            }
        });

        addImageButton.addEventListener('click', () => {
            inputFiles.click();
        });

        function handleFiles(files) {
            // rm all files from same name
            const filesName = [];
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (filesName.indexOf(file.name) > -1) {
                    files = [...files.slice(0, i), ...files.slice(i + 1)];
                    i--;
                } else {
                    filesName.push(file.name);
                }
            }

            if (files.length > 0) {
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    if (file.type.match('image.*')) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            const image = document.createElement('img');
                            image.src = e.target.result;
                            image.title = file.name;
                            image.alt = file.name;
                            makePostImgs.innerHTML += `<div><img data-name="${file.name}" src="${image.src}"></div>`;
                        }
                        reader.readAsDataURL(file);
                    } else {
                        let name = "";
                        if (file.name.length > 10) {
                            name = file.name.substring(0, 10) + "...";
                        } else {
                            name = file.name;
                        }
                        const div = document.createElement('div');
                        div.classList.add('file');
                        div.title = file.name;
                        div.innerHTML = `<div class="file-type"><img src="/public/img/file.png"></div><div class="name"><a href="#">${name}</a></div><div class="size"><p>${calcSize(file.size)}</p></div>`;
                        const remove = document.createElement('div');
                        remove.classList.add('remove');
                        remove.innerHTML = '<img src="/public/img/close.png">';
                        remove.addEventListener('click', () => {
                            uploadedFileList.removeChild(div);
                            const index = Array.from(inputFiles.files).indexOf(file);
                            inputFiles.files = [...inputFiles.files.slice(0, index), ...inputFiles.files.slice(index + 1)];
                        });
                        div.appendChild(remove);
                        uploadedFileList.appendChild(div);
                    }
                }
            }

            function calcSize(size) {
                if (size < 1024) {
                    return `${size} B`;
                } else if (size < 1024 * 1024) {
                    return `${Math.floor(size / 1024 * 100) / 100} KB`;
                } else if (size < 1024 * 1024 * 1024) {
                    return `${Math.floor(size / 1024 / 1024 * 100) / 100} MB`;
                } else {
                    return `${Math.floor(size / 1024 / 1024 / 1024 * 100) / 100} GB`;
                }
            }
        }
    }

})();