<?php

use App\Models\Abonent;
use App\Models\Accrual;
use App\Models\Counter;
use App\Models\CounterValue;
use App\Models\Dictionary\AccrualType;
use App\Models\Organization;
use App\Models\Payment;
use App\Models\Saldo;
use App\Models\Tarif;

if (!function_exists('create_accrual_by_counter')) {
    function create_accrual_by_counter($id): void
    {
        $counter = Counter::whereId($id)->first();
        if ($counter->count_zones == 1) {
            $last_val = CounterValue::where('counter_id', $id)
                ->where('is_blocked', false)->orderBy('date', 'desc')
                ->orderBy('is_real', 'desc')->orderBy('value', 'desc')->first();
            $prev_val = CounterValue::where('counter_id', $id)
                ->where('is_blocked', true)->orderBy('date', 'desc')->first();
            $difference = $last_val->value - $prev_val->value;
            $tarif = Tarif::where('accrualtype_id', $counter->accrualtype_id)
                ->whereNull('counterzonetype_id')
                ->where('date_begin', '<', $last_val->date)
                ->where(function ($query) use ($last_val) {
                    $query->where('date_end', null)->orWhere('date_end', '>', $last_val->date);
                })->first();
            $accrual_val = $difference * $tarif->value;
        }
        if ($counter->count_zones == 2) {
            $last_val_1 = CounterValue::where('counter_id', $id)
                ->where('counterzonetype_id', 1)
                ->where('is_blocked', false)->orderBy('date', 'desc')
                ->orderBy('is_real', 'desc')->orderBy('value', 'desc')->first();
            $prev_val_1 = CounterValue::where('counter_id', $id)
                ->where('counterzonetype_id', 1)
                ->where('is_blocked', true)->orderBy('date', 'desc')->first();
            $last_val_2 = CounterValue::where('counter_id', $id)
                ->where('counterzonetype_id', 2)
                ->where('is_blocked', false)->orderBy('date', 'desc')
                ->orderBy('is_real', 'desc')->orderBy('value', 'desc')->first();
            $prev_val_2 = CounterValue::where('counter_id', $id)
                ->where('counterzonetype_id', 2)
                ->where('is_blocked', true)->orderBy('date', 'desc')->first();
            $difference_1 = $last_val_1->value - $prev_val_1->value;
            $tarif_1 = Tarif::where('accrualtype_id', $counter->accrualtype_id)
                ->where('counterzonetype_id', 1)
                ->where('date_begin', '<', $last_val_1->date)
                ->where(function ($query) use ($last_val_1) {
                    $query->where('date_end', null)->orWhere('date_end', '>', $last_val_1->date);
                })->first();
            $difference_2 = $last_val_2->value - $prev_val_2->value;
            $tarif_2 = Tarif::where('accrualtype_id', $counter->accrualtype_id)
                ->where('counterzonetype_id', 2)
                ->where('date_begin', '<', $last_val_2->date)
                ->where(function ($query) use ($last_val_2) {
                    $query->where('date_end', null)->orWhere('date_end', '>', $last_val_2->date);
                })->first();
            $accrual_val = $difference_1 * $tarif_1->value + $difference_2 * $tarif_2->value;
        }

        if ($accrual_val > 0) {
            $accrual = new Accrual();
            if ($counter->count_zones == 1) $accrual->date = $last_val->date;
            if ($counter->count_zones == 2) $accrual->date = $last_val_1->date;
            $accrual->value = $accrual_val;
            $accrual->accrualtype_id = $counter->accrualtype_id;
            $accrual->abonent_id = $counter->abonent_id;
            $accrual->save();
        }

        if ($counter->count_zones == 1) {
            $last_val->is_blocked = true;
            $last_val->save();
        }

        if ($counter->count_zones == 2) {
            $last_val_1->is_blocked = true;
            $last_val_1->save();
            $last_val_2->is_blocked = true;
            $last_val_2->save();
        }
    }
}

//todo need testing
if (!function_exists('create_calculated_counters_value_by_abonent')) {
    function create_calculated_counters_value_by_abonent($id)
    {
        $counters = Counter::where('abonent_id', $id)->get();
        foreach ($counters as $counter) {
            $make_accrual_1 = false;
            $make_accrual_2 = false;
            if ($counter->count_zones == 1) {
                $real_values = CounterValue::where('counter_id', $counter->id)->where('is_real', true)->orderBy('date', 'desc')->get();
                $last_value = CounterValue::where('counter_id', $counter->id)->orderBy('date', 'desc')->first();
                $make_accrual_1 = create_calculated_counters_value($counter, $real_values, $last_value);
            }
            if ($counter->count_zones == 2) {
                $real_values = CounterValue::where('counter_id', $counter->id)->where('is_real', true)
                    ->where('counterzonetype_id', 1)->orderBy('date', 'desc')->get();
                $last_value = CounterValue::where('counter_id', $counter->id)
                    ->where('counterzonetype_id', 1)->orderBy('date', 'desc')->first();
                $make_accrual_1 = create_calculated_counters_value($counter, $real_values, $last_value);

                $real_values = CounterValue::where('counter_id', $counter->id)->where('is_real', true)
                    ->where('counterzonetype_id', 2)->orderBy('date', 'desc')->get();
                $last_value = CounterValue::where('counter_id', $counter->id)
                    ->where('counterzonetype_id', 2)->orderBy('date', 'desc')->first();
                $make_accrual_2 = create_calculated_counters_value($counter, $real_values, $last_value);
            }
            if ($make_accrual_1 || $make_accrual_2) create_accrual_by_counter($counter->id);
        }
    }
}

if (!function_exists('create_calculated_counters_value')) {
    function create_calculated_counters_value($counter, $real_values, $last_value)
    {
        $current_month = date('Y-m');
        $current_date = date('Y-m-d');
        if ($last_value->date->format('Y-m') != $current_month) {
            if ($real_values->count() > 1) {
                $realdate_diff = date_diff(new DateTime($real_values[0]->date), new DateTime($real_values[1]->date))->format('%a');
                $daily_intake = ($real_values[0]->value - $real_values[1]->value) / ($realdate_diff);
                $date_diff = date_diff(new DateTime($last_value->date), new DateTime($current_date))->format('%a');
                $new_value = round($last_value->value + $date_diff * $daily_intake);
                if ($new_value > $last_value->value) {
                    $value = new CounterValue();
                    $value->date = $current_date;
                    $value->value = $new_value;
                    $value->is_real = false;
                    $value->is_blocked = false;
                    $value->counterzonetype_id = $last_value->counterzonetype_id;
                    $value->counter_id = $counter->id;
                    $value->save();

                    return true;
                }
            }
        }
        return false;
    }
}
if (!function_exists('create_calculated_counters_value_for_all')) {
    function create_calculated_counters_value_for_all()
    {
        $current_day = date('d');
        $organizations = Organization::where('accrual_date', date('d'))->get();
        foreach ($organizations as $organization) {
            $abonents = Abonent::where('organization_id', $organization->id)->get();
            foreach ($abonents as $abonent) {
                create_calculated_counters_value_by_abonent($abonent->id);
            }
        }
    }
}

if (!function_exists('get_abonent_saldo_by_accrual_type')) {
    function get_abonent_saldo_by_accrual_type($abonent_id, $accrualtype_id)
    {
        $saldo = Saldo::where('abonent_id', $abonent_id)->where('accrualtype_id', $accrualtype_id)->first();
        $accruals = Accrual::where('abonent_id', $abonent_id)->where('accrualtype_id', $accrualtype_id)->get();
        $payments = Payment::where('abonent_id', $abonent_id)->where('accrualtype_id', $accrualtype_id)->get();
        if ($saldo != null) {
            $result = $saldo->value;
        } else {
            $result = 0;
        }
        foreach ($accruals as $accrual) {
            $result += $accrual->value;
        }
        foreach ($payments as $payment) {
            $result -= $payment->value;
        }
        return $result;
    }
}

if (!function_exists('get_abonent_saldo')) {
    function get_abonent_saldo($abonent_id)
    {
        $accrual_types = AccrualType::all();
        $saldo = 0;
        foreach ($accrual_types as $type) {
            $saldo += get_abonent_saldo_by_accrual_type($abonent_id, $type->id);
        }
        return $saldo;
    }
}

