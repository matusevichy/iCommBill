<?php

namespace App\Http\Controllers;

use App\Models\Dictionary\BudgetItemType;
use App\Models\Organization;
use App\Models\OrganizationExpence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizationExpenceController extends Controller
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
        if ($user == null || $user->cannot('create', [OrganizationExpence::class, $organization])) return abort(403);
        $budget_item_types = BudgetItemType::all();
        return view('organizationexpence.create', compact('organization', 'budget_item_types'));
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
        if ($user == null || $user->cannot('create', [OrganizationExpence::class, $organization])) return abort(403);
        $validation = $request->validate([
            'name' => ['string', 'max:255', 'required'],
            'value' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'organization_id' => ['required', 'exists:organizations,id'],
            'budgetitemtype_id' => ['required', 'exists:budget_item_types,id']
        ]);
        $organizationexpence = new OrganizationExpence();
        $organizationexpence->name = $request->name;
        $organizationexpence->value = $request->value;
        $organizationexpence->date = $request->date;
        $organizationexpence->organization_id = $request->organization_id;
        $organizationexpence->budgetitemtype_id = $request->budgetitemtype_id;

        $organizationexpence->save();

        return redirect('/organizations/' . $organization->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrganizationExpence  $organizationexpence
     * @return \Illuminate\Http\Response
     */
    public function show(OrganizationExpence $organizationexpence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrganizationExpence  $organizationexpence
     * @return \Illuminate\Http\Response
     */
    public function edit(OrganizationExpence $organizationexpence)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $organizationexpence)) return abort(403);
        $budget_item_types = BudgetItemType::all();
        return view('organizationexpence.edit', compact('organizationexpence', 'budget_item_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrganizationExpence  $organizationexpence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrganizationExpence $organizationexpence)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $organizationexpence)) return abort(403);
        $validation = $request->validate([
            'name' => ['string', 'max:255', 'required'],
            'value' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'budgetitemtype_id' => ['required', 'exists:budget_item_types,id']
        ]);
        $organizationexpence->fill($request->only('name', 'value', 'date', 'budgetitemtype_id'));
        $organizationexpence->save();

        return redirect('/organizations/'.$organizationexpence->organization_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrganizationExpence  $organizationexpence
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrganizationExpence $organizationexpence)
    {
        $organization_id = $organizationexpence->organization_id;
        $organizationexpence->delete();
        return redirect('/organizations/' . $organization_id);
    }
}
