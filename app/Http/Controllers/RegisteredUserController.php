<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterUserRequest $request)
    {
        // Get the validated data
        $userAttributes = $request->only(['name', 'email', 'password']);
        $employerAttributes = $request->only(['employer', 'logo']);

        //Create a new user
        $user = User::create($userAttributes);

        //Store logo in local directory and pass path
        //logo -> Instance of Laravel UploadFiles class
        //argument logos -> folder name you want to store image in
        $logoPath = $request->logo->store('logos');

        // Prepend 'storage/' to the saved logo path
        $logoPath = 'storage/' . $logoPath;

        //Create a user employer
        $user->employer()->create([
            'name' => $employerAttributes['employer'],
            'logo' => $logoPath,
        ]);

        //Login the user
        Auth::login($user);

        //return to view
        return redirect('/');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
