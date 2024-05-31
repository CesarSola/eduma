@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Step forms -->
            <div class="form-step active" data-step="1">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                            @csrf
                         </form>



                            <div class="flex items-center gap-4">

                                <button type="button" class="btn btn-primary flex items-center gap-4" data-toggle="modal" data-target="#edit">
                                    Cambiar Contraseña
                                </button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="edit" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">


                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <!-- Vista para editar un curso -->
                                            <div class="max-w-xl">
                                                @include('profile.partials.update-password-form')
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </form>
                    </div>

                </div>

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
@stop

@section('js')
@stop
