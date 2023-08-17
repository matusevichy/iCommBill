<?php

namespace App\Http\Controllers;

use App\Models\Dictionary\OrganizationType;
use App\Models\Dictionary\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Nullable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('viewAny', User::class)) return abort(403);
//        $user_orgs = $user->organizations()->allRelatedIds()->toArray();
        $users = User::all()->sortBy('name');
//        if ($user->role_id == 2) $users = User::with('organizations')->
//            whereHas('organizations', function ($query) use ($user_orgs) {
//                return $query->whereIn('organization_id', $user_orgs);
//            })->get()->sortBy('name');

        return view('user.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('create', User::class)) return abort(403);
        $roles = Role::all();
        return view('user.create', $roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric', 'digits:10', 'unique:users'],
            'email' => ['string', 'email', 'max:255', 'unique:users', 'nullable'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request['name'],
            'phone' => $request['phone'],
            'role_id' => 3,
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        $user->email = $request->email;
        $user->save();
        //ToDo fix bag with email field
        return redirect('/users');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $current_user = Auth::user();
        if ($current_user == null || $current_user->cannot('view', $user)) return abort(403);

        $user_orgs = $user->organizations;
        return view('user.show', compact('user', 'user_orgs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $current_user = Auth::user();
        if ($current_user == null || $current_user->cannot('update', $user)) return abort(403);
        $roles = Role::all()->sortBy('id');
        return view('user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $current_user = Auth::user();
        if ($current_user == null || $current_user->cannot('update', $user)) return abort(403);
        if ($request->password !== null) {
            $validation = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'numeric', 'digits:10', 'unique:users,phone,' . $user->id],
                'email' => ['string', 'email', 'max:255', 'unique:users,email,' . $user->id, 'nullable'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            $user->password = Hash::make($request->password);
        } else {
            $validation = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'numeric', 'digits:10', 'unique:users,phone,' . $user->id],
                'email' => ['string', 'email', 'max:255', 'unique:users,email,' . $user->id, 'nullable'],
            ]);
        }
        $user->fill($request->only('name', 'phone', 'email', 'role_id'));
        $user->email = $request->email;
        $user->save();
        if ($current_user->role_id == 1) return redirect('/users');
        else {
            return redirect('/users/' . $current_user->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
