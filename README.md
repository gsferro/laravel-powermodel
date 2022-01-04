# Laravel PowerModel

Forma elegante e eficiente de formatar campos de data, hora e afins, colocando somente um sufixo no nome original do atributo sem precisar declarar Accessors e/ou Mutators dentro da model.
Pode facilmente também exibir um somatório usando relacionamento, sem precisar declarar o Accessor, como visto no [Uso avançado](#uso-avanado)

### Instalação

    composer require gsferro/powermodel

- Caso de algum Problema por conta da sua versão do php (<8.0.0), execute:

   ```text
   composer require gsferro/powermodel --ignore-platform-reqs
   ```

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
    $model->created_at_fdh // sufixo '_fdh' => 16/12/2021 12:00:00
    $model->created_at_dhi // sufixo '_dhi' => 16/12/2021 12:00
    $model->created_at_fmt // sufixo '_fmt' => 16/12/2021
    $model->created_at_fmr // sufixo '_fmr' => 12:00
    $model->created_at_rar // sufixo '_rar' => 12:00:00
    ```
1. CPF | CNPJ - `_inc`
   - Verifica se o valor é um cpf ou cnpj e coloca a mascara de acordo
   ```php 
    # original
    $model->cpf // 12345678900
    # sufixo
    $model->cpf_inc // sufixo '_inc' => 123.456.789-00
    
    # original
    $model->cnpj // 12345678901234
    # sufixo
    $model->cnpj_inc // sufixo '_inc' => 12.345.678/9012-34

    # original
    $model->cpf_cnpj // 12345678900 | 12345678901234
    # sufixo
    $model->cpf_cnpj_inc // sufixo '_inc' => 123.456.789-00 | 12.345.678/9012-34
    ```
1. Valor Monetário - `_mbr` (float)
    ```php
    # original
    $model->valor_unitario // 12345.67
    # sufixo
    $model->valor_unitario_mbr // sufixo '_mbr' =>  12.345,67
    ```
   
1. Valor Numerico - `_nbr` (int)
    ```php
    # original
    $model->valor_numerico // 1234567
    # sufixo
    $model->valor_numerico_nbr // sufixo '_nbr' =>  1.234.567
    ```

1. Email Mascarado - `_msk`
    ```php
    # TODO pegar a configuração da mascara do e-mail via config
   
    # original
    $model->email // "fulano@exemplo.com"
    # sufixo
    $model->email_msk // sufixo '_msk' =>  "f*****o@exemplo.com"
   
    # Caso o campo não seja um email valido, devolvera o valor original:
    $model->email // "fulano#exemplo.com"
    # sufixo
    $model->email_msk // sufixo '_msk' =>  "fulano#exemplo.com"
    ```
   
### Uso Avançado    
- Sum - `<relationName>_sum_<collumn_name>`
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
   
   - Ou você pode simplesmente fazer assim:
   
   ```php
       # Para fins de demonstração na Model vc tem um relacionamento chamado itens
       # Invocando
       $model = Model::first();
       $model->itens_sum_valor_total_estimado; // 123456.89
       # e ainda utilizar a formatação com o sufixo
       $model->itens_sum_valor_total_estimado_mbr; // 1.234.567,89
   ```
- Count - `<relationName>_count_relation`
   ```php
       # Para fins de demonstração na Model vc tem um Accessors que faz o count utilizando um relacionamento
       public function getCountItensEstimadoAttribute(): string
       {
           return $this->itens()->count() ?? 0;
       }
   
       # Invocando
       $model = Model::first();
       $model->itens_count_relation; // 12345689
       $model->itens_count_relation_nbr; // 123.456.789
   ```
   
   - Ou você pode simplesmente fazer assim:
   
   ```php
       # Para fins de demonstração na Model vc tem um relacionamento chamado itens
       # Invocando
       $model = Model::first();
       $model->itens_count_relation; // 12345689
       # e ainda utilizar a formatação com o sufixo
       $model->count_itens_nbr; // 123.456.789
   ```

### Appends
   Caso queria ao invocar a model, já exibir o Accessor, basta colocado no append:

   - Usando o exemplo do [Uso avançado](#uso-avanado)

   1. Sem append:
   ```php
    # Tinker
    >>> $model = Model::first()
    => {
        id: "1",
        created_at: "2021-12-10 15:19:20.697",
        updated_at: "2021-12-10 15:19:20.697",
      }
    $model->sum_valor_total_estimado; // 123456.89
    $model->sum_valor_total_estimado_mbr; // 1.234.567,89
   ```

   1. Com append na model:
   ```php
    protected $appends = [
        'sum_valor_total_estimado',
        'sum_valor_total_estimado_mbr',
    ]; 

    # Tinker
    >>> $model = Model::first()
    => {
        id: "1",
        created_at: "2021-12-10 15:19:20.697",
        updated_at: "2021-12-10 15:19:20.697",
        +sum_valor_total_estimado: "123456.89",
        +sum_valor_total_estimado_mbr: "1.234.567,89",
      }
   ```
   1. Com append usando prefixo de relacionamento, sem precisar criar o Accessor:
   ```php
       protected $appends = [
           'sum_valor_total_estimado',
           'sum_valor_total_estimado_mbr',
           'itens_sum_valor_total_estimado',
           'itens_sum_valor_total_estimado_mbr',
       ]; 
   
       # Tinker
       >>> $model = Model::first()
       => {
           id: "1",
           created_at: "2021-12-10 15:19:20.697",
           updated_at: "2021-12-10 15:19:20.697",
           +sum_valor_total_estimado: "123456.89",
           +sum_valor_total_estimado_mbr: "1.234.567,89",
           +itens_sum_valor_total_estimado: "123456.89",
           +itens_sum_valor_total_estimado_mbr: "1.234.567,89",
         }
      ```

### TODO
1. No getAttribute
   1. Prefixo para soma campo em um relacionamento
   1. IP
   1. TelCel
1. Implementar para o setAtribute
1. No caso de empty, devolver um valor padrão que esteja dentro de uma config ao inves de somente ""

### Observações Gerais
1. Na versão do laravel 8.77 foi lançada uma nova abordagem para criar os Accessors e Mutators
1. Fique a vontade para enviar pull-request com mais formatações genéricas para facilitar o uso no dia-a-dia

### License 
    
- MIT License
