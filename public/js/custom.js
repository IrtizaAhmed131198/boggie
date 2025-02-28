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



// filepond js 



// filepond js 