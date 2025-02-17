<!DOCTYPE html>
<html>
<head>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <table width="600" cellspacing="0" cellpadding="0" border="0" align="center" style="background-color: #ffffff; margin: 20px auto; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <tr>
            <td align="center" style="padding: 10px; background-color: #ffffff;">
                <img src="{{ asset('assets/imgs/logo.png') }}" alt="Shop Logo" style="max-width: 100px; height: 100px;">
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                <h1 style="margin-top: 20px;">Thank you for your purchase!</h1>
                <p>Order Number: {{ $orderNumber }}</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px;">
                <p><strong>Hi {{ $customerName }},</strong></p>
                <p>Thank you for shopping with us! Here’s a summary of your order.</p>
                <h3>Order Details</h3>
                <ul>
                    @foreach ($items as $item)
                        <li>{{ $item['name'] }} - {{ $item['qty'] }} x ${{ $item['baseprice'] }}</li>
                    @endforeach
                </ul>
                <p><strong>Subtotal:</strong> ${{ $subtotal }}</p>
                <p><strong>Shipping:</strong> ${{ $shipping }}</p>
                <p><strong>Total:</strong> ${{ $total }}</p>
                <p>If you have any questions, feel free to contact us at info@goat-trailams.com</p>
                <p>Best regards,<br>The GAMS Team</p>
            </td>
        </tr>
    </table>
</body>
</html>
