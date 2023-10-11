<div>
    @can('create', [\App\Models\OrganizationIncome::class, $organization])
        <a href="{{route('organizationsaldos.create', $organization->id)}}" class="btn btn-primary"
           role="button">{{__("Add")}} </a>
    @endcan
   <table class="table table-striped table-responsive-md">
        <thead>
        <tr>
            <th>{{__('Value')}}</th>
            <th>{{__('Date')}}</th>
            <th>{{__('Actions')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($organization->organizationsaldos as $item)
            <tr>
                <td>{{$item->value}}</td>
                <td>{{$item->date}}</td>
                <td>
                    <div class="row">
                        <div class="col col-sm-auto px-1">
                            @can('update', $item)
                                <a href="{{route('organizationsaldos.edit', $item->id)}}" class="btn btn-primary"
                                   role="button"><i title="{{__('Edit')}}" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            @endcan
                        </div>
                        <div class="col col-sm-auto px-1">
                            @can('delete', $item)
                                <form action="{{ route('organizationsaldos.destroy', $item->id) }}" method="POST"
                                      class="form-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-primary" onclick="return confirm('Are you sure?')"><i
                                            title="{{__('Delete')}}" class="fa fa-times" aria-hidden="true"></i></button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
