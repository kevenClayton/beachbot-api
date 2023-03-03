<?php

namespace App\Http\Controllers\Api;

use App\Models\Espaco;
use App\Models\HorariosReservadosEspacos;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Cmixin\BusinessTime;
use BusinessTime\Schedule;
use Spatie\OpeningHours\OpeningHours;
use App\Models\HorariosDisponiveisEspacos;
use App\Models\HorarioFuncionamento;
use App\Enums\DiasSemana;
use Throwable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use DateTime;


class AgendamentoController extends Controller
{

    public function criarReservaHorario(Request $request){
        try{
            $dados = $request->all();
            $dataReserva = $dados['data_reservado_espaco'];
            $horaInicioReserva = $dados['hora_inicio_reservado_espaco'];
            $horaFimReserva = $dados['hora_fim_reservado_espaco'];
            $codigoEspaco = $dados['codigo_espaco'];
            $codigoCliente = $dados['codigo_cliente_espaco'];

            $regras = [
                'data_reservado_espaco' => 'required',
                'hora_inicio_reservado_espaco' => 'required',
                'hora_fim_reservado_espaco' => 'required',
                'codigo_espaco' => 'required',
                'codigo_cliente_espaco' => 'required',
            ];

            $mesagens = [
                'data_reservado_espaco.required' => 'Parâmetro "dias" é obrigatório!',
                'hora_inicio_reservado_espaco.required' => 'Parâmetro "horaInicio" é obrigatório!',
                'hora_fim_reservado_espaco.required' => 'Parâmetro "horaFim" é obrigatório!',
                'codigo_espaco.required' => 'Parâmetro "codigo_espaco" é obrigatório!',
                'codigo_cliente_espaco.required' => 'Parâmetro "codigo_cliente_espaco" é obrigatório!',
            ];

            $validator = Validator::make($dados, $regras, $mesagens);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Erro validação',
                    'erro'=>true,
                    'errors' => $validator->errors(),
                ],400);
            }

            $espaco = Espaco::find($codigoEspaco);

            if($espaco->situacao == false){
                return response()->json([
                    'errro'=> true,
                    'message'=> 'O espaço está desativado, e não pode fazer reserva de horário',
                ], 422);
            }

            $podeSerCriado = $this->podeSerCriadoNoEspaco($dataReserva, $horaInicioReserva, $horaFimReserva, $codigoEspaco);
            if($podeSerCriado == false){
                return response()->json([
                    'errro'=> true,
                    'message'=> 'Já existe reserva neste horário para o espaço '.$espaco->nome_espaco.'',
                ], 422);
            }

            $horarioReserado = HorariosReservadosEspacos::create($dados);

            return response()->json([
                    'message'=> 'Horário reservado com sucesso',
                    'reserva'=> $horarioReserado,
                ], 200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 404);
        }
    }

    public function podeSerCriadoNoEspaco($data, $horaInicio, $horaFim, $codigoEspaco)
    {
        // combinar a data e a hora de início e fim para criar objetos DateTime
        $dataHoraInicio = new DateTime("$data $horaInicio");
        $dataHoraFim = new DateTime("$data $horaFim");
        $dataHoraInicio = $dataHoraInicio->format('Y-m-d H:i');
        $dataHoraFim = $dataHoraFim->format('Y-m-d H:i');
        // verificar se há algum agendamento existente que conflite com as datas e horas fornecidas
        $conflito = HorariosReservadosEspacos::where(function ($query) use ($dataHoraInicio, $dataHoraFim, $codigoEspaco) {
            $query->where('codigo_espaco', $codigoEspaco)
                ->whereBetween(DB::raw("CONCAT(data_reservado_espaco, ' ', hora_inicio_reservado_espaco)"), [$dataHoraInicio, $dataHoraFim])
                  ->orWhere(function ($query) use ($dataHoraInicio, $dataHoraFim) {
                      $query->where(DB::raw("CONCAT(data_reservado_espaco, ' ', hora_inicio_reservado_espaco)"), '<', $dataHoraInicio)
                            ->where(DB::raw("CONCAT(data_reservado_espaco, ' ', hora_fim_reservado_espaco)"), '>', $dataHoraFim);
                  });
        })->exists();

        return !$conflito;
    }
    public function retornarHorarioFuncionamento(Request $request){
        try{

            if(isset($request->all()['data'])){
                $data = $request->all()['data'];
                $diaDaSemanaCodigo = $this->saberDiaSemanaCodigo($data);
                $horario_de_funcionamento = $this->horarioFuncionamento($diaDaSemanaCodigo);
            }else{
                $horario_de_funcionamento = $this->horarioFuncionamento();
            }

            return response()->json([
                'message'=> 'Horário funcionamento',
                'horarios'=> $horario_de_funcionamento,
            ], 200);
        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 404);
        }
    }

    public function retornarHorariosAgendadosPorPeriodo(Request $request){
        try{

            $dados = $request->all();


            $regras = [
                'dias' => 'required',
                'codigo_espaco' => 'required',
            ];

            $mesagens = [
                'data.required' => 'Parâmetro "dias" é obrigatório!',
                'codigo_espaco.required' => 'Parâmetro "codigo_espaco" é obrigatório!',
            ];

            $validator = Validator::make($dados, $regras, $mesagens);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Erro validação',
                    'erro'=>true,
                    'errors' => $validator->errors(),
                ],400);
            }

            $dias = $dados['dias'];
            $codigoEspaco = $dados['codigo_espaco'];

            $periodoDias = $this->diasPorPeriodo( $dias);

            $datas = [];

            foreach($periodoDias as $dia){

                $horarios_agendados = $this->horariosAgendadosPorDia($dia->toDateString(),$codigoEspaco); // função para obter horários já agendados

                $datas[] = [
                    'data' => $dia->locale('pt-br')->toDateString(),
                    'diaMes' => $dia->locale('pt-br')->day,
                    'diaNome' => $dia->locale('pt-br')->dayName,
                    'mesCodigo' => $dia->locale('pt-br')->month,
                    'mesNome' => $dia->locale('pt-br')->monthName,
                    'diaSemanaNomeCurto' => $dia->locale('pt-br')->shortDayName,
                    'diaSemanaCodigo' => $dia->locale('pt-br')->dayOfWeek,
                    'horarios'=> $horarios_agendados
                ];

            }

            return response()->json([
                'message'=>'Horários agendados do período de '.$dias.' dia(s)',
                'horarios'=> $datas
            ],200);
        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 404);
        }
    }

    private function diasPorPeriodo($dias){
        $dataInicio = Carbon::now(); // data de início
        $dataFim = Carbon::now()->addDays($dias); // data de término (30 dias depois)

        $periodo = Carbon::parse($dataInicio)->toPeriod($dataFim)->create($dataInicio, $dataFim);
        return $periodo;
    }
    public function retornarHorariosAgendadosPorDia(Request $request){
        try{

            $dados = $request->all();


            $regras = [
                'data' => 'required',
                'codigo_espaco' => 'required',
            ];

            $mesagens = [
                'data.required' => 'Parâmetro "data" é obrigatório!',
                'codigo_espaco.required' => 'Parâmetro "codigo_espaco" é obrigatório!',
            ];

            $validator = Validator::make($dados, $regras, $mesagens);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Erro validação',
                    'erro'=>true,
                    'errors' => $validator->errors(),
                ],400);
            }

            $data = $dados['data'];
            $codigoEspaco = $dados['codigo_espaco'];

            $horariosAgendadosPorDia = $this->horariosAgendadosPorDia($data,$codigoEspaco);

            return response()->json([
                'message'=> 'Horários agendados do dia '.$data.'',
                'horarios'=>$horariosAgendadosPorDia
            ],200);
        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 404);
        }
    }
    public function retornarHorariosDisponveisPorPeriodo(Request $request){

        try{
            $dadosRequest = $request->all();


            $regras = [
                'codigo_espaco' => 'required',
                'dias' => 'required',
            ];

            $mesagens = [
                'codigo_espaco.required' => 'Parâmetro "codigo_espaco" é obrigatório!',
                'dias.required' => 'Parâmetro "dias" é obrigatório!',
            ];

            $validator = Validator::make($dadosRequest, $regras, $mesagens);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Erro validação',
                    'erro'=>true,
                    'errors' => $validator->errors(),
                ],400);
            }

            $dias = $dadosRequest['dias'];
            $codigoEspaco = $dadosRequest['codigo_espaco'];

            $periodoDias = $this->diasPorPeriodo($dias);

            $datas = [];

            foreach($periodoDias as $dia){

                $diaDaSemanaCodigo = $dia->dayOfWeek; //Pega dia atual

                $horario_de_funcionamento = $this->horarioFuncionamento($diaDaSemanaCodigo);

                $horarios_agendados = $this->horariosAgendadosPorDia($dia->toDateString(), $codigoEspaco); // função para obter horários já agendados
                $horariosDisponiveis = $this->calcular_horarios_disponiveis($horario_de_funcionamento, $horarios_agendados);

                $datas[] = [
                    'data' => $dia->locale('pt-br')->toDateString(),
                    'diaMes' => $dia->locale('pt-br')->day,
                    'diaNome' => $dia->locale('pt-br')->dayName,
                    'mesCodigo' => $dia->locale('pt-br')->month,
                    'mesNome' => $dia->locale('pt-br')->monthName,
                    'diaSemanaNomeCurto' => $dia->locale('pt-br')->shortDayName,
                    'diaSemanaCodigo' => $dia->locale('pt-br')->dayOfWeek,
                    'horarios'=> $horariosDisponiveis
                ];

            }

            return response()->json([
                'message'=>'Horários disponíveis do período de '.$dias.' dia(s)',
                'datas'=> $datas
            ],200);
        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 404);
        }
    }
    public function retornarHorariosDisponveisPorDia(Request $request){

        try{
            $dadosRequest = $request->all();


            $regras = [
                'codigo_espaco' => 'required',
            ];

            $mesagens = [
                'codigo_espaco.required' => 'Parâmetro "codigo_espaco" é obrigatório!',
            ];

            $validator = Validator::make($dadosRequest, $regras, $mesagens);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Erro validação',
                    'erro'=>true,
                    'errors' => $validator->errors(),
                ],400);
            }

            if(isset($dadosRequest['data'])){
                $data = $dadosRequest['data'];
                $diaDaSemanaCodigo = $this->saberDiaSemanaCodigo($data);
            }else{
                $diaDaSemanaCodigo = Carbon::now()->dayOfWeek; //Pega dia atual
                $data = Carbon::now()->toDateString();
            }

            $codigoEspaco = $dadosRequest['codigo_espaco'];

            $horario_de_funcionamento = $this->horarioFuncionamento($diaDaSemanaCodigo);

            $horarios_agendados = $this->horariosAgendadosPorDia($data, $codigoEspaco); // função para obter horários já agendados
            $horariosDisponiveis = $this->calcular_horarios_disponiveis($horario_de_funcionamento, $horarios_agendados);

            return response()->json([
                'message'=>'Horários disponíveis do dia '.$data.'!',
                'horarios'=>$horariosDisponiveis
            ],200);
        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 404);
        }
    }

    public function retornarAgendaQuadraPorDia(Request $request){

        try{

            $dadosRequest = $request->all();


            $regras = [
                'codigo_espaco' => 'required',
            ];

            $mesagens = [
                'codigo_espaco.required' => 'Parâmetro "codigo_espaco" é obrigatório!',
            ];

            $validator = Validator::make($dadosRequest, $regras, $mesagens);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Erro validação',
                    'erro'=>true,
                    'errors' => $validator->errors(),
                ],400);
            }

            if(isset($dadosRequest['data'])){
                $data = $dadosRequest['data'];
                $diaDaSemanaCodigo = $this->saberDiaSemanaCodigo($data);
            }else{
                $diaDaSemanaCodigo = Carbon::now()->dayOfWeek; //Pega dia atual
                $data = Carbon::now()->toDateString();
            }

            $codigoEspaco = $dadosRequest['codigo_espaco'];

            $horario_de_funcionamento = $this->horarioFuncionamento($diaDaSemanaCodigo);

            $horarios_agendados = $this->horariosAgendadosComClientePorDia($data, $codigoEspaco); // função para obter horários já agendados
            $horariosDisponiveis = $this->calcular_horarios_disponiveis($horario_de_funcionamento, $horarios_agendados);

            return response()->json([
                'message'=>'Horários disponíveis do dia '.$data.'!',
                'horarios'=>$horariosDisponiveis
            ],200);
        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 404);
        }
    }

    function saberDiaSemanaCodigo($data){
        $diaDaSemanaCodigo = Carbon::parse($data)->dayOfWeek;
        return $diaDaSemanaCodigo;
    }

    private function horarioFuncionamento($diaDaSemanaCodigo = null){
        if($diaDaSemanaCodigo === null){
            $horario_de_funcionamento = HorarioFuncionamento::all(['horario_funcionamento_inicio', 'horario_funcionamento_fim', 'dia_semana_codigo','dia_semana_horario_funcionamento']);
        }else{
            $horario_de_funcionamento = HorarioFuncionamento::where('dia_semana_codigo', $diaDaSemanaCodigo)->first(['horario_funcionamento_inicio', 'horario_funcionamento_fim']);
        }
        return $horario_de_funcionamento;
    }
    private function horariosAgendadosPorDia($data, $codigoEspaco)
    {
        $horariosReservadosEspacos = HorariosReservadosEspacos::where('data_reservado_espaco', $data)
                                ->where('codigo_espaco', $codigoEspaco)
                                ->get(['hora_inicio_reservado_espaco', 'hora_fim_reservado_espaco'])
                                ->toArray();
        $horariosReservados = [];

        foreach ($horariosReservadosEspacos as $horarios){
            $quantidadeHorasReserva = Carbon::parse($horarios['hora_inicio_reservado_espaco'])->diffInRealHours($horarios['hora_fim_reservado_espaco']);

            if($quantidadeHorasReserva > 1){
                $inicio = Carbon::parse($horarios['hora_inicio_reservado_espaco']);
                $fim = Carbon::parse($horarios['hora_fim_reservado_espaco']);

                for ($hora = $inicio; $hora->lessThan($fim); $hora->addHour()) {
                    $horariosReservados[] = $hora->format('H:i');
                }
            }else{
                $horariosReservados[] = $horarios['hora_inicio_reservado_espaco'];
            }
        }
        return $horariosReservados;
    }

    private function calcular_horarios_disponiveis($horario_de_funcionamento, $horarios_agendados)
    {
        $horarios_disponiveis = [];

        // $horario_de_funcionamento = ['inicio' => '09:00', 'fim' => '18:00'];
        $horario_atual = $horario_de_funcionamento['horario_funcionamento_inicio'];
        // $horarios_agendados = ['19:00', '14:00', '15:00'];


        while ($horario_atual < $horario_de_funcionamento['horario_funcionamento_fim']) {
            if (!in_array($horario_atual, $horarios_agendados)) {
                $horarios_disponiveis[] = $horario_atual;
            }

        $horario_atual = $this->adicionar_horario($horario_atual, 60);
        }

        return $horarios_disponiveis;
    }
    public function retornarProximosDias(Request $request){
        try{
            $datas = [];

            $regras = [
                'dias' => 'required',
            ];

            $mesagens = [
                'dias.required' => 'Parâmetro "dias" é obrigatório!',
            ];

            $validator = Validator::make($request->all(), $regras, $mesagens);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Erro validação',
                    'erro'=>true,
                    'errors' => $validator->getMessageBag(),
                ],400);
            }

            $numeroDias = $request->all()['dias'];

            for ($i = 0; $i < $numeroDias; $i++) {
                $data = Carbon::now()->addDays($i);
                $datas[] = [
                    'data' => $data->locale('pt-br')->toDateString(),
                    'diaMes' => $data->locale('pt-br')->day,
                    'diaNome' => $data->locale('pt-br')->dayName,
                    'mesCodigo' => $data->locale('pt-br')->month,
                    'mesNome' => $data->locale('pt-br')->monthName,
                    'diaSemanaNomeCurto' => $data->locale('pt-br')->shortDayName,
                    'diaSemanaCodigo' => $data->locale('pt-br')->dayOfWeek,
                ];
            }
            return response()->json([
                'message'=> 'Dias por um período de '.$numeroDias.' dia(s)',
                'dias'=> $datas

            ], 200);
        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 404);
        }

    }

    public function retornarHorariosDisponiveisTodosEspacos(Request $request)
    {
        $espacos = Espaco::all();

        $horariosDisponiveis = collect();

        foreach ($espacos as $espaco) {
            $horariosDisponiveis = $horariosDisponiveis->merge($espaco->horariosDisponiveis);
        }

        return response()->json([
            'data' => $horariosDisponiveis,
        ],200);
    }

    function adicionar_horario($horario, $minutos) {
        $horas_minutos = explode(':', $horario);
        $horas = (int) $horas_minutos[0];
        $minutoss = (int) $horas_minutos[1];
        $minutos += $minutoss;
        $horas += floor($minutos / 60);
        $minutos = $minutos % 60;
        return sprintf('%02d:%02d', $horas, $minutos);
    }


}
