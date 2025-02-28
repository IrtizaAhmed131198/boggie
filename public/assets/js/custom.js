// audio player 
document.addEventListener('DOMContentLoaded', function () {
    const audio = document.getElementById('audio');
    const playPauseButton = document.getElementById('play-pause-button');
    const playBtn = document.getElementById('play-btn');
    const progressBar = document.getElementById('progress-bar');
    const seekBar = document.getElementById('seek-bar');
    const timestamp = document.getElementById('timestamp');

    // Function to toggle play/pause
    function togglePlayPause() {
        if (audio.paused) {
            audio.play();
            playPauseButton.setAttribute('aria-label', 'Pause');
            playPauseButton.innerHTML = `
                <svg width="18px" height="20px" viewBox="0 0 18 20" xmlns="http://www.w3.org/2000/svg">
                    <g fill="currentcolor">
                        <path d="M0,0 L6,0 L6,20 L0,20 Z M12,0 L18,0 L18,20 L12,20 Z"></path>
                    </g>
                </svg>
            `; // Pause icon
        } else {
            audio.pause();
            playPauseButton.setAttribute('aria-label', 'Play');
            playPauseButton.innerHTML = `
                <svg width="18px" height="20px" viewBox="0 0 18 20" xmlns="http://www.w3.org/2000/svg">
                    <g fill="currentcolor">
                        <path d="M17.29,9.02 C18.25,9.56 18.25,10.44 17.29,10.98 L1.74,19.78 C0.78,20.33 0,19.87 0,18.76 L0,1.24 C0,0.13 0.78,-0.32 1.74,0.22 L17.29,9.02 Z"></path>
                    </g>
                </svg>
            `; // Play icon
        }
    }

    // Add event listeners to both buttons
    playPauseButton.addEventListener('click', togglePlayPause);
    playBtn.addEventListener('click', togglePlayPause);

    // Update progress bar and timestamp
    audio.addEventListener('timeupdate', function () {
        const currentTime = audio.currentTime;
        const duration = audio.duration;

        // Ensure duration is a valid number
        if (duration > 0) {
            const progressPercent = (currentTime / duration) * 100;

            // Update progress bar and seek bar
            progressBar.value = progressPercent;
            seekBar.value = progressPercent;

            // Update timestamp
            const currentMinutes = Math.floor(currentTime / 60);
            const currentSeconds = Math.floor(currentTime % 60);
            const durationMinutes = Math.floor(duration / 60);
            const durationSeconds = Math.floor(duration % 60);

            timestamp.textContent = 
                `${padTime(currentMinutes)}:${padTime(currentSeconds)} / ${padTime(durationMinutes)}:${padTime(durationSeconds)}`;
        }
    });

    // Seek functionality
    seekBar.addEventListener('input', function () {
        const seekTime = (seekBar.value / 100) * audio.duration;
        audio.currentTime = seekTime;
    });

    // Helper function to pad time values
    function padTime(time) {
        return time < 10 ? `0${time}` : time;
    }
});
// audio player 


// new fullpage('#fullpage', {
//     navigation: true,
//     responsiveWidth: 700,
//     easing: 'easeInOutBack',
//     // anchors: ['home', 'about-us', 'contact'],
//     parallax: true,
//     onLeave: function (origin, destination, direction) {
//         console.log("Leaving section" + origin.index);
//     },
// });





//           let isScrolling = false; // Prevents triggering scroll multiple times in quick succession

// // Add an event listener to detect wheel scrolling
// document.addEventListener("wheel", function(event) {
//     if (isScrolling) return; // Ignore if already scrolling

//     // Define sections for smooth scroll behavior
//     const section2 = document.querySelector("#section1");
//     const section3 = document.querySelector("#section2");

//     // Check if we are in Section 2 or Section 3
//     if (section2.getBoundingClientRect().top <= window.innerHeight && section2.getBoundingClientRect().bottom > 0) {
//         // Inside Section 2
//         if (event.deltaY > 0 && !isScrolling) {  // Scroll down
//             isScrolling = true;
//             section3.scrollIntoView({ behavior: "smooth" });
//             setTimeout(() => { isScrolling = false; }, 800); // Reset after animation
//         } else if (event.deltaY < 0 && !isScrolling) { // Scroll up
//             isScrolling = true;
//             section1.scrollIntoView({ behavior: "smooth" });
//             setTimeout(() => { isScrolling = false; }, 800); // Reset after animation
//         }
//     } else if (section3.getBoundingClientRect().top <= window.innerHeight && section3.getBoundingClientRect().bottom > 0) {
//         // Inside Section 3
//         if (event.deltaY > 0 && !isScrolling) {  // Scroll down
//             isScrolling = true;
//             // We can define any further content to scroll here
//             window.scrollTo({ top: document.body.scrollHeight, behavior: "smooth" });
//             setTimeout(() => { isScrolling = false; }, 800); // Reset after animation
//         } else if (event.deltaY < 0 && !isScrolling) { // Scroll up
//             isScrolling = true;
//             section2.scrollIntoView({ behavior: "smooth" });
//             setTimeout(() => { isScrolling = false; }, 800); // Reset after animation
//         }
//     }
// }, { passive: false });









$(document).ready(function () {
    // Smooth scroll to the target section
    $('.scroll-btn').click(function () {
        $('.section').removeClass('hidden');
        $('#main-parent').slideDown();
        var target = $(this).data('target'); // Get the target section ID
        $('html, body').animate({
            scrollTop: $(target).offset().top
        }, 1000); // Duration of the scroll (1000ms = 1 second)
    });

    let lastScrollTop = $(window).scrollTop();

    $(window).on("scroll", function () {
        let scrollTop = $(this).scrollTop();
        let section2Top = $("#section2").offset().top;
        let section2Height = $("#section2").outerHeight();

        // Detect if Section 2 is in viewport while scrolling up
        if (
            scrollTop < lastScrollTop && // Scrolling up
            scrollTop >= section2Top - $(window).height() / 2 && // Section 2 enters viewport
            scrollTop < section2Top + section2Height
        ) {
            hideOtherSections($("#section2")); // Hide other sections when Section 2 is in view
        }

        lastScrollTop = scrollTop;
    });

    // Function to hide all sections except the one in view
    function hideOtherSections($visibleSection) {
        $(".section").not($visibleSection).addClass("hidden");
        $visibleSection.removeClass("hidden");
    }

});




//  let currentSection = 0;  // Keeps track of the current section
//                 const totalSections = document.querySelectorAll('.sectionscrl').length; // Total number of sections

//                 // Scroll event handler
//                 function handleScroll(event) {
//                     // Normalize the wheel delta (different browsers use different values)
//                     const delta = event.wheelDelta || -event.deltaY || -event.detail;

//                     // Scroll up (delta > 0) or scroll down (delta < 0)
//                     if (delta > 0 && currentSection > 0) {
//                         currentSection--;  // Scroll up to the previous section
//                     } else if (delta < 0 && currentSection < totalSections - 1) {
//                         currentSection++;  // Scroll down to the next section
//                     }

//                     // Scroll to the target section
//                     scrollToSection(currentSection);
//                 }

//                 // Function to scroll to the target section
//                 function scrollToSection(sectionIndex) {
//                     const targetSection = document.querySelectorAll('.sectionscrl')[sectionIndex]; // Get the target section
//                     window.scrollTo({
//                         top: targetSection.offsetTop, // Scroll to the section's offset position
//                         behavior: 'smooth' // Enable smooth scrolling
//                     });
//                 }

//                 // Attach the scroll event listener to the document
//                 document.addEventListener('wheel', handleScroll, { passive: false }); // 'passive: false' is necessary for 'event.preventDefault()' to work

















function switchDiv() {
    var e = $(window).outerWidth();
    768 >= e && $(".topAppendTxt").each(function () {
        var e = $(this).find(".cloneDiv").clone(!0);
        $(this).find(".cloneDiv").remove(), $(this).append(e)
    })
}

function playVideo1() {
    document.getElementById("video2").pause(), document.getElementById("video3").pause()
}

function playVideo2() {
    document.getElementById("video1").pause(), document.getElementById("video3").pause()
}

function playVideo3() {
    document.getElementById("video2").pause(), document.getElementById("video1").pause()
}
$(document).ready(function () {
    function e() {
        var e = (new Date).getTime(),
            c = (l - e) / 1e3;
        t = s(parseInt(c / 86400)), c %= 86400, i = s(parseInt(c / 3600)), c %= 3600, a = s(parseInt(c / 60)), o = s(parseInt(c % 60)), n.innerHTML = "<span>" + t + "</span><span>" + i + "</span><span>" + a + "</span><span>" + o + "</span>"
    }

    function s(e) {
        return (10 > e ? "0" : "") + e
    }
    $(".howitwork-carousel").owlCarousel({
        loop: !0,
        nav: !1,
        mouseDrag: !1,
        autoplay: !1,
        autoplayTimeout: 3e3,
        autoplayHoverPause: !0,
        dots: !0,
        items: 1,
        autoHeight: !1
    }), $("#step1").addClass("hiw-active"), $("#step1").click(function () {
        $("#step2, #step3, #step4, #step5, #step6").removeClass("hiw-active"), $("#step1").addClass("hiw-active"), $(".howitwork-carousel").trigger("to.owl.carousel", 0)
    }), $("#step2").click(function () {
        $("#step1, #step3, #step4, #step5, #step6").removeClass("hiw-active"), $("#step2").addClass("hiw-active"), $(".howitwork-carousel").trigger("to.owl.carousel", 1)
    }), $("#step3").click(function () {
        $("#step1, #step2, #step4, #step5, #step6").removeClass("hiw-active"), $("#step3").addClass("hiw-active"), $(".howitwork-carousel").trigger("to.owl.carousel", 2)
    }), $("#step4").click(function () {
        $("#step1, #step2, #step3, #step5, #step6").removeClass("hiw-active"), $("#step4").addClass("hiw-active"), $(".howitwork-carousel").trigger("to.owl.carousel", 3)
    }), $("#step5").click(function () {
        $("#step1, #step2, #step3, #step4, #step6").removeClass("hiw-active"), $("#step5").addClass("hiw-active"), $(".howitwork-carousel").trigger("to.owl.carousel", 4)
    }), $("#step6").click(function () {
        $("#step1, #step2, #step3, #step4, #step5").removeClass("hiw-active"), $("#step6").addClass("hiw-active"), $(".howitwork-carousel").trigger("to.owl.carousel", 5)
    }), $(".owl-dot:nth-child(1)").click(function () {
        $("#step2, #step3, #step4, #step5, #step6").removeClass("hiw-active"), $("#step1").addClass("hiw-active"), $(".howitwork-carousel").trigger("to.owl.carousel", 0)
    }), $(".owl-dot:nth-child(2)").click(function () {
        $("#step1, #step3, #step4, #step5, #step6").removeClass("hiw-active"), $("#step2").addClass("hiw-active"), $(".howitwork-carousel").trigger("to.owl.carousel", 1)
    }), $(".owl-dot:nth-child(3)").click(function () {
        $("#step1, #step2, #step4, #step5, #step6").removeClass("hiw-active"), $("#step3").addClass("hiw-active"), $(".howitwork-carousel").trigger("to.owl.carousel", 2)
    }), $(".owl-dot:nth-child(4)").click(function () {
        $("#step1, #step2, #step3, #step5, #step6").removeClass("hiw-active"), $("#step4").addClass("hiw-active"), $(".howitwork-carousel").trigger("to.owl.carousel", 3)
    }), $(".owl-dot:nth-child(5)").click(function () {
        $("#step1, #step2, #step3, #step4, #step6").removeClass("hiw-active"), $("#step5").addClass("hiw-active"), $(".howitwork-carousel").trigger("to.owl.carousel", 4)
    }), $(".owl-dot:nth-child(6)").click(function () {
        $("#step1, #step2, #step3, #step4, #step5").removeClass("hiw-active"), $("#step6").addClass("hiw-active"), $(".howitwork-carousel").trigger("to.owl.carousel", 5)
    }), switchDiv(), $("li:first-child").addClass("first"), $("li:last-child").addClass("last"), $('[href="#"]').attr("href", "javascript:;"), $(".menu-Bar").click(function () {
        $(this).toggleClass("open"), $(".menuWrap").toggleClass("open"), $("body").toggleClass("ovr-hiddn")
    }), $(".loginUp").click(function () {
        $(".LoginPopup").fadeIn(), $(".overlay").fadeIn()
    }), $(".signUp").click(function () {
        $(".signUpPop").fadeIn(), $(".overlay").fadeIn()
    }), $(".btn-popup").click(function () {
        $(".LoginPopup").fadeIn(), $(".overlay").fadeIn()
    }), $(".closePop,.overlay").click(function () {
        $(".popupMain").fadeOut(), $(".overlay").fadeOut()
    }), $(".menu .menu-item-has-children").addClass("dropdown-nav "), $(".menu .menu-item-has-children ul.sub-menu").addClass("dropdown"), $("[data-targetit]").on("click", function (e) {
        $(this).addClass("active"), $(this).siblings().removeClass("active");
        var s = $(this).data("targetit");
        $("." + s).siblings('[class^="box-"]').hide(), $("." + s).fadeIn(), $(".tabViewList").slick("setPosition", 0)
    }), $(".accordian h4").click(function () {
        $(".accordian li").removeClass("active"), $(this).parent("li").addClass("active"), $(".accordian li div").slideUp(), $(this).parent("li").find("div").slideDown()
    }), $("li.dropdown-nav").hover(function () {
        $(this).children("ul").stop(!0, !1, !0).slideToggle(300)
    }), $(".searchBtn").click(function () {
        $(".searchWrap").addClass("active"), $(".overlay").fadeIn("active"), $(".searchWrap input").focus(), $(".searchWrap input").focusout(function (e) {
            $(this).parents().removeClass("active"), $(".overlay").fadeOut("active"), $("body").removeClass("ovr-hiddn")
        })
    }), $(".index-slider").slick({
        dots: !1,
        infinite: !0,
        speed: 300,
        slidesToShow: 1
    }), $(".testi-sldier").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: !0,
        dots: !1,
        arrows: !0,
        lazyLoad: "progressive",
        focusOnSelect: !0,
        prevArrow: '<i class="fas fa-caret-left slick-prev key1"></i>',
        nextArrow: '<i class="fas fa-caret-right slick-next key2"></i>',
        responsive: [{
            breakpoint: 568,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }]
    }), $(".client_strip_slider").slick({
        dots: !1,
        arrows: !1,
        infinite: !0,
        speed: 300,
        autoplay: !0,
        slidesToShow: 6,
        slidesToScroll: 1,
        responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: !0,
                dots: !0
            }
        }, {
            breakpoint: 767,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        }]
    }), $("#popupcountrycode").val("+1"), $("#countrycode").val("+1"), $("#homeformcountry").change(function () {
        var e = $(this).children("option:selected").val(),
            s = $(this).children("option:selected").attr("data-abbr");
        $("#countrycode").val("+" + e), "CA" == s ? ($(this).siblings("span").removeClass(), $(this).siblings("span").addClass("fgca")) : ($(this).siblings("span").removeClass(), $(this).siblings("span").addClass("fg" + e))
    }), $("#popupformcountry").change(function () {
        var e = $(this).children("option:selected").val(),
            s = $(this).children("option:selected").attr("data-abbr");
        $("#popupcountrycode").val("+" + e), "CA" == s ? ($(this).siblings("span").removeClass(), $(this).siblings("span").addClass("fgca")) : ($(this).siblings("span").removeClass(), $(this).siblings("span").addClass("fg" + e))
    }), $(".countrylist").change(function () {
        var e = $(this).children("option:selected").val(),
            s = $(this).children("option:selected").attr("data-abbr");
        $("#countrycode").val("+" + e), $(".countrycode").val("+" + e), "CA" == s ? ($(this).siblings("span").removeClass(), $(this).siblings("span").addClass("fgca")) : ($(this).siblings("span").removeClass(), $(this).siblings("span").addClass("fg" + e))
    });
    var t, i, a, o, l = (new Date).getTime() + 1728e5,
        n = document.getElementById("tiles");
    e(), setInterval(function () {
        e()
    }, 1e3)
}), $(".side-bar-frm-head, .sidebar-popup").click(function () {
    $(".side-bar-form").toggleClass("active"), $(".side-bar-frm-head").toggleClass("active"), $(".side-bar").toggleClass("active")
}), $(window).on("load", function () {
    var e = window.location.href.substr(window.location.href.lastIndexOf("index.html") + 1);
    $("ul.menu li a").each(function () {
        var s = $(this).attr("href");
        s == e && ($(this).removeClass("active"), $(this).closest("li").addClass("active"), $("ul.menu li.first").removeClass("active"))
    }), $(window).width() > 767
}), $(window).width() < 767 && $(".client-strip ul").slick({
    dots: !1,
    infinite: !0,
    speed: 300,
    slidesToShow: 2,
    autoplay: !0
});

