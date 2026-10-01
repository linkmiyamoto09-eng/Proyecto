// 1. Declaración en el ámbito superior o inicio del DOMContentLoaded
const AUTH_API = '../../backend/apis/auth_api.php';

const registerForm = document.getElementById('registerForm');
if (registerForm) {
  registerForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const email = document.getElementById('email').value;
    const nombre = document.getElementById('nombre').value;
    const pass = document.getElementById('pass').value;
    const confirmPass = document.getElementById('confirmPass').value;
    const messageDiv = document.getElementById('register-message');

    if (pass !== confirmPass) {
      if (messageDiv) {
        messageDiv.style.color = 'red';
        messageDiv.innerText = 'Las contraseñas no coinciden.';
      }
      return;
    }

    try {
      // Petición conectada a la API de autenticación
      const res = await fetch(`${AUTH_API}?action=register`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ nombre, email, contrasena: pass })
      });

      if (!res.ok) {
        const rawText = await res.text();
        console.error(`Error ${res.status} del servidor:`, rawText);
        if (messageDiv) {
          messageDiv.style.color = 'red';
          messageDiv.innerText = `Error en el servidor (${res.status})`;
        }
        return;
      }

      const data = await res.json();

      if (data.status === 'success') {
        alert('¡Registro exitoso! Redirigiendo...');
        window.location.href = 'pagina1.html';
      } else {
        if (messageDiv) {
          messageDiv.style.color = 'red';
          messageDiv.innerText = data.message || 'Error al registrar el usuario';
        }
      }
    } catch (err) {
      console.error('Error de red/fetch:', err);
      if (messageDiv) {
        messageDiv.style.color = 'red';
        messageDiv.innerText = 'Error al conectar con el servidor';
      }
    }
  });
}