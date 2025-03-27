import React, { useEffect, useState } from 'react';
import './App.css';
import Home from "./components/Home";

function App() {
  const [events, setEvents] = useState([]);

  useEffect(() => {
    fetch('http://localhost:5000/api/events')
      .then(res => res.json())
      .then(data => setEvents(data))
      .catch(err => console.error('Error fetching events:', err));
  }, []);

  return (
    <div className="App">
      <h1>Welcome to Adelaide Fringe Booking 🎭</h1>
      <Home />

      <h2>Event List</h2>
      <table>
        <thead>
          <tr>
            <th>Event Name</th>
            <th>Time</th>
            <th>Location</th>
          </tr>
        </thead>
        <tbody>
          {events.map(event => (
            <tr key={event.id}>
              <td>{event.event_name}</td>
              <td>{new Date(event.event_time).toLocaleString()}</td>
              <td>{event.event_location}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

export default App;
