<!DOCTYPE html>
<html>
<head></head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <table width="600" cellspacing="0" cellpadding="0" border="0" align="center" style="background-color: #ffffff; margin: 20px auto; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <tr>
            <td align="center" style="padding: 10px; background-color: #ffffff;">
                <img src="{{ asset('assets/imgs/logo.png') }}" alt="Shop Logo" style="max-width: 100px; height: 100px;">
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 10px; background-color: #ffffff;">
                <h2>New Order Received</h2>
                <p>Order Number: {{ $orderNumber }}</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px;">
                <h3>Customer Details</h3>
                <p><strong>Name:</strong> {{ $customerName }}</p>
                <p><strong>Email:</strong> {{ $customerEmail }}</p>
                <p><strong>Phone:</strong> {{ $customerPhone }}</p>
                <h3>Order Summary</h3>
                <ul>
                    @foreach ($items as $item)
                        <li>{{ $item['name'] }} - {{ $item['qty'] }} x ${{ $item['baseprice'] }}</li>
                    @endforeach
                </ul>
                <p><strong>Subtotal:</strong> ${{ $subtotal }}</p>
                <p><strong>Shipping:</strong> ${{ $shipping }}</p>
                <p><strong>Total:</strong> ${{ $total }}</p>
                <p><strong>Payment Status:</strong> {{ $paymentStatus }}</p>
                <p><strong>Order Date:</strong> {{ $orderDate }}</p>
                <p>Please log in to the admin dashboard to view and manage this order.</p>
            </td>
        </tr>
    </table>
</body>
</html>
