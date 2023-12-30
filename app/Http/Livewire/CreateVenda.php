<?php

namespace App\Http\Livewire;

use App\Models\Method;
use App\Models\Operation;
use App\Models\Operation_Method;
use App\Models\Operation_Product;
use App\Models\Operator;
use App\Models\Product;
use Illuminate\Support\MessageBag;
use Livewire\Component;

class CreateVenda extends Component
{

    protected $listeners = ['render', 'mount'];
    public $produtos;
    public $fps;
    public $operador;
    public $selectedProduct = '';
    public $selectedFp = '';
    public $estoqueAtual;
    public $quantidadeAdicionada;
    public $produtosAdicionados = [];
    public $fpsAdicionadas = [];
    public $totalVenda;
    public $valorPago;
    public $troco;
    public $desconto;
    public $subtotalVenda;
    public $valorDaFp;
    public $tempErrorStyle = false;

    public $rules = [

        'quantidadeAdicionada' => 'required|numeric|min:1',
        'selectedProduct' => 'required',
        'valorDaFp' => 'required|numeric|min:0.01',
        'selectedFp' => 'required',
        'valorPago' => 'required',

    ];

    protected $messages = [

        'quantidadeAdicionada.required' => 'Campo obrigatório.',
        'quantidadeAdicionada.min' => 'A quantidade dever ser maior que 0.',
        'selectedProduct.required' => 'Campo obrigatório.',
        'valorDaFp.required' => 'Campo obrigatório.',
        'valorDaFp.min' => 'O valor dever ser maior que 0.',
        'selectedFp.required' => 'Campo obrigatório.',
        'valorPago.required' => 'Campo obrigatório.',

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

        if (session()->get('operador_selecionado')) {
            $this->operador = Operator::find(session()->get('operador_selecionado')->id);
        } else {
            $this->operador = "";
        }
    }

    public function updatedselectedProduct()
    {

        $produtosEncontrados = [];

        foreach ($this->produtosAdicionados as $prod) {
            if ($prod['id'] == intval($this->selectedProduct)) {
                $produtosEncontrados[] = intval($prod['quantidade']);
            }
        }

        $qtdAdicionada = array_sum($produtosEncontrados);

        if (!is_null($this->selectedProduct) and !empty($this->selectedProduct)) {
            $produto = Product::find($this->selectedProduct);
            $this->estoqueAtual = $produto->estoque - $qtdAdicionada;
            if ($this->estoqueAtual == 0) {
                $this->tempErrorStyle = true;
            } else {
                $this->tempErrorStyle = false;
            }
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


            $qtd_adicionada = intval($this->quantidadeAdicionada);

            if ($this->estoqueAtual >= $qtd_adicionada) {
                $subtotal = $produto->preco * $this->quantidadeAdicionada;

                $this->produtosAdicionados[] = [
                    'id' => $produto->id,
                    'descricao' => $produto->descricao,
                    'preco' => $produto->preco,
                    'quantidade' => $this->quantidadeAdicionada,
                    'subtotal' => $subtotal,
                ];

                $this->emit('resetSelect');
                $this->reset(['estoqueAtual', 'quantidadeAdicionada']);
            } else {
                $this->addError('quantidadeAdicionada', 'Quantidade excede o estoque disponível.');
            }
        }
    }

    public function addFp()
    {

        $this->validate([
            'selectedFp' => $this->rules['selectedFp'],
        ]);

        if (!empty($this->valorDaFp)) {
            $this->valorDaFp = str_replace(".", "", $this->valorDaFp);

            $this->valorDaFp = str_replace(',', '.', $this->valorDaFp);

            $this->valorDaFp = floatval($this->valorDaFp);

            $this->validate([
                'valorDaFp' => $this->rules['valorDaFp'],
            ]);

            $this->valorDaFp = number_format($this->valorDaFp, 2, ',', '.');

            $forma_pag = Method::find($this->selectedFp);

            $this->fpsAdicionadas[] = [
                'id' => $forma_pag->id,
                'descricao' => $forma_pag->descricao,
                'valor' => $this->valorDaFp,
            ];

            $this->reset('valorDaFp');
            $this->emit('resetSelectFp');
        } else {
            $this->validate([
                'valorDaFp' => $this->rules['valorDaFp'],
            ]);
        }
    }

    public function removeProduct($index)
    {
        if (isset($this->produtosAdicionados[$index])) {
            unset($this->produtosAdicionados[$index]);
        }

        $this->produtosAdicionados = array_values($this->produtosAdicionados);

        $this->reset(['estoqueAtual', 'quantidadeAdicionada', 'tempErrorStyle']);
        $this->emit('resetSelect');
    }

    public function removeFp($index)
    {
        if (isset($this->fpsAdicionadas[$index])) {
            unset($this->fpsAdicionadas[$index]);
        }

        $this->fpsAdicionadas = array_values($this->fpsAdicionadas);
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

            $total_venda_formatado = $totalVenda;

            if (is_numeric($total_venda_formatado)) {
                // dd($total_venda_formatado);
                return $calc_valorPago - $total_venda_formatado;
            }
        }

        return null;
    }

    public function finalizarVenda()
    {
        $this->validate([
            'valorPago' => $this->rules['valorPago'],
        ]);

        //VERIFICAR SE HÁ PRODUTOS ADICIONADOS

        if (count($this->produtosAdicionados) === 0) {
            $this->addError('produtosAdicionados', 'Adicione pelo menos um produto à venda.');
            return;
        }

        //VERIFICAR SE HÁ FP(S) ADICIONADA(S)

        if (count($this->fpsAdicionadas) === 0) {
            $this->addError('fpsAdicionadas', 'Adicione pelo menos uma forma de pagamento à venda.');
            return;
        }

        //VERIFICAR TROCO NEGATIVO

        $formatted_troco = str_replace(".", "", $this->troco);
        $formatted_troco = str_replace(',', '.', $formatted_troco);
        $formatted_troco = floatval($formatted_troco);

        if ($formatted_troco < 0) {
            $this->addError('troco', 'O troco não pode ser negativo.');
            return;
        }

        //VERIFICAR SUBTOTAL NEGATIVO

        $formatted_subtotal = str_replace(".", "", $this->subtotalVenda);
        $formatted_subtotal = str_replace(',', '.', $formatted_subtotal);
        $formatted_subtotal = floatval($formatted_subtotal);

        if ($formatted_subtotal < 0) {
            $this->addError('subtotal', 'O subtotal não pode ser negativo.');
            return;
        }
        if ($formatted_subtotal == 0) {
            $this->addError('subtotal', 'O subtotal não pode ser zero.');
            return;
        }

        //VERIFICAR SE O VALOR DA FP OU DAS FPS BATEM COM O SUBTOTAL...

        //...SE MENOR PEDE PARA ADICIONAR MAIS FP, SE MAIOR, PEDE PARA REMOVER UMA OU MAIS FPS

        $totalFormasPagamento = 0;
        foreach ($this->fpsAdicionadas as $formaPagamento) {

            $formatted_formaPag = str_replace(".", "", $formaPagamento['valor']);
            $formatted_formaPag = str_replace(',', '.', $formatted_formaPag);
            $formatted_formaPag = floatval($formatted_formaPag);

            $totalFormasPagamento += $formatted_formaPag;
        }

        if ($totalFormasPagamento < $formatted_subtotal) {

            $faltando = $formatted_subtotal - $totalFormasPagamento;
            $faltando = number_format($faltando, 2, ',', '.');

            $this->addError('fpsAdicionadas', 'Adicione mais formas de pagamento para completar o pagamento. Faltando: R$ ' . $faltando);
            return;
        } elseif ($totalFormasPagamento > $formatted_subtotal) {

            $excedendo = $totalFormasPagamento - $formatted_subtotal;
            $excedendo = number_format($excedendo, 2, ',', '.');

            $this->addError('fpsAdicionadas', 'Remova uma ou mais formas de pagamento para corresponder ao subtotal da venda. Excedendo: R$ ' . $excedendo);
            return;
        }

        //CONCLUINDO A VENDA

        $this->reset(['estoqueAtual', 'quantidadeAdicionada']);
        $this->emit('resetSelect');

        // Abata o estoque no banco de dados
        foreach ($this->produtosAdicionados as $produtoVendido) {

            $produtoModel = Product::find($produtoVendido['id']);
            $produtoModel->estoque -= intval($produtoVendido['quantidade']);
            $produtoModel->save();
        }

        //SALVANDO VENDA NO BANCO

        //FORMATANDO VALORES

        $formattedTotalVenda = str_replace(".", "", $this->totalVenda);
        $formattedTotalVenda = str_replace(',', '.', $formattedTotalVenda);
        $formattedTotalVenda = floatval($formattedTotalVenda);

        $formattedValorPago = str_replace(".", "", $this->valorPago);
        $formattedValorPago = str_replace(',', '.', $formattedValorPago);
        $formattedValorPago = floatval($formattedValorPago);

        $formattedTroco = str_replace(".", "", $this->troco);
        $formattedTroco = str_replace(',', '.', $formattedTroco);
        $formattedTroco = floatval($formattedTroco);

        $formattedDesconto = str_replace(".", "", $this->desconto);
        $formattedDesconto = str_replace(',', '.', $formattedDesconto);
        $formattedDesconto = floatval($formattedDesconto);

        //FIM FORMATANDO VALORES

        $novaVenda = Operation::create([

            'tipo' => 1,
            'descricao' => 'VENDA',
            'is_venda' => 1,
            'operator_id' => $this->operador->id,
            'especie' => 4,
            'total' => $formatted_subtotal,
            'total_venda' => $formattedTotalVenda,
            'valor_pago' => $formattedValorPago,
            'troco' => $formattedTroco,
            'desconto' => $formattedDesconto,
            'user_id' => auth()->user()->id

        ]);

        //SALVANDO PRODUTOS DA VENDA NA TABELA OPERATION_PRODUCTS

        foreach ($this->produtosAdicionados as $produtoVendido) {
            Operation_Product::create([
                'operation_id' => $novaVenda->id,
                'nome_produto' => $produtoVendido['descricao'],
                'preco_unitario' => $produtoVendido['preco'],
                'quantidade_vendida' => $produtoVendido['quantidade'],
                'subtotal_vendido' => $produtoVendido['subtotal'],
            ]);
        }

        //SALVANDO FP'S DA VENDA NA TABELA OPERATION_METHODS

        foreach ($this->fpsAdicionadas as $fpDaVenda) {

            $fpDaVenda['valor'] = str_replace(".", "", $fpDaVenda['valor']);
            $fpDaVenda['valor'] = str_replace(',', '.', $fpDaVenda['valor']);
            $fpDaVenda['valor'] = floatval($fpDaVenda['valor']);

            Operation_Method::create([
                'operation_id' => $novaVenda->id,
                'nome_fp' => $fpDaVenda['descricao'],
                'valor_pago' => $fpDaVenda['valor'],
            ]);
        }


        $this->emit('alert', 'Venda realizada com sucesso!');
        $this->emitTo('visao-geral', 'render');

        $this->reset('produtosAdicionados');
        $this->reset('selectedProduct');
        $this->reset('selectedFp');
        $this->reset('estoqueAtual');
        $this->reset('quantidadeAdicionada');
        $this->reset('fpsAdicionadas');
        $this->reset('totalVenda');
        $this->reset('valorPago');
        $this->reset('troco');
        $this->reset('desconto');
        $this->reset('subtotalVenda');
        $this->reset('valorDaFp');
        $this->reset('tempErrorStyle');
    }

    public function callCancelarVenda()
    {
        $this->dispatchBrowserEvent('show-cancelar-venda');
    }

    public function cancelarVenda()
    {
        $this->reset('produtosAdicionados');
        $this->reset('selectedProduct');
        $this->reset('selectedFp');
        $this->reset('estoqueAtual');
        $this->reset('quantidadeAdicionada');
        $this->reset('fpsAdicionadas');
        $this->reset('totalVenda');
        $this->reset('valorPago');
        $this->reset('troco');
        $this->reset('desconto');
        $this->reset('subtotalVenda');
        $this->reset('valorDaFp');
        $this->reset('tempErrorStyle');
        $this->emit('resetSelect');
        $this->emit('resetSelectFp');

        $this->resetErrorBag();

        $this->emit('alert', 'Venda cancelada com sucesso!');
        $this->dispatchBrowserEvent('hide-cancelar-venda');
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
