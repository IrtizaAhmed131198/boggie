<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://unpkg.com/fullpage.js/dist/fullpage.min.js"></script>

<!--<script src="js/lax.js"></script>-->

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- filepond cdns -->
<!-- filepond cdns -->

<script src="js/custom.js"></script>
<script>
    document.getElementById('uploadImage').addEventListener('change', function(event) {
        let previewContainer = document.getElementById('imagePreview');
        previewContainer.innerHTML = ""; // Clear previous previews

        for (let file of event.target.files) {
            let reader = new FileReader();
            reader.onload = function(e) {
                let img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = "230px"; // Adjust size as needed
                img.style.height = "150px";
                img.style.objectFit = "cover";
                img.style.border = "1px solid #ccc";
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
<script>
    let canvas = document.getElementById("imageCanvas");
let ctx = canvas.getContext("2d");
let userImage = new Image();
let templateImage = new Image();
let isDragging = false;
let offsetX, offsetY, templateX = 50, templateY = 50;
let templateWidth = 150, templateHeight = 150;

// PNG Template Image
templateImage.src = "{{ asset('assets/images/Gecko-hoodie-and-glasses.png') }}";

// ✅ Fix: Canvas Size hamesha 500x500
canvas.width = 500;
canvas.height = 500;

document.getElementById("uploadImage").addEventListener("change", function(event) {
    let file = event.target.files[0];
    if (file) {
        let reader = new FileReader();
        reader.onload = function(e) {
            userImage.onload = () => {
                drawCanvas(); // Image ko canvas par adjust karo
                new bootstrap.Modal(document.getElementById("imageEditorModal")).show();
            };
            userImage.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

function drawCanvas() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // ✅ Fix: Image ko canvas ke andar fit dikhana
    let scale = Math.min(canvas.width / userImage.width, canvas.height / userImage.height);
    let imgWidth = userImage.width * scale;
    let imgHeight = userImage.height * scale;
    let imgX = (canvas.width - imgWidth) / 2;
    let imgY = (canvas.height - imgHeight) / 2;

    // 🟢 **Canvas par Image ko adjust karke draw karo**
    ctx.drawImage(userImage, imgX, imgY, imgWidth, imgHeight);

    // 🟢 **PNG ko bhi draw karo**
    ctx.drawImage(templateImage, templateX, templateY, templateWidth, templateHeight);
}

// ✅ Fix: Unlimited PNG Move Allowed
canvas.addEventListener("mousedown", (e) => {
    let mouseX = e.offsetX;
    let mouseY = e.offsetY;

    if (mouseX >= templateX && mouseX <= templateX + templateWidth &&
        mouseY >= templateY && mouseY <= templateY + templateHeight) {
        isDragging = true;
        offsetX = mouseX - templateX;
        offsetY = mouseY - templateY;
    }
});

canvas.addEventListener("mousemove", (e) => {
    if (isDragging) {
        templateX = e.offsetX - offsetX;
        templateY = e.offsetY - offsetY;
        drawCanvas();
    }
});

canvas.addEventListener("mouseup", () => { isDragging = false; });
canvas.addEventListener("mouseleave", () => { isDragging = false; });
canvas.addEventListener("mouseout", () => { isDragging = false; });

function downloadImage() {
    let link = document.createElement("a");
    
    // 🟢 **Original Image ko Full Resolution me Draw karna**
    let tempCanvas = document.createElement("canvas");
    let tempCtx = tempCanvas.getContext("2d");
    tempCanvas.width = userImage.width;
    tempCanvas.height = userImage.height;

    // 🟢 **Original Image Draw karo**
    tempCtx.drawImage(userImage, 0, 0, userImage.width, userImage.height);

    // 🟢 **PNG bhi Original Image ke hisaab se Adjust karna**
    let pngScale = userImage.width / canvas.width;
    tempCtx.drawImage(templateImage, templateX * pngScale, templateY * pngScale, templateWidth * pngScale, templateHeight * pngScale);

    // 🟢 **Download Final Image**
    link.download = "edited_image.png";
    link.href = tempCanvas.toDataURL();
    link.click();
}

// Initialize FilePond
FilePond.create(document.querySelector('.filepond'));

</script>
<script>
    // Create a new IntersectionObserver instance
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            // Check if the section is in the viewport
            if (entry.isIntersecting) {
                entry.target.classList.add('in-view');
            } else {
                entry.target.classList.remove('in-view');
            }
        });
    }, {
        threshold: 0.5 // Trigger when 50% of the section is in view
    });

    // Select the section element
    const section = document.getElementById('animated-sec');

    // Start observing the section
    observer.observe(section);
</script>

<script>
    var swiper = new Swiper(".mySwiper", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: false,
        loop: true,
        slidesPerView: 4,
        spaceBetween: 0,
        freeMode: false,
        autoplay: {
            delay: 2500,
            disableOnInteraction: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        coverflowEffect: {
            rotate: 50,
            stretch: 0,
            depth: 100,
            modifier: 2,
            slideShadows: true,
        },
        // pagination: {
        //     el: ".swiper-pagination",
        // },
    });
</script>

<script>
    // Play button
    const play_btn = document.querySelector('#play-btn');

    // Audio file
    let sound = new Audio("images/boogie-song.mp3");

    // Enable loop
    sound.loop = true;

    // Play event
    play_btn.addEventListener('click', play);

    function play() {
        sound.play();
    }
</script>

<script>
    jQuery('.parent-marquee').owlCarousel({
        center: true,
        items: 8,
        loop: true,
        margin: 40,
        nav: false,
        dots: false,
        autoplay: true,
        slideTransition: 'linear',
        autoplayTimeout: 3000,
        autoplaySpeed: 3000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 8
            },
            1000: {
                items: 8
            }
        }
    });
</script>

<script>
    jQuery('.parent-marquee-2').owlCarousel({
        center: true,
        items: 6,
        loop: true,
        margin: 50,
        nav: false,
        dots: false,
        // autoWidth: true,
        autoplay: true,
        slideTransition: 'linear',
        autoplayTimeout: 3000,
        autoplaySpeed: 3000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 2
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            },
            1199: {
                items: 5
            },
            1440: {
                items: 6
            }
        }
    });

    jQuery('.parent-marquee-3').owlCarousel({
        center: true,
        items: 8,
        loop: true,
        margin: 0,
        nav: false,
        dots: false,
        autoplay: true,
        slideTransition: 'linear',
        autoplayTimeout: 3000,
        autoplaySpeed: 3000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 2
            },
            600: {
                items: 3
            },
            1000: {
                items: 8
            },
            1199: {
                items: 8
            },
            1440: {
                items: 8
            }
        }
    });
</script>

<script>
    function copyToClipboard() {
        var text = document.getElementById("copyText").innerText;
        var tempInput = document.createElement("textarea");
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
    }
</script>
