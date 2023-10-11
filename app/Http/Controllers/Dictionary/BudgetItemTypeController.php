<?php

namespace App\Http\Controllers\Dictionary;

use App\Http\Controllers\Controller;
use App\Models\Dictionary\BudgetItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetItemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('viewAny', BudgetItemType::class)) return abort(403);
        $budgetitemtypes = BudgetItemType::all()->sortBy('name');
        return view('budgetitemtype.index', compact('budgetitemtypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('create', BudgetItemType::class)) return abort(403);
        return view('budgetitemtype.create');
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
        if ($user == null || $user->cannot('create', BudgetItemType::class)) return abort(403);
        $validation = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:budget_item_types'],
        ]);

        $type = new BudgetItemType();
        $type->name = $request->name;
        $type->save();

        return redirect('/budgetitemtypes');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Dictionary\BudgetItemType $budgetitemtype
     * @return \Illuminate\Http\Response
     */
    public function show(BudgetItemType $budgetitemtype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Dictionary\BudgetItemType $budgetitemtype
     * @return \Illuminate\Http\Response
     */
    public function edit(BudgetItemType $budgetitemtype)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $budgetitemtype)) return abort(403);
        return view('budgetitemtype.edit', compact('budgetitemtype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Dictionary\BudgetItemType $budgetitemtype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BudgetItemType $budgetitemtype)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $budgetitemtype)) return abort(403);
        $validation = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:budget_item_types'],
        ]);

        $budgetitemtype->name = $request->name;
        $budgetitemtype->save();

        return redirect('/budgetitemtypes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Dictionary\BudgetItemType $budgetitemtype
     * @return \Illuminate\Http\Response
     */
    public function destroy(BudgetItemType $budgetitemtype)
    {
        //
    }
}
