<?php

namespace App\Http\Controllers;

use App\Models\Dictionary\AccrualType;
use App\Models\Organization;
use App\Models\Tarif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TarifController extends Controller
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
        if ($user == null || $user->cannot('create', [Tarif::class, $organization])) return abort(403);
        $accrual_types = AccrualType::all();
        return view('tarif.create', compact('organization', 'accrual_types'));
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
        if ($user == null || $user->cannot('create', [Tarif::class, $organization])) return abort(403);
        $validation = $request->validate([
            'value' => ['required', 'numeric'],
            //ToDo check next condition
            'date_begin' => ['required', 'date', function ($attribute, $value, $fail) use ($request) {
                $tarifs = Tarif::where('organization_id', $request->organization_id)->
                where('accrualtype_id',$request->accrualtype_id)->
                where(function ($query) use ($value, $request) {
                    $query->where('date_end', null)->orWhere('date_end', '>', $value);
                });

                if ($tarifs->count() !== 0) {
                    $fail('On date ' . $value . ' organization has two or many tarifs');
                }
            }],
            'date_end' => ['date', 'after:date_begin', 'nullable'],
            'organization_id' => ['required', 'exists:organizations,id'],
            'accrualtype_id' => ['required', 'exists:accrual_types,id']
        ]);
        $tarif = new Tarif();
        $tarif->value = $request->value;
        $tarif->date_begin = $request->date_begin;
        $tarif->date_end = $request->date_end;
        $tarif->organization_id = $request->organization_id;
        $tarif->accrualtype_id = $request->accrualtype_id;
        $tarif->save();

        return redirect('/organizations/'.$organization->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tarif  $tarif
     * @return \Illuminate\Http\Response
     */
    public function show(Tarif $tarif)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tarif  $tarif
     * @return \Illuminate\Http\Response
     */
    public function edit(Tarif $tarif)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $tarif)) return abort(403);
        $accrual_types = AccrualType::all();
        return view('tarif.edit', compact('tarif', 'accrual_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tarif  $tarif
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tarif $tarif)
    {
        //ToDo check accruals when tarif update or remove?
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $tarif)) return abort(403);
        $validation = $request->validate([
            'value' => ['required', 'numeric'],
            //ToDo check next condition
            'date_begin' => ['required', 'date', function ($attribute, $value, $fail) use ($request) {
                $tarifs = Tarif::where('organization_id', $request->organization_id)->
                where('accrualtype_id',$request->accrualtype_id)->
                where(function ($query) use ($value, $request) {
                    $query->where('date_end', null)->orWhere('date_end', '>', $value);
                });

                if ($tarifs->count() !== 0) {
                    $fail('On date ' . $value . ' organization has two or many tarifs');
                }
            }],
            'date_end' => ['date', 'after:date_begin', 'nullable'],
            'accrualtype_id' => ['required', 'exists:accrual_types,id']
        ]);

        $tarif->fill($request->only('value', 'date_begin', 'date_end', 'accrualtype_id'));
        $tarif->save();

        return redirect('/organizations/'.$tarif->organization_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tarif  $tarif
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tarif $tarif)
    {
        $organization_id = $tarif->organization_id;
        $tarif->delete();
        return redirect('/organizations/'.$organization_id);
    }
}
