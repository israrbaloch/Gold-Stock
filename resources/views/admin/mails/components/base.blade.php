<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
    @yield('links')
</head>

<body>
    <div style="max-width: 1400px; margin: 0 auto;">
        <table style="width: 100%; border-collapse: collapse;">
            @include('admin.mails.components.banner')

            <tr>
                <td style="padding: 20px;">
                    @yield('content')
                </td>
            </tr>

            @include('admin.mails.components.footer')
        </table>
    </div>
</body>

</html>
