import React from "react";
import "./Navbar.css";
import Logo from "../assets/mari.png";

export default function Navbar({ isOpen, setIsOpen }) {
  return (
    <nav className={`navbar-container ${isOpen ? "open" : ""}`}>
      <div className="navbar-header">
        <div className="navbar-logo">
          <img src={Logo} alt="logo" className="navbar-logo-img" />
          <span className="navbar-brand">FLAGSEC</span>
        </div>
        <button className="close-btn" onClick={() => setIsOpen(false)}>
          ✘
        </button>
      </div>

      <ul className="navbar-links">
        <li><a href="#">☣︎ CURSOS</a></li>
        <li><a href="#">☣︎ CONÓCENOS</a></li>
        <li><a href="#">☣︎ CONTACTO</a></li>
      </ul>
    </nav>
  );
}

