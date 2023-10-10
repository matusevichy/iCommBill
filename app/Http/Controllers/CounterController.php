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
            'count_zones' => ['required', 'numeric', 'between:1,2']
        ]);

        $counter = new Counter();
        $counter->number = $request->number;
        $counter->date_begin = $request->date_begin;
        $counter->date_end = $request->date_end;
        $counter->abonent_id = $request->abonent_id;
        $counter->accrualtype_id = $request->accrualtype_id;
        $counter->count_zones = $request->count_zones;
        $counter->save();

        if ($counter->count_zones == 1) {
            $counter_value = new CounterValue();
            $counter_value->value = $request->counter_value;
            $counter_value->is_real = true;
            $counter_value->is_blocked = true;
            $counter_value->date = $request->date_begin;
            $counter_value->counter_id = $counter->id;
            $counter_value->save();
        }

        if ($counter->count_zones == 2) {
            $counter_value_1 = new CounterValue();
            $counter_value_1->value = $request->counter_value_1;
            $counter_value_1->is_real = true;
            $counter_value_1->is_blocked = true;
            $counter_value_1->date = $request->date_begin;
            $counter_value_1->counter_id = $counter->id;
            $counter_value_1->counterzonetype_id = 1;
            $counter_value_1->save();

            $counter_value_2 = new CounterValue();
            $counter_value_2->value = $request->counter_value_2;
            $counter_value_2->is_real = true;
            $counter_value_2->is_blocked = true;
            $counter_value_2->date = $request->date_begin;
            $counter_value_2->counter_id = $counter->id;
            $counter_value_2->counterzonetype_id = 2;
            $counter_value_2->save();
        }

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
        if ($counter->count_zones == 1) {
            $last_value = CounterValue::where('counter_id', $counter->id)->where('is_real', true)->whereNull('counterzonetype_id')->orderBy('date', 'desc')->first();
            $validation = $request->validate([
                'number' => ['string', 'max:255'],
                'date_end' => ['date', 'after:date_begin', 'after:' . $last_value->date, 'required_with:counter_value', 'nullable'],
                'accrualtype_id' => ['required', 'exists:accrual_types,id'],
                'counter_value' => ['required_with:date_end', 'numeric', 'min:' . $last_value->value, 'nullable']
            ]);
        }
        if ($counter->count_zones == 2) {
            $last_value_1 = CounterValue::where('counter_id', $counter->id)->where('is_real', true)->where('counterzonetype_id', 1)->orderBy('date', 'desc')->first();
            $last_value_2 = CounterValue::where('counter_id', $counter->id)->where('is_real', true)->where('counterzonetype_id', 2)->orderBy('date', 'desc')->first();
            $validation = $request->validate([
                'number' => ['string', 'max:255'],
                'date_end' => ['date', 'after:date_begin', 'after:' . $last_value->date, 'required_with:counter_value', 'nullable'],
                'accrualtype_id' => ['required', 'exists:accrual_types,id'],
                'counter_value_1' => ['required_with:date_end', 'numeric', 'min:' . $last_value_1->value, 'nullable'],
                'counter_value_2' => ['required_with:date_end', 'numeric', 'min:' . $last_value_2->value, 'nullable']
            ]);
        }
        $counter->fill($request->only('number', 'date_end', 'accrualtype_id'));
        $counter->save();

        if ($request->date_end !== null) {
            if ($counter->count_zones == 1) {
                $counter_value = new CounterValue();
                $counter_value->value = $request->counter_value;
                $counter_value->is_real = true;
                $counter_value->is_blocked = false;
                $counter_value->date = $request->date_end;
                $counter_value->counter_id = $counter->id;
                $counter_value->save();
            }
            if ($counter->count_zones == 2){
                $counter_value_1 = new CounterValue();
                $counter_value_1->value = $request->counter_value_1;
                $counter_value_1->is_real = true;
                $counter_value_1->is_blocked = false;
                $counter_value_1->date = $request->date_end;
                $counter_value_1->counter_id = $counter->id;
                $counter_value_1->save();

                $counter_value_2 = new CounterValue();
                $counter_value_2->value = $request->counter_value_2;
                $counter_value_2->is_real = true;
                $counter_value_2->is_blocked = false;
                $counter_value_2->date = $request->date_end;
                $counter_value_2->counter_id = $counter->id;
                $counter_value_2->save();
            }
            create_accrual_by_counter($counter->id);
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
