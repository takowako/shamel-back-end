@foreach($employees as $k=>$e)
<tr>
    <th scope="row">{{$k+1}}</th>
    <td class="text-capitalize">{{$e['f_name']}} {{$e['l_name']}}</td>
    <td >
        {{$e['email']}}
    </td>
    <td>{{$e['phone']}}</td>
    <td>{{$e->role?$e->role['name']:translate('messages.role_deleted')}}</td>
    <td>
        @if (auth('vendor_employee')->id()  != $e['id'])
        <a class="btn btn-sm btn-white"
            href="{{route('vendor.employee.edit',[$e['id']])}}" title="{{translate('messages.edit_Employee')}}"><i class="tio-edit"></i>
        </a>
        <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:"
           data-id="employee-{{$e['id']}}" data-message="{{translate('messages.Want_to_delete_this_role')}}" title="{{translate('messages.delete_Employee')}}"><i class="tio-delete-outlined"></i>
        </a>
        <form action="{{route('vendor.employee.delete',[$e['id']])}}"
                method="post" id="employee-{{$e['id']}}">
            @csrf @method('delete')
        </form>
        @endif
    </td>
</tr>
@endforeach
