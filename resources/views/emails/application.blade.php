@extends('emails.layouts.email')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <p>Имя: {{$application->user->name}}, email: {{$application->user->email}}</p>
                <p>Дата создания заявки: {{$application->created_at}}</p>
                <p>Сообщение: {{$application->message}}</p>
            </div>
        </div>
    </div>
@endsection
