<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $task = Task::count();
        $todo = Task::where('user_id',auth()->user()->id)->select('id', 'name', 'date','proses')->latest()->get();
        return view('layouts.include.konten.todo', compact('task','todo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required',
            'date'=>'required',
            'proses'=>'required'
        ]);
        Task::create([
            'name' => $request->name,
            'date'=>$request->date,
            'proses'=>$request->proses,
            'user_id'=>Auth::user()->id
        ]);
        return redirect()->back()->with('success', 'Data Berhasil Di Tambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required|max:220',
            'date' => 'required',
            'proses'=>'required'
        ]);
        $todo = Task::findOrFail($id);
        if ($request->date == '') {
            $todo->update([
                'name' => $request->name,
            ]);
            return redirect()->back()->with(['success' => 'Title berhasil di ubah']);
        } else {
            $todo->update([
                'name' => $request->name,
                'date' => $request->date,
                'proses'=> $request->proses

            ]);
        }
        return redirect()->back()->with(['success' => 'Title berhasil di ubah']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect()->back()->with(['success' => 'Data telah dihapus']);
    }
}
