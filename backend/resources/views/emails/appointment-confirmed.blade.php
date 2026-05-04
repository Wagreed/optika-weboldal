<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Időpont megerősítve</title>
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
              <h1 style="margin:12px 0 0;color:#ffffff;font-size:26px;font-weight:700;letter-spacing:-.02em;">Időpontja megerősítve</h1>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="padding:40px;">
              <p style="margin:0 0 20px;color:#374151;font-size:15px;line-height:1.6;">
                Kedves <strong>{{ $recipientName }}</strong>,
              </p>
              <p style="margin:0 0 28px;color:#374151;font-size:15px;line-height:1.6;">
                Örömmel értesítjük, hogy időpont kérése <strong style="color:#16a34a;">megerősítést nyert</strong>. Az alábbiakban találja a foglalás részleteit:
              </p>

              <!-- Appointment details box -->
              <table width="100%" cellpadding="0" cellspacing="0" style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:12px;overflow:hidden;margin-bottom:28px;">
                <tr>
                  <td style="padding:24px;">
                    <table width="100%" cellpadding="0" cellspacing="8">
                      <tr>
                        <td style="color:#6b7280;font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;padding-bottom:8px;">Szolgáltatás</td>
                        <td style="color:#1e3a8a;font-size:15px;font-weight:700;text-align:right;padding-bottom:8px;">{{ $appointment->appointmentType?->name ?? 'Általános időpont' }}</td>
                      </tr>
                      <tr>
                        <td style="color:#6b7280;font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;padding-bottom:8px;">Dátum</td>
                        <td style="color:#1e3a8a;font-size:15px;font-weight:700;text-align:right;padding-bottom:8px;">{{ $appointment->appointment_date->format('Y. F j.') }}</td>
                      </tr>
                      <tr>
                        <td style="color:#6b7280;font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;">Időpont</td>
                        <td style="color:#1e3a8a;font-size:15px;font-weight:700;text-align:right;">{{ $appointment->start_time ? \Illuminate\Support\Str::substr($appointment->start_time, 0, 5) : 'Pontosítás folyamatban' }}</td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>

              <p style="margin:0 0 16px;color:#374151;font-size:15px;line-height:1.6;">
                Kérjük, érkezzen <strong>5 perccel korábban</strong>. Ha bármilyen változás merülne fel, kérjük, vegye fel velünk a kapcsolatot időben.
              </p>
              <p style="margin:0;color:#374151;font-size:15px;line-height:1.6;">
                Üdvözlettel,<br><strong>Optika csapata</strong>
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
