<?php

namespace App\Http\Controllers;

use App\Models\Abonent;
use App\Models\AbonentTarif;
use App\Models\Accrual;
use App\Models\Counter;
use App\Models\Dictionary\AccrualType;
use App\Models\Notice;
use App\Models\Organization;
use App\Models\Payment;
use App\Models\Saldo;
use App\Models\Tarif;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbonentController extends Controller
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
        if ($user == null || $user->cannot('create', [Abonent::class, $organization])) return abort(403);
        $users = User::all();
        return view('abonent.create', compact('organization', 'users'));
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
        $organization = Organization::whereId($request->organization_id)->first();
        if ($user == null || $user->cannot('create', [Abonent::class, $organization])) return abort(403);
        $validation = $request->validate([
//            'account_number' => ['required', 'string', 'max:255'],
            'location_number' => ['required', 'string', 'max:255'],
            'street' => ['string', 'max:255', 'nullable'],
            'square' => ['required', 'numeric'],
            'cadastral_number' => ['string', 'max:255', 'nullable'],
            'organization_id' => ['required', 'exists:organizations,id'],
            'user_id' => ['required', 'exists:users,id']
        ]);

        $abonent = new Abonent();
        $abonent->account_number = 'tmp';
        $abonent->location_number = $request->location_number;
        $abonent->street = $request->street;
        $abonent->square = $request->square;
        $abonent->ownership = $request->ownership == null ? 0 : 1;
        $abonent->cadastral_number = $request->cadastral_number;
        $abonent->organization_id = $request->organization_id;
        $abonent->user_id = $request->user_id;
        $abonent->save();

        $zero_count = env('ACCOUNT_NUMBER_LENGTH') - mb_strlen($organization->id) - mb_strlen($abonent->id);
        if ($zero_count >= 0) {
            $account_number = $organization->id . str_pad("", $zero_count, "0") . $abonent->id;
            $abonent->account_number = $account_number;
            $abonent->save();
        }
        return redirect('organizations/' . $organization->id);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Abonent $abonent
     * @return \Illuminate\Http\Response
     */
    public function show(Abonent $abonent)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('view', $abonent)) return abort(403);
        $date = date('Y-m-d');
        $saldos = Saldo::where('abonent_id', $abonent->id)->with('accrualtype')->get();
        $accruals = Accrual::where('abonent_id', $abonent->id)->with('accrualtype')->get();
        $payments = Payment::where('abonent_id', $abonent->id)->with('accrualtype')->get();
        $counters = Counter::where('abonent_id', $abonent->id)->with('accrualtype')->with('countervalues')->get();
        $org_tarifs = Tarif::where('organization_id', $abonent->organization_id)
            ->where('date_begin', '<', $date)
            ->where(function ($query) use ($date) {
                $query->where('date_end', null)->orWhere('date_end', '>', $date);
            })->get();
        $tarifs = AbonentTarif::where('abonent_id', $abonent->id)->with('accrualtype')->get();
        $notices = Notice::where('organization_id', $abonent->organization_id)
            ->where('date_begin', '<=', $date)
            ->where(function ($query) use ($date) {
                $query->where('date_end', null)->orWhere('date_end', '>=', $date);
            })->get();
        $accrual_types = AccrualType::all();
        return view('abonent.show',
            compact('abonent', 'saldos', 'accruals', 'payments', 'counters', 'notices', 'accrual_types', 'tarifs', 'org_tarifs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Abonent $abonent
     * @return \Illuminate\Http\Response
     */
    public function edit(Abonent $abonent)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $abonent)) return abort(403);
        $users = User::all();
        return view('abonent.edit', compact('abonent', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Abonent $abonent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Abonent $abonent)
    {
//        dd($request);
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $abonent)) return abort(403);
        $validation = $request->validate([
//            'account_number' => ['required', 'string', 'max:255'],
            'location_number' => ['required', 'string', 'max:255'],
            'street' => ['string', 'max:255', 'nullable'],
            'square' => ['required', 'numeric'],
            'cadastral_number' => ['string', 'max:255', 'nullable'],
            'organization_id' => ['required', 'exists:organizations,id'],
            'user_id' => ['required', 'exists:users,id']
        ]);

        $abonent->fill($request->only('location_number', 'square', 'cadastral_number', 'user_id'));
        $abonent->ownership = $request->ownership == null ? 0 : 1;
        $abonent->street = $request->street;
        $abonent->save();

        return redirect('organizations/' . $abonent->organization_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Abonent $abonent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Abonent $abonent)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('delete', $abonent)) return abort(403);

        $organization = Organization::whereId($abonent->organization_id)->first();

        $abonent->delete();
        return redirect('organizations/' . $organization->id);
    }
}
