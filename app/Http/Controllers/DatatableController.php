<?php

namespace App\Http\Controllers;

use App\Models\Datatable;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class DatatableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.index');
    }

    /**
     * Show the datatable a new resource.
     */
    public function getUsers()
    {
        $users = User::query();

        return DataTables::of($users)
            ->addColumn('action', function ($user) {
                return '<a href="' . route('users.show', $user->id) . '" class="btn btn-info">View</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('pages.show', compact('user'));
    }
}