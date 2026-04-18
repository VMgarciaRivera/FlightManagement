document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const messageDiv = document.getElementById('message');
    const btn = document.getElementById('loginBtn');

    // Bloquear botón mientras carga
    btn.disabled = true;
    btn.innerText = "Verificando...";
    messageDiv.innerText = "";

    try {
        const response = await fetch('/login', { 
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, password })
        });

        const data = await response.json();
        console.log("Respuesta del servidor:", data);

        if (response.ok) {
            // se guarda el token para usarlo en las peticiones de vuelos
            localStorage.setItem('authToken', data.token);
            localStorage.setItem('userEmail', data.user);
            
            messageDiv.style.color = "#2ecc71";
            messageDiv.innerText = "¡Bienvenido! Redirigiendo...";
            
            // Redirigir al dashboard después de 1.5 segundos
            setTimeout(() => {
                window.location.href = '/public/dashboard/dashboard.html';
            }, 1500);
        } else {
            throw new Error(data.error || "Credenciales incorrectas");
        }
    } catch (error) {
        console.error("Error durante el inicio de sesión:", error);
        messageDiv.style.color = "#e74c3c";
        messageDiv.innerText = error.message;
    } finally {
        btn.disabled = false;
        btn.innerText = "Iniciar Sesión";
    }
});