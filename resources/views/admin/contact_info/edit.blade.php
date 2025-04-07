@extends('layouts.admin')

@section('admin_content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Lábléc kapcsolati adatok szerkesztése</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.contact_info.update') }}" method="POST">
                @csrf

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h4>Magyar adatok</h4>
                        <div class="mb-3">
                            <label for="address_hu" class="form-label">Cím (magyar)</label>
                            <input type="text" class="form-control @error('address_hu') is-invalid @enderror" id="address_hu" name="address_hu" value="{{ old('address_hu', $contactInfo->address_hu ?? '') }}">
                            @error('address_hu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h4>Angol adatok</h4>
                        <div class="mb-3">
                            <label for="address_en" class="form-label">Cím (angol)</label>
                            <input type="text" class="form-control @error('address_en') is-invalid @enderror" id="address_en" name="address_en" value="{{ old('address_en', $contactInfo->address_en ?? '') }}">
                            @error('address_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone" class="form-label">Telefonszám</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $contactInfo->phone ?? '') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email cím</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $contactInfo->email ?? '') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <h4 class="mb-3">Közösségi média linkek</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="facebook" class="form-label">Facebook</label>
                            <input type="url" class="form-control @error('facebook') is-invalid @enderror" id="facebook" name="facebook" value="{{ old('facebook', $contactInfo->facebook ?? '') }}">
                            @error('facebook')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="instagram" class="form-label">Instagram</label>
                            <input type="url" class="form-control @error('instagram') is-invalid @enderror" id="instagram" name="instagram" value="{{ old('instagram', $contactInfo->instagram ?? '') }}">
                            @error('instagram')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="linkedin" class="form-label">LinkedIn</label>
                            <input type="url" class="form-control @error('linkedin') is-invalid @enderror" id="linkedin" name="linkedin" value="{{ old('linkedin', $contactInfo->linkedin ?? '') }}">
                            @error('linkedin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-stanford">Mentés</button>
                </div>
            </form>
        </div>
    </div>
@endsection
