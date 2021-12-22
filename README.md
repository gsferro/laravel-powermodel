# Laravel PowerModel

Forma easy de formar campos de data e hora ao exibir colocando somente um sufixo

### Instalação

    ```text
        composer require gsferro/porwermodel
    ```

### Configurar Model

    1. Na model coloquei a trait `PowerModel`

### Uso

    ```text
        $model = Model::first();

        /*
        |---------------------------------------------------
        | Datas 
        |---------------------------------------------------
        */
        
        # original
        $model->created_at // 2021-12-16 12:00:00
        # sufixo
        $model->created_at_fdh // 16/12/2021 12:00:00
        $model->created_at_dhi // 16/12/2021 12:00
        $model->created_at_fmt // 16/12/2021
        $model->created_at_fmr // 12:00
        $model->created_at_rar // 12:00:00

        /*
        |---------------------------------------------------
        | Valor Monetario 
        |---------------------------------------------------
        */

        # original
        $model->valor_unitario // 12345.67
        # sufixo
        $model->valor_unitario_mbr // 12.345,67
    ```