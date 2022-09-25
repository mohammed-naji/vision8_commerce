<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.0/css/bootstrap.min.css">
    <style>
        .invoice-head td {
            padding: 0 8px;
        }

        .container {
            padding-top: 30px;
        }

        .invoice-body {
            background-color: transparent;
        }

        .invoice-thank {
            margin-top: 60px;
            padding: 5px;
        }

        address {
            margin-top: 15px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="span4">
                {{-- {!! QrCode::format('png')->size(150)->generate('Mohammed Naji Buy Ferari Car From Us'); !!} --}}
                <img
                    src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(100)->generate('Mohammed Naji Buy Ferari Car From Us')) }}" />
                <address>
                    <strong>Webivorous Web services Pvt. Ltd.</strong><br>

                    35, Lajpat Nagar<br>
                    Gurugram, Haryana-122001 (India)
                </address>
            </div>
            <div class="span4 well">
                <table class="invoice-head">
                    <tbody>
                        <tr>
                            <td class="pull-right"><strong>Customer #</strong></td>
                            <td>{{ $order->user_id }}</td>
                        </tr>
                        <tr>
                            <td class="pull-right"><strong>Invoice #</strong></td>
                            <td>{{ $order->id }}</td>
                        </tr>
                        <tr>
                            <td class="pull-right"><strong>Date</strong></td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="span8">
                <h2>Invoice</h2>
            </div>
        </div>
        <div class="row">
            <div class="span8 well invoice-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->order_items as $item)
                        <tr>
                            <td>{{ $item->product->trans_name }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ $item->quantity * $item->price }}</td>
                        </tr>
                        @endforeach

                        <tr>
                            <td colspan="4"></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                            <td><strong>Total</strong></td>
                            <td><strong>${{ $order->total }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="span8 well invoice-thank">
                <h5 style="text-align:center;">Thank You!</h5>
            </div>
        </div>
        <div class="row">
            <div class="span3">
                <strong>Phone:</strong>+91-124-111111
            </div>
            <div class="span3">
                <strong>Email:</strong> <a href="web@webivorous.com">web@webivorous.com</a>
            </div>
            <div class="span3">
                <strong>Website:</strong> <a href="http://webivorous.com">http://webivorous.com</a>
            </div>
        </div>
    </div>
</body>

</html>
