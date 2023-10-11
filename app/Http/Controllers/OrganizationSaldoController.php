<?php

namespace App\Http\Controllers;

use App\Models\Dictionary\BudgetItemType;
use App\Models\Organization;
use App\Models\OrganizationSaldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizationSaldoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Organization $organization)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('create', [OrganizationSaldo::class, $organization])) return abort(403);
        return view('organizationsaldo.create', compact('organization'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $organization = Organization::whereId($request->organization_id)->first();
        if ($user == null || $user->cannot('create', [OrganizationSaldo::class, $organization])) return abort(403);
        $validation = $request->validate([
            'value' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'organization_id' => ['required', 'exists:organizations,id'],
        ]);
        $organizationsaldo = new OrganizationSaldo();
        $organizationsaldo->value = $request->value;
        $organizationsaldo->date = $request->date;
        $organizationsaldo->organization_id = $request->organization_id;

        $organizationsaldo->save();

        return redirect('/organizations/' . $organization->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrganizationSaldo  $organizationsaldo
     * @return \Illuminate\Http\Response
     */
    public function show(OrganizationSaldo $organizationsaldo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrganizationSaldo  $organizationsaldo
     * @return \Illuminate\Http\Response
     */
    public function edit(OrganizationSaldo $organizationsaldo)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $organizationsaldo)) return abort(403);
        return view('organizationsaldo.edit', compact('organizationsaldo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrganizationSaldo  $organizationsaldo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrganizationSaldo $organizationsaldo)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $organizationsaldo)) return abort(403);
        $validation = $request->validate([
            'value' => ['required', 'numeric'],
            'date' => ['required', 'date'],
        ]);
        $organizationsaldo->fill($request->only('value', 'date'));
        $organizationsaldo->save();

        return redirect('/organizations/'.$organizationsaldo->organization_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrganizationSaldo  $organizationsaldo
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrganizationSaldo $organizationsaldo)
    {
        $organization_id = $organizationsaldo->organization_id;
        $organizationsaldo->delete();
        return redirect('/organizations/' . $organization_id);
    }
}
