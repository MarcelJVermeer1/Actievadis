<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Bevestig je e-mailadres</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f9fafb; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="margin: 0; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.05); padding: 40px;">
                    <tr>
                        <td align="center" style="padding-bottom: 20px;">
                            <h1 style="margin: 0; color: #1a202c;">{{ config('app.name') }}</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="color: #2d3748; font-size: 16px; line-height: 1.6;">
                            <p>Hallo {{ $user->name }},</p>
                            <p>Bedankt voor je registratie! Bevestig je e-mailadres om je aanmelding te voltooien.</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 60px 0 30px 0;">
                            <a href="{{ $url }}"
                                style="background-color: #fd9a00; color: #ffffff; text-decoration: none;
                                      padding: 12px 24px; border-radius: 6px; font-weight: bold; display: inline-block;">
                                Bevestig e-mailadres
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="color: #4a5568; font-size: 14px; line-height: 1.5; text-align: center;">
                            <p>Als de knop hierboven niet werkt, kopieer en plak dan deze link in je browser:</p>
                            <p style="word-break: break-all;">
                                <a href="{{ $url }}" style="color: #fd9a00;">
                                    {{ $url }}
                                </a>
                            </p>
                            <p>Als je geen account hebt aangemaakt, is geen verdere actie nodig.</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding-top: 20px; color: #a0aec0; font-size: 12px;">
                            &copy; {{ date('Y') }} {{ config('app.name') }}. Alle rechten voorbehouden.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>