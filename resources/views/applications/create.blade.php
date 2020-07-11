@extends('applications.layouts.user_app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <form action="{{route('application.store')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                    <div class="form-row align-items-center justify-content-center">
                        <div class="col-sm-6 my-1">

                            @if (session()->has('added'))
                                @if (session('added') === true)
                                    <div id="status" class="alert alert-success" role="alert">
                                        Ваша заявка успешно добавлена!
                                    </div>
                                @else
                                    <div id="status" class="alert alert-danger" role="alert">
                                        Вы можете оставлять заявку только раз в сутки.
                                    </div>
                                @endif
                            @else
                                <div id="status" class="alert alert-primary" role="alert">
                                    Оставьте вашу заявку.
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="m-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="inlineFormInputTitle">Тема</label>
                                <input name="subject" type="text" class="form-control @error('subject') is-invalid @enderror"
                                    id="inlineFormInputTitle" placeholder="Тема" required
                                    value="@if(old('subject')){{old('subject')}}@else{{$application->subject ?? ''}}@endif">
                            </div>

                            <div class="form-group">
                                <label for="message">Сообщение</label>
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror"
                                    id="message" rows="3" placeholder="Сообщение" required
                                >@if(old('message')){{old('message')}}@else{{$application->message ?? ''}}@endif</textarea>
                            </div>

                            <file-component @error('file'):error="true"@enderror></file-component>

                            <div class="text-center">
                                <button name="submit" type="submit" class="btn btn-primary">Отправить</button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
