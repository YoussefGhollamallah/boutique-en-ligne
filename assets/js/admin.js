document.addEventListener('DOMContentLoaded', function () {
    console.log('Loaded');

    function displayMessage(message, isSuccess = true) {
        console.log('Displaying message:', message);

        const existingMessage = document.querySelector('.message');
        if (existingMessage) {
            existingMessage.remove();
        }

        const messageElement = document.createElement('section');
        messageElement.textContent = message;
        messageElement.classList.add('message');

        if (isSuccess) {
            messageElement.classList.add('success-message');
        } else {
            messageElement.classList.add('error-message');
        }

        console.log('Appending message to the DOM');
        document.body.appendChild(messageElement);
    }

    async function sendData() {
        const nom = document.querySelector('#categories').value.trim();
        const desc = document.querySelector('#desc').value.trim();

        if (nom.length === 0 || desc.length === 0) {
            displayMessage('Please provide both a name and description.', false);
            return;
        }

        console.log('Sending data:', { nom, desc });

        const formData = new URLSearchParams();
        formData.append('nom', nom);
        formData.append('desc', desc);

        try {
            const response = await fetch('../../src/controllers/AdminTreatments.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: formData.toString(),
            });

            if (response.ok) {
                const data = await response.text();
                const trimmedData = data.trim();
                console.log('Response received:', trimmedData);

                if (trimmedData === "Category added successfully!") {
                    displayMessage('Category added successfully!', true);
                    setTimeout(function () {
                        window.location.href = '../views/admin-sub-category.php';
                    }, 4000);
                } else if (trimmedData === "This category already exists!") {
                    displayMessage('This category already exists!', false);
                } else {
                    displayMessage(`Unexpected response: ${trimmedData}`, false);
                }
            } else {
                displayMessage(`Server error: ${response.statusText}`, false);
            }
        } catch (error) {
            console.error('Fetch error:', error);
            displayMessage(`Network error: ${error.message}`, false);
        }
    }

    document.querySelector('.btn-ajouter').addEventListener('click', function (e) {
        e.preventDefault();
        sendData();
    });

    let form = document.getElementById('categoryForm');
    let hiddenForm = document.getElementById('hiddenForm');

    let modify = document.querySelector('#modify');
    modify.addEventListener('click', function () {
        console.log('Clicked');
        
        form.style.display = 'none';
        
        hiddenForm.style.display = 'block';
    });

    let add = document.querySelector('#Add')

    add.addEventListener('click', function(){
        form.style.display = 'block'
        hiddenForm.style.display = 'none'
    })
});
