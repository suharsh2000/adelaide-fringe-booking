// src/User.js
import React, { useEffect, useState } from 'react';
import axios from 'axios';

const User = ({ userId }) => {
    const [user, setUser ] = useState(null);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchUser  = async () => {
            try {
                const response = await axios.get(`http://localhost:5000/api/users/${userId}`);
                setUser (response.data);
            } catch (err) {
                setError(err.response.data.message);
            }
        };

        fetchUser ();
    }, [userId]);

    if (error) {
        return <div>Error: {error}</div>;
    }

    if (!user) {
        return <div>Loading...</div>;
    }

    return (
        <div>
            <h2>User Details</h2>
            <p>Name: {user.name}</p>
            <p>Email: {user.email}</p>
        </div>
    );
};

export default User;