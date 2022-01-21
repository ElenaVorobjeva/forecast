let start = 0;
let end = 120;
let step = 3;
let date = getDateObj('2021100100');

sliderHandler(start, end, step, date);

function sliderHandler(start, end, step, date) {
    let slider = document.querySelector("#sliderInput");
    let sliderLabel = document.querySelector(".slider-label");

    slider.setAttribute("min", start); 
    slider.setAttribute("max", end); 
    slider.setAttribute("step", step); 
    slider.setAttribute("value", start);

    document.querySelector(".start").innerHTML = start;
    document.querySelectorAll(".prev").forEach(function (item) {
        item.innerHTML = "-" + step + "ч.";
    });
    document.querySelector(".end").innerHTML = end;
    document.querySelectorAll(".next").forEach(function (item) {
        item.innerHTML = "+" + step + "ч.";
    });
    document.querySelector(".slider-label").innerHTML = start + "ч.";

    let startDate = new Date(date);
    startDate.setHours(startDate.getHours() + start);

    let hoursInDay = 0;
    for(let i = 1; i <= end - start; i++) {
        if(startDate.getHours() !== 0) hoursInDay++;
        else {
            if(i !== 1) {
                startDate.setDate(startDate.getDate() - 1);
                createBlock(startDate, hoursInDay);
                hoursInDay = 1;
                startDate.setDate(startDate.getDate() + 1);
            }
            else hoursInDay++;
        }
        if(i === end - start) {
            createBlock(startDate, hoursInDay);
            hoursInDay = 1;
        }
        startDate.setHours(startDate.getHours() + 1);
    }

    function createBlock(date, width) {
        let dayBlock = document.createElement('div');
        dayBlock.className = 'day';
        dayBlock.style.width = width / (end - start) * 100 + '%';
        dayBlock.innerHTML = window.innerWidth <= 525 ? `${addZero(date.getDate())}.${addZero(date.getMonth() + 1)}` : `${addZero(date.getDate())}.${addZero(date.getMonth() + 1)}.${date.getFullYear()}`;
        document.querySelector('.day-container').append(dayBlock);
    }

    slider.addEventListener("input", showSliderValue, false);

    document.querySelector("#previous-button").addEventListener('click', function() {
        if(slider.value >= start && slider.value <= end) {
            slider.value = +slider.value - step;
            showSliderValue();
        }
    });

    document.querySelector("#next-button").addEventListener('click', function() {
        if(slider.value >= start && slider.value <= end) {
            slider.value = +slider.value + step;
            showSliderValue();
        }
    });

    document.querySelector('.component_map-container img').addEventListener("wheel", function(e) {
        if(slider.value >= start && slider.value <= end) {
            if (e.deltaY < 0) {
                slider.value = +slider.value - step;
            }
            else if (e.deltaY > 0) {
                slider.value = +slider.value + step;
            }
            showSliderValue();
        }
    });

    function showSliderValue() {
        sliderLabel.innerHTML = slider.value + 'ч.';
        let bulletPosition = (slider.value - slider.min) / (slider.max - slider.min);
        sliderLabel.style.left = Math.floor(bulletPosition * (slider.offsetWidth - 20)) + "px";
    }

    function addZero(num) {
        return ('0' + num).slice(-2);
    }
}

function getDateObj(date) { 
    return new Date(
        +date.slice(0, 4), 
        +date.slice(4, 6) - 1,
        +date.slice(6, 8),
        +date.slice(8)
    );
}