@extends('layouts.app')

@section('title', 'Kezdőlap - Maroon Website')

@section('content')
    <!-- Hero szekció a könyvtárképpel és felúszó szöveggel -->
    <section class="hero-section">
        <div class="container hero-content">
            @if(isset($contentBlocks['hero']))
                <h1>{{ $contentBlocks['hero']->title }}</h1>
                <div class="hero-text">
                    {!! $contentBlocks['hero']->content !!}
                </div>
                <a href="#about" class="btn btn-stanford btn-lg">Tudj meg többet</a>
            @else
                <h1>Üdvözöljük a weboldalunkon</h1>
                <p>Ez egy elegáns, Stanford stílusú weboldal gazdag maroon színvilággal.</p>
                <a href="#about" class="btn btn-stanford btn-lg">Tudj meg többet</a>
            @endif
        </div>
    </section>

    <!-- Rólunk szekció -->
    {{-- @if(isset($contentBlocks['about']))
        <section id="about" class="content-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <h2>{{ $contentBlocks['about']->title }}</h2>
                        <div>
                            {!! $contentBlocks['about']->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif --}}

    <!-- Szolgáltatások szekció -->
    {{-- @if(isset($contentBlocks['services']))
        <section id="services" class="content-section bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <h2>{{ $contentBlocks['services']->title }}</h2>
                        <div>
                            {!! $contentBlocks['services']->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif --}}

    <!-- Kapcsolat szekció -->
    {{-- @if(isset($contentBlocks['contact']))
        <section id="contact" class="content-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <h2>{{ $contentBlocks['contact']->title }}</h2>
                        <div>
                            {!! $contentBlocks['contact']->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif --}}
@endsection
