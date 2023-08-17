<?php

namespace App\Http\Controllers;

use App\Models\Abonent;
use App\Models\Counter;
use App\Models\CounterValue;
use App\Models\Dictionary\AccrualType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CounterController extends Controller
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
        if ($user == null || $user->cannot('create', [Counter::class, $abonent])) return abort(403);
        $accrual_types = AccrualType::where('by_counter', 1)->get();
        return view('counter.create', compact('abonent', 'accrual_types'));
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
        if ($user == null || $user->cannot('create', [Counter::class, $abonent])) return abort(403);
        $validation = $request->validate([
            'number' => ['string', 'max:255'],
            //ToDo check next condition (orWhere)
            'date_begin' => ['required', 'date', function ($attribute, $value, $fail) use ($request) {
                $counters = Counter::where('abonent_id', $request->abonent_id)->
                where('accrualtype_id', $request->accrualtype_id)->
                where(function ($query) use ($value, $request) {
                    $query->where('date_end', null)->orWhere('date_end', '>', $value);
                });

                if ($counters->count() !== 0) {
                    $fail('On date ' . $value . ' abonent has two or many counters');
                }
            }],
            'date_end' => ['date'],
            'abonent_id' => ['required', 'exists:abonents,id'],
            'accrualtype_id' => ['required', 'exists:accrual_types,id'],
            'counter_value' => ['required', 'numeric']
        ]);

        $counter = new Counter();
        $counter->number = $request->number;
        $counter->date_begin = $request->date_begin;
        $counter->date_end = $request->date_end;
        $counter->abonent_id = $request->abonent_id;
        $counter->accrualtype_id = $request->accrualtype_id;
        $counter->save();

        $counter_value = new CounterValue();
        $counter_value->value = $request->counter_value;
        $counter_value->is_real = false;
        $counter_value->is_blocked = true;
        $counter_value->date = $request->date_begin;
        $counter_value->counter_id = $counter->id;
        $counter_value->save();

        return redirect('/abonents/' . $abonent->id);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Counter $counter
     * @return \Illuminate\Http\Response
     */
    public function show(Counter $counter)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('view', $counter)) return abort(403);
        $counter_values = CounterValue::where('counter_id', $counter->id)->get();
        return view('counter.show', compact('counter', 'counter_values'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Counter $counter
     * @return \Illuminate\Http\Response
     */
    public function edit(Counter $counter)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $counter)) return abort(403);
        $accrual_types = AccrualType::where('by_counter', 1)->get();
        return view('counter.edit', compact('counter', 'accrual_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Counter $counter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Counter $counter)
    {
        $user = Auth::user();
        if ($user == null || $user->cannot('update', $counter)) return abort(403);
        $last_value = CounterValue::where('counter_id', $counter->id)->where('is_real', true)->orderBy('date', 'desc')->first();
        $validation = $request->validate([
            'number' => ['string', 'max:255'],
            'date_end' => ['date', 'after:date_begin', 'after:' . $last_value->date, 'required_with:counter_value', 'nullable'],
            'accrualtype_id' => ['required', 'exists:accrual_types,id'],
            'counter_value' => ['required_with:date_end', 'numeric', 'min:' . $last_value->value, 'nullable']
        ]);
        $counter->fill($request->only('number', 'accrualtype_id'));
        $counter->save();

        if ($request->date_end !== null) {
            $counter_value = new CounterValue();
            $counter_value->value = $request->counter_value;
            $counter_value->is_real = true;
            $counter_value->is_blocked = false;
            $counter_value->date = $request->date_end;
            $counter_value->counter_id = $counter->id;
            $counter_value->save();
        }
        return redirect('/counters/' . $counter->abonent_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Counter $counter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Counter $counter)
    {
        //
    }
}
