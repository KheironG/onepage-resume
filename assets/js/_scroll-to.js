window.addEventListener( 'scroll', () => {
    const trigger = document.getElementById('scroll-to');
    if ( document.documentElement.scrollTop > screen.availHeight ) {
        trigger.classList.remove('hidden');
    } else {
        trigger.classList.add('hidden');
    }
}, false);

function scrollToTop() {
    window.scrollTo(0, 0);
    return;
}
