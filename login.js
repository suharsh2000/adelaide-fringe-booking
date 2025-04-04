document.getElementById('loginForm').addEventListener('submit', async function(event) {
    event.preventDefault(); // Prevent the default form submission

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    try {
        const response = await fetch('http://localhost:5004/api/login', { // Updated to port 5004
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email, password }),
        });

        const data = await response.json();

        if (response.ok) {
            // Handle successful login
            alert('Login successful!'); // You can also redirect or store the token
            document.getElementById('errorMessage').textContent = ''; // Clear any previous error messages
        } else {
            // Display error message
            document.getElementById('errorMessage').textContent = data.message;
        }
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('errorMessage').textContent = 'An error occurred. Please try again.';
    }
});