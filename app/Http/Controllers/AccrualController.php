<?php

namespace App\Http\Controllers;

use App\Models\Abonent;
use App\Models\Accrual;
use App\Models\Dictionary\AccrualType;
use App\Models\Organization;
use App\Models\Tarif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccrualController extends Controller
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
    public function createByOrg(Organization $organization)
    {
        $user = Auth::user();
        if ($user == null ||
            !in_array($organization->id, $user->organizations()->allRelatedIds()->toArray())) return abort(403);
        $accrual_types = AccrualType::where('by_counter', false)->get();
        $abonents = Abonent::where('organization_id', $organization->id)->get();
        return view('accrual.createByOrg', compact('organization', 'accrual_types', 'abonents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Abonent $abonent)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('create', [Accrual::class, $abonent])) return abort(403);
        $accrual_types = AccrualType::all();
        return view('accrual.create', compact('abonent', 'accrual_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeByOrg(Request $request)
    {
        $user = Auth::user();
        if ($user == null ||
            !in_array($request->organization_id, $user->organizations()->allRelatedIds()->toArray())) return abort(403);
        $tarif = Tarif::where('accrualtype_id', $request->accrualtype_id)
            ->where('date_begin', '<', $request->date)
            ->where(function ($query) use ($request) {
                $query->where('date_end', null)->orWhere('date_end', '>', $request->date);
            })->first();
        $validation = $request->validate([
            'date' => ['required', 'date', function ($attribute, $value, $fail) use ($tarif, $request) {
                if ($tarif == null) {
                    $fail('On date ' . $request->date . ' organization hasn`t tarif. Accrual is not available!');
                }
            }],
            'organization_id' => ['required', 'exists:organizations,id'],
            'accrualtype_id' => ['required', 'exists:accrual_types,id']
        ]);

        foreach ($request->abonents as $abonent_id) {
            $abonent = Abonent::whereId($abonent_id)->first();
            $accrual = new Accrual();
            $accrual->value = $request->by_square != null? $tarif->value * $abonent->square : $tarif->value;
            $accrual->date = $request->date;
            $accrual->abonent_id = $abonent_id;
            $accrual->accrualtype_id = $request->accrualtype_id;
            $accrual->save();
        }
        return redirect('/organizations/' . $request->organization_id);
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
        $abonent = Abonent::whereId($request->abonent_id)->first();
        if ($user == null || $user->cannot('create', [Accrual::class, $abonent])) return abort(403);
        $validation = $request->validate([
            'value' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'abonent_id' => ['required', 'exists:abonents,id'],
            'accrualtype_id' => ['required', 'exists:accrual_types,id']
        ]);
        $accrual = new Accrual();
        $accrual->value = $request->value;
        $accrual->date = $request->date;
        $accrual->abonent_id = $request->abonent_id;
        $accrual->accrualtype_id = $request->accrualtype_id;
        $accrual->save();

        return redirect('/abonents/' . $abonent->id);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Accrual $accrual
     * @return \Illuminate\Http\Response
     */
    public function show(Accrual $accrual)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Accrual $accrual
     * @return \Illuminate\Http\Response
     */
    public function edit(Accrual $accrual)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $accrual)) return abort(403);
        $accrual_types = AccrualType::all();
        return view('accrual.edit', compact('accrual', 'accrual_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Accrual $accrual
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Accrual $accrual)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $accrual)) return abort(403);
        $validation = $request->validate([
            'value' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'accrualtype_id' => ['required', 'exists:accrual_types,id']
        ]);
        $accrual->fill($request->only('value', 'date', 'accrualtype_id'));
        $accrual->save();
        return redirect('/abonents/' . $accrual->abonent_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Accrual $accrual
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accrual $accrual)
    {
        $abonent_id = $accrual->abonent_id;
        $accrual->delete();
        return redirect('/abonents/' . $abonent_id);
    }
}
