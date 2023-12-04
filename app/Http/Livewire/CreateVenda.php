<?php

namespace App\Http\Livewire;

use App\Models\Method;
use App\Models\Product;
use Livewire\Component;

use function PHPUnit\Framework\isNull;

class CreateVenda extends Component
{

    public $produtos;
    public $fps;
    public $selectedProduct = '';
    public $selectedFp = '';
    public $estoqueAtual;
    public $quantidadeAdicionada;
    public $produtosAdicionados = [];
    public $totalVenda;
    public $valorPago;
    public $troco;
    public $desconto;
    public $subtotalVenda;
    public $valorDaFp;

    public $rules = [

        'quantidadeAdicionada' => 'required|numeric|min:1',
        'selectedProduct' => 'required',
        'valorDaFp' => 'required|numeric|min:1',
        'selectedFp' => 'required',

    ];

    protected $messages = [

        'quantidadeAdicionada.required' => 'Campo obrigatório.',
        'quantidadeAdicionada.min' => 'A quantidade dever ser maior que 0.',
        'selectedProduct.required' => 'Campo obrigatório.',
        'valorDaFp.required' => 'Campo obrigatório.',
        'valorDaFp.min' => 'O valor dever ser maior que 0.',
        'selectedFp.required' => 'Campo obrigatório.',

    ];

    public function mount()
    {
        $this->produtos = Product::where('user_id', auth()->user()->id)
            ->where('status', 1)
            ->orderBy('descricao', 'ASC')
            ->get();

        $this->fps = Method::where('user_id', auth()->user()->id)
            ->where('status', 1)
            ->orderBy('descricao', 'ASC')
            ->get();
    }

    public function updatedselectedProduct()
    {
        if (!is_null($this->selectedProduct) and !empty($this->selectedProduct)) {
            $produto = Product::find($this->selectedProduct);
            $this->estoqueAtual = $produto->estoque;
        } else {
            $this->reset('estoqueAtual');
        }
    }

    public function updatedselectedFp()
    {
    }

    public function addProduct()
    {

        $this->validate([
            'selectedProduct' => $this->rules['selectedProduct'],
            'quantidadeAdicionada' => $this->rules['quantidadeAdicionada'],
        ]);


        if (!is_null($this->selectedProduct) and !empty($this->selectedProduct)) {
            $produto = Product::find($this->selectedProduct);

            $subtotal = $produto->preco * $this->quantidadeAdicionada;

            $this->produtosAdicionados[] = [
                'id' => $produto->id,
                'descricao' => $produto->descricao,
                'preco' => $produto->preco,
                'quantidade' => $this->quantidadeAdicionada,
                'subtotal' => $subtotal,
            ];

            $this->reset(['estoqueAtual', 'quantidadeAdicionada']);
            $this->emit('resetSelect');
        }
    }

    public function addFp()
    {

        $this->validate([
            'selectedFp' => $this->rules['selectedFp'],
        ]);

        $this->valorDaFp = str_replace(".", "", $this->valorDaFp);

        $this->valorDaFp = str_replace(',', '.', $this->valorDaFp);

        $this->valorDaFp = floatval($this->valorDaFp);

        $this->validate([
            'valorDaFp' => $this->rules['valorDaFp'],
        ]);

        $this->valorDaFp = number_format($this->valorDaFp, 2, ',', '.');
    }

    public function removeProduct($index)
    {
        if (isset($this->produtosAdicionados[$index])) {
            unset($this->produtosAdicionados[$index]);
        }

        $this->produtosAdicionados = array_values($this->produtosAdicionados);
    }

    public function calcularTotalVenda()
    {
        $total = 0;

        foreach ($this->produtosAdicionados as $produto) {
            $total += $produto['subtotal'];
        }

        return $total;
    }

    public function calcularTrocoSeExistir($totalVenda)
    {
        $calc_valorPago = $this->valorPago;

        $calc_valorPago = str_replace(".", "", $calc_valorPago);

        $calc_valorPago = str_replace(',', '.', $calc_valorPago);

        $calc_valorPago = floatval($calc_valorPago);

        if (!is_null($calc_valorPago)) {
            $total_venda_formatado = str_replace(".", "", $totalVenda);
            $total_venda_formatado = str_replace(',', '.', $total_venda_formatado);

            $total_venda_formatado = floatval($total_venda_formatado);

            if (is_numeric($total_venda_formatado)) {
                return $calc_valorPago - $total_venda_formatado;
            }
        }

        return null;
    }

    public function render()
    {


        $this->totalVenda = $this->calcularTotalVenda();

        $desconto = str_replace(".", "", $this->desconto);
        $desconto = str_replace(',', '.', $desconto);
        $desconto = floatval($desconto);


        if (!is_null($this->totalVenda) and floatval($this->totalVenda) > 0 and floatval($this->valorPago) > 0) {
            $this->troco = $this->calcularTrocoSeExistir($this->totalVenda);
            $this->troco = $this->troco + $desconto;
            $this->troco = number_format($this->troco, 2, ',', '.');
        } else {
            $this->reset('troco', 'desconto');
        }


        if (floatval($this->valorPago > 0)) {

            $this->subtotalVenda = $this->totalVenda - $desconto;
            $this->subtotalVenda = number_format($this->subtotalVenda, 2, ',', '.');
        } else {
            $this->reset('subtotalVenda');
        }


        $this->totalVenda = number_format($this->calcularTotalVenda(), 2, ',', '.');


        return view('livewire.create-venda');
    }
}
