<div>
    <table class="table table-responsive-sm table-bordered table-striped table-hover table-sm">
        <thead>
        <tr>
            <th>Student Data</th>
            <th>Payment For Month</th>
            <th>Amount</th>
            <th>Personal Discount</th>
            <th>Subtotal</th>
        </tr>
        </thead>
        <tbody>
            @foreach($student_name as $key => $data) 
            
            <tr>
                <td>{{ $data }}</td>
                <td>{{ $payment_month[$key] }}</td>
                <td>{{ Helper::MoneyFormat($amount[$key]) }}</td>
                <td><input type="number" wire:model="personal_discount.{{ $key }}"  min='0' style="border:none" type-currency="IDR"></td>
                <td>{{ Helper::MoneyFormat($SubTotal[$key]) }}</td>
            </tr>
            @endforeach

            <tr>
                <td colspan="4" align="right"><b>Total</b></td>
                <td>{{ Helper::MoneyFormat($total) }}</td>
            </tr>
            <tr>
                <td colspan="4" align="right"><b>Fine Amount</b></td>
                <td>{{ Helper::MoneyFormat($fineAmount) }}</td>
            </tr>
            <tr>
                <td colspan="4" align="right"><b>Fine Discount</b></td>
                <td>RP. <input type="number" min="0" style="border:none" wire:model="fineDiscount"></td>
            </tr>
            <tr>
                <td colspan="4" align="right"><b>Final Total</b></td>
                <td><b>{{Helper::MoneyFormat($finalTotal)}}</b></td>
            </tr>
                
        </tbody>
    </table>
    <button class="btn btn-primary"><i class="nav-icon la la-money-bill"></i> Pay Now</button>
</div>
