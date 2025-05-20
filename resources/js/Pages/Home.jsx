import React from "react";
import "../../css/Home.css";
import { Link } from "react-router-dom";

export default function Home() {
    return (
        <div className="home-container">
            <h1>Welcome to the App</h1>
            <p>This is the homepage. Please login or register to continue.</p>

            <div className="btn-group">
                <Link to="/login">Login</Link>
                <Link to="/register">Register</Link>
            </div>
        </div>
    );
}
