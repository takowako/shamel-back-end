<div class="row">
    <div class="col-lg-12 text-center "><h1 >{{ translate('Deliveryman_Earning_List') }}</h1></div>
    <div class="col-lg-12">



    <table>
        <thead>
            <tr>
                <th>{{ translate('delivery_man_info') }}</th>
                <th></th>
                <th>
                    {{ translate('name')  }}- {{ $data['dm']->f_name.' '.$data['dm']->l_name}}
                    <br>
                    {{ translate('phone')  }}- {{ $data['dm']->phone}}
                    <br>
                    {{ translate('email')  }}- {{ $data['dm']->email}}
                    <br>
                    {{ translate('total_order')  }}- {{ $data['dm']->order_count }}
                    <br>
                    {{ translate('total_earning')  }}- {{  \App\CentralLogics\Helpers::format_currency($data['dm']->wallet?->total_earning)}}

                </th>
                <th></th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th>{{ translate('Filter_Criteria') }}</th>
                <th></th>
                <th>
                    {{ translate('date')  }}- {{ $data['date'] ??translate('N/A') }}

                </th>
                <th></th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        <tr>
            <th>{{ translate('sl') }}</th>
            <th>{{translate('messages.Order_Id')}}</th>
            <th>{{translate('messages.Distance')}}</th>
            <th>{{translate('messages.Delivery_Fee_Earned')}}</th>
            <th>{{translate('messages.Tips')}}</th>
        </thead>
        <tbody>
        @foreach($data['earnings'] as $key => $earning)
            <tr>
                <td>{{ $key+1}}</td>
                <td>
                    {{ $earning->order_id }}
                </td>
                <td>
                    {{ $earning->order?->distance }} {{  translate('messages.km') }}
                </td>
                <td>{{ \App\CentralLogics\Helpers::format_currency($earning->original_delivery_charge) }} </td>
                <td>{{ \App\CentralLogics\Helpers::format_currency($earning->dm_tips) }} </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
</div>
