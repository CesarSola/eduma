<?php

namespace Database\Seeders;

use App\Models\Estandar; // Ensure you have the Estandar model
use App\Models\Estandares;
use Illuminate\Database\Seeder;

class EstandaresSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Estandares::create([
            'numero' => 'EC0 076',
            'name' => 'Evaluación de la competencia de candidatos con base en Estándares de Competencia',
            'Dnecesarios' =>
            '1. Ficha de registro del candidato
            2. Exámen diagnóstico
            3. Plan de Evaluación
            4. Instrumentos de evaluación: cuestionario, lista de cotejo y guías de obervación
            5. Juicio de competencia
            6. Anexos documentales
            7. Cédula de evaluación
            8. Encuesta de satisfacción del candidato',
            'tipo' => 'Tipo 1',
        ]);

        Estandares::create([
            'numero' => 'EC0 301',
            'name' => 'Diseño de cursos de formación del capital humano de manera presencial grupal, sus instrumentos de evaluación y manuales del curso',
            'Dnecesarios' =>
            '1. Carta descrpitiva
            2. Manual del instructor
            3. Manual del participante
            4. Lista de verificación con requerimientos
            5. Evaluación diagnóstica
            6. Evaluación formativa de cotejo
            7. Evaluación sumativa
            7.1 Hoja de respuestas
            8. Evaluación de satisfacción',
            'tipo' => 'Tipo 3',
        ]);
        Estandares::create([
            'numero' => 'EC0 217.01',
            'name' => 'Impartición de cursos de formación del capital humano de manera presencial grupal',
            'Dnecesarios' =>
            '1. Planeación del curso
            2. Contrato de aprendizaje
            3. Manual del participante
            4. Lista de verificación
            5. Evaluación formativa
            6. Hoja de respuestas
            7. Lista de asistencia',
            'tipo' => 'Tipo 4',
        ]);
        Estandares::create([
            'numero' => 'EC0 336',
            'name' => 'Desarrollo de cursos de formación en línea',
            'Dnecesarios' =>
            '1. Cronograma para el desarrollo del curso en línea
            2. Documento de información general del curso
            3. Calendario general de actividades
            4. Documento de texto elaborado (Revisión)
            5. Guía de actividades de aprendizaje de cada unidad del curso
            6. Instrumento de evaluación del aprendizaje elaborado
            7. Material multimedia elaborado
            8. Presentación electrónica elaborada
            9. Reporte para la revisión del funcionamiento del curso de fromación en línea',
            'tipo' => 'Tipo 5',
        ]);
        Estandares::create([
            'numero' => 'EC 401',
            'name' => 'Liderazgo en el Servicio Público',
            'Dnecesarios' =>
            '1. Metas de desempeño individual
            2. Evaluación multiperceptual
            3. Cuestionario',
            'tipo' => 'Tipo 6',
        ]);
        Estandares::create([
            'numero' => 'EC405',
            'name' => 'Atención al Ciudadano en el Sector Público',
            'Dnecesarios' =>
            '1. Guión
            2. Documentos dependiendo del trámite
            3. Cuestionario',
            'tipo' => 'Tipo 6',
        ]);
    }
}
