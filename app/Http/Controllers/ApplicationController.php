<?php

namespace App\Http\Controllers;

use App\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('applications.index',
            [
                'applications' => Application::orderBy('marked', 'asc')
                    ->paginate(Application::SHOW_BY_DEFAULT)
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('applications.create', [
            'application' => [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        # если с момента создания заявки не прошло 24 часа
        if (! $request->user()->canCreate()) {
            # запись не добавляется
            $request->session()->flash('added', false);
            return redirect()->route('application.create');
        }

        # валидация
        $validator = $request->validate([
            'user_id' => 'required|int',
            'subject' => 'required|string|max:255',
            'message' => 'required',
            'file' => 'required|file|max:1024|mimes:pdf,doc,docx',
        ]);

        # путь к загруженному файлу
        $path = $request->file('file')->store('uploads', 'public');

        # добавление в базу данных
        $application = Application::create([
            'user_id' => $request->input('user_id'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'file' => asset('/storage/' . $path),
        ]);
        # последняя добавленная в бд запись
        $last = $application->latest()->first();

        # запись успешно добавлена
        $request->session()->flash('added', true);

        # отправка email
        dispatch(new \App\Jobs\SendEmailJob($last));

        return redirect()->route('application.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        $marked = $request->input('marked');
        $application->marked = $marked;
        $application->save();
        return $application->marked;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        //
    }
}
