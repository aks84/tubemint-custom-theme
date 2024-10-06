jQuery(document).ready(function($) {
    var currentIndex = 0;
    var slides = $('.slider-item');
    var slideCount = slides.length;
    var dots = $('.dot');

    function showSlide(index) {
        slides.hide(); // Hide all slides
        slides.eq(index).slideDown();; // Show the current slide

        dots.removeClass('active'); // Remove 'active' class from all dots
        dots.eq(index).addClass('active'); // Add 'active' class to the current dot
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % slideCount;
        showSlide(currentIndex);
    }

    // Initial setup
    showSlide(currentIndex);

    // Auto slide every 5 seconds
    var slideInterval = setInterval(nextSlide, 5000);

    // Handle dot click
    dots.on('click', function() {
        clearInterval(slideInterval); // Stop auto-sliding when a dot is clicked
        var slideIndex = $(this).data('slide');
        currentIndex = slideIndex;
        showSlide(currentIndex);

        // Restart the interval after manual navigation
        slideInterval = setInterval(nextSlide, 5000);
    });
});


jQuery(document).ready(function($) {
    // Handle hover for the main navigation items
    $('.nav-menu > li').hover(
        function() {
            // Show the mega menu on hover
            $(this).find('.mega-menu').stop(true, true).slideDown(300);
        },
        function() {
            // Hide the mega menu when not hovering
            $(this).find('.mega-menu').stop(true, true).slideUp(300);
        }
    );

    // Optional: Handle hover for submenu items if necessary
    $('.menu-item-has-children').hover(
        function() {
            // Show the submenu on hover
            $(this).find('.sub-menu').stop(true, true).slideDown(300);
        },
        function() {
            // Hide the submenu when not hovering
            $(this).find('.sub-menu').stop(true, true).slideUp(300);
        }
    );
});


jQuery(document).ready(function($) {
    $('.nav-menu > li.mega-menu-item').hover(
        function() {
            console.log('Hover in');
            $(this).find('.mega-menu').stop(true, true).slideDown(300);
        },
        function() {
            console.log('Hover out');
            $(this).find('.mega-menu').stop(true, true).slideUp(300);
        }
    );
});