document.addEventListener('DOMContentLoaded', function() {
    // Handle file selection
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const productId = this.id.split('-')[1]; // Assuming IDs like "file-123"
            if (file) {
                console.log(`File selected for product ${productId}:`, file.name);
            }
        });
    });

    // Function to get data from the PHP page
    async function getData() {
        try {
            const response = await fetch('./src/controllers/admin-treatement.php');

            if (response.ok) {
                const data = await response.text(); 
                console.log('Data received:', data);
                
                // Display success or error message
                const messageElement = document.createElement('div');
                if (data === "Category Added") {
                    messageElement.textContent = "Added Successfully";
                } else {
                    messageElement.textContent = "Something went wrong";
                }
                document.body.appendChild(messageElement);
            } else {
                console.error('Error fetching page:', response.statusText);
            }
        } catch (error) {
            console.error('Fetch error:', error);
        }
    }

    document.querySelector('.btn-ajouter').addEventListener('click', function(e) {
        e.preventDefault();
        let name = document.querySelector('#categories').value;
        let desc = document.querySelector('#desc').value;

        if (name.length > 0 && desc.length > 0) {
            getData();
        } else {
            console.error('Name and description must be filled out.');
        }
    });
});
