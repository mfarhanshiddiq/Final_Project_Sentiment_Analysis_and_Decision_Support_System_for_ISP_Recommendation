<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama - Pilih Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
        /* General body styles */
        body {
            background: url('assets/background.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            color: white;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.7);
        }

        /* Header styles */
        h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        /* Paragraph styles */
        p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        /* Button styles */
        .btn-login {
            width: 220px;
            margin: 10px;
            padding: 12px;
            border-radius: 30px;
            font-weight: bold;
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        /* Tombol Login Pengawas - Biru */
        .btn-pengawas {
            background-color: #007bff;
            color: white;
        }

        .btn-pengawas:hover {
            background-color: #0056b3;
        }

        /* Tombol Login Admin - Putih */
        .btn-admin {
            background-color: white;
            color: black;
        }

        .btn-admin:hover {
            background-color: #f1f1f1;
        }

        /* Flex container for buttons */
        .btn-container {
            display: flex;
            justify-content: center;
            gap: 20px; /* Space between buttons */
        }
    </style>
</head>

<body>
    <h1>Pemilihan Provider Ideal</h1>
    <p>Silahkan Pilih Untuk Login Sebagai User atau Admin</p>

    <!-- Flex container for the buttons -->
    <div class="btn-container">
        <!-- Tombol untuk Login Pengawas -->
        <a href="login_pengawas.php?role=pengawas" class="btn btn-login btn-pengawas">Login User</a>

        <!-- Tombol untuk Login Admin -->
        <a href="login.php?role=admin" class="btn btn-login btn-admin">Login Admin</a>
    </div>
</body>

</html>
