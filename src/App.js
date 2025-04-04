import React from 'react';
import User from './User ';

function App() {
    return (
        <div className="App">
            <h1>My Fullstack App</h1>
            <User  userId="Champion-1743004066498" /> {/* Replace with a valid user ID from your database */}
        </div>
    );
}

export default App;