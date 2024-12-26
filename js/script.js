  // Initialize WOW.js for scroll animations
  new WOW().init();

  // Fade-in effect for content sections
  function handleIntersection(entries, observer) {
      entries.forEach(entry => {
          if (entry.isIntersecting) {
              entry.target.classList.add('visible');
              observer.unobserve(entry.target);
          }
      });
  }

  const observer = new IntersectionObserver(handleIntersection, {
      root: null,
      threshold: 0.1
  });

  document.querySelectorAll('.fade-in').forEach(el => {
      observer.observe(el);
  });

  

  // Function to handle video autoplay with sound
  document.addEventListener('DOMContentLoaded', function() {
      var video = document.getElementById('heroVideo');
      
      // Try to play the video automatically
      var playPromise = video.play();

      if (playPromise !== undefined) {
          playPromise.then(_ => {
              // Autoplay started successfully
              console.log('Autoplay started');
          }).catch(error => {
              // Autoplay was prevented
              console.log('Autoplay prevented');
              
              // Create a play button
              var playButton = document.createElement('button');
              playButton.innerHTML = 'Play Video';
              playButton.style.position = 'absolute';
              playButton.style.zIndex = '10';
              playButton.style.top = '50%';
              playButton.style.left = '50%';
              playButton.style.transform = 'translate(-50%, -50%)';
              playButton.style.padding = '10px 20px';
              playButton.style.fontSize = '18px';
              playButton.style.cursor = 'pointer';
              
              // Add the button to the hero section
              document.querySelector('.hero').appendChild(playButton);
              
              // Play the video when the button is clicked
              playButton.addEventListener('click', function() {
                  video.play();
                  this.remove();
              });
          });
      }
  });

  // Add this script just before the closing </body> tag
  document.addEventListener('DOMContentLoaded', function() {
      const currentLocation = location.href;
      const menuItems = document.querySelectorAll('.nav-menu a');
      const menuLength = menuItems.length;
      for (let i = 0; i < menuLength; i++) {
          if (menuItems[i].href === currentLocation) {
              menuItems[i].className = 'active';
          }
      }
  });

  $(document).ready(function(){
    $('.staff-slider').slick({
        slidesToShow: 3, // Show 3 staff members at a time
        slidesToScroll: 1,
        dots: true, // Show dots for navigation
        infinite: true, // Infinite scrolling
        responsive: [
            {
                breakpoint: 768, // Adjust for smaller screens
                settings: {
                    slidesToShow: 1, // Show 1 staff member on small screens
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 1024, // Adjust for medium screens
                settings: {
                    slidesToShow: 2, // Show 2 staff members on medium screens
                    slidesToScroll: 1
                }
            }
        ]
    });
});$(document).ready(function(){
    $('.staff-slider').slick({
        slidesToShow: 3, // Show 3 staff members at a time
        slidesToScroll: 1,
        dots: true, // Show dots for navigation
        infinite: true, // Infinite scrolling
        responsive: [
            {
                breakpoint: 768, // Adjust for smaller screens
                settings: {
                    slidesToShow: 1, // Show 1 staff member on small screens
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 1024, // Adjust for medium screens
                settings: {
                    slidesToShow: 2, // Show 2 staff members on medium screens
                    slidesToScroll: 1
                }
            }
        ]
    });
});