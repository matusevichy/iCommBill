@extends('layouts.app')

@section('title', __('Edit tarif'))

@section('content')
    <div class="container">
        <form action="{{route('abonenttarifs.update', $abonenttarif)}}" method="post">
            @csrf
            <div class="form-floating mb-3">
                <input type="date" id="date_begin" name="date_begin"
                       class="form-control @error('date_begin') is-invalid @enderror"
                       value="{{ $abonenttarif->date_begin }}" required autocomplete="date_begin">
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
                       value="{{ $abonenttarif->date_end }}" autocomplete="date_end">
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
                                {{$type->id == $abonenttarif->accrualtype_id? 'selected': ''}}  byCounter="{{$type->by_counter}}">
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
            <div id="by_square_div"
                 style="visibility: {{$abonenttarif->accrualtype->by_counter == false? "visible" : "hidden"}}">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="by_square" name="by_square"
                        {{($abonenttarif->by_square == true)? "checked" : ""}}>
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
            bySquare = by_square_element.getElementsByTagName("input");
            bySquare[0].checked = false;
            if (byCounter == 0) {
                by_square_element.style.visibility = "visible";
            }
            else if(byCounter == 1) {
                by_square_element.style.visibility = "hidden";
            }
            else{
                by_square_element.style.visibility = "hidden";
            }
        }
    </script>
@endsection