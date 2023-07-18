const currentUrl = window.location.href;

const page1Link = document.getElementById('page1-link');
const page2Link = document.getElementById('page2-link');

if (currentUrl.includes('index1.html')) {
    page1Link.classList.add('active');
} else if (currentUrl.includes('index2.html')) {
    page2Link.classList.add('active');
}
