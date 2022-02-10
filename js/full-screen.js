function fullScreenFunction(zoomDownButton, zoomUpButton, fullScreenButton, playPauseButton, closeButton, img) {
    let width = 100;
    zoomFunction(img, width, width);

    // zoom down
    zoomDownButton.addEventListener('click', () => {
        if (width > 100) zoomFunction(img, width -= 10, width)
    });

    // zoom up
    zoomUpButton.addEventListener('click', () => {
        if (width < 300) zoomFunction(img, width += 10, width)
    });

    // scroll
    document.querySelector(".full-screen").addEventListener('wheel', function (event) {
        if (event.deltaY > 0) {
            if (width > 100) zoomFunction(img, width -= 10, width);
        }
        else if (event.deltaY < 0) {
            if (width < 300) zoomFunction(img, width += 10, width)
        }
    });

    // full screen
    fullScreenButton.addEventListener('click', () => {
        zoomFunction(img, width = 100, width);
        img.style.top = 0;
        img.style.left = 0;
    });

    // zoomFunction
    function zoomFunction(img, w, h) {
        if (w >= 100 && w <= 300) {
            img.style.width = w + '%';
            img.style.height = h + '%';
        }
        if (w > 100) img.style.cursor = "grab"
        else img.style.cursor = "default";
    }

    // drag'n'drop
    img.onmousedown = function (e) {
        if (width > 100) {
            let coords = getCoords(img);
            let shiftX = e.pageX - coords.left;
            let shiftY = e.pageY - coords.top;

            img.style.position = 'absolute';
            let newImg = document.querySelector('.full-screen__container').appendChild(img);
            zoomFunction(newImg, width, width);
            newImg.style.objectFit = "contain";
            newImg.style.cursor = "grabbing";
            moveAt(e);

            img.style.zIndex = 15;

            function moveAt(e) {
                img.style.left = e.pageX - shiftX + 'px';
                img.style.top = e.pageY - shiftY + 'px';
            }

            document.onmousemove = function (e) {
                moveAt(e);
            };

            img.onmouseup = function () {
                img.style.cursor = "grab";
                document.onmousemove = null;
                img.onmouseup = null;
            };
        }
    }

    img.ondragstart = function () {
        return false;
    };

    function getCoords(elem) {
        let img = elem.getBoundingClientRect();
        return {
            top: img.top + pageYOffset,
            left: img.left + pageXOffset
        };
    }

    // previous

    // play
    playPauseButton.addEventListener('click', function () {
        playPauseButton.querySelector("div").classList.toggle("triangle")
        playPauseButton.querySelector("div").classList.toggle("pause");
    });

    // next

    //close 
    closeButton.addEventListener('click', closeFunction);
    document.addEventListener('keyup', function (event) {
        if (event.code == "Escape") closeFunction();
    });

    function closeFunction() {
        document.querySelector(".full-screen").style.display = "none";
    }
}