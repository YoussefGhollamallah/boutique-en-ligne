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

    async function sendData(formData) {
        try {
            const response = await fetch('../controllers/AdminTreatments.php', {
                method: 'POST',
                body: formData
            });

            if (response.ok) {
                const data = await response.text();
                const trimmedData = data.trim();
                console.log('Réponse reçue:', trimmedData);
            
                if (trimmedData.includes("succès") || trimmedData.includes("réussie")) {
                    displayMessage(trimmedData, true);
                    setTimeout(function () {
                        window.location.reload();
                    }, 4000);
                } else {
                    displayMessage(trimmedData, false);
                }
            } else {
                displayMessage(`Erreur serveur : ${response.statusText}`, false);
            }
        } catch (error) {
            console.error('Erreur de fetch :', error);
            displayMessage(`Erreur réseau : ${error.message}`, false);
        }
    }

    // Handle the submission of the main form
    document.querySelector('.btn-ajouter').addEventListener('click', function (e) {
        e.preventDefault();
        const form = document.getElementById('categoryForm');
        const formData = new FormData(form);
        sendData(formData);
    });

    document.querySelector('.btn-Modifier').addEventListener('click', function (e) {
        e.preventDefault();
        const form = document.getElementById('hiddenForm');
        const formData = new FormData(form);
        sendData(formData);
    });

    // Toggling between the forms
    let form = document.getElementById('categoryForm');
    let hiddenForm = document.getElementById('hiddenForm');

    let modify = document.querySelector('#modify');
    modify.addEventListener('click', function () {
        console.log('Modification clique');
        form.style.display = 'none';
        hiddenForm.style.display = 'block';  // Make sure this is set to 'block'
    });

    let add = document.querySelector('#Add');
    add.addEventListener('click', function () {
        form.style.display = 'block';
        hiddenForm.style.display = 'none';  // Make sure this is set to 'none'
    });

    document.querySelector('#delete').addEventListener('click', function (e) {
        e.preventDefault();
        const form = document.getElementById('hiddenForm');
        const formData = new FormData(form);
        sendData(formData);
    });
});