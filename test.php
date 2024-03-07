<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laundry Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
      overflow: hidden;
    }
    .bubble-container {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 1;
      animation: fadeIn 3s forwards;
    }
    .bubble {
      width: 150px;
      height: 150px;
      background-color: #007bff;
      border-radius: 50%;
      position: absolute;
      opacity: 0;
      animation: bubbleAnimation 3s infinite;
    }
    @keyframes bubbleAnimation {
      0% {
        transform: translateY(0) scale(0);
        opacity: 0;
      }
      50% {
        opacity: 1;
      }
      100% {
        transform: translateY(-200px) scale(1);
        opacity: 0;
      }
    }
    @keyframes fadeIn {
      0% {
        opacity: 1;
      }
      100% {
        opacity: 0;
      }
    }
    .logo-container {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 2;
      opacity: 0;
      animation: fadeIn 3s forwards 3s;
    }
    .logo {
      width: 150px;
      height: 150px;
      background-image: url('assets/img/ly1.png');
      background-size: cover;
      background-position: center;
      border-radius: 50%;
    }
    .form-container {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 3;
      opacity: 0;
      animation: fadeIn 3s forwards 6s;
    }
    .login-form {
      width: 300px;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
    .login-form h2 {
      text-align: center;
    }
    .form-group {
      margin-bottom: 20px;
    }
    .form-group label {
      font-weight: bold;
    }
    .form-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .form-group button {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 5px;
      background-color: #007bff;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="bubble-container">
    <div class="bubble"></div>
  </div>
  <div class="logo-container">
    <div class="logo"></div>
  </div>
  <div class="form-container">
    <form class="login-form">
      <h2>Login to Laundry</h2>
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
        <button type="submit">Login</button>
      </div>
    </form>
  </div>
  <script>
    // You can add any JavaScript code you need here
  </script>
</body>
</html>
