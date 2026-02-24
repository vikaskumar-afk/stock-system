<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                       style="background:#ffffff; border-radius:8px; padding:30px; box-shadow:0 2px 8px rgba(0,0,0,0.05);">

                    <!-- Header -->
                    <tr>
                        <td style="text-align:left;">
                            <h2 style="margin:0; color:#2d3748;">
                                Welcome {{ $name }} 🎉
                            </h2>
                        </td>
                    </tr>

                    <!-- Message -->
                    <tr>
                        <td style="padding-top:15px; color:#4a5568; font-size:15px;">
                            Your account has been created successfully. Below are your login credentials:
                        </td>
                    </tr>

                    <!-- Credentials Box -->
                    <tr>
                        <td style="padding-top:20px;">
                            <table width="100%" cellpadding="10" cellspacing="0"
                                   style="background:#f7fafc; border:1px solid #e2e8f0; border-radius:6px;">
                                <tr>
                                    <td style="font-size:14px; color:#2d3748;">
                                        <strong>Email:</strong> {{ $email }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:14px; color:#2d3748;">
                                        <strong>Password:</strong> {{ $password }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>


                    <!-- Button -->
                    <tr>
                        <td align="left" style="padding-top:25px;">
                            <a href="{{ url('login') }}"
                               style="background:#2563eb; color:#ffffff; text-decoration:none;
                                      padding:12px 20px; border-radius:5px;
                                      font-size:14px; display:inline-block;">
                                Login Now
                            </a>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding-top:30px; font-size:12px; color:#a0aec0;">
                            If you did not create this account, please contact support.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>