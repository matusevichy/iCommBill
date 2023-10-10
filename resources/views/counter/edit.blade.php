@extends('layouts.app')

@section('title', __('Edit counter'))

@section('content')
    @isset($messages)
            <?php dd($messages) ?>

    @endisset
    <form action="{{route('counters.update', $counter->id)}}" method="post">
        @csrf
        <div class="form-floating mb-3">
            <input type="text" id="number" name="number" class="form-control @error('number') is-invalid @enderror"
                   value="{{ $counter->number }}" required autocomplete="number" autofocus>
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
                   value="{{ $counter->date_begin }}" readonly autocomplete="date_begin">
            <label for="value">{{__('Counter installation date')}}</label>

            @error('date_begin')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="date" id="date_end" name="date_end"
                   class="form-control @error('date_end') is-invalid @enderror"
                   value="{{ $counter->date_end == null ? '' : $counter->date_end}}" autocomplete="date_end">
            <label for="value">{{__('Counter removing date')}}</label>

            @error('date_end')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div>
            <select name="accrualtype_id" id="accrualtype_id"
                    class="form-select  @error('accrualtype_id') is-invalid @enderror">
                <option value="" selected>{{__('Select accrual type')}}</option>
                @foreach($accrual_types as $type)
                    <option value="{{$type->id}}" {{$type->id === $counter->accrualtype_id? 'selected' : ''}}>
                        {{__($type->name)}}  {{($type->by_counter == true)? "(".__("by counter").")":""}}
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
                   step="1" value="{{ $counter->count_zones }}" min="1" max="2" readonly
                   autocomplete="count_zones">
            <label for="value">{{__('Zones count')}}</label>

            @error('count_zones')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        @if($counter->count_zones == 1)
            <div class="form-floating mb-3">
                <input type="number" id="counter_value" name="counter_value"
                       class="form-control @error('counter_value') is-invalid @enderror"
                       step="0.01" value="{{ old('counter_value') }}" autocomplete="counter_value">
                <label for="counter_value">{{__('Real end counter value')}}</label>

                @error('counter_value')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
        @endif
        @if($counter->count_zones == 2)
            <div class="form-floating mb-3">
                <input type="number" id="counter_value_1" name="counter_value_1"
                       class="form-control @error('counter_value_1') is-invalid @enderror"
                       step="0.01" value="{{ old('counter_value_1') }}" autocomplete="counter_value_1">
                <label for="value">{{__('Real end counter value')}} ({{__('Day')}})</label>

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
                <label for="value">{{__('Real end counter value')}} ({{__('Night')}})</label>

                @error('counter_value_2')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
        @endif
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Submit') }}
            </button>
        </div>
        @method('PUT')
    </form>
@endsection
