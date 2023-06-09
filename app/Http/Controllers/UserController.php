<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function PHPSTORM_META\map;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all()->where('role', 'user');
        return view('users.user', compact('user'));
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
            return redirect(route('admin.user.index'))->withErrors($validate);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect(route('admin.user.index'))->with('success','Data input has been completed successfully');
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
            return redirect(route('admin.user.index'))->withErrors($validate);
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
        return redirect(route('admin.user.index'))->with('success','Data has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect(route('admin.user.index'))->with('success','Data deletion has been completed successfully');
    }


    public function updateDataUser(Request $request, string $id)
    {
        $validate = $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'min:8|confirmed',
            ],
            [
                'name.required' => 'Name has not been inputted yet',
                'email.required' => 'Email has not been inputted yet',
                'password.min' => 'Password Min 8 Character',
                'password.confirmed' => 'Password Mismatch or not fill yet',
            ]
        );

        if (!$validate) {
            return redirect()->back()->withErrors($validate);
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
        return redirect(route('profile'))->with('success','Data has been updated');
    }
}
