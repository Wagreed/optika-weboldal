<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Időpont kérés elutasítva</title>
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:'Segoe UI',Arial,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background:#f1f5f9;padding:40px 16px;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08);">

          <!-- Header -->
          <tr>
            <td style="background:linear-gradient(135deg,#1e3a8a 0%,#2563eb 100%);padding:36px 40px;text-align:center;">
              <p style="margin:0;color:#bfdbfe;font-size:13px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;">Optika</p>
              <h1 style="margin:12px 0 0;color:#ffffff;font-size:26px;font-weight:700;letter-spacing:-.02em;">Időpont kérés</h1>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="padding:40px;">
              <p style="margin:0 0 20px;color:#374151;font-size:15px;line-height:1.6;">
                Kedves <strong>{{ $recipientName }}</strong>,
              </p>
              <p style="margin:0 0 28px;color:#374151;font-size:15px;line-height:1.6;">
                Sajnálattal értesítjük, hogy az alábbi időpont kérését <strong style="color:#dc2626;">nem tudtuk elfogadni</strong>:
              </p>

              <!-- Appointment details box -->
              <table width="100%" cellpadding="0" cellspacing="0" style="background:#fef2f2;border:1px solid #fecaca;border-radius:12px;overflow:hidden;margin-bottom:28px;">
                <tr>
                  <td style="padding:24px;">
                    <table width="100%" cellpadding="0" cellspacing="8">
                      <tr>
                        <td style="color:#6b7280;font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;padding-bottom:8px;">Szolgáltatás</td>
                        <td style="color:#7f1d1d;font-size:15px;font-weight:700;text-align:right;padding-bottom:8px;">{{ $appointment->appointmentType?->name ?? 'Általános időpont' }}</td>
                      </tr>
                      <tr>
                        <td style="color:#6b7280;font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;">Kért dátum</td>
                        <td style="color:#7f1d1d;font-size:15px;font-weight:700;text-align:right;">{{ $appointment->appointment_date->format('Y. F j.') }}</td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>

              @if($reason)
              <table width="100%" cellpadding="0" cellspacing="0" style="background:#fffbeb;border:1px solid #fde68a;border-radius:12px;margin-bottom:28px;">
                <tr>
                  <td style="padding:20px 24px;">
                    <p style="margin:0 0 6px;color:#92400e;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;">Indoklás</p>
                    <p style="margin:0;color:#374151;font-size:14px;line-height:1.6;">{{ $reason }}</p>
                  </td>
                </tr>
              </table>
              @endif

              <p style="margin:0 0 16px;color:#374151;font-size:15px;line-height:1.6;">
                Kérjük, látogassa meg weboldalunkat egy másik időpont foglalásához, vagy hívja ügyfélszolgálatunkat.
              </p>
              <p style="margin:0;color:#374151;font-size:15px;line-height:1.6;">
                Megértését köszönjük,<br><strong>Optika csapata</strong>
              </p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="background:#f8fafc;padding:24px 40px;text-align:center;border-top:1px solid #e2e8f0;">
              <p style="margin:0;color:#94a3b8;font-size:12px;">Főutca 12. · +40 xxx xxx xxx · info@optika.ro</p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>
