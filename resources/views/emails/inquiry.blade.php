<!DOCTYPE html>
<html>
<head></head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <table width="600" cellspacing="0" cellpadding="0" border="0" align="center" style="background-color: #ffffff; margin: 20px auto; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <tr>
            <td align="center" style="padding: 10px; background-color: #ffffff;">
                <img src="{{ asset('assets/imgs/logo.png') }}" alt="Logo" style="max-width: 100px; height: 100px;">
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                <h1 style="margin-top: 20px;">Thank you for contacting us!</h1>
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding: 20px;">
                <p>We have received your message and will get back to you as soon as possible.</p>
                <p>Here are the details you provided:</p>
                <ul>
                    <li><strong>Name:</strong> {{ $name }}</li>
                    <li><strong>Email:</strong> {{ $email }}</li>
                    <li><strong>Phone Number:</strong> {{ $phone }}</li>
                    <li><strong>Notes:</strong> {{ $notes }}</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td align="center" style="font-size: 0.9em; text-align: center; margin-top: 20px;">
                Best regards,<br>GAMS Team
            </td>
        </tr>
    </table>
</body>
</html>
