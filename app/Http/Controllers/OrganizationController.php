<?php

namespace App\Http\Controllers;

use App\Models\Abonent;
use App\Models\Dictionary\OrganizationType;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('viewAny', Organization::class)) return abort(403);
        if ($user->role_id == 1) $organizations = Organization::with('users')->get()->sortBy('name');
        if ($user->role_id == 2) {
            $user_orgs = $user->organizations()->allRelatedIds()->toArray();
            $organizations = Organization::with('users')->whereIn('id', $user_orgs)->
            get()->sortBy('name');
        }
        return view('organization.index')->with('organizations', $organizations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('create', Organization::class)) return abort(403);
        $types = OrganizationType::all()->sortBy('name');
        $users = User::all()->whereBetween('role_id', array(1, 2));
        return view('organization.create', compact('types', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('create', Organization::class)) return abort(403);
        $validation = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'user_limit' => ['required', 'numeric'],
            'accrual_date' => ['numeric'],
            'organizationtype_id' => ['required', 'exists:organization_types,id'],
        ]);

        $org = new Organization();
        $org->name = $request->name;
        $org->location = $request->location;
        $org->user_limit = $request->user_limit;
        $org->accrual_date = $request->accrual_date;
        $org->organizationtype_id = $request->organizationtype_id;
        $org->save();

        $org->users()->attach($request->users);
        return redirect('/organizations');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Organization $organization
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('view', $organization)) return abort(403);
        $abonents = Abonent::where('organization_id', $organization->id)->with('user')->get();
        return view('organization.show', compact('organization', 'abonents'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Organization $organization
     * @return \Illuminate\Http\Response
     */
    public function edit(Organization $organization)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $organization)) return abort(403);
        $types = OrganizationType::all()->sortBy('name');
        $users = User::all()->whereBetween('role_id', array(1, 2));
        return view('organization.edit', compact('organization', 'types', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Organization $organization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organization $organization)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $organization)) return abort(403);
        $validation = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'user_limit' => ['required', 'numeric'],
            'accrual_date' => ['numeric'],
            'organizationtype_id' => ['required', 'exists:organization_types,id'],
        ]);
        $organization->fill($request->only('name', 'location', 'user_limit', 'accrual_date', 'organizationtype_id'));
        $organization->is_active = $request->is_active == null ? 0 : 1;
        $organization->save();
        $organization->users()->sync($request->users);
        return redirect('/organizations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Organization $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('delete', $organization)) return abort(403);
        if (Auth::user()->role_id == 1) {
            $organization->users()->detach();
            $organization->delete();
        }
        return redirect('/organizations');
    }
}
