# Laravel PowerModel

Forma elegante e eficiente de formatar campos de data, hora e afins ao exibir, colocando somente um sufixo no nome original do atributo sem precisar declarar Accessors e/ou Mutators dentro da model

### Instalação

    composer require gsferro/porwermodel

### Configurar Model

Na model coloquei a trait `PowerModel`

### Uso

    # Para fins de demonstração
    $model = Model::first();

1. Datas:
   - formato de banco para BR
    ```php 
    # original
    $model->created_at // 2021-12-16 12:00:00
    # sufixo
    $model->created_at_fdh // 16/12/2021 12:00:00
    $model->created_at_dhi // 16/12/2021 12:00
    $model->created_at_fmt // 16/12/2021
    $model->created_at_fmr // 12:00
    $model->created_at_rar // 12:00:00
    ```
1. CPF | CNPJ
   - Verifica se o valor é um cpf ou cnpj e coloca a mascara de acordo
   ```php 
    # original
    $model->cpf // 12345678900
    # sufixo
    $model->cpf_inc // 123.456.789-00
    
    # original
    $model->cnpj // 12345678901234
    # sufixo
    $model->cnpj_inc // 12.345.678/9012-34

    # original
    $model->cpf_cnpj // 12345678900 | 12345678901234
    # sufixo
    $model->cpf_cnpj_inc // 123.456.789-00 | 12.345.678/9012-34
    ```
1. Valor Monetário
    ```php
    # original
    $model->valor_unitario // 12345.67
    # sufixo
    $model->valor_unitario_mbr // 12.345,67
    ```
### Uso Avançado    

```php
    # Para fins de demonstração na Model vc tem um Accessors que faz a soma utilizando um relacionamento
    public function getSumValorTotalEstimadoAttribute(): string
    {
        return $this->itens()->sum('valor_total_estimado') ?? 0.00;
    }

    # Invocando
    $model = Model::first();
    $model->sum_valor_total_estimado; // 123456.89
    $model->sum_valor_total_estimado_mbr; // 1.234.567,89
```

### TODO
1. No getAttribute
   1. IP
   1. TelCel
1. Implementar para o setAtribute
1. No caso de empty, devolver um valor padrão que esteja dentro de uma config ao inves de somente ""

### Observações Gerais
1. Na versão do laravel 8.77 foi lançada uma nova abordagem para criar os Accessors e Mutators
1. Fique a vontade para enviar pull-request com mais formatações genéricas para facilitar o uso no dia-a-dia

### License 
    
- MIT License
