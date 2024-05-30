@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Progress bar for steps with icons -->
            <div class="steps-bar mb-6">
                <ul class="progressBar">
                    <li class="step active" data-step="1" id="cuenta">
                        <div class="circle"><i class="fas fa-user"></i></div>
                        <span>Usuario</span>
                    </li>
                    <li class="step" data-step="2" id="personal">
                        <div class="circle"><i class="fas fa-info-circle"></i></div>
                        <span>Personal</span>
                    </li>
                    <li class="step" data-step="3" id="social">
                        <div class="circle"><i class="fas fa-share-alt"></i></div>
                        <span>Social</span>
                    </li>
                    <li class="step" data-step="4" id="confirm">
                        <div class="circle"><i class="fas fa-check"></i></div>
                        <span>Finalizar</span>
                    </li>
                </ul>
            </div>

            <!-- Step forms -->
            <div class="form-step active" data-step="1">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                            @csrf
                        </form>

                        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div>
                                        <p class="text-sm mt-2 text-gray-800">
                                            {{ __('Your email address is unverified.') }}
                                            <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                {{ __('Click here to re-send the verification email.') }}
                                            </button>
                                        </p>

                                        @if (session('status') === 'verification-link-sent')
                                            <p class="mt-2 font-medium text-sm text-green-600">
                                                {{ __('A new verification link has been sent to your email address.') }}
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Additional Fields -->
                            <div>
                                <x-input-label for="calle_avenida" :value="__('Calle/Avenida')" />
                                <x-text-input id="calle_avenida" name="calle_avenida" type="text" class="mt-1 block w-full" :value="old('calle_avenida', $user->calle_avenida)" />
                                <x-input-error class="mt-2" :messages="$errors->get('calle_avenida')" />
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="numext" :value="__('No.Ext')" />
                                    <x-text-input id="numext" name="numext" type="text" class="mt-1 block w-full" :value="old('numext', $user->numext)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('numext')" />
                                </div>

                                <div>
                                    <x-input-label for="codpos" :value="__('Código')" />
                                    <x-text-input id="codpos" name="codpos" type="text" class="mt-1 block w-full" maxlength="10" :value="old('codpos', $user->codpos)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('codpos')" />
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="colonia" :value="__('Colonia')" />
                                    @if(!empty($data['response']['colonia']))
                                        <select>
                                            @foreach($data['response']['colonia'] as $colonia)
                                                <option>{{ $colonia }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <p>No se encontraron colonias para este código postal.</p>
                                    @endif
                                    <x-input-error class="mt-2" :messages="$errors->get('colonia')" />
                                </div>
                                <div>
                                    <x-input-label for="estado" :value="__('Estado')" />
                                    <x-text-input id="estado" name="estado" type="text" class="mt-1 block w-full" :value="old('estado', $user->estado)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('estado')" />
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="ciudad" :value="__('Ciudad')" />
                                    <x-text-input id="ciudad" name="ciudad" type="text" class="mt-1 block w-full" :value="old('ciudad', $user->ciudad)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('ciudad')" />
                                </div>

                                <div>
                                    <x-input-label for="municipio" :value="__('Delegación/Municipio')" />
                                    <x-text-input id="municipio" name="municipio" type="text" class="mt-1 block w-full" :value="old('municipio', $user->municipio)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('municipio')" />
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Actualizar') }}</x-primary-button>
                                <button type="button" class="btn btn-primary flex items-center gap-4" data-toggle="modal" data-target="#exampleModal">
                                    Cambiar Contraseña
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="flex items-center gap-4">
                    <button class="next-step">Siguiente</button>
                </div>
            </div>

            <div class="form-step" data-step="2">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg"></div>
                <button class="prev-step">Anterior</button>
                <button class="next-step">Siguiente</button>
            </div>

            <div class="form-step" data-step="3">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg"></div>
                <button class="prev-step">Anterior</button>
                <button class="next-step">Siguiente</button>
            </div>

            <div class="form-step" data-step="4">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <h3>Cuarto Paso</h3>
                        <p>Aquí puedes añadir más información o contenido que desees para el último paso.</p>
                    </div>
                    <x-primary-button>{{ __('Actualizar') }}</x-primary-button>
                </div>
                <button class="prev-step">Anterior</button>
                <button type="submit" class="submit-form">Enviar</button>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* General styles for progress bar */
        .progressBar {
            display: flex;
            justify-content: space-between;
            position: relative;
            counter-reset: step;
            margin-bottom: 30px;
            padding-left: 0;
            list-style-type: none;
        }

        .progressBar::before {
            content: '';
            position: absolute;
            top: 30%;
            left: 5%;
            width: 90%;
            height: 4px;
            background-color: #e9ecef;
            transform: translateY(-50%);
            z-index: 1;
        }

        /* Styles for individual steps */
        .step {
            position: relative;
            text-align: center;
            cursor: pointer;
            z-index: 2;
        }

        .step .circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 5px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .step.active .circle, .step.completed .circle {
            background-color: #172ab8;
            color: white;
            transform: scale(1.1);
        }

        .step span {
            display: block;
            margin-top: 5px;
            font-weight: bold;
            color: #6c757d;
        }

        .step.active span, .step.completed span {
            color: #343a40;
        }

        /* Styles for step forms */
        .form-step {
            display: none;
            transition: opacity 0.3s;
        }

        .form-step.active {
            display: block;
            opacity: 1;
        }

        /* Navigation buttons */
        .prev-step, .next-step {
            margin: 10px 5px;
            background-color: #17a2b8;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .prev-step:hover, .next-step:hover {
            background-color: #138496;
        }
    </style>
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const steps = document.querySelectorAll('.step');
            const formSteps = document.querySelectorAll('.form-step');
            let currentStep = 0;

            function showStep(step) {
                formSteps.forEach((formStep, index) => {
                    formStep.classList.remove('active');
                    steps[index].classList.remove('active', 'completed');
                });
                formSteps[step].classList.add('active');
                steps[step].classList.add('active');
                for (let i = 0; i < step; i++) {
                    steps[i].classList.add('completed');
                }
            }

            document.querySelectorAll('.next-step').forEach(button => {
                button.addEventListener('click', () => {
                    if (currentStep < formSteps.length - 1) {
                        currentStep++;
                        showStep(currentStep);
                    }
                });
            });

            document.querySelectorAll('.prev-step').forEach(button => {
                button.addEventListener('click', () => {
                    if (currentStep > 0) {
                        currentStep--;
                        showStep(currentStep);
                    }
                });
            });

            showStep(currentStep);
        });
    </script>
@stop
