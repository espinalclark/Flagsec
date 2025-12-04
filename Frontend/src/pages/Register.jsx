import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import './Register.css';

function Register() {
  const navigate = useNavigate();
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const handleSubmit = (e) => {
    e.preventDefault();
    
    // Por ahora solo simulamos registro y redirigimos al login
    console.log("Usuario registrado:", { name, email, password });
    navigate("/login"); // después de registrarse, ir a login
  };

  return (
    <div className="register-container">
      <div className="register-box">
        <h2 className="register-title">Crear Cuenta</h2>
        <form className="register-form" onSubmit={handleSubmit}>
          <label htmlFor="name">Nombre completo</label>
          <input
            type="text"
            id="name"
            placeholder="Tu nombre"
            value={name}
            onChange={(e) => setName(e.target.value)}
            required
          />

          <label htmlFor="email">Correo electrónico</label>
          <input
            type="email"
            id="email"
            placeholder="tu@correo.com"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            required
          />

          <label htmlFor="password">Contraseña</label>
          <input
            type="password"
            id="password"
            placeholder="********"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            required
          />

          <button type="submit" className="register-button">
            Registrarse
          </button>
        </form>
        <p className="register-login">
          ¿Ya tienes cuenta? <span onClick={() => navigate("/login")}>Inicia Sesión</span>
        </p>
      </div>
    </div>
  );
}

export default Register;

