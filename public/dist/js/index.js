
// Get the current URL
const currentUrl = window.location.href;

// Get the links for Page #1 and Page #2
const page1Link = document.getElementById('page1-link');
const page2Link = document.getElementById('page2-link');

// Check if the current URL matches the links' href
if (currentUrl.includes('index1.html')) {
    // Add the "active" class to the Page #1 li element
    page1Link.classList.add('active');
} else if (currentUrl.includes('index2.html')) {
    // Add the "active" class to the Page #2 li element
    page2Link.classList.add('active');
}