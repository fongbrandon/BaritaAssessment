<html>
    <head>
        <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    </head>
    <body>
        <label for="isin_code">Security</label>
        <select id="isin_code" name="isin_code" onchange="filterTable()" required>
            <option value="">All</option>
            @foreach($securities as $security)
                <option value="{{ $security->isin_code }}">{{ $security->description }}</option>
            @endforeach
        </select>
        <label for="status_id">Status</label>
        <select id="status_id" name="status_id" onchange="filterTable()" required>
            <option value="">All</option>
            @foreach($statuses as $status)
                <option value="{{ $status->status_id }}">{{ $status->status_name }}</option>
            @endforeach
        </select>
        <label for="payment_date">Payment Date</label>
        <input type="date" id="payment_date" name="payment_date" onchange="filterTable()" required>

        <button type="button" onclick="location.href='/create_coupon'">New</button>
        <table>
            <thead>
                <tr>
                    <th>Coupon ID</th>
                    <th>ISIN Code</th>
                    <th>Payment Date</th>
                    <th>Record Date</th>
                    <th>Status ID</th>
                </tr>
            </thead>
            <tbody id="coupon-table-body">
                @foreach ($coupons as $coupon)
                    <tr>
                        <td><?php echo $coupon->coupon_id; ?></td>
                        <td><?php echo App\Coupons::getISINDescription($coupon->isin_code); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($coupon->payment_date)); ?></td>
                        <td><?php echo App\Coupons::getStatusName($coupon->status_id); ?></td>
                        <td>
                        @if($coupon->status_id===1)
                            <a  href="{{ route('create_coupon', ['id' => $coupon->coupon_id, 'create'=>false]) }}">
                            <button>Edit</button>
                            </a>
                        @endif
                        @if($coupon->status_id===1)
                        <a  href="{{ route('index', ['id' => $coupon->coupon_id, 'method'=>'delete']) }}">
                            <button>Delete</button>
                        </a>
                        @endif
                        @if($coupon->status_id===1)
                            <button onclick="approveCoupon('{{$coupon->coupon_id}}')">Approve</button>
                        @endif
                        @if($coupon->status_id===2)
                            <button onclick="cancelCoupon('{{$coupon->coupon_id}}')">Cancel</button>
                        @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <script>
            function filterTable() {
                var isinCode = document.getElementById("isin_code").value;
                var statusId = document.getElementById("status_id").value;
                var paymentDate = document.getElementById("payment_date").value;

                var rows = document.getElementById("coupon-table-body").rows;

                for (var i = 0; i < rows.length; i++) {
                    var isinCodeCell = rows[i].cells[1];
                    var statusIdCell = rows[i].cells[4];
                    var paymentDateCell = rows[i].cells[2];

                    if ((isinCode && isinCode !== isinCodeCell.innerHTML) ||
                        (statusId && statusId !== statusIdCell.innerHTML) ||
                        (paymentDate && paymentDate !== paymentDateCell.innerHTML)) {
                        rows[i].style.display = "none";
                    } else {
                        rows[i].style.display = "";
                    }
                }
            }

            function approveCoupon(coupon_id){
                if(confirm('Do you want to approve this coupon?')){
                    location.href = "/?method=approve&id=" + coupon_id
                }
            }


            function cancelCoupon(coupon_id){
                if(confirm('Do you want to cancel this coupon?')){
                    location.href = "/?method=cancel&id=" + coupon_id
                }
            }
        </script>
        <script>
            const { createApp } = Vue

            createApp({
                data() {
                return {
                    message: 'Hello Vue!'
                }
                }
            }).mount('#vue_here')
</script>
    </body>
</html>
