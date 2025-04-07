<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Új regisztráció érkezett</title>
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
        .info-block {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f9f9f9;
            border-left: 3px solid #800000;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Új regisztráció érkezett</h1>
    </div>

    <div class="content">
        <p>Üdvözöljük,</p>

        <p>Új regisztráció érkezett az oldalon. Az alábbi adatokat küldte be a felhasználó:</p>

        <div class="info-block">
            <p><strong>Név:</strong> {{ $registration->name }}</p>
            <p><strong>Email:</strong> {{ $registration->email }}</p>
            <p><strong>Telefon:</strong> {{ $registration->phone }}</p>
            <p><strong>Születési adatok:</strong> {{ $registration->birth_details }}</p>
            <p><strong>Fizetési mód:</strong>
                @if($registration->payment_method == 'bank_transfer')
                    Banki utalás
                @elseif($registration->payment_method == 'revolut')
                    Revolut
                @else
                    Egyéb
                @endif
            </p>
        </div>

        <h3>Válaszok a kérdésekre:</h3>

        <div class="info-block">
            <p><strong>1. Miért születtünk a Földre?</strong><br>{{ $registration->question1 }}</p>
            <p><strong>2. Volt már coachnál vagy pszichológusnál?</strong><br>{{ $registration->question2 == 'yes' ? 'Igen' : 'Nem' }}</p>
            <p><strong>3. Mennyire tud az érzéseiről beszélni?</strong><br>{{ $registration->question3 }}/5</p>
            <p><strong>4. Különbség szerelem és kötődés között:</strong><br>{{ $registration->question4 }}</p>
            <p><strong>5. Legsürgetőbb terület:</strong><br>
                @switch($registration->question5)
                    @case('low_confidence')
                        Alacsony önbizalom, önbecsülés
                        @break
                    @case('anxiety')
                        Szorongás, stressz
                        @break
                    @case('cant_stand_up')
                        Nem tud kiállni magáért
                        @break
                    @case('no_focus')
                        Nincs fókusza, halogat
                        @break
                    @case('overthinking')
                        Gyakran agyalás, amiből nem tud kiszállni
                        @break
                    @case('self_love')
                        Nem érti, mi az az önszeretet
                        @break
                    @default
                        {{ $registration->question5 }}
                @endswitch
            </p>
            <p><strong>Vágyakozás:</strong><br>{{ $registration->desire }}</p>
        </div>

        @if($registration->love_language_test_file)
            <p><strong>Szeretetnyelv-teszt:</strong> <a href="{{ asset('storage/' . $registration->love_language_test_file) }}">Letöltés</a></p>
        @endif

        <p>Regisztráció időpontja: {{ $registration->created_at->format('Y-m-d H:i:s') }}</p>
    </div>
</body>
</html>
