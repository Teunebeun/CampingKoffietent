<?php

namespace App\Http\Controllers\cms;

use App\Campingbaas;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use App\User;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class CMSUserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|View
     */

    public function index()
    {
        $users = User::all();

        return view('/cms/users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function create()
    {
        return view('/cms/users.create');
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function store(StoreUserRequest $request)
    {
        $request->validated();

        $avatarName = null;
        if ($request->hasFile('profile_picture')) {
            $date = $cleanStr = preg_replace('/[^A-Za-z0-9]/', '', Carbon::now());
            $avatarName = 'img/user/' . $date . '.' . $request->profile_picture->getClientOriginalExtension();
            $request->file('profile_picture')->move(public_path('img/user'), $avatarName);;
        }

        $user = new User([
            'name' => $request->get('name'),
            'middlename' => $request->get('middlename'),
            'lastname' => $request->get('lastname'),
            'phonenumber' => $request->get('phonenumber'),
            'email' => $request->get('email'),
            'profile_picture' => $avatarName,
            'password' => Hash::make($request->get('password')),
        ]);

        $user->save();
        return redirect('/users')->with('success', 'Gebruiker opgeslagen!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function edit(User $user)
    {
        return view('/cms/users.edit', [
            'account' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $request->validated();
        $avatarName = null;
        if ($request->hasFile('profile_picture')) {
            if (File::exists(public_path($user->profile_picture))) {
                File::delete(public_path($user->profile_picture));
            }
            $avatarName = 'img/user/' . $user->id . '.' . $request->profile_picture->getClientOriginalExtension();
            $request->file('profile_picture')->move(public_path('img/user'), $avatarName);;
        } else {
            $avatarName = $user->profile_picture ?? null;
        }
        $user->name = $request->get('name');
        $user->middlename = $request->get('middlename');
        $user->lastname = $request->get('lastname');
        $user->phonenumber = $request->get('phonenumber');
        $user->email = $request->get('email');
        $user->profile_picture = $avatarName;
        $user->save();

        return redirect('/users')->with('success', 'Gebruiker geupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(User $user)
    {
        if (File::exists(public_path($user->profile_picture))) {

            File::delete(public_path($user->profile_picture));

        } else {
            dd('File does not exists.');
        }
        $user->delete();

        return redirect('/users')->with('success', 'Gebruiker verwijderd!');
    }
}
