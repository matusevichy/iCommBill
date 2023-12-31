@extends('layouts.app')

@section('title', __('Edit tarif'))

@section('content')
    <div class="container">
        <form action="{{route('tarifs.update', $tarif)}}" method="post">
            @csrf
            <div class="form-floating mb-3">
                <input id="name" type="text"
                       class="form-control @error('name') is-invalid @enderror" name="name"
                       value="{{ $tarif->name }}" autocomplete="name" autofocus>
                <label for="name">{{ __('Tarif name') }}</label>
                @error('name')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="number" id="value" name="value" class="form-control @error('value') is-invalid @enderror"
                       step="0.01" value="{{ $tarif->value }}" required autocomplete="value">
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
                       value="{{ $tarif->date_begin }}" required autocomplete="date_begin">
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
                        class="form-select  @error('accrualtype_id') is-invalid @enderror" required
                        onchange="changeType(this.options[this.selectedIndex].getAttribute('byCounter'))">
                    <option value="">{{__('Select accrual type')}}</option>
                    @foreach($accrual_types as $type)
                        <option value="{{$type->id}}"
                                {{$type->id == $tarif->accrualtype_id? 'selected': ''}}  byCounter="{{$type->by_counter}}">
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
            <div id="zone_types_div"
                 style="visibility: {{$tarif->accrualtype->by_counter == true? "visible" : "hidden"}}">
                <select name="counterzonetype_id" id="counterzonetype_id"
                        class="form-select  @error('counterzonetype_id') is-invalid @enderror">
                    <option value="" selected>{{__('Select zone type (if exist)')}}</option>
                    @foreach($counter_zone_types as $zone_type)
                        <option
                            value="{{$zone_type->id}}" {{$zone_type->id == $tarif->counterzonetype_id? 'selected': ''}}>
                            {{__($zone_type->name)}}
                        </option>
                    @endforeach
                </select>

                @error('counterzonetype_id')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
            <div id="by_square_div"
                 style="visibility: {{$tarif->accrualtype->by_counter == false? "visible" : "hidden"}}">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="by_square" name="by_square"
                        {{($tarif->by_square == true)? "checked" : ""}}>
                    <label class="form-check-label ps-1">{{__('Accruals by square')}}</label>
                </div>
            </div>
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Submit') }}
                </button>
            </div>
            @method('PUT')
        </form>
    </div>
@endsection
@section('js')
    <script>
        function changeType(byCounter) {
            by_square_element = document.getElementById("by_square_div");
            zone_types_element = document.getElementById('zone_types_div');
            bySquare = by_square_element.getElementsByTagName("input");
            zone_types = zone_types_element.querySelector("select");
            bySquare[0].checked = false;
            zone_types.value = '';
            if (byCounter == 0) {
                by_square_element.style.visibility = "visible";
                zone_types_element.style.visibility = "hidden";
            }
            else if(byCounter == 1) {
                by_square_element.style.visibility = "hidden";
                zone_types_element.style.visibility = "visible";
            }
            else{
                by_square_element.style.visibility = "hidden";
                zone_types_element.style.visibility = "hidden";
            }
        }
    </script>
@endsection
