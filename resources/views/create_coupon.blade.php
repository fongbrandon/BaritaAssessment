<html>
    <head>
        <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    </head>
    <body>
        <div id="vue_here">
            <form action="/submit_coupon" method="POST">
                @csrf
                <label for="isin_code">Security</label>
                <select v-model="isin_code" id="isin_code" name="isin_code" required>
                    @foreach($Securities as $security)
                        <option value="{{ $security->isin_code }}" {{  isset($Coupon) && $Coupon->isin_code == $security->isin_code ? 'selected' : '' }}>{{ $security->description }}</option>
                    @endforeach
                </select>
                <label for="payment_date">Payment Date</label>
                <input v-model="payment_date" type="date" id="payment_date" name="payment_date" required>
                <input type="submit" value="Submit">
            </form>
        </div>

        <template>
            <script>

                const { createApp } = Vue;
                createApp({
                    data() {
                        return {
                            message: 'Hello Vue!',
                            isin_code:'',
                            payment_date:'',
                            couponId: '',
                            method: 'create'
                        }
                    },
                    mounted(){
                        @if(isset($Coupon))
                        // Testing coupon
                        this.couponId = {{$Coupon->coupon_id}};
                        this.isin_code = "{{$Coupon->isin_code}}";
                        const paymentDate = new Date("{{$Coupon->payment_date}}");
                        this.payment_date = paymentDate.toISOString().slice(0,10);
                        this.method = "edit";
                        console.log(this.couponId);
                        console.log(this.isin_code);
                        console.log(this.payment_date);
                        @endif
                    },
                    props:{
                        id_prop:{
                            type:Number,
                            default:undefined,
                        },
                    },
                    create(){
                        console.log(this.couponId);
                console.log(this.isin_code);
                console.log(this.payment_date);
                    }
                }).mount('#vue_here')
            </script>
        </template>
    </body>
</html>
