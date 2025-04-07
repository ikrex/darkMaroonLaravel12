@extends('layouts.app')

@section('title', 'Balázs Bettina')

@section('styles')
<style>
    /* Stanford-stílusú fix fejléc és háttér */
    .fixed-bg-header {
        position: relative;
        height: 75vh;
        background: url('/images/BalazsBettinaHomePage.jpg') center center no-repeat;
        background-size: cover;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
    }

    .fixed-bg-header::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: -1;
    }

    .header-content {
        text-align: center;
        color: white;
        z-index: 1;
    }

    .header-content h1 {
        font-size: 5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    /* Felcsúszó tartalom szekció */
    .content-wrapper {
        background-color: white;
        position: relative;
        z-index: 2;
        padding: 4rem 0;
    }

    .content-headline {
        font-size: 2.5rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 2rem;
        color: #800000;
    }

    .content-text {
        font-size: 1.2rem;
        line-height: 1.8;
        max-width: 800px;
        margin: 0 auto;
    }

    /* CTA gomb */
    .stanford-button {
        display: inline-block;
        background-color: #800000;
        color: white;
        padding: 12px 30px;
        font-size: 1.1rem;
        text-decoration: none;
        border-radius: 4px;
        margin-top: 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .stanford-button:hover {
        background-color: #600000;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        color: white;
    }

    .text-center {
        text-align: center;
    }
</style>
@endsection

@section('content')
    <!-- Fix háttérkép fejléc -->
    <section class="fixed-bg-header">
        <div class="header-content">
            <h1>Balázs Bettina</h1>
        </div>
    </section>

    <!-- Felcsúszó tartalom -->
    <section class="content-wrapper">
        <div class="container">
            @if(isset($content))
                <h2 class="content-headline">{{ $content->title }}</h2>
                <div class="content-text">
                    {!! $content->content !!}
                </div>
                <div class="text-center">
                    <a href="#contact" class="stanford-button">Kapcsolat</a>
                </div>
            @endif
        </div>
    </section>
@endsection
