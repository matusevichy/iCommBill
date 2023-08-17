@extends('layouts.app')

@section('title', __('Add payment'))

@section('content')
    <form action="{{route('payments.store')}}" method="post">
        @csrf
        <div class="form-floating mb-3">
            <input type="number" id="value" name="value" class="form-control @error('value') is-invalid @enderror"
                   step="0.01" value="{{ old('value') }}" required autocomplete="value">
            <label for="value">{{__('Payment value')}}</label>

            @error('value')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror"
                   value="{{ date('Y-m-d') }}" required autocomplete="value">
            <label for="value">{{__('Payment date')}}</label>

            @error('date')
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
                    <option value="{{$type->id}}">{{__($type->name)}}</option>
                @endforeach
            </select>

            @error('accrualtype_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-md-6 offset-md-4">
            <input type="hidden" name="abonent_id" value="{{$abonent->id}}">
            <button type="submit" class="btn btn-primary">
                {{ __('Submit') }}
            </button>
        </div>
    </form>
@endsection
