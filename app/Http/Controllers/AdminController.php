<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = User::all()->where('role', 'admin')->where('id','!=',Auth::user()->id);
        return view('users.admin', compact('admin'));
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
        $validate = $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
            ],
            [
                'email.required' => 'Email has not been inputted yet',
                'email.unique' => 'Email already exists',
                'password.required' => 'Password has not been entered yet',
                'password.min' => 'Minimum password length is 8 characters',
            ]
        );

        if (!$validate) {
            return redirect(route('admin.admin.index'))->withErrors($validate);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin'
        ]);
        return redirect(route('admin.admin.index'))->with('success','Data input has been completed successfully');
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
        $validate = $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email',
            ],
            [
                'email.required' => 'Email has not been inputted yet',
            ]
        );

        if (!$validate) {
            return redirect(route('admin.admin.index'))->withErrors($validate);
        }
        $user = User::find($id);
        if($request->password == null)
        {
            $password = $user->password;
        }else{
            $password = Hash::make($request->password);

        }

        User::whereId($id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
        ]);
        return redirect(route('admin.admin.index'))->with('success','Data has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect(route('admin.admin.index'))->with('success','Data deletion has been completed successfully');
    }
}
