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
    var header = $('#site-header');
    var sticky = header.offset().top;

    $(window).scroll(function() {
        if (window.pageYOffset > sticky) {
            header.addClass('sticky');
        } else {
            header.removeClass('sticky');
        }
    });
});
