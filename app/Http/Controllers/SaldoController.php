<?php

namespace App\Http\Controllers;

use App\Models\Abonent;
use App\Models\Dictionary\AccrualType;
use App\Models\Saldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaldoController extends Controller
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
    public function create(Abonent $abonent)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('create', [Saldo::class, $abonent])) return abort(403);
        $accrual_types = AccrualType::all();
        return view('saldo.create', compact('abonent', 'accrual_types'));
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
        $abonent = Abonent::whereId($request->abonent_id)->first();
        if ($user == null || $user->cannot('create', [Saldo::class, $abonent])) return abort(403);
        $validation = $request->validate([
            'value' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'abonent_id' => ['required', 'exists:abonents,id'],
            'accrualtype_id' => ['required', 'exists:accrual_types,id']
        ]);
        $saldo = new Saldo();
        $saldo->value = $request->value;
        $saldo->date = $request->date;
        $saldo->abonent_id = $request->abonent_id;
        $saldo->accrualtype_id = $request->accrualtype_id;
        $saldo->save();

        return redirect('/abonents/'.$abonent->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Saldo  $saldo
     * @return \Illuminate\Http\Response
     */
    public function show(Saldo $saldo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Saldo  $saldo
     * @return \Illuminate\Http\Response
     */
    public function edit(Saldo $saldo)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $saldo)) return abort(403);
        $accrual_types = AccrualType::all();
        return view('saldo.edit', compact('saldo', 'accrual_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Saldo  $saldo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Saldo $saldo)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $saldo)) return abort(403);
        $validation = $request->validate([
            'value' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'accrualtype_id' => ['required', 'exists:accrual_types,id']
        ]);
        $saldo->fill($request->only('value', 'date', 'accrualtype_id'));
        $saldo->save();
        return redirect('/abonents/'.$saldo->abonent_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Saldo  $saldo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Saldo $saldo)
    {
        $abonent_id = $saldo->abonent_id;
        $saldo->delete();
        return redirect('/abonents/'.$abonent_id);
    }
}
