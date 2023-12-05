<div>
    {{--    <h3>{{__('Tarifs')}}</h3>--}}
    @can('create', [\App\Models\AbonentTarif::class, $abonent])
        <a href="{{route('abonenttarifs.create', $abonent->id)}}" class="btn btn-primary"
           role="button">{{__("Add")}} </a>
    @endcan
    <span class="text-danger row">* {{__('tariffs calculated by the area of the plot (apartment) must be calculated for the area in square meters')}}</span>
    <table class="table table-striped table-responsive-md">
        <thead>
        <tr>
            <th scope="col">{{__('Accrual type')}}</th>
            <th>{{__('Date begin')}}</th>
            <th>{{__('Date end')}}</th>
            <th>{{__('Accruals by square')}}</th>
            <th>{{__('Actions')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tarifs as $tarif)
            <tr>
                <td>{{__($tarif->accrualtype->name)}}</td>
                <td>{{$tarif->date_begin}}</td>
                <td>{{$tarif->date_end}}</td>
                <td>{{($tarif->by_square)? __("Yes") : __("No")}}</td>
                <td>
                    <div class="row">
                        <div class="col col-sm-auto px-1">
                            @can('update', $tarif)
                                <a href="{{route('abonenttarifs.edit', $tarif->id)}}" class="btn btn-primary"
                                   role="button"><i title="{{__('Edit')}}" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            @endif
                        </div>
                        <div class="col col-sm-auto px-1">
                            @can('delete', $tarif)
                                <form action="{{ route('abonenttarifs.destroy', $tarif->id) }}" method="POST"
                                      class="form-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-primary" onclick="return confirm('Are you sure?')"><i
                                            title="{{__('Delete')}}" class="fa fa-times" aria-hidden="true"></i></button>
                                </form>
                        </div>
                        @endcan
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
