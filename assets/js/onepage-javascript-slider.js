function getNewIndex( direction ) {
    const triggers = document.getElementsByClassName('slider-trigger');
    const slides = document.getElementsByClassName('portfolio-item');
    const count = slides.length -1;

    let currentSlideIndex;
    for ( let i = 0; i < slides.length; i++ ) {
        if ( !slides[i].classList.contains('hidden') ) {
            currentSlideIndex = parseInt(i);
            slides[i].classList.add('hidden');
        }
    }

    let newIndex = direction + currentSlideIndex;
    if ( direction + currentSlideIndex > count ) {
        newIndex = 0;
    } else if ( direction + currentSlideIndex == -1 ) {
        newIndex = count;
    }

    setNewIndex( newIndex, slides, triggers );

    return;

}

function setNewIndex ( newIndex, slides, triggers ) {
    for ( let i = 0; i < slides.length; i++ ) {
        if ( i == newIndex ) {
            slides[i].classList.remove('hidden');
        }
    }

    for ( let i = 0; i < triggers.length; i++ ) {
        if ( i == newIndex ) {
            triggers[i].classList.add('active');
        } else {
            triggers[i].classList.remove('active');
        }
    }

    return;
}
