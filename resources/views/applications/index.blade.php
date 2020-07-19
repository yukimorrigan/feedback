@extends('applications.layouts.manager_app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Тема</th>
                        <th scope="col" colspan="2">Сообщение</th>
                        <th scope="col">Имя клиента</th>
                        <th scope="col">Почта клиента</th>
                        <th scope="col">Ссылка на прикрепленный файл</th>
                        <th scope="col">Время создания</th>
                        <th scope="col">Прочитано</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($applications as $application)
                        <tr is="table-row-component" :application="{{$application}}" :user="{{$application->user}}"
                            :route="'{{route('application.update', $application)}}'"
                            :csrf="{{json_encode(csrf_token())}}"></tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Данные отсутствуют</td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8" class="text-center align-middle">
                                {{-- Отрисовка постраничного перехода --}}
                                <ul class="pagination pull-right d-inline-flex m-0">
                                    {{$applications->links()}}
                                </ul>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endsection
