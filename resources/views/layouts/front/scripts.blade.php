<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
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
    let canvas = document.getElementById("imageCanvas");
    let ctx = canvas.getContext("2d");
    let userImage = new Image();
    let templateImage = new Image();
    let isDragging = false, offsetX, offsetY, templateX = 50, templateY = 50;

    // PNG Template Image
    templateImage.src = "{{ asset('assets/images/Gecko-hoodie-and-glasses.png') }}";

    document.getElementById("uploadImage").addEventListener("change", function(event) {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                userImage.onload = () => {
                    drawCanvas();
                    new bootstrap.Modal(document.getElementById("imageEditorModal")).show(); // Open modal
                    document.getElementById("uploadImage").value = "edited_image.png"; // Reset input field
                };
                userImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    function drawCanvas() {
        canvas.width = userImage.width || 500;
        canvas.height = userImage.height || 500;
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(userImage, 0, 0, canvas.width, canvas.height);
        if (templateImage.src) {
            ctx.drawImage(templateImage, templateX, templateY, 200, 200);
        }
    }

    canvas.addEventListener("mousedown", (e) => {
        if (e.offsetX >= templateX && e.offsetX <= templateX + 200 &&
            e.offsetY >= templateY && e.offsetY <= templateY + 200) {
            isDragging = true;
            offsetX = e.offsetX - templateX;
            offsetY = e.offsetY - templateY;
        }
    });

    canvas.addEventListener("mousemove", (e) => {
        if (isDragging) {
            templateX = e.offsetX - offsetX;
            templateY = e.offsetY - offsetY;
            drawCanvas();
        }
    });

    canvas.addEventListener("mouseup", () => {
        isDragging = false;
    });

    function downloadImage() {
        let link = document.createElement("a");
        link.download = "edited_image.png";
        link.href = canvas.toDataURL();
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