<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Maintenance</title>
  <link rel="icon" href="https://pixelrealm.fr/storage/img/faviconx.png" />

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      font-family: Arial, sans-serif;
      color: white;
      overflow: hidden;
    }

    #background-video {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      object-fit: cover;
      z-index: -1;
    }

    .content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      padding: 20px;
      width: 100%;
      max-width: 90vw;
    }

    .logo {
      width: 60vw;
      max-width: 500px;
      height: auto;
      margin-bottom: 30px;
      animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
      0%   { transform: translateY(0); }
      50%  { transform: translateY(-15px); }
      100% { transform: translateY(0); }
    }

    .maintenance-box {
      background-color: rgba(0, 0, 0, 0.6);
      padding: 15px 30px;
      border-radius: 10px;
      display: inline-flex;
      align-items: center;
      gap: 15px;
      font-size: 1.5rem;
      backdrop-filter: blur(5px);
    }

    .spinner {
      width: 32px;
      height: 32px;
      border: 4px solid white;
      border-top: 4px solid transparent;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    @media (max-width: 600px) {
      .logo {
        width: 80vw;
        max-width: 300px;
      }

      .maintenance-box {
        font-size: 1.2rem;
        padding: 10px 20px;
      }

      .spinner {
        width: 24px;
        height: 24px;
        border-width: 3px;
      }
    }
  </style>
</head>
<body>

  <video id="background-video" autoplay loop muted playsinline>
    <source src="https://pixelrealm.fr/storage/img/bg-soonedited.mp4" type="video/mp4" />
    Votre navigateur ne supporte pas la lecture de vidéos HTML5.
  </video>

  <div class="content">
    <img src="https://pixelrealm.fr/storage/img/new-logo-pixelrealm.png" alt="Logo" class="logo" />
    <div class="maintenance-box">
      <div class="spinner"></div>
      Maintenance en cours
    </div>
  </div>

</body>
</html>
