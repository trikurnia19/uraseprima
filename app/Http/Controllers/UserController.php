<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        {
            $request->validate([
                'name' => 'string',
                'email' => 'string',
                'age' => 'int',
                'height' => 'int',
                'password' => 'string'
            ]);
    
            $user = User::create([
                'name' => $request->name,
                'age' => $request->age,
                'height' => $request->height,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return redirect()
            ->route('user.index')
            ->with('message', 'Data ditambahkan');
    }
}

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
                'age' => 'int',
                'height' => 'int',

            ]);
    
            $user->name = $request->name;
            $user->email = $request->email;
            $user->age = $request->age;
            $user->height = $request->height;
    
            if (! empty($request->get('password'))) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
    
            return redirect()
                ->route('user.index')
                ->with('message', 'User berhasil ');
        
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/');
    }
}
