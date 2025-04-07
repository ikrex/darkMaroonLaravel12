@php
    $locale = Session::get('locale', 'hu');
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $locale === 'en' ? 'Registration Confirmation' : 'Regisztráció visszaigazolása' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            background-color: #800000;
            color: white;
            padding: 15px;
            text-align: center;
        }
        .content {
            padding: 20px;
            border: 1px solid #ddd;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 0.8em;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $locale === 'en' ? 'Registration Confirmation' : 'Regisztráció visszaigazolása' }}</h1>
    </div>

    <div class="content">
        <p>{{ $locale === 'en' ? 'Dear' : 'Kedves' }} {{ $registration->name }},</p>

        @if($locale === 'en')
            <p>Thank you for your registration! We have received your submission and will contact you shortly.</p>

            <p>Here is a summary of your registration data:</p>
        @else
            <p>Köszönjük a regisztrációdat! Megkaptuk a jelentkezésedet és hamarosan kapcsolatba lépünk veled.</p>

            <p>Íme a regisztrációd adatainak összefoglalója:</p>
        @endif

        <ul>
            <li><strong>{{ $locale === 'en' ? 'Name' : 'Név' }}:</strong> {{ $registration->name }}</li>
            <li><strong>{{ $locale === 'en' ? 'Email' : 'Email' }}:</strong> {{ $registration->email }}</li>
            <li><strong>{{ $locale === 'en' ? 'Phone' : 'Telefon' }}:</strong> {{ $registration->phone }}</li>
        </ul>

        @if($locale === 'en')
            <p>If you have any questions, feel free to contact us.</p>

            <p>Best regards,<br>Balázs Bettina</p>
        @else
            <p>Ha bármilyen kérdésed van, nyugodtan keress minket.</p>

            <p>Üdvözlettel,<br>Balázs Bettina</p>
        @endif
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Balázs Bettina. {{ $locale === 'en' ? 'All rights reserved.' : 'Minden jog fenntartva.' }}</p>
    </div>
</body>
</html>
