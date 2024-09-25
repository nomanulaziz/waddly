<?php

namespace App\Http\Controllers;

use App\DataTables\JobsDataTable;
use App\DataTables\UsersDataTable;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    // public function index()
    // {
    //     return view('users.index'); 
    // }

    public function index(JobsDataTable $dataTable)
    {
        return $dataTable->render('users.index');
    }
    
    // Function to return users for DataTables
    public function getUsersData(Request $request)
    {
        // Start by querying the User model
        $query = User::query();

        // Handle search functionality
        if ($request->has('search') && !empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Get the filtered count BEFORE applying pagination
        $filteredUsersCount = $query->count();

        // Handle ordering
        if ($request->has('order')) {
            $orderBy = $request->input('columns')[$request->input('order.0.column')]['data'];
            $direction = $request->input('order.0.dir');
            $query->orderBy($orderBy, $direction);
        } else {
            $query->orderBy('id', 'desc');
        }

        // Apply pagination (start and length)
        $users = $query->skip($request->input('start'))->take($request->input('length'))->get();

        // Get the total number of users (before filtering)
        $totalUsers = User::count();

        // Return JSON response
        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalUsers,            // Total users in the database
            'recordsFiltered' => $filteredUsersCount, // Users matching the search, without pagination
            'data' => $users                          // Paginated user data
        ]);
    }


    // Function to get user data for editing
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Function to update the user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return response()->json(['success' => true]);
    }

    // Function to delete the user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => true]);
    }
}
