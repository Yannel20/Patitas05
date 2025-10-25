@extends('layouts.navigation')

@section('title', 'Editar Perfil')

@section('content')
<div class="bg-gradient-to-br from-pink-100 via-pink-200 to-pink-300 min-h-screen py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-10">

        {{-- Información del Perfil --}}
        <div class="bg-white shadow-xl sm:rounded-xl p-8 border border-pink-200">
            @include('profile.partials.update-profile-information-form')
        </div>

        {{-- Actualizar Contraseña --}}
        <div class="bg-white shadow-xl sm:rounded-xl p-8 border border-pink-200">
            @include('profile.partials.update-password-form')
        </div>

        {{-- Eliminar Cuenta --}}
        <div class="bg-white shadow-xl sm:rounded-xl p-8 border border-pink-200">
            @include('profile.partials.delete-user-form')
        </div>

    </div>
</div>
@endsection
