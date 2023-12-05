<?php

namespace App\Http\Controllers;

use App\Models\Abonent;
use App\Models\AbonentTarif;
use App\Models\Dictionary\AccrualType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbonentTarifController extends Controller
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
        if ($user == null || $user->cannot('create', [AbonentTarif::class, $abonent])) return abort(403);
        $accrual_types = AccrualType::where('by_counter', false)->get();
        return view('abonenttarif.create', compact('abonent', 'accrual_types'));
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
        if ($user == null || $user->cannot('create', [AbonentTarif::class, $abonent])) return abort(403);
        $validation = $request->validate([
            'date_begin' => ['required', 'date', function ($attribute, $value, $fail) use ($request) {
                $tarifs = AbonentTarif::where('abonent_id', $request->abonent_id)->
                where('accrualtype_id', $request->accrualtype_id)->
//                where('by_square', $request->has('by_square'))->
                where(function ($query) use ($value, $request) {
                    $query->where('date_end', null)->orWhere('date_end', '>', $value);
                });
                if ($tarifs->count() !== 0) {
                    $fail('On date ' . $value . ' abonent has two or many tarifs');
                }
            }],
            'date_end' => ['date', 'after:date_begin', 'nullable'],
            'abonent_id' => ['required', 'exists:abonents,id'],
            'accrualtype_id' => ['required', 'exists:accrual_types,id']
        ]);
        $tarif = new AbonentTarif();
        $tarif->date_begin = $request->date_begin;
        $tarif->date_end = $request->date_end;
        $tarif->abonent_id = $request->abonent_id;
        $tarif->accrualtype_id = $request->accrualtype_id;
        $tarif->by_square = $request->has('by_square');
        $tarif->save();

        return redirect('/abonents/' . $abonent->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AbonentTarif  $abonenttarif
     * @return \Illuminate\Http\Response
     */
    public function show(AbonentTarif $abonenttarif)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AbonentTarif  $abonenttarif
     * @return \Illuminate\Http\Response
     */
    public function edit(AbonentTarif $abonenttarif)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $abonenttarif)) return abort(403);
        $accrual_types = AccrualType::where('by_counter', false)->get();
        return view('abonenttarif.edit', compact('abonenttarif', 'accrual_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AbonentTarif  $abonenttarif
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AbonentTarif $abonenttarif)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $abonenttarif)) return abort(403);
        $validation = $request->validate([
            'date_begin' => ['required', 'date', function ($attribute, $value, $fail) use ($abonenttarif, $request) {
                $tarifs = AbonentTarif::where('abonent_id', $request->abonent_id)->
                where('id', '!=', $abonenttarif->id)->
                where('accrualtype_id', $request->accrualtype_id)->
//                where('by_square', $request->has('by_square'))->
                where(function ($query) use ($value, $request) {
                    $query->where('date_end', null)->orWhere('date_end', '>', $value);
                });

                if ($tarifs->count() !== 0) {
                    $fail('On date ' . $value . ' abonent has two or many tarifs');
                }
            }],
            'date_end' => ['date', 'after:date_begin', 'nullable'],
            'accrualtype_id' => ['required', 'exists:accrual_types,id']
        ]);
        $abonenttarif->fill($request->only('date_begin', 'date_end', 'accrualtype_id'));
        $abonenttarif->by_square = $request->has('by_square');
        $abonenttarif->save();

        return redirect('/abonents/' . $abonenttarif->abonent_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AbonentTarif  $abonenttarif
     * @return \Illuminate\Http\Response
     */
    public function destroy(AbonentTarif $abonenttarif)
    {
        $abonent_id = $abonenttarif->abonent_id;
        $abonenttarif->delete();
        return redirect('/abonents/'.$abonent_id);
    }
}
