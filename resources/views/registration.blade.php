@extends('layouts.app')

@section('title', __('messages.registration_form'))

@section('content')
<div class="container py-5">

{{-- Debug információ --}}
{{-- <div class="alert alert-info mb-4">
    <p>Current Locale: {{ App::getLocale() }}</p>
    <p>Session Locale: {{ Session::get('locale', 'session-locale-not-set') }}</p>
    <p>Translation test: {{ __('messages.registration_form') }}</p>
</div> --}}


    <h1 class="mb-4">{{ __('messages.registration_form') }}</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('registration.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card mb-4">
            <div class="card-header">
                <h5>{{ __('messages.basic_data') }}</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('messages.name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="birth_details" class="form-label">{{ __('messages.birth_details') }}</label>
                    <input type="text" class="form-control" id="birth_details" name="birth_details" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('messages.email') }}</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">{{ __('messages.phone') }}</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="mb-3">
                    <label for="payment_method" class="form-label">{{ __('messages.payment_method') }}</label>
                    <select class="form-select" id="payment_method" name="payment_method" required>
                        <option value="">-- {{ __('messages.choose_payment_methood') }} --</option>
                        <option value="bank_transfer">{{ __('messages.bank_transfer') }}</option>
                        <option value="revolut">{{ __('messages.revolut') }}</option>
                        <option value="other">{{ __('messages.other') }}</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="love_language_test" class="form-label">{{ __('messages.love_language_test') }}</label>
                    <input type="file" class="form-control" id="love_language_test" name="love_language_test">
                    <div class="form-text">
                        <a href="#" target="_blank">{{ __('messages.love_language_link') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5>{{ __('messages.questions') }}</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="form-label">1. {{ __('messages.question1') }} <small class="text-muted">{{ __('messages.question1_hint') }}</small></label>
                    <textarea class="form-control" name="question1" rows="2" required></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">2. {{ __('messages.question2') }}</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question2" id="question2_yes" value="yes" required>
                        <label class="form-check-label" for="question2_yes">{{ __('messages.yes') }}</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question2" id="question2_no" value="no">
                        <label class="form-check-label" for="question2_no">{{ __('messages.no') }}</label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">3. {{ __('messages.question3') }}</label>
                    <div class="form-text mb-2">{{ __('messages.scale_hint') }}</div>
                    <div class="d-flex">
                        @for($i = 1; $i <= 5; $i++)
                            <div class="form-check me-4">
                                <input class="form-check-input" type="radio" name="question3" id="question3_{{ $i }}" value="{{ $i }}" required>
                                <label class="form-check-label" for="question3_{{ $i }}">{{ $i }}</label>
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">4. {{ __('messages.question4') }} <small class="text-muted">{{ __('messages.question4_hint') }}</small></label>
                    <textarea class="form-control" name="question4" rows="3" required></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">5. {{ __('messages.question5') }} <small class="text-muted">{{ __('messages.question5_hint') }}</small></label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question5" id="question5_1" value="low_confidence" required>
                        <label class="form-check-label" for="question5_1">{{ __('messages.low_confidence') }}</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question5" id="question5_2" value="anxiety">
                        <label class="form-check-label" for="question5_2">{{ __('messages.anxiety') }}</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question5" id="question5_3" value="cant_stand_up">
                        <label class="form-check-label" for="question5_3">{{ __('messages.cant_stand_up') }}</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question5" id="question5_4" value="no_focus">
                        <label class="form-check-label" for="question5_4">{{ __('messages.no_focus') }}</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question5" id="question5_5" value="overthinking">
                        <label class="form-check-label" for="question5_5">{{ __('messages.overthinking') }}</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="question5" id="question5_6" value="self_love">
                        <label class="form-check-label" for="question5_6">{{ __('messages.self_love') }}</label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label"><strong>{{ __('messages.complete_sentence') }}</strong></label>
                    <div class="input-group">
                        <span class="input-group-text">{{ __('messages.desire') }}</span>
                        <input type="text" class="form-control" name="desire" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-stanford btn-lg">{{ __('messages.submit') }}</button>
        </div>
    </form>
</div>
@endsection
