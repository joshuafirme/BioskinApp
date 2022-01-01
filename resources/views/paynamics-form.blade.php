<form action="https://testpti.payserv.net/webpayment/Default.aspx" method="post" id="paynamics_payment_form">
    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Roboto);
        .Absolute-Center {
            font-family: "Roboto", Helvetica, Arial, sans-serif;
            width: auto;
            height: 100px;
            position: absolute;
            top:0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
            text-align: center;
            font-size: 14px;
        }
    </style>
    <div class="Absolute-Center">
        <h3>Please wait while you are being redirected to Paynamics payment page.</h3>
    </div>
    <input type="hidden" name="paymentrequest" id="paymentrequest" value="{{ $_GET['v'] }}" style="width:800px; padding: 20px;">
    <script type="text/javascript">
        document.forms["paynamics_payment_form"].submit();
    </script>
</form>