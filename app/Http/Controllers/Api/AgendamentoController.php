<?php

namespace App\Http\Controllers\Api;

use App\Models\HorariosReservadosEspacos;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Cmixin\BusinessTime;
use BusinessTime\Schedule;
use Spatie\OpeningHours\OpeningHours;
use App\Models\HorariosDisponiveisEspacos;
use App\Models\HorarioFuncionamento;
use App\Enums\DiasSemana;



class AgendamentoController extends Controller
{
    public function horariosFuncionamentoEstabelecimento(){

        $horariosFuncionamentoSegunda = HorarioFuncionamento::where('dia_semana_horario_funcionamento','segunda')->first(['horario_funcionamento']);
        $horariosFuncionamentoTerca = HorarioFuncionamento::where('dia_semana_horario_funcionamento', 'terca')->first(['horario_funcionamento']);
        $horariosFuncionamentoQuarta = HorarioFuncionamento::where('dia_semana_horario_funcionamento', 'quarta')->first(['horario_funcionamento']);
        $horariosFuncionamentoQuinta = HorarioFuncionamento::where('dia_semana_horario_funcionamento', 'quinta')->first(['horario_funcionamento']);
        $horariosFuncionamentoSexta = HorarioFuncionamento::where('dia_semana_horario_funcionamento', 'sexta')->first(['horario_funcionamento']);
        $horariosFuncionamentoSabado = HorarioFuncionamento::where('dia_semana_horario_funcionamento', 'sabado')->first(['horario_funcionamento']);
        $horariosFuncionamentoDomingo = HorarioFuncionamento::where('dia_semana_horario_funcionamento', 'domingo')->first(['horario_funcionamento']);

        return response()->json([
            'message' => 'Horários de funcionamento do estabelecimento retornado com sucesso!',
            'horarios'=> [
                'segunda'=>$horariosFuncionamentoSegunda->horario_funcionamento,
                'terca'=>$horariosFuncionamentoTerca->horario_funcionamento,
                'quarta'=>$horariosFuncionamentoQuarta->horario_funcionamento,
                'quinta'=>$horariosFuncionamentoQuinta->horario_funcionamento,
                'sexta'=>$horariosFuncionamentoSexta->horario_funcionamento,
                'sabado'=>$horariosFuncionamentoSabado->horario_funcionamento,
                'domingo'=>$horariosFuncionamentoDomingo->horario_funcionamento,
            ],
            ], 200);



     }
    public function todosHorariosDisponiveis2(){

        $horariosFuncionamentoSegunda    =      HorarioFuncionamento::where('dia_semana_horario_funcionamento','segunda')->first(['horario_funcionamento_inicio','horario_funcionamento_fim']);
        $horariosFuncionamentoTerca      =      HorarioFuncionamento::where('dia_semana_horario_funcionamento', 'terca')->first(['horario_funcionamento_inicio','horario_funcionamento_fim']);
        $horariosFuncionamentoQuarta     =      HorarioFuncionamento::where('dia_semana_horario_funcionamento', 'quarta')->first(['horario_funcionamento_inicio','horario_funcionamento_fim']);
        $horariosFuncionamentoQuinta     =      HorarioFuncionamento::where('dia_semana_horario_funcionamento', 'quinta')->first(['horario_funcionamento_inicio','horario_funcionamento_fim']);
        $horariosFuncionamentoSexta      =      HorarioFuncionamento::where('dia_semana_horario_funcionamento', 'sexta')->first(['horario_funcionamento_inicio','horario_funcionamento_fim']);
        $horariosFuncionamentoSabado     =      HorarioFuncionamento::where('dia_semana_horario_funcionamento', 'sabado')->first(['horario_funcionamento_inicio','horario_funcionamento_fim']);
        $horariosFuncionamentoDomingo    =      HorarioFuncionamento::where('dia_semana_horario_funcionamento', 'domingo')->first(['horario_funcionamento_inicio','horario_funcionamento_fim']);

        return Carbon::parse('2023-02-27 19:00:00')->locale('pt-br')->dayName;

        $horariosReservados = HorariosReservadosEspacos::all('data_hora_inicio_reservado_espaco', 'data_hora_fim_reservado_espaco');
        return response()->json([
            'message' => 'Horários de funcionamento do estabelecimento retornado com sucesso!',
            'horariosReservados'=> $horariosReservados,
            ], 200);
        dd($horariosReservados);


        $inicio_pretendido = '2023-02-23 19:00:00';
        $final_pretendido = '2023-02-23 20:00:00';

        $inicio_existente = '2023-02-23 14:00:00';
        $final_existente = '2023-02-23 23:00:00';

        $livre = $inicio_pretendido >= $final_existente || $final_pretendido <= $inicio_existente;
        dd($livre);


    }
    public function horariosDisponiveisUmItem($tipo){

    }

    public function todosHorariosDisponiveisk(){
        $horario_de_funcionamento = ['inicio' => '09:00', 'fim' => '18:00'];
        $horarios_agendados = ['10:00', '12:00', '15:00', '16:30'];

        $horarios_disponiveis = [];

        $horario_atual = $horario_de_funcionamento['inicio'];

        while ($horario_atual < $horario_de_funcionamento['fim']) {
            if (!in_array($horario_atual, $horarios_agendados)) {
                $horarios_disponiveis[] = $horario_atual;
            }

            $horario_atual = adicionar_horario($horario_atual, 30); // adicionar 30 minutos
        }
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















    public function todosHorariosDisponiveis($periodo = 'dia')
    {
        $horario_de_funcionamento = ['inicio' => '14:00', 'fim' => '23:00'];

        $horarios_agendados = $this->retornarTodosHorariosAgendados(); // função para obter horários já agendados
        $horariosDisponiveis = $this->calcular_horarios_disponiveis($horario_de_funcionamento, $horarios_agendados);

        return response()->json([
            'message' => 'Horários de funcionamento do estabelecimento retornado com sucesso!',
            'horariosDisponiveis'=> $horariosDisponiveis,
            ], 200);
    }

    public function carregarHorariosDisponveisPorDia(Request $request){

        $dadosRequest = $request->all();

        $diaDaSemanaCodigo = Carbon::parse($dadosRequest['data'])->dayOfWeek;

        return $horario_de_funcionamento = HorarioFuncionamento::where('dia_semana_codigo', $diaDaSemanaCodigo)->get(['horario_funcionamento_inicio', 'horario_funcionamento_fim']);
        $horarios_agendados = $this->retornarTodosHorariosAgendadosPorDia($data); // função para obter horários já agendados
        $horariosDisponiveis = $this->calcular_horarios_disponiveis($horario_de_funcionamento, $horarios_agendados);
    }


    private function retornarTodosHorariosAgendados()
    {
        $horariosReservados = HorariosReservadosEspacos::all('data_hora_inicio_reservado_espaco')
                                    ->pluck('data_hora_inicio_reservado_espaco')
                                    ->toArray();
        return $horariosReservados;
    }
    public function retornarTodosHorariosAgendadosPorDia($data)
    {
        $horariosReservados = HorariosReservadosEspacos::where('data', $data)
                                ->get('data_hora_inicio_reservado_espaco')
                                ->pluck('data_hora_inicio_reservado_espaco')
                                ->toArray();
        return $horariosReservados;
    }

    private function calcular_horarios_disponiveis($horario_de_funcionamento, $horarios_agendados)
    {
        $horarios_disponiveis = [];

        // $horario_de_funcionamento = ['inicio' => '09:00', 'fim' => '18:00'];
        $horario_atual = $horario_de_funcionamento['inicio'];
        // $horarios_agendados = ['10:00', '12:00', '15:00', '16:30'];


        while ($horario_atual < $horario_de_funcionamento['fim']) {
            if (!in_array($horario_atual, $horarios_agendados)) {
                $horarios_disponiveis[] = $horario_atual;
            }

        $horario_atual = $this->adicionar_horario($horario_atual, 60);
        }

        return $horarios_disponiveis;
    }


    // Retornar horários livres do dia

    // Retornar horários ocupados do mês


    // ---- CHAMADAS OK ------//
    public function retornarProximos7Dias(){
        $datas = [];

        for ($i = 0; $i < 7; $i++) {
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
        return response()->json($datas, 200);
    }

}
