import React, { useState } from "react";
import axios from 'axios';
import "../../css/Register.css"; // 👈 Import the CSS file

export default function Register() {
    const [name, setName] = useState("");
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [confirmPassword, setConfirmPassword] = useState("");
    const [error, setError] = useState(""); // For error messages

    const handleSubmit = (e) => {
        e.preventDefault();

        // Reset error on submit
        setError("");

        // Validate confirm password
        if (password !== confirmPassword) {
            setError("Passwords do not match");
            return;
        }

        try {
            const res = axios.post('/api/register', { name, email, password, password_confirmation: confirmPassword });
            console.log(res.data);
        } catch (err) {
            alert('Login failed!');
        }

        // Add your register logic here, e.g., call API
        console.log({ name, email, password });
    };

    return (
        <div className="register-container">
            <h2>Register</h2>
            <form onSubmit={handleSubmit}>
                <div>
                    <label>Name</label>
                    <input
                        type="text"
                        value={name}
                        onChange={(e) => setName(e.target.value)}
                        required
                    />
                </div>
                <div>
                    <label>Email</label>
                    <input
                        type="email"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        required
                    />
                </div>
                <div>
                    <label>Password</label>
                    <input
                        type="password"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                        required
                    />
                </div>
                <div>
                    <label>Confirm Password</label>
                    <input
                        type="password"
                        value={confirmPassword}
                        onChange={(e) => setConfirmPassword(e.target.value)}
                        required
                    />
                </div>

                {/* Show error message */}
                {error && <p className="error-message" style={{ color: "red" }}>{error}</p>}

                <button type="submit">Register</button>
            </form>
        </div>
    );
}
