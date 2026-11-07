@extends('layouts.app')

@section('title', 'Pondok Pesantren Nurur Rahmah — Membentuk Generasi Qur\'ani')
@section('description', 'Pondok Pesantren Nurur Rahmah memadukan tahfidz Al-Qur\'an, kajian kitab kuning, dan pendidikan formal dalam lingkungan yang hangat dan penuh keberkahan.')

@section('content')
    @include('landing.sections.hero', ['hero' => $hero, 'stats' => $stats])

    @include('landing.sections.about', [
        'history' => $history,
        'vision' => $vision,
        'missions' => $missions,
        'leader' => $leader,
    ])

    @include('landing.sections.programs', ['programs' => $programs])

    @include('landing.sections.gallery', ['gallery' => $gallery])

    @include('landing.sections.news', ['news' => $news])

    @include('landing.sections.contact', ['contact' => $contact])
@endsection
