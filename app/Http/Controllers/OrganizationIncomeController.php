<?php

namespace App\Http\Controllers;

use App\Models\Dictionary\BudgetItemType;
use App\Models\Organization;
use App\Models\OrganizationIncome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizationIncomeController extends Controller
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
        if ($user == null || $user->cannot('create', [OrganizationIncome::class, $organization])) return abort(403);
        $budget_item_types = BudgetItemType::all();
        return view('organizationincome.create', compact('organization', 'budget_item_types'));
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
        if ($user == null || $user->cannot('create', [OrganizationIncome::class, $organization])) return abort(403);
        $validation = $request->validate([
            'name' => ['string', 'max:255', 'required'],
            'value' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'organization_id' => ['required', 'exists:organizations,id'],
            'budgetitemtype_id' => ['required', 'exists:budget_item_types,id']
        ]);
        $organizationincome = new OrganizationIncome();
        $organizationincome->name = $request->name;
        $organizationincome->value = $request->value;
        $organizationincome->date = $request->date;
        $organizationincome->organization_id = $request->organization_id;
        $organizationincome->budgetitemtype_id = $request->budgetitemtype_id;

        $organizationincome->save();

        return redirect('/organizations/' . $organization->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrganizationIncome  $organizationincome
     * @return \Illuminate\Http\Response
     */
    public function show(OrganizationIncome $organizationincome)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrganizationIncome  $organizationincome
     * @return \Illuminate\Http\Response
     */
    public function edit(OrganizationIncome $organizationincome)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $organizationincome)) return abort(403);
        $budget_item_types = BudgetItemType::all();
        return view('organizationincome.edit', compact('organizationincome', 'budget_item_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrganizationIncome  $organizationincome
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrganizationIncome $organizationincome)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $organizationincome)) return abort(403);
        $validation = $request->validate([
            'name' => ['string', 'max:255', 'required'],
            'value' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'budgetitemtype_id' => ['required', 'exists:budget_item_types,id']
        ]);
        $organizationincome->fill($request->only('name', 'value', 'date', 'budgetitemtype_id'));
        $organizationincome->save();

        return redirect('/organizations/'.$organizationincome->organization_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrganizationIncome  $organizationincome
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrganizationIncome $organizationincome)
    {
        $organization_id = $organizationincome->organization_id;
        $organizationincome->delete();
        return redirect('/organizations/' . $organization_id);
    }
}
