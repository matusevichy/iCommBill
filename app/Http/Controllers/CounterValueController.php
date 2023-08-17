<?php

namespace App\Http\Controllers;


use App\Models\Counter;
use App\Models\CounterValue;
use App\Models\Tarif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CounterValueController extends Controller
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
    public function create(Counter $counter)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('create', [CounterValue::class, $counter])) return abort(403);
        return view('countervalue.create', compact('counter'));
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
        $counter = Counter::whereId($request->counter_id)->first();
        if ($user == null || $user->cannot('create', [CounterValue::class, $counter])) return abort(403);
        $last_value = CounterValue::where('counter_id', $counter->id)
            ->where('is_real', true)->orderBy('date', 'desc')->first();
        $validation = $request->validate([
            'value' => ['required', 'numeric', 'min:' . $last_value->value],
            'date' => ['required', 'date', 'after:' . $last_value->date],
            'on_accrual' => [function ($attribute, $value, $fail) use ($counter, $request) {
                //ToDo check next condition (orWhere)
                $tarif = Tarif::where('accrualtype_id', $counter->accrualtype_id)
                    ->where('date_begin', '<', $request->date)
                    ->where(function ($query) use ($request) {
                        $query->where('date_end', null)->orWhere('date_end', '>', $request->date);})->first();
                if ($tarif == null) {
                    $fail('On date ' . $request->date . ' organization hasn`t tarif. Accrual is not available!');
                }
            }],
            'counter_id' => ['required', 'exists:counters,id'],
        ]);
        $counter_value = new CounterValue();
        $counter_value->value = $request->value;
        $counter_value->date = $request->date;
        $counter_value->is_real = true;
        $counter_value->is_blocked = false;
        $counter_value->counter_id = $request->counter_id;
        $counter_value->save();

        if ($request->on_accrual != null) {
            create_accrual_by_counter($request->counter_id);
        }

        return redirect('/counters/' . $counter->id);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\CounterValue $countervalue
     * @return \Illuminate\Http\Response
     */
    public function show(CounterValue $countervalue)
    {
        dd($countervalue);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\CounterValue $countervalue
     * @return \Illuminate\Http\Response
     */
    public function edit(CounterValue $countervalue)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $countervalue)) return abort(403);
        return view('countervalue.edit', compact('countervalue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CounterValue $countervalue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CounterValue $countervalue)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $countervalue)) return abort(403);
        $last_value = CounterValue::where('counter_id', $countervalue->counter_id)->
        where('is_real', true)->where('id', '!=', $countervalue->id)->orderBy('date', 'desc')->first();
        $validation = $request->validate([
            'value' => ['required', 'numeric', 'min:' . $last_value->value],
            'date' => ['required', 'date', 'after:' . $last_value->date],
        ]);
        $countervalue->fill($request->only('value', 'date'));
        $countervalue->save();
        return redirect('/counters/' . $countervalue->counter_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\CounterValue $countervalue
     * @return \Illuminate\Http\Response
     */
    public function destroy(CounterValue $countervalue)
    {
        $counter_id = $countervalue->counter_id;
        $countervalue->delete();
        return redirect('/counters/' . $counter_id);
    }
}
