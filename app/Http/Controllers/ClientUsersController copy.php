<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\User;
use Illuminate\Http\Request;

class ClientUsersController extends Controller
{
    public function index ()
    {
        $users = $this->getUsers();;

        return view('users.index', ['users' => $users]);
    }

    public function getUsers()
    {
        return User::all();
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email']));
        return response()->json(['success' => true]);
    }

    public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return response()->json(['success' => true]); 
}

}
