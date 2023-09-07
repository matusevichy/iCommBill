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
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Submit') }}
            </button>
        </div>
        @method('PUT')
    </form>
@endsection
