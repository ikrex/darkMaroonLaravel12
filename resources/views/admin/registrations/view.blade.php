@extends('layouts.admin')

@section('admin_content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Regisztráció megtekintése</h1>
        <a href="{{ route('admin.registrations.list') }}" class="btn btn-secondary">Vissza a listához</a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Alapadatok</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Név:</div>
                <div class="col-md-9">{{ $registration->name }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Születési adatok:</div>
                <div class="col-md-9">{{ $registration->birth_details }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Email:</div>
                <div class="col-md-9">{{ $registration->email }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Telefon:</div>
                <div class="col-md-9">{{ $registration->phone }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Fizetési mód:</div>
                <div class="col-md-9">
                    @if($registration->payment_method == 'bank_transfer')
                        Banki utalás
                    @elseif($registration->payment_method == 'revolut')
                        Revolut
                    @else
                        Egyéb
                    @endif
                </div>
            </div>
            @if($registration->love_language_test_file)
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">Szeretetnyelv-teszt:</div>
                    <div class="col-md-9">
                        <a href="{{ asset('storage/' . $registration->love_language_test_file) }}" target="_blank">Letöltés</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Kérdések</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12 fw-bold">1. Szerinted miért születtünk a Földre?</div>
                <div class="col-md-12">{{ $registration->question1 }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 fw-bold">2. Voltál-e már coachnál vagy pszichológusnál valaha?</div>
                <div class="col-md-12">{{ $registration->question2 == 'yes' ? 'Igen' : 'Nem' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 fw-bold">3. Mennyire tudsz könnyedén az érzéseidről beszélni?</div>
                <div class="col-md-12">{{ $registration->question3 }}/5</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 fw-bold">4. Mi a különbség a szerelem és kötődés között?</div>
                <div class="col-md-12">{{ $registration->question4 }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 fw-bold">5. Legsürgetőbb terület:</div>
                <div class="col-md-12">
                    @switch($registration->question5)
                        @case('low_confidence')
                            Alacsony önbizalom, önbecsülés
                            @break
                        @case('anxiety')
                            Szorongás, stressz
                            @break
                        @case('cant_stand_up')
                            Nem tudok kiállni magamért
                            @break
                        @case('no_focus')
                            Nincs fókuszom, halogatok
                            @break
                        @case('overthinking')
                            Gyakran agyalok, amiből nem tudok kiszállni
                            @break
                        @case('self_love')
                            Nem értem, mi az az önszeretet
                            @break
                        @default
                            {{ $registration->question5 }}
                    @endswitch
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 fw-bold">Mindennél jobban arra vágyom, hogy...</div>
                <div class="col-md-12">{{ $registration->desire }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Dátum információk</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Létrehozva:</div>
                <div class="col-md-9">{{ $registration->created_at->format('Y-m-d H:i:s') }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Frissítve:</div>
                <div class="col-md-9">{{ $registration->updated_at->format('Y-m-d H:i:s') }}</div>
            </div>
        </div>
    </div>
@endsection
