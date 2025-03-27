const express = require('express');
const mysql = require('mysql2');
const cors = require('cors');
require('dotenv').config();

const app = express();
const PORT = process.env.PORT || 5000;

app.use(cors());
app.use(express.json());

// MySQL connection setup
const db = mysql.createConnection({
  host: process.env.DB_HOST,
  user: process.env.DB_USER,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_NAME,
  port: process.env.DB_PORT
});

db.connect((err) => {
  if (err) {
    console.error('❌ DB connection failed:', err);
    return;
  }
  console.log('✅ Connected to MySQL database');
});

// API endpoint to fetch all events
app.get('/api/events', (req, res) => {
  db.query('SELECT * FROM event', (err, results) => {
    if (err) {
      console.error('❌ Error fetching events:', err);
      res.status(500).send('Server error');
      return;
    }
    res.json(results);
  });
});

// Additional simple route to test backend
app.get('/', (req, res) => {
  res.send('Backend is working 🚀');
});

app.listen(PORT, () => {
  console.log(`🚀 Backend server running on http://localhost:${PORT}`);
});
