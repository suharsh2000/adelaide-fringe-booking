import mongoose from 'mongoose';
import express from 'express'; // Make sure to import express
import bodyParser from 'body-parser';
import cors from 'cors';
import User from './models/User.js'; // Import the User model

const app = express(); // Initialize your Express app
const PORT = process.env.PORT || 5006;

// Middleware Setup
app.use(bodyParser.json());
app.use(cors({
    origin: 'http://localhost:5006',
    methods: ['GET', 'POST'],
    allowedHeaders: ['Content-Type', 'Authorization']
}));
app.use(express.static('../frontend/frontend')); // Serve static files from the frontend directory

// Connect to MongoDB
mongoose.connect('mongodb://localhost:27017/FringeDB') // Specify your database name
    .then(() => console.log('MongoDB connected'))
    .catch(err => console.error('MongoDB connection error:', err));

// Endpoint to fetch all users
app.get('/api/users', async (req, res) => {
    try {
        const users = await User.find(); // Fetch all users
        res.json(users); // Return all user details
    } catch (error) {
        console.error('Error fetching users:', error);
        res.status(500).json({ message: 'Internal server error' });
    }
});


// Endpoint to create a new user
app.post('/api/users', async (req, res) => {
    const { email, password } = req.body;

    try {
        // Check if the user already exists
        const existingUser = await User.findOne({ email });
        if (existingUser) {
            return res.status(400).json({ message: 'User already exists.' });
        }

        // Create a new user
        const newUser = new User({ email, password });
        await newUser.save(); // Save the user to the database

        res.status(201).json({ message: 'User created successfully!', user: newUser });
    } catch (error) {
        console.error('Error creating user:', error);
        res.status(500).json({ message: 'Internal server error' });
    }
});

// Login endpoint
app.post('/api/login', async (req, res) => {
    const { email, password } = req.body;

    try {
        // Find user by email
        const user = await User.findOne({ email });
        if (!user) {
            return res.status(401).json({ message: 'Invalid email or password.' });
        }

        // Here, you might want to hash and compare passwords securely
        // Assuming passwords are stored as plain text (not recommended in production)
        if (user.password !== password) {
            return res.status(401).json({ message: 'Invalid email or password.' });
        }

        // Send response for successful login
        res.status(200).json({ message: 'Login successful!' });
    } catch (error) {
        console.error('Error during login:', error);
        res.status(500).json({ message: 'Internal server error.' });
    }
});

// Start the server
app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});