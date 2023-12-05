@extends('layouts.app')

@section('title', __('Add counter'))

@section('content')
    <div class="container">
        <form action="{{route('counters.store')}}" method="post">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" id="number" name="number" class="form-control @error('number') is-invalid @enderror"
                       value="{{ old('number') }}" required autocomplete="number" autofocus>
                <label for="number">{{__('Counter number')}}</label>

                @error('number')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="date" id="date_begin" name="date_begin"
                       class="form-control @error('date_begin') is-invalid @enderror"
                       value="{{ date('Y-m-d') }}" required autocomplete="date_begin">
                <label for="value">{{__('Counter installation date')}}</label>

                @error('date_begin')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
            <div>
                <select name="accrualtype_id" id="accrualtype_id"
                        class="form-select  @error('accrualtype_id') is-invalid @enderror" required>
                    <option value="" selected>{{__('Select accrual type')}}</option>
                    @foreach($accrual_types as $type)
                        <option value="{{$type->id}}">{{__($type->name)}}
                            {{($type->by_counter == true)? "(".__("by counter").")":""}}
                        </option>
                    @endforeach
                </select>

                @error('accrualtype_id')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="number" id="count_zones" name="count_zones"
                       class="form-control @error('count_zones') is-invalid @enderror"
                       step="1" value="" min="1" max="2" required
                       autocomplete="count_zones">
                <label for="value">{{__('Zones count')}} (1 {{__('or')}} 2)</label>

                @error('count_zones')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
            <div id="value_for_1_zone" style="display: none">
                <div class="form-floating mb-3">
                    <input type="number" id="counter_value" name="counter_value"
                           class="form-control @error('counter_value') is-invalid @enderror"
                           step="0.01" value="{{ old('counter_value') }}" autocomplete="counter_value">
                    <label for="value">{{__('Real start counter value')}}</label>

                    @error('counter_value')
                    <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                    @enderror
                </div>
            </div>
            <div id="values_for_2_zones" style="display: none">
                <div class="form-floating mb-3">
                    <input type="number" id="counter_value_1" name="counter_value_1"
                           class="form-control @error('counter_value_1') is-invalid @enderror"
                           step="0.01" value="{{ old('counter_value_1') }}" autocomplete="counter_value_1">
                    <label for="value">{{__('Real start counter value')}} ({{__('Day')}})</label>

                    @error('counter_value_1')
                    <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="number" id="counter_value_2" name="counter_value_2"
                           class="form-control @error('counter_value_2') is-invalid @enderror"
                           step="0.01" value="{{ old('counter_value_2') }}" autocomplete="counter_value_2">
                    <label for="value">{{__('Real start counter value')}} ({{__('Night')}})</label>

                    @error('counter_value_2')
                    <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 offset-md-4">
                <input type="hidden" name="abonent_id" value="{{$abonent->id}}">
                <button type="submit" class="btn btn-primary">
                    {{ __('Submit') }}
                </button>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script>
        window.addEventListener("DOMContentLoaded", function () {
            count_zones_input = document.getElementById('count_zones');
            count_zones_input.addEventListener('input', function (e) {
                count_zones = count_zones_input.value;
                value_for_1_zone_div = document.getElementById('value_for_1_zone');
                values_for_2_zones_div = document.getElementById('values_for_2_zones');
                counter_value = document.getElementById('counter_value');
                counter_value_1 = document.getElementById('counter_value_1');
                counter_value_2 = document.getElementById('counter_value_2');
                if (count_zones == 1) {
                    counter_value.required = true;
                    counter_value_1.required = false;
                    counter_value_2.required = false;
                    value_for_1_zone_div.style.display = 'block';
                    values_for_2_zones_div.style.display = 'none';
                } else if (count_zones == 2) {
                    counter_value.required = false;
                    counter_value_1.required = true;
                    counter_value_2.required = true;
                    value_for_1_zone_div.style.display = 'none';
                    values_for_2_zones_div.style.display = 'block';
                } else {
                    value_for_1_zone_div.style.display = 'none';
                    values_for_2_zones_div.style.display = 'none';
                }
            });
        });
    </script>
@endsection
