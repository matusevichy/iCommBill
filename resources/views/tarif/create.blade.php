@extends('layouts.app')

@section('title', __('Add tarif'))

@section('content')
    <div class="container">
        <form action="{{route('tarifs.store')}}" method="post">
            @csrf
            <div class="form-floating mb-3">
                <input id="name" type="text"
                       class="form-control @error('name') is-invalid @enderror" name="name"
                       value="{{ old('name') }}" autocomplete="name" autofocus>
                <label for="name">{{ __('Tarif name') }}</label>
                @error('name')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="number" id="value" name="value" class="form-control @error('value') is-invalid @enderror"
                       step="0.01" value="{{ old('value') }}" required autocomplete="value">
                <label for="value">{{__('Tarif value')}}</label>
                <span
                    class="text-danger">* {{__('tariffs calculated by the area of the plot (apartment) must be calculated for the area in square meters')}}</span>
                @error('value')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="date" id="date_begin" name="date_begin"
                       class="form-control @error('date_begin') is-invalid @enderror"
                       value="{{ date('Y-m-d') }}" required autocomplete="date_begin">
                <label for="value">{{__('Date begin')}}</label>

                @error('date_begin')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="date" id="date_end" name="date_end"
                       class="form-control @error('date_end') is-invalid @enderror"
                       value="" autocomplete="date_end">
                <label for="value">{{__('Date end')}}</label>

                @error('date_end')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
            <div>
                <select name="accrualtype_id" id="accrualtype_id"
                        class="form-select  @error('accrualtype_id') is-invalid @enderror" required
                        onchange="changeType(this.options[this.selectedIndex].getAttribute('byCounter'))">
                    <option value="" selected>{{__('Select accrual type')}}</option>
                    @foreach($accrual_types as $type)
                        <option value="{{$type->id}}" byCounter="{{$type->by_counter}}">{{__($type->name)}}
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
            <div id="by_square_div" style="visibility: hidden">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="by_square" name="by_square">
                    <label class="form-check-label ps-1">{{__('Accruals by square')}}</label>
                </div>
            </div>
            <div class="col-md-6 offset-md-4">
                <input type="hidden" name="organization_id" value="{{$organization->id}}">
                <button type="submit" class="btn btn-primary">
                    {{ __('Submit') }}
                </button>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script>
        function changeType(byCounter) {
            element = document.getElementById("by_square_div");
            bySquare = element.getElementsByTagName("input");
            bySquare[0].checked = false;
            if (byCounter == 0) {
                element.style.visibility = "visible";
            } else {
                element.style.visibility = "hidden";
            }
            console.log(bySquare[0].checked);
        }
    </script>
@endsection
