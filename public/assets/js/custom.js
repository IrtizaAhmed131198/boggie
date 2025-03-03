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








$(document).ready(function() {
    // Smooth scroll to the target section
    $('.scroll-btn').click(function() {
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

