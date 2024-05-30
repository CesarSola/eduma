@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Barra de navegación para los pasos con iconos -->
            <div class="steps-bar mb-6">
                <ul class="progressBar">
                    <li class="step active" data-step="1" id="cuenta">
                        <div class="circle"><i class="fas fa-user"></i></div>
                        <span>Cuenta</span>
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

            <!-- Formularios en pasos -->
            <div class="form-step active" data-step="1">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
                <button class="next-step">Siguiente</button>
            </div>

            <div class="form-step" data-step="2">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
                <button class="prev-step">Anterior</button>
                <button class="next-step">Siguiente</button>
            </div>

            <div class="form-step" data-step="3">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                </div>
                <button class="prev-step">Anterior</button>
                <button class="next-step">Siguiente</button>
            </div>

            <div class="form-step" data-step="4">
                <!-- Este es un paso adicional que puedes llenar con el contenido que necesites -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <!-- Contenido del cuarto paso -->
                        <h3>Cuarto Paso</h3>
                        <p>Aquí puedes añadir más información o contenido que desees para el último paso.</p>
                    </div>
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
    <style>/* Estilos generales para la barra de progreso */
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
            top:30%;
            left: 5%;
            width: 90%;
            height: 4px;
            background-color: #e9ecef;
            transform: translateY(-50%);
            z-index: 1;
        }

        /* Estilos para los pasos individuales */
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

        .step.active .circle {
            background-color: #172ab8;
            color: white;
            transform: scale(1.1);
        }

        .step.completed .circle {
            background-color: rgb(164, 2, 164);
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

        /* Estilos para los formularios de cada paso */
        .form-step {
            display: none;
            transition: opacity 0.3s;
        }

        .form-step.active {
            display: block;
            opacity: 1;
        }

        /* Botones para navegar entre pasos */
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
