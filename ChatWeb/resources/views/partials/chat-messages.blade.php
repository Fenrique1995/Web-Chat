@foreach($messages as $message)
    <div class="chat-message">
        <strong>{{ $message->user->name }}:</strong> {{ $message->message }}
    </div>
@endforeach