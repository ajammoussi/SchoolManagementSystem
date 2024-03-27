function isAtBottom() {
    return window.innerHeight + window.scrollY >= document.body.offsetHeight;
}

// Function to load more content
function loadMoreContent() {

    setTimeout(function() {
        const contentContainer = document.getElementById('content');
        const newContent = document.createElement('div');
        newContent.innerHTML = '<p>New content goes here</p>';
        contentContainer.appendChild(newContent);
    }, 1000);
}

// Event listener for scroll events
window.addEventListener('scroll', function() {

    if (isAtBottom()) {
        loadMoreContent();
    }
});

document.addEventListener("DOMContentLoaded", function() {
    // Select all links inside the navigation
    const navLinks = document.querySelectorAll("#navigation a");

    // Loop through each link and attach a click event listener
    navLinks.forEach(function(link) {
        link.addEventListener("click", function(event) {
            // Prevent default link behavior
            event.preventDefault();

            // Get the target section id from the href attribute
            const targetId = this.getAttribute("href").substring(1);

            // Find the target section by id
            const targetSection = document.getElementById(targetId);

            // Scroll to the target section smoothly
            targetSection.scrollIntoView({ behavior: "smooth" });
        });
    });
});
