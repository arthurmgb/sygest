<?php

namespace App\Http\Livewire;

use App\Models\Operation;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Relatorio extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $data = [];

    public $qtd = 10;

    public function resetRelatorio()
    {
        $this->reset('data');
    }

    public function render()
    {

        if (!empty($this->data['inicial'])) {

            $di = $this->data['inicial'] . ' 00:00:00';

            if (empty($this->data['final'])) {

                $this->data['final'] = Carbon::today()->format('Y-m-d');

                $df = $this->data['final'] . ' 23:59:00';
            } else {

                $df = $this->data['final'] . ' 23:59:00';
            }

            $operations = Operation::where('user_id', auth()->user()->id)
                ->whereBetween('created_at', [$di, $df])
                ->latest('id')
                ->paginate($this->qtd);

            $receita_entrada = Operation::where('user_id', auth()->user()->id)
            ->whereBetween('created_at', [$di, $df])
            ->whereIn('tipo', [1])
            ->sum('total');

            $receita_saida = Operation::where('user_id', auth()->user()->id)
            ->whereBetween('created_at', [$di, $df])
            ->whereIn('tipo', [0,3])
            ->sum('total');

            $receita_valor = $receita_entrada - $receita_saida;

            $receita_valor = number_format($receita_valor,2,",",".");

            $operations_count = Operation::where('user_id', auth()->user()->id)
            ->whereBetween('created_at', [$di, $df])
            ->count();

            return view('livewire.relatorio', compact('operations', 'receita_valor', 'operations_count'))
                ->layout('pages.relatorios');
        } else {

            return view('livewire.relatorio')
                ->layout('pages.relatorios');
        }
    }
}
