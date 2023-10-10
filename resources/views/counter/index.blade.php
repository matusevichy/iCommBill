<div>
    {{--    <h3>{{__('Counters')}}</h3>--}}
    @can('create', [\App\Models\Counter::class, $abonent])
        <a href="{{route('counters.create', $abonent->id)}}" class="btn btn-primary"
           role="button">{{__("Add")}} </a>
    @endcan
    <table class="table table-striped table-responsive-md">
        <thead>
        <tr>
            <th scope="row">{{__('Accrual type')}}</th>
            <th>{{__('Number')}}</th>
            <th>{{__('Date begin')}}</th>
            <th>{{__('Date end')}}</th>
            <th>{{__('Zones count')}}</th>
            <th>{{__('Actions')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($counters as $counter)
            <tr>
                <td>{{__($counter->accrualtype->name)}}</td>
                <td><a href="{{route('counters.show', $counter->id)}}">{{$counter->number}}</a></td>
                <td>{{$counter->date_begin}}</td>
                <td>{{$counter->date_end}}</td>
                <td>{{$counter->count_zones}}</td>
                <td>
                    <div class="row">
                        <div class="col col-sm-auto px-1">
                            @can('update', $counter)
                                <a href="{{route('counters.edit', $counter->id)}}" class="btn btn-primary"
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
