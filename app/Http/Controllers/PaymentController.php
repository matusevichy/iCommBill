<?php

namespace App\Http\Controllers;

use App\Models\Abonent;
use App\Models\Dictionary\AccrualType;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
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
        return view('payment.create', compact('abonent', 'accrual_types'));
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
        if ($user == null || $user->cannot('create', [Payment::class, $abonent])) return abort(403);
        $validation = $request->validate([
            'value' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'abonent_id' => ['required', 'exists:abonents,id'],
            'accrualtype_id' => ['required', 'exists:accrual_types,id']
        ]);
        $payment = new Payment();
        $payment->value = $request->value;
        $payment->date = $request->date;
        $payment->abonent_id = $request->abonent_id;
        $payment->accrualtype_id = $request->accrualtype_id;
        $payment->save();

        return redirect('/abonents/'.$abonent->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $payment)) return abort(403);
        $accrual_types = AccrualType::all();
        return view('payment.edit', compact('payment', 'accrual_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $payment)) return abort(403);
        $validation = $request->validate([
            'value' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'accrualtype_id' => ['required', 'exists:accrual_types,id']
        ]);
        $payment->fill($request->only('value', 'date', 'accrualtype_id'));
        $payment->save();
        return redirect('/abonents/'.$payment->abonent_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $abonent_id = $payment->abonent_id;
        $payment->delete();
        return redirect('/abonents/'.$abonent_id);
    }
}
