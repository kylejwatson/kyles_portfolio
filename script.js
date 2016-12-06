/**
 * Created by kyle on 06/12/16.
 */
$(document).ready(function(){
    // Add smooth scrolling to all links
    $("a").on('click', function(event) {

        // Make sure this.hash has a value before overriding default behavior
        if (this.hash != "") {
            // Prevent default anchor click behavior
            event.preventDefault();

            // Store hash
            var hash = this.hash;

            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 800, function(){

                // Add hash (#) to URL when done scrolling (default click behavior)
                window.location.hash = hash;
            });
        } // End if
    });
    $(window).scroll(function() {
       $("aside ul li a").each(function() {
            if ($(document).scrollTop() + $(window).height()/2 < $(this.hash).offset().top) {
               $(this).children("span").addClass("fa-arrow-circle-down").removeClass("fa-arrow-circle-up");
            } else {
                $(this).children("span").addClass("fa-arrow-circle-up").removeClass("fa-arrow-circle-down");
            }
        });
    });
});