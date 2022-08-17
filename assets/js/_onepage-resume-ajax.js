function contactForm() {

    event.preventDefault();

    const button = document.getElementById('button');
    const loader = document.getElementById('loader');
    const email  = document.getElementById('email');
    const message = document.getElementById('message');
    button.classList.add('hidden');
    button.previousElementSibling.classList.add('hidden');
    loader.classList.remove('hidden');
    email.classList.remove('error');
    email.nextElementSibling.classList.add('hidden');
    message.classList.remove('error');
    message.nextElementSibling.classList.add('hidden');

    const data = {};
    data.name = document.getElementById('name').value;
    data.email = email.value;
    data.subject = document.getElementById('subject').value;
    data.message = message.value;
    data.nonce = onepage_ajax.nonce;

    let url = onepage_ajax.ajax_url + '?action=onepage_resume_ajax';
    let headers = {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    };

    fetch( url,
        {
            method: 'POST',
            headers: headers,
            body: JSON.stringify(data)
        } )
        .then(data => data.text())
        .then(data => {
            const response = JSON.parse(data);

            console.log(response);

            if ( response != true ) {

                switch (response) {
                    case 'general':
                        button.previousElementSibling.classList.remove('hidden');
                        break;
                    case 'email':
                        email.classList.add('error');
                        email.nextElementSibling.classList.remove('hidden');
                        break;
                    case 'message':
                        message.classList.add('error');
                        message.nextElementSibling.classList.remove('hidden');
                        break;
                    default:
                }

                button.classList.add('button-error');
                button.textContent = 'Inte skickat';
                setTimeout( function() {
                    button.classList.remove('button-error');
                    button.textContent = 'Skicka';
                }, 3000);

            }

            if ( response == true ) {
                button.classList.add('button-success');
                button.textContent = 'Skickat!';
                setTimeout( function() {
                    button.classList.remove('button-success');
                    button.textContent = 'Skicka';
                    document.getElementById("contact").reset();
                }, 3000);
            }

            button.classList.remove('hidden');
            loader.classList.add('hidden');

        })
        .catch(error => {
            button.previousElementSibling.classList.remove('hidden');
            button.classList.add('button-error');
            button.textContent = 'Inte skickat';
            setTimeout( function() {
                button.classList.remove('button-error');
                button.textContent = 'Skicka';
            }, 3000);
        });

    return;

}
