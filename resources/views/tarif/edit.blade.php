@extends('layouts.app')

@section('title', __('Edit tarif'))

@section('content')
    <form action="{{route('tarifs.update', $tarif)}}" method="post">
        @csrf
        <div class="form-floating mb-3">
            <input type="number" id="value" name="value" class="form-control @error('value') is-invalid @enderror"
                   step="0.01" value="{{ $tarif->value }}" required autocomplete="value">
            <label for="value">{{__('Tarif value')}}</label>
            <span class="text-danger">* {{__('tariffs calculated by the area of the plot (apartment) must be calculated for the area in square meters')}}</span>

            @error('value')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="date" id="date_begin" name="date_begin"
                   class="form-control @error('date_begin') is-invalid @enderror"
                   value="{{ $tarif->date_begin }}" required autocomplete="date_begin">
            <label for="value">{{__('Date begin')}}</label>

            @error('date_begin')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input type="date" id="date_end" name="date_end" class="form-control @error('date_end') is-invalid @enderror"
                   value="{{ $tarif->date_end }}" autocomplete="date_end">
            <label for="value">{{__('Date end')}}</label>

            @error('date_end')
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
                    <option value="{{$type->id}}" {{$type->id == $tarif->accrualtype_id? 'selected': ''}}>
                        {{__($type->name)}}
                    </option>
                @endforeach
            </select>

            @error('accrualtype_id')
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
