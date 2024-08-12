<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatWeb</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        .chat-box {
            height: calc(100vh - 90px); /* Ajusta el tamaño para que deje espacio para el navbar, el formulario y los settings */
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
        .chat-form form {
            display: flex;
            width: 100%;
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
        .settings-form {
            display: none;
            position: fixed;
            right: 0;
            top: 60px; /* Justo debajo del navbar */
            width: 300px;
            height: calc(100vh - 60px);
            padding: 10px;
            background: #f8f9fa;
            border-left: 1px solid #ddd;
            z-index: 1000;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Chat</a>
            <div class="collapse navbar-collapse justify-content-end">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-secondary mr-2">Logout</button>
                </form>
                <button id="settings-button" class="btn btn-info">Settings</button>
            </div>
        </div>
    </nav>
    <div class="container chat-container">
        <div class="chat-box" id="chat-box">
            @foreach($messages as $message)
                <div class="chat-message">
                    <strong>{{ $message->user->name }}:</strong> {{ $message->message }}
                </div>
            @endforeach
        </div>
        <div class="settings-form" id="settings-form">
            <form id="update-form" action="{{ route('user.update') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
            <form id="delete-form" action="{{ route('user.delete') }}" method="POST" class="mt-3">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Account</button>
            </form>
        </div>
        <div class="chat-form">
            <form id="chat-form" action="{{ route('chat.send') }}" method="POST">
                @csrf
                <input type="text" class="form-control" id="message" name="message" required>
                @error('message')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
                <button type="submit" class="btn btn-primary ml-2">Send</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#settings-button').on('click', function() {
                $('#settings-form').toggle();
            });

            $('#chat-form').on('submit', function(e) {
                e.preventDefault();
                
                $.ajax({
                    url: "{{ route('chat.send') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#message').val(''); // Clear the input field
                        loadMessages(); // Refresh the chat messages
                    }
                });
            });

            function loadMessages() {
                $.ajax({
                    url: "{{ route('chat.messages') }}", // Ruta para obtener los mensajes de chat
                    method: 'GET',
                    success: function(data) {
                        $('#chat-box').html(data);
                        $('.chat-box').scrollTop($('.chat-box')[0].scrollHeight); // Scroll to bottom
                    }
                });
            }

            // Auto-refresh chat messages every 5 seconds
            setInterval(loadMessages, 5000);
        });
    </script>
</body>
</html>