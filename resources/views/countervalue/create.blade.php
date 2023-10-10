@extends('layouts.app')

@section('title', __('Add counter value'))

@section('content')
    <div class="container">
        <form action="{{route('countervalues.store')}}" method="post">
            @csrf
            @if($counter->count_zones == 1)
                <div class="form-floating mb-3">
                    <input type="number" id="value" name="value"
                           class="form-control @error('value') is-invalid @enderror"
                           step="0.01" value="{{ old('value') }}" required autocomplete="value">
                    <label for="value">{{__('Counter value')}}</label>

                    @error('value')
                    <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                    @enderror
                </div>
            @endif
            @if($counter->count_zones == 2)
                <div class="form-floating mb-3">
                    <input type="number" id="value_1" name="value_1"
                           class="form-control @error('value_1') is-invalid @enderror"
                           step="0.01" value="{{ old('value_1') }}" required autocomplete="value">
                    <label for="value">{{__('Counter value')}}  ({{__('Day')}})</label>

                    @error('value_1')
                    <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="number" id="value_2" name="value_2"
                           class="form-control @error('value_2') is-invalid @enderror"
                           step="0.01" value="{{ old('value_2') }}" required autocomplete="value">
                    <label for="value">{{__('Counter value')}}  ({{__('Night')}})</label>

                    @error('value_2')
                    <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                    @enderror
                </div>
            @endif
            <div class="form-floating mb-3">
                <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror"
                       value="{{ old('date')? old('date') : date('Y-m-d') }}" required autocomplete="value">
                <label for="value">{{__('Value date')}}</label>

                @error('date')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
            <div>
                <label for="on_accrual">{{__('Make accrual')}}</label>
                <input type="checkbox" name="on_accrual" id="on_accrual"
                       class="@error('on_accrual') is-invalid @enderror">
                @error('on_accrual')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
            <div class="col-md-6 offset-md-4">
                <input type="hidden" name="counter_id" value="{{$counter->id}}">
                <button type="submit" class="btn btn-primary">
                    {{ __('Submit') }}
                </button>
            </div>
        </form>
    </div>
@endsection
