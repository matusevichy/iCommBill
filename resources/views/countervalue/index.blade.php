<h3>{{__('Counter values')}}</h3>
@can('create', [\App\Models\CounterValue::class, $counter])
    <a href="{{route('countervalues.create', $counter->id)}}" class="btn btn-primary"
       role="button">{{__("Add")}} </a>
@endcan
<div>
    <table class="table table-striped table-responsive-md">
        <thead>
        <tr>
            <th scope="row">{{__('Value date')}}</th>
            <th>{{__('Value')}}</th>
            <th>{{__('Zone')}}</th>
            <th>{{__('Type')}}</th>
            <th>{{__('Actions')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($counter_values as $counter_value)
            <tr>
                <td>
                    {{$counter_value->date}}
                </td>
                <td>
                    {{$counter_value->value}}
                </td>
                <td>
                    {{($counter_value->counterzonetype_id == null)? "" : __($counter_value->counterzonetype->name)}}
                </td>
                <td>
                    {{$counter_value->is_real == 0 ? __('Calculated') : __('Real')}}
                </td>
                <td>
                    <div class="row">
                        <div class="col col-sm-auto px-1">
                            @can('update', $counter_value)
                                <a href="{{route('countervalues.edit', $counter_value->id)}}" class="btn btn-primary"
                                   role="button"><i title="{{__('Edit')}}" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            @endcan
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
