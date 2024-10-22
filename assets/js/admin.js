document.addEventListener('DOMContentLoaded', function () {
    // Function to display messages on the page
    function displayMessage(message, isSuccess = true) {
        console.log('Displaying message:', message); // Log the message

        // Remove any existing message element
        const existingMessage = document.querySelector('.message');
        if (existingMessage) {
            existingMessage.remove();
        }

        // Create a new message element
        const messageElement = document.createElement('div');
        messageElement.textContent = message;
        messageElement.classList.add('message'); // Add a common class for message styling

        // Apply success or error class based on the response
        if (isSuccess) {
            messageElement.classList.add('success-message'); // Styling for success
        } else {
            messageElement.classList.add('error-message'); // Styling for error
        }

        // Append the message element to the body
        console.log('Appending message to the DOM'); // Log DOM appending
        document.body.appendChild(messageElement);
    }

    // Function to send form data via POST
    async function sendData() {
        const nom = document.querySelector('#categories').value.trim();
        const desc = document.querySelector('#desc').value.trim();

        // Ensure both fields are filled out
        if (nom.length === 0 || desc.length === 0) {
            displayMessage('Please provide both a name and description.', false);
            return;
        }

        console.log('Sending data:', { nom, desc }); // Log the data being sent

        // Prepare the form data for the POST request
        const formData = new URLSearchParams();
        formData.append('nom', nom);
        formData.append('desc', desc);

        try {
            // Send the form data using fetch
            const response = await fetch('../../src/controllers/admin-treatments.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: formData.toString(),
            });

            // Handle the response
            if (response.ok) {
                const data = await response.text();
                const trimmedData = data.trim();
                console.log('Response received:', trimmedData); // Log the response text

                // Check the exact response and display the appropriate message
                if (trimmedData === "Category added successfully!") {
                    displayMessage('Category added successfully!', true);
                    
                    // Redirect after a short delay
                    setTimeout(function () {
                        window.location.href = '../views/admin-sub-category.php';
                    }, 2000);
                    displayMessage('Category added successfully!', true);
                    
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

    // Add event listener to the button
    document.querySelector('.btn-ajouter').addEventListener('click', function (e) {
        e.preventDefault(); // Prevent default form submission
        sendData(); // Call the function to send data
    });
});
