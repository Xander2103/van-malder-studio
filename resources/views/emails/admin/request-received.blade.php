<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuwe aanvraag — Van Malder Studio</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; color: #0f172a; line-height: 1.6; margin: 0; padding: 0; background: #f8fafc;">
    <div style="max-width: 640px; margin: 24px auto; background: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; overflow: hidden;">

        <div style="background: #0f172a; padding: 24px 32px;">
            <h1 style="color: #ffffff; font-size: 18px; font-weight: 600; margin: 0;">Van Malder Studio</h1>
            <p style="color: #94a3b8; font-size: 13px; margin: 4px 0 0;">Nieuwe aanvraag ontvangen</p>
        </div>

        <div style="padding: 32px;">
            <table style="width: 100%; border-collapse: collapse;">
                @foreach ($rows as $row)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 8px 0; width: 180px; vertical-align: top; color: #64748b; font-size: 13px; font-weight: 500; padding-right: 12px;">{{ $row['label'] }}</td>
                    <td style="padding: 8px 0; vertical-align: top; color: #0f172a; font-size: 14px; word-break: break-word;">
                        @if (!empty($row['pre_wrap']))
                            <span style="white-space: pre-wrap;">{{ $row['value'] }}</span>
                        @else
                            {{ $row['value'] }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
        </div>

        <div style="background: #f8fafc; padding: 16px 32px; border-top: 1px solid #e2e8f0;">
            <p style="color: #94a3b8; font-size: 12px; margin: 0;">
                Van Malder Studio — automatisch gegenereerde notificatie. Antwoord op deze e-mail gaat rechtstreeks naar de aanvrager.
            </p>
        </div>

    </div>
</body>
</html>
