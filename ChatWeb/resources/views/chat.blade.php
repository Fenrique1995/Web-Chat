<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatWeb</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-box {
            height: calc(100vh - 120px); /* Ajusta el tamaño para que deje espacio para el navbar y el formulario */
            overflow-y: scroll;
            border: 1px solid #ddd;
            margin-bottom: 0; /* Quitar el margen inferior para que esté pegado al formulario */
        }
        .chat-message {
            margin-bottom: 10px;
        }
        .chat-container {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        .chat-form {
            padding: 10px;
            background: #f8f9fa;
            border-top: 1px solid #ddd;
            display: flex;
            align-items: center; /* Alinea verticalmente el contenido */
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: 1000; /* Asegura que esté sobre el contenido de chat */
        }
        .chat-form input {
            flex: 1;
            margin-right: 10px; /* Espacio entre el input y el botón */
        }
        .chat-form button {
            white-space: nowrap;
        }
        .navbar {
            margin-bottom: 0; /* Quitar el margen inferior para que el chat-box esté pegado al navbar */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Chat</a>
            <div class="collapse navbar-collapse justify-content-end">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="container chat-container">
        <div class="chat-box">
            @foreach($messages as $message)
                <div class="chat-message">
                    <strong>{{ $message->user->name }}:</strong> {{ $message->message }}
                </div>
            @endforeach
        </div>
        <div class="chat-form">
            <form action="{{ route('chat.send') }}" method="POST" style="width: 100%;">
                @csrf
                <input type="text" class="form-control" id="message" name="message" required>
                @error('message')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </form>
            <button type="submit" class="btn btn-primary ml-2">Send</button>
        </div>
    </div>
</body>
</html>
