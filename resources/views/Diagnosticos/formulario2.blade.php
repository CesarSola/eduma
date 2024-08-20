<!DOCTYPE html>
<html>
<head>
    <title>Formulario Diagnóstico</title>
    <style>

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    background-color: #f4f4f4;
    text-align: justify;
}
header {
    text-align: center;
    background-color: #00e6c7;
    color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
    font-size: 2.5em;
    margin: 0;
}

h2 {
    font-size: 1.5em;
    margin: 0;
}

p {
    font-size: 1.2em;
    margin: 10px 0 0;
}

.table {
    width: 80%;
    border-collapse: collapse;
    margin: 20px 0;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
}

.table thead {
    background-color: #0073e6;
    color: white;
    text-align: left;
}

.table th, .table td {
    padding: 12px 15px;
    border: 1px solid #ddd;
}

.table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

.table tbody tr:hover {
    background-color: #e0e0e0;
}
form div {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="text"],
input[type="email"],
textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

button {
    background-color: #0073e6;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #03b500;
}

    #mensaje-evaluacion {
        display: none;
        margin-top: 20px;
        padding: 10px;
        border: 1px solid #000;
        text-align: center;
    }

    .evaluarse {
        background-color: #08ff4ee8;
        color: #000000;
        border-color: #c3e6cb;
    }

    .asesorarse {
        background-color: #fb2c2c;
        color: #000000;
        border-color: #f5c6cb;
    }

    .table-bordered td {



    }
    body {
        text-align: justify; /* Centra el texto horizontalmente */
    }

    .table-bordered {
        margin: 0 auto; /* Centra la tabla en el contenedor */
    }

    .table-bordered td {

        font-size: 16px; /* Ajusta el tamaño de la letra según tus necesidades */
    }
    p {
        text-align: center; /* Centra el texto horizontalmente */

        }
</style>


</style>
    </style>
</head>
<body>
    <header>
        <h1>AUTODIAGNÓSTICO</h1>
        <h2>EC0076</h2>
        <p>Evaluación de la competencia de
            candidatos con base en
            Estándares de Competencia.</p>
    </header>
    <div>


    <form id="formulario-diagnostico" action="{{ route('formulario2.index') }}" method="POST">
        @csrf
        <br>
        <div style="display: flex; justify-content: center;">
            <p style="padding: 0px; font-size: 25px; background-color: black; color:white; width: 800px; text-align: center;">
                <strong>ELEMENTO 1 DE 4</strong>
            </p>
        </div>

        <p>Con relación a este elemento ¿Puede usted realizar los siguientes  <strong>DESEMPEÑOS</strong> ?</p>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Presenta el Plan de Evaluación al candidato:</th>
                    <th>SI</th>
                    <th>NO</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1. Mencionando su nombre completo, función y la actividad a realizar</td>
                    <td><input type="radio" name="q1" value="si" required></td>
                    <td><input type="radio" name="q1" value="no" required></td>
                </tr>
                <tr>
                    <td>2. Verificando que la información contenida en la Ficha de Registro corresponda con los datos de la identificación oficial del candidato</td>
                    <td><input type="radio" name="q2" value="si" required></td>
                    <td><input type="radio" name="q2" value="no" required></td>
                </tr>
                <tr>
                    <td>3. Brindando la retroalimentación con base al resultado obtenido en el Diagnóstico aplicado</td>
                    <td><input type="radio" name="q3" value="si" required></td>
                    <td><input type="radio" name="q3" value="no" required></td>
                </tr>
                <tr>
                    <td>4. Preguntando si conoce y entiende sus derechos y obligaciones como usuario del SNC</td>
                    <td><input type="radio" name="q4" value="si" required></td>
                    <td><input type="radio" name="q4" value="no" required></td>
                </tr>
                <tr>
                    <td>5. Confirmando que el EC con el que se realizará la evaluación corresponde a lo solicitado por el candidato</td>
                    <td><input type="radio" name="q5" value="si" required></td>
                    <td><input type="radio" name="q5" value="no" required></td>
                </tr>
                <tr>
                    <td>6. Explicando en lenguaje usual del medio en qué consiste el proceso de evaluación con base en el EC</td>
                    <td><input type="radio" name="q6" value="si" required></td>
                    <td><input type="radio" name="q6" value="no" required></td>
                </tr>
                <tr>
                    <td>7. Preguntando si existen dudas referentes a las actividades descritas hasta el momento y en su caso resolverlas</td>
                    <td><input type="radio" name="q7" value="si" required></td>
                    <td><input type="radio" name="q7" value="no" required></td>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Acuerda el Plan de Evaluación con el candidato:</th>
                    <th>SI</th>
                    <th>NO</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1. Estableciendo quién proveerá los recursos para el desarrollo de la evaluación establecidos en el EC</td>
                    <td><input type="radio" name="q8" value="si" required></td>
                    <td><input type="radio" name="q8" value="no" required></td>
                </tr>
                <tr>
                    <td>2. Explicando que para recibir el juicio de Competente tendrá que cumplir o superar el puntaje mínimo establecido en el IEC</td>
                    <td><input type="radio" name="q9" value="si" required></td>
                    <td><input type="radio" name="q9" value="no" required></td>
                </tr>
                <tr>
                    <td>3. Definiendo de común acuerdo el lugar, fecha y horario para el desarrollo de la evaluación</td>
                    <td><input type="radio" name="q10" value="si" required></td>
                    <td><input type="radio" name="q10" value="no" required></td>
                </tr>
                <tr>
                    <td>4. Comentando que la entrega de resultados de la evaluación deberá realizarse en un periodo no mayor a cinco días hábiles</td>
                    <td><input type="radio" name="q11" value="si" required></td>
                    <td><input type="radio" name="q11" value="no" required></td>
                </tr>
                <tr>
                    <td>5. Definiendo de común acuerdo el lugar, fecha y horario para la entrega de resultados</td>
                    <td><input type="radio" name="q12" value="si" required></td>
                    <td><input type="radio" name="q12" value="no" required></td>
                </tr>
                <tr>
                    <td>6. Preguntando si existen dudas referentes a los acuerdos establecidos y en su caso resolverlas</td>
                    <td><input type="radio" name="q13" value="si" required></td>
                    <td><input type="radio" name="q13" value="no" required></td>
                </tr>
                <tr>
                    <td>7. Solicitando la firma / huella digital de conformidad del candidato</td>
                    <td><input type="radio" name="q14" value="si" required></td>
                    <td><input type="radio" name="q14" value="no" required></td>
                </tr>
                <tr>
                    <td>8. Entregando una copia del Plan de Evaluación acordado y firmado por ambas partes</td>
                    <td><input type="radio" name="q15" value="si" required></td>
                    <td><input type="radio" name="q15" value="no" required></td>
                </tr>
                <tr>
                    <td>9. Solicitando el acuse de recibido de la copia del Plan de Evaluación acordado</td>
                    <td><input type="radio" name="q16" value="si" required></td>
                    <td><input type="radio" name="q16" value="no" required></td>
                </tr>
            </tbody>

        </table>
        <br>
        <p>Con relación a este elemento ¿Usted obtiene los siguientes <strong>PRODUCTOS</strong>?</p>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>1.El Plan de Evaluación acordado:</th>
                    <th>SI</th>
                    <th>NO</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td>1. Se presenta en el formato establecido en la normatividad vigente del CONOCER:</td>
                <td><input type="radio" name="q17" value="SI"></td>
                <td><input type="radio" name="q17" value="NO"></td>
            </tr>
            <tr>
                <td>2. Contiene los nombres completos del candidato y del evaluador:</td>
                <td><input type="radio" name="q18" value="SI"></td>
                <td><input type="radio" name="q18" value="NO"></td>
            </tr>
            <tr>
                <td>3. Incluye el resultado del diagnóstico aplicado previamente y las recomendaciones para el candidato:</td>
                <td><input type="radio" name="q19" value="SI"></td>
                <td><input type="radio" name="q19" value="NO"></td>
            </tr>
            <tr>
                <td>4. Contiene el lugar, fecha y horarios para el proceso de evaluación y para la entrega de resultados, con base en el acuerdo previo:</td>
                <td><input type="radio" name="q20" value="SI"></td>
                <td><input type="radio" name="q20" value="NO"></td>
            </tr>
            <tr>
                <td>5. Específica a los responsables de proporcionar los recursos para el desarrollo de la evaluación establecidos en el EC y en congruencia con el acuerdo previo:</td>
                <td><input type="radio" name="q21" value="SI"></td>
                <td><input type="radio" name="q21" value="NO"></td>
            </tr>
            <tr>
                <td>6. Contiene la firma / huella digital de conformidad del candidato y del evaluador:</td>
                <td><input type="radio" name="q22" value="SI"></td>
                <td><input type="radio" name="q22" value="NO"></td>
            </tr>
            <tr>
                <td>7. Contiene el acuse de recibido de la copia del Plan de Evaluación acordado:</td>
                <td><input type="radio" name="q23" value="SI"></td>
                <td><input type="radio" name="q23" value="NO"></td>
            </tr>
        </tbody>
        </table>
        <br>
        <p>Con relación a este elemento ¿Usted obtiene los siguientes <strong>CONOCIMIENTOS</strong>? </p>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Cuenta con conocimientos en los siguientes temas:</th>
                    <th>SI</th>
                    <th>NO</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td>1. Características y aplicabilidad de la Evidencia Histórica.</td>
                <td><input type="radio" name="q24" value="SI"></td>
                <td><input type="radio" name="q24" value="NO"></td>
            </tr>
            <tr>
                <td>2. Consideraciones para determinar la competencia de un candidato con base en un proceso de evaluación.</td>
                <td><input type="radio" name="q25" value="SI"></td>
                <td><input type="radio" name="q25" value="NO"></td>
            </tr>
        </tbody>
        </table>
        <br>
        <p>Con relación a este elemento ¿Usted obtiene los siguientes <strong>CONOCIMIENTOS</strong>? </p>
        <br>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <TH></TH>
                    <th>SI</th>
                    <th>NO</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <tr>
                    <td><h5>1. Amabilidad: La manera en que durante la presentación y el acuerdo del Plan de Evaluación brinda un trato cordial y respetuoso,</h5>
                        <h5> explicando todo el proceso de manera clara, sin tecnicismos y resolviendo cada una de las dudas o cuestionamientos realizados por el candidato.</h5></td>
                    <td><input type="radio" name="q26" value="SI"></td>
                    <td><input type="radio" name="q26" value="NO"></td>
                </tr>
            </tbody>
        </table>
        <br>
        <div style="display: flex; justify-content: center;">
            <p style="padding: 0px; font-size: 25px; background-color: black; color:white; width: 800px; text-align: center;">
                <strong>ELEMENTO 2 DE 4</strong>
            </p>
        </div>


        <p>Con relación a este elemento ¿Puede usted realizar los siguientes  <strong>DESEMPEÑOS</strong> ?</p>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>1.Verifica las condiciones establecidas en el EC de manera previa a la aplicación del IEC:</th>
                    <th>SI</th>
                    <th>NO</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1. Corroborando la disponibilidad de los recursos para el desarrollo de la
                        valuación especificados en el Plan de Evaluación acordado y en las
                        instrucciones de aplicación definidas en el IEC, ye</td>
                    <td><input type="radio" name="q27" value="SI"></td>
                    <td><input type="radio" name="q27" value="NO"></td>
                </tr>
                <tr>
                    <td>2.Corroborando la funcionalidad de los recursos para el desarrollo de la
                        evaluación especificados en el Plan de Evaluación acordado y en las
                        instrucciones de aplicación definidas en el IEC.</td>
                    <td><input type="radio" name="q28" value="SI"></td>
                    <td><input type="radio" name="q28" value="NO"></td>
                </tr>
            </tbody>
        </table>

        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>2.Comunica las instrucciones de aplicación del IEC al candidato:</th>
                    <th>SI</th>
                    <th>NO</th>
                </tr>
            </thead>
         <tbody>
            <tr>
                <td>1. Con base en las actividades a desarrollar especificadas en el Plan de
                    Evaluación acordado y la secuencia en que éstas deberán ser
                    atendidas,</td>
                <td><input type="radio" name="q29" value="SI"></td>
                <td><input type="radio" name="q29" value="NO"></td>
            </tr>
            <tr>
                <td>2. Mencionando las reglas generales de conducta / protocolos de
                    actuación / seguridad en caso de una situación de riesgo, en apego a lo
                    establecidos por el lugar en el que se desarrolla la evaluación,</td>
                <td><input type="radio" name="q30" value="SI"></td>
                <td><input type="radio" name="q30" value="NO"></td>
            </tr>
            <tr>
                <td>3. Preguntando si existen dudas antes de comenzar su proceso de
                    evaluación y en su caso resolverlas,</td>
                <td><input type="radio" name="q31" value="SI"></td>
                <td><input type="radio" name="q31" value="NO"></td>
            </tr>
            <tr>
                <td>4. Indicando que su función / interacción como evaluador se ajustará a las
                    instrucciones especificadas en el IEC,</td>
                <td><input type="radio" name="q32" value="SI"></td>
                <td><input type="radio" name="q32" value="NO"></td>
            </tr>
            <tr>
                <td>5. Mencionando que al iniciar el proceso de evaluación no se atenderán
                    dudas / particularidades relacionadas con las actividades a desarrollar,</td>
                <td><input type="radio" name="q33" value="SI"></td>
                <td><input type="radio" name="q33" value="NO"></td>
            </tr>
            <tr>
                <td>6. Indicando el inicio del proceso de evaluación.</td>
                <td><input type="radio" name="q34" value="SI"></td>
                <td><input type="radio" name="q34" value="NO"></td>
            </tr>
            </tbody>
        </table>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>3.Recopila las evidencias de Desempeño, AHV / Respuestas a Situaciones
                        Emergentes demostradas por el candidato, con base en lo establecido en el
                        Plan de Evaluación:</th>
                    <th>SI</th>
                    <th>NO</th>
                </tr>
            </thead>
        <tbody>
            <tr>
                <td>1. Evitando en todo momento realizar expresiones verbales / no verbales
                    aprobatorias / desaprobatorias que incidan en la ejecución de los
                    desempeños / conductas que el candidato demuestra,</td>
                <td><input type="radio" name="q35" value="SI"></td>
                <td><input type="radio" name="q35" value="NO"></td>
            </tr>
            <tr>
                <td>2. Registrando el cumplimiento / incumplimiento y observaciones de las
                    actividades en el espacio destinado en las guías de observación del IEC,
                    al momento que el candidato las ejecuta,</td>
                <td><input type="radio" name="q36" value="SI"></td>
                <td><input type="radio" name="q36" value="NO"></td>
            </tr>
            <tr>
                <td>3. Evitando interrumpir / distraer al candidato durante el desarrollo de
                    actividades establecidas en las guías de observación.</td>
                <td><input type="radio" name="q37" value="SI"></td>
                <td><input type="radio" name="q37" value="NO"></td>
            </tr>
        </tbody>
        </table>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>4.Recopila las evidencias de Producto obtenidas por el candidato, con base en
                        lo establecido en el Plan de Evaluación:</th>
                    <th>SI</th>
                    <th>NO</th>
                </tr>
            </thead>
        <tbody>
            <tr>
                <td>1. Verificando las características de las evidencias de producto
                    presentadas por el candidato, en congruencia con lo establecido en la
                    lista de cotejo, después de que las haya entregado, y</td>
                <td><input type="radio" name="q38" value="SI"></td>
                <td><input type="radio" name="q38" value="NO"></td>
            </tr>
            <tr>
                <td>2. Registrando el cumplimiento / incumplimiento y observaciones en el
                    espacio destinado en las listas de cotejo del IEC.</td>
                <td><input type="radio" name="q39" value="SI"></td>
                <td><input type="radio" name="q39" value="NO"></td>
            </tr>
        </tbody>
        </table>
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>5.Aplica cuestionario al candidato con base en lo establecido en el Plan de
                        Evaluación</th>
                    <th>SI</th>
                    <th>NO</th>
                </tr>
            </thead>
        <tbody>
            <tr>
                <td>1. Explicando que deberá responder los reactivos relacionados con
                    conocimientos, así como las instrucciones para su aplicación,</td>
                <td><input type="radio" name="q40" value="SI"></td>
                <td><input type="radio" name="q40" value="NO"></td>
            </tr>
            <tr>
                <td>2. Comentándole el número y tipo de reactivos que deberá responder, y</td>
                <td><input type="radio" name="q41" value="SI"></td>
                <td><input type="radio" name="q41" value="NO"></td>
            </tr>
            <tr>
                <td>3. Preguntando si existen dudas antes de comenzar a responder el
                    cuestionario y en su caso resolverlas.</td>
                <td><input type="radio" name="q42" value="SI"></td>
                <td><input type="radio" name="q42" value="NO"></td>
            </tr>
        </tbody>
        </table>
        <br>
     <table class="table table-bordered">
    <thead>
        <tr>
            <th>6.Cierra la aplicación del IEC:</th>
            <th>SI</th>
            <th>NO</th>
        </tr>
    </thead>
<tbody>
    <tr>
        <td>1. Notificando al candidato que la aplicación del IEC ha concluido,</td>
        <td><input type="radio" name="q43" value="SI"></td>
        <td><input type="radio" name="q43" value="NO"></td>
    </tr>
    <tr>
        <td>2. Verificando que todos los reactivos del IEC estén
            registrados/observados, y</td>
        <td><input type="radio" name="q44" value="SI"></td>
        <td><input type="radio" name="q44" value="NO"></td>
    </tr>
    <tr>
        <td>3. Recordando al candidato el lugar, fecha y horario para la entrega de
            resultados con base en lo acordado en el Plan de Evaluación.</td>
        <td><input type="radio" name="q45" value="SI"></td>
        <td><input type="radio" name="q45" value="NO"></td>
    </tr>
</tbody>
</table>
<br>
<p>Con relación a este elemento ¿Puede usted realizar los siguientes  <strong>CONOCIMIENTOS</strong> ?</p>
<br>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Cuenta con conocimientos en los siguientes temas:</th>
            <th>SI</th>
            <th>NO</th>
        </tr>
    </thead>
<tbody>
    <tr>
        <td>
            1. Situaciones de Riesgo durante el proceso de evaluación:
            <ul>
                <li>Definición.</li>
                <li>Características.</li>
                <li>Conducta del evaluador frente a una Situación de Riesgo.</li>
            </ul>
        </td>
        <td><input type="radio" name="q46" value="SI"></td>
        <td><input type="radio" name="q46" value="NO"></td>
    </tr>

    <tr>
        <td>2. Verificando que todos los reactivos del IEC estén
            registrados/observados, y</td>
        <td><input type="radio" name="q47" value="SI"></td>
        <td><input type="radio" name="q47" value="NO"></td>
    </tr>
</tbody>
</table>
<br>
<p>Con relación a este elemento ¿Puede usted realizar los siguientes  <strong>ACTITUDES, HÁBITOS y VALORES</strong> ?</p>
<br>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Usted presenta:</th>
            <th>SI</th>
            <th>NO</th>
        </tr>
    </thead>
<tbody>
    <tr>
        <td>1. Responsabilidad: La manera en que recopila las evidencias de
            Desempeño / Producto / Conocimiento / AHV del candidato cumpliendo
            con los criterios establecidos para dicho fin en el Decálogo y en el
            Código de Ética del evaluador.</td>

        <td><input type="radio" name="q48" value="SI"></td>
        <td><input type="radio" name="q48" value="NO"></td>
    </tr>

</tbody>
</table>
<br>
<div style="display: flex; justify-content: center;">
    <p style="padding: 0px; font-size: 25px; background-color: black; color:white; width: 800px; text-align: center;">
        <strong>ELEMENTO 3 DE 4</strong>
    </p>
</div>
<p>Con relación a este elemento ¿Puede usted realizar los siguientes <strong>DESEMPEÑOS</strong>?</p>
<br>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>1. Revisa cumplimientos / incumplimientos del proceso de evaluación para la obtención del juicio de competencia:</th>
            <th>SI</th>
            <th>NO</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1. Cotejando las respuestas de conocimiento correctas / incorrectas emitidas por el candidato, tomando como referente el anexo 2 del IEC,</td>
            <td><input type="radio" name="q49" value="SI"></td>
            <td><input type="radio" name="q49" value="NO"></td>
        </tr>
        <tr>
            <td>2. Realizando la cuantificación de los pesos relativos de los reactivos de acuerdo a lo establecido en el IEC para la obtención de la ponderación final, y</td>
            <td><input type="radio" name="q50" value="SI"></td>
            <td><input type="radio" name="q50" value="NO"></td>
        </tr>
        <tr>
            <td>3. Emitiendo el juicio de competencia con base en el puntaje obtenido y la verificación del correcto cumplimiento de al menos un reactivo en cada criterio de Desempeño y Producto.</td>
            <td><input type="radio" name="q51" value="SI"></td>
            <td><input type="radio" name="q51" value="NO"></td>
        </tr>
    </tbody>
</table>
<br>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>2. Realiza el llenado de la Cédula de Evaluación del proceso de evaluación del candidato:</th>
            <th>SI</th>
            <th>NO</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1. Con base en las evidencias registradas durante el proceso de evaluación en el IEC, y</td>
            <td><input type="radio" name="q52" value="SI"></td>
            <td><input type="radio" name="q52" value="NO"></td>
        </tr>
        <tr>
            <td>2. Describiendo las mejores prácticas, áreas de oportunidad asociadas a los reactivos que no se cumplieron, el código de éstos y las recomendaciones con base en las evidencias recopiladas</td>
            <td><input type="radio" name="q53" value="SI"></td>
            <td><input type="radio" name="q53" value="NO"></td>
        </tr>
    </tbody>
</table>
<br>
<p>Con relación a este elemento ¿Puede usted realizar los siguientes <strong>DESEMPEÑOS</strong>?</p>
<br>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>1. El Instrumento de Evaluación por Competencias aplicado al candidato:</th>
            <th>SI</th>
            <th>NO</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1. Especifica la fecha de su aplicación de acuerdo con lo definido en el Plan de Evaluación,</td>
            <td><input type="radio" name="q54" value="SI"></td>
            <td><input type="radio" name="q54" value="NO"></td>
        </tr>
        <tr>
            <td>2. Incluye el nombre completo del candidato y del evaluador en los espacios destinados para ello,</td>
            <td><input type="radio" name="q55" value="SI"></td>
            <td><input type="radio" name="q55" value="NO"></td>
        </tr>
        <tr>
            <td>3. Incluye las firmas / huella digital del evaluador y el candidato en los espacios destinados para ello,</td>
            <td><input type="radio" name="q56" value="SI"></td>
            <td><input type="radio" name="q56" value="NO"></td>
        </tr>
        <tr>
            <td>4. Contiene el registro de los cumplimientos / incumplimientos y observaciones de todos los reactivos presentados por el candidato,</td>
            <td><input type="radio" name="q57" value="SI"></td>
            <td><input type="radio" name="q57" value="NO"></td>
        </tr>
        <tr>
            <td>5. Incluye la cuantificación de los pesos relativos en la sección destinada para ello, e</td>
            <td><input type="radio" name="q58" value="SI"></td>
            <td><input type="radio" name="q58" value="NO"></td>
        </tr>
        <tr>
            <td>6. Incluye el juicio de competencia obtenido por el candidato en el espacio destinado para ello.</td>
            <td><input type="radio" name="q59" value="SI"></td>
            <td><input type="radio" name="q59" value="NO"></td>
        </tr>
    </tbody>
</table>




<br>
    <input type="hidden" id="current_date" name="current_date">
    <div style="display: flex; justify-content: center;">
        <button type="button" class="primary" onclick="contabilizarTodasRespuestas()">Enviar resultados</button>
    </div>

    <div id="decision-section" style="display: none;">

        <label>¿Usted desea?</label>
        <br>
        <input type="radio" name="decision" value="Evaluarme" required> Evaluarme
        <br>
        <input type="radio" name="decision" value="Asesorarme" required> Asesorarme
        <br>
        <button type="submit" value="submit">Descarga y enviar resultados</button>

    </div>

    </form>
</div>

<br>
<h2>Tabla de Porcentaje</h2>
<table id="tabla-resultados" border="1">
    <thead>
        <tr>
            <th colspan="2">TABLA DE PORCENTAJE</th>
        </tr>
    </thead>
    <tbody id="resultados-body">
        <tr>
            <th>1. Cuente el número de respuestas afirmativas (Sí) que obtuvo y anótelas:</th>
            <td id="num-si">0</td>
        </tr>
        <tr>
            <th>2. Cuente el número de respuestas negativas (No) que obtuvo y anótelas:</th>
            <td id="num-no">0</td>
        </tr>
        <tr>
            <th>3. Verifique que la suma de las respuestas afirmativas (SI) y negativas (NO) sea igual al total de reactivos (145):</th>
            <td id="suma-total">0</td>
        </tr>
        <tr>
            <th>4. Divida las respuestas afirmativas que obtuvo entre el total de respuestas y multiplique por 100 para que su resultado sea en porcentaje:</th>
            <td id="porcentaje-si">0%</td>
        </tr>
    </tbody>
</table>
<br>
<div id="mensaje-evaluacion"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<table id="resultados" class="table table-bordered mt-5">
        <thead>
            <tr>
                <tr>
                    <th>Elemento 1 de 4  : Diseñar cursos de formación del capital humano de manera presencial grupal.</th>
                    <th>TOTAL DE REACTIVOS</th>
                    <th>SI</th>
                    <th>NO</th>
                    <th>Total</th>
                </tr>
            </tr>
        </thead>
        <tbody>
            <td colspan="4">Aún no hay resultados.</td>
        </tbody>
    </table>
<br>
<table id="resultados1" class="table table-bordered mt-5">
    <thead>
        <tr>
            <th>Elemento 2 de 4: Diseñar cursos de formación del capital humano de manera presencial grupal.</th>
            <th>TOTAL DE REACTIVOS</th>
            <th>SI</th>
            <th>NO</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
       <td colspan="4">Aún no hay resultados.</td>
    </tbody>
</table>
<br>
<table id="resultados2" class="table table-bordered mt-5">
    <thead>
        <tr>
            <th>Elemento 3 de 4: Diseñar cursos de formación del capital humano de manera presencial grupal.</th>
            <th>TOTAL DE REACTIVOS</th>
            <th>SI</th>
            <th>NO</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
       <td colspan="4">Aún no hay resultados.</td>
    </tbody>
</table>
<br>
<script>
    function contabilizarTodasRespuestas() {

        contabilizarRespuestas();
        contabilizarRespuestas1();
        contabilizarRespuestas2();

        const currentDate = new Date().toISOString().split('T')[0]; // Formato YYYY-MM-DD
        document.getElementById('current_date').value = currentDate;
         document.getElementById('decision-section').style.display = 'block';
    }
</script>


<script>
    function contabilizarRespuestas() {
        const formulario = document.getElementById('formulario-diagnostico');
        const preguntas = formulario.querySelectorAll('input[type="radio"]:checked');
        const resultados = {
            desempeños: { total: 16, si: 0, no: 0 },
            productos: { total: 7, si: 0, no: 0 },
            conocimientos: { total: 2, si: 0, no: 0 },
            actitudes: { total: 1, si: 0, no: 0 }
        };

        preguntas.forEach(pregunta => {
            const name = pregunta.name;
            const value = pregunta.value.toLowerCase(); // Convert value to lowercase for consistent comparison

            if (name.match(/^q\d+$/)) {
                const numeroPregunta = parseInt(name.replace('q', ''), 10);

                // Desempeños
                if (numeroPregunta >= 1 && numeroPregunta <= 16) {
                    if (value === 'si') {
                        resultados.desempeños.si++;
                    } else if (value === 'no') {
                        resultados.desempeños.no++;
                    }
                }
                // Productos
                else if (numeroPregunta >= 17 && numeroPregunta <= 23) {
                    if (value === 'si') {
                        resultados.productos.si++;
                    } else if (value === 'no') {
                        resultados.productos.no++;
                    }
                }
                // Conocimientos
                else if (numeroPregunta >= 24 && numeroPregunta <= 25) {
                    if (value === 'si') {
                        resultados.conocimientos.si++;
                    } else if (value === 'no') {
                        resultados.conocimientos.no++;
                    }
                }
                // Actitudes
                else if (numeroPregunta === 26) {
                    if (value === 'si') {
                        resultados.actitudes.si++;
                    } else if (value === 'no') {
                        resultados.actitudes.no++;
                    }
                }
            }
        });

        const tbody = document.querySelector('#resultados tbody');
        tbody.innerHTML = `
            <tr>
                <td>Desempeños</td>
                <td>${resultados.desempeños.total}</td>
                <td>${resultados.desempeños.si}</td>
                <td>${resultados.desempeños.no}</td>
                <td>${resultados.desempeños.si + resultados.desempeños.no}</td>
            </tr>
            <tr>
                <td>Productos</td>
                <td>${resultados.productos.total}</td>
                <td>${resultados.productos.si}</td>
                <td>${resultados.productos.no}</td>
                <td>${resultados.productos.si + resultados.productos.no}</td>
            </tr>
            <tr>
                <td>Conocimientos</td>
                <td>${resultados.conocimientos.total}</td>
                <td>${resultados.conocimientos.si}</td>
                <td>${resultados.conocimientos.no}</td>
                <td>${resultados.conocimientos.si + resultados.conocimientos.no}</td>
            </tr>
            <tr>
                <td>Actitudes</td>
                <td>${resultados.actitudes.total}</td>
                <td>${resultados.actitudes.si}</td>
                <td>${resultados.actitudes.no}</td>
                <td>${resultados.actitudes.si + resultados.actitudes.no}</td>
            </tr>
        `;

        // Optional: You can update input values if needed
        document.getElementById('productos-total-input1').value = resultados.productos.total;
        document.getElementById('productos-si-input1').value = resultados.productos.si;
        document.getElementById('productos-no-input1').value = resultados.productos.no;
        document.getElementById('productos-suma-input1').value = resultados.productos.si + resultados.productos.no;

        document.getElementById('conocimientos-total-input1').value = resultados.conocimientos.total;
        document.getElementById('conocimientos-si-input1').value = resultados.conocimientos.si;
        document.getElementById('conocimientos-no-input1').value = resultados.conocimientos.no;
        document.getElementById('conocimientos-suma-input1').value = resultados.conocimientos.si + resultados.conocimientos.no;

        document.getElementById('actitudes-total-input1').value = resultados.actitudes.total;
        document.getElementById('actitudes-si-input1').value = resultados.actitudes.si;
        document.getElementById('actitudes-no-input1').value = resultados.actitudes.no;
        document.getElementById('actitudes-suma-input1').value = resultados.actitudes.si + resultados.actitudes.no;
    }
</script>
<br>
<script>
    function contabilizarRespuestas1() {
        const formulario = document.getElementById('formulario-diagnostico');
        const preguntas = formulario.querySelectorAll('input[type="radio"]:checked');
        const resultados = {
            desempeños: { total: 19, si: 0, no: 0 },
            conocimientos: { total: 2, si: 0, no: 0 },
            actitudes: { total: 1, si: 0, no: 0 }
        };

        preguntas.forEach(pregunta => {
            const name = pregunta.name;
            const value = pregunta.value.toLowerCase(); // Convert value to lowercase for consistent comparison

            if (name.match(/^q\d+$/)) {
                const numeroPregunta = parseInt(name.replace('q', ''), 10);

                if (numeroPregunta >= 27 && numeroPregunta <= 45) { // Desempeños
                    if (value === 'SI') {
                        resultados.desempeños.si++;
                    } else if (value === 'NO') {
                        resultados.desempeños.no++;
                    }
                } else if (numeroPregunta >= 46 && numeroPregunta <= 47) { // Productos
                    if (value === 'SI') {
                        resultados.conocimientos.si++;
                    } else if (value === 'NO') {
                        resultados.conocimientos.no++;
                    }
                } else if (numeroPregunta == 48) { // Actitudes
                    if (value === 'SI') {
                        resultados.actitudes.si++;
                    } else if (value === 'NO') {
                        resultados.actitudes.no++;
                    }
                }
            }
        });

        const tbody = document.querySelector('#resultados1 tbody');
        tbody.innerHTML = `
            <tr>
                <td>Desempeños</td>
                <td>${resultados.desempeños.total}</td>
                <td>${resultados.desempeños.si}</td>
                <td>${resultados.desempeños.no}</td>
                <td>${resultados.desempeños.si + resultados.desempeños.no}</td>
            </tr>
            <tr>
                <td>Productos</td>
                <td>${resultados.conocimientos.total}</td>
                <td>${resultados.conocimientos.si}</td>
                <td>${resultados.conocimientos.no}</td>
                <td>${resultados.conocimientos.si + resultados.conocimientos.no}</td>
            </tr>
            <tr>
                <td>Actitudes</td>
                <td>${resultados.actitudes.total}</td>
                <td>${resultados.actitudes.si}</td>
                <td>${resultados.actitudes.no}</td>
                <td>${resultados.actitudes.si + resultados.actitudes.no}</td>
            </tr>
        `;

        // Guardar resultados en inputs
        document.getElementById('desempeños-total-input2').value = resultados.desempeños.total;
        document.getElementById('desempeños-si-input2').value = resultados.desempeños.si;
        document.getElementById('desempeños-no-input2').value = resultados.desempeños.no;
        document.getElementById('desempeños-suma-input2').value = resultados.desempeños.si + resultados.desempeños.no;

        document.getElementById('conocimientos-total-input2').value = resultados.conocimientos.total;
        document.getElementById('conocimientos-si-input2').value = resultados.conocimientos.si;
        document.getElementById('conocimientos-no-input2').value = resultados.conocimientos.no;
        document.getElementById('conocimientos-suma-input2').value = resultados.conocimientos.si + resultados.conocimientos.no;

        document.getElementById('actitudes-total-input2').value = resultados.actitudes.total;
        document.getElementById('actitudes-si-input2').value = resultados.actitudes.si;
        document.getElementById('actitudes-no-input2').value = resultados.actitudes.no;
        document.getElementById('actitudes-suma-input2').value = resultados.actitudes.si + resultados.actitudes.no;
    }
</script>
<script>
    function contabilizarRespuestas2() {
        const formulario = document.getElementById('formulario-diagnostico');
        const preguntas = formulario.querySelectorAll('input[type="radio"]:checked');
        const resultados = {
            desempenos: { total: 5, si: 0, no: 0 },
            productos: { total: 5, si: 0, no: 0 },
        };

        preguntas.forEach(pregunta => {
            const name = pregunta.name;
            const value = pregunta.value.toUpperCase();

            if (name.match(/^q\d+$/)) {
                const numeroPregunta = parseInt(name.replace('q', ''), 10);

                if (numeroPregunta >= 49 && numeroPregunta <= 53) { // Desempeños
                    resultados.desempenos.total++;
                    if (value === 'SI') {
                        resultados.desempenos.si++;
                    } else if (value === 'NO') {
                        resultados.desempenos.no++;
                    }
                } else if (numeroPregunta >= 54 && numeroPregunta <= 59) { // Productos
                    resultados.productos.total++;
                    if (value === 'SI') {
                        resultados.productos.si++;
                    } else if (value === 'NO') {
                        resultados.productos.no++;
                    }
                }
            }
        });

        const tbody = document.querySelector('#resultados2 tbody');
        tbody.innerHTML = `
            <tr>
                <td>Desempeños</td>
                <td>${resultados.desempenos.total}</td>
                <td>${resultados.desempenos.si}</td>
                <td>${resultados.desempenos.no}</td>
                <td>${resultados.desempenos.si + resultados.desempenos.no}</td>
            </tr>
            <tr>
                <td>Productos</td>
                <td>${resultados.productos.total}</td>
                <td>${resultados.productos.si}</td>
                <td>${resultados.productos.no}</td>
                <td>${resultados.productos.si + resultados.productos.no}</td>
            </tr>
        `;

        // Guardar resultados en inputs
        document.getElementById('desempenos-total-input3').value = resultados.desempenos.total;
        document.getElementById('desempenos-si-input3').value = resultados.desempenos.si;
        document.getElementById('desempenos-no-input3').value = resultados.desempenos.no;
        document.getElementById('desempenos-suma-input3').value = resultados.desempenos.si + resultados.desempenos.no;

        document.getElementById('productos-total-input3').value = resultados.productos.total;
        document.getElementById('productos-si-input3').value = resultados.productos.si;
        document.getElementById('productos-no-input3').value = resultados.productos.no;
        document.getElementById('productos-suma-input3').value = resultados.productos.si + resultados.productos.no;
    }
</script>


<script>
    function calcularResultados3() {
        const formulario = document.getElementById('formulario-diagnostico');
        const preguntas = formulario.querySelectorAll('input[type="radio"]:checked');
        const totalPreguntas = 58; // Total de preguntas es 145
        let numSi = 0;
        let numNo = 0;

        preguntas.forEach(pregunta => {
            if (pregunta.value === 'si') {
                numSi++;
            } else if (pregunta.value === 'no') {
                numNo++;
            }
        });

        if (numSi + numNo !== totalPreguntas) {
            alert('Debe seleccionar respuestas.');
            return;
        }

        const porcentajeSi = (numSi / totalPreguntas) * 100;

        // Actualizar los campos ocultos con el porcentaje y números calculados
        document.getElementById('num-si-input').value = numSi;
        document.getElementById('num-no-input').value = numNo;
        document.getElementById('porcentaje-si-input').value = porcentajeSi.toFixed(2) + '%';

        // Mostrar los resultados en la página
        document.getElementById('num-si').textContent = numSi;
        document.getElementById('num-no').textContent = numNo;
        document.getElementById('suma-total').textContent = totalPreguntas;
        document.getElementById('porcentaje-si').textContent = porcentajeSi.toFixed(2) + '%';

        // Mostrar el mensaje de evaluación o asesoría
        const mensaje = document.getElementById('mensaje-evaluacion');
        let recomendacion = '';
        if (porcentajeSi >= 90) {
            mensaje.textContent = "Le recomendamos: EVALUARSE";
            mensaje.className = 'evaluarse';
            recomendacion = 'EVALUARSE';
        } else {
            mensaje.textContent = "Le recomendamos: ASESORARSE";
            mensaje.className = 'asesorarse';
            recomendacion = 'ASESORARSE';
        }
        mensaje.style.display = 'block';

        // Almacenar la recomendación en el input oculto
        document.getElementById('recomendacion-input').value = recomendacion;
    }

    function contabilizarYEnviar() {
        calcularResultados3();
        document.getElementById('formulario-diagnostico').submit();
    }

    document.getElementById('calcular-btn').addEventListener('click', contabilizarYEnviar);

    </script>




</body>
</html>
