@extends('layouts.app')

@section('title', 'Balázs Bettina')

@section('content')
    <!-- Hero szekció a könyvtárképpel és felúszó szöveggel -->
    <section class="hero-section">
        <div class="container hero-content">
        </div>
    </section>

    <!-- Rólunk szekció -->
    @if(isset($content))
        <section id="about" class="content-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <h2>{{ $content->title }}</h2>
                        <div>
                            {!! $content->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

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
