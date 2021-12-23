<?php

if (!function_exists('pwMask')) {
    /**
     * Adiciona a mascara $mask no $str
     *
     * @param string $mask ###.###.###-##
     * @param string $str
     * @return string
     */
    function pwMask(string $mask, string $str): string
    {
        if (empty($mask) || empty($str)) {
            return $str;
        }

        $str = str_replace(" ", "", $str);
        for ($i = 0; $i < strlen($str); $i++) {
            $mask[ strpos($mask, "#") ] = $str[ $i ];
        }

        return $mask;
    }
}

if (!function_exists('pwRemoveMask')) {
    /**
     * remove os caracteres que geram mascara
     *
     * @param string $valor
     * @return string
     */
    function pwRemoveMask(string $valor): string
    {
        if (empty($valor)) {
            return $valor;
        }

        return
            str_replace(".", "",
                str_replace("-", "",
                    str_replace("/", "",
                        $valor
                    )
                )
            );
    }
}

if (!function_exists('pwMaskCpf')) {
    /**
     * Adiciona a mascara de cpf no $str
     *
     * @param string $cpf
     * @return string
     *@see pwMask()
     */
    function pwMaskCpf(string $cpf): string
    {
        if (strlen($cpf) == 11 || strlen($cpf) == 14) {
            return pwMask("###.###.###-##", pwRemoveMask($cpf));
        }

        return $cpf;
    }
}

if (!function_exists('pwMaskCnpj')) {
    /**
     * Adiciona a mascara de cpf no $str
     *
     * @param string $cnpj
     * @return string
     */
    function pwMaskCnpj(string $cnpj): string
    {
        if (strlen($cnpj) == 14 || strlen($cnpj) == 18) {
            return pwMask("##.###.###/####-##", pwRemoveMask($cnpj));
        }

        return $cnpj;
    }
}

if (!function_exists('pwVerifyCpjCnpj')) {
    /**
     * Adiciona a mascara de cpf no $str
     *
     * @param string $cpfCnpj
     * @return string
     */
    function pwVerifyCpjCnpj(string $cpfCnpj): string
    {
        $i = strlen(pwRemoveMask($cpfCnpj));
        switch ($i) {
            case 11:
                return pwMaskCpf($cpfCnpj);
            case 14:
                return pwMaskCnpj($cpfCnpj);
            default:
                return $cpfCnpj;
        }
    }
}

if (!function_exists('pwMaskMoneyBr')) {
    /**
     * Adiciona a mascara de moneyBr no $value
     *
     * @param float $value
     * @return string
     */
    function pwMaskMoneyBr(float $value): string
    {
        return number_format($value, 2, ',', '.');
    }
}

if (!function_exists('pwOriginalKey')) {
    /**
     * Adiciona a mascara de moneyBr no $value
     *
     * @param string $key
     * @return string
     */
    function pwOriginalKey(string $key): string
    {
        return substr($key, 0, -4);
    }
}

if (!function_exists('pwGetSufixo')) {
    /**
     * Adiciona a mascara de moneyBr no $value
     *
     * @param string $key
     * @return string
     */
    function pwGetSufixo(string $key): string
    {
        return substr( $key, -4 );
    }
}

if (!function_exists('pwGetCollumnRelation')) {
    /**
     * Adiciona a mascara de moneyBr no $value
     *
     * @param string $key
     * @return array
     */
    function pwGetCollumnRelation(string $key): array
    {
        return explode("_",
            str_replace("_mbr", "",
                str_replace("sum_", "",
                    $key
                )
            ),
            2);
    }
}

if (!function_exists('pwMaskEmail')) {
    /**
     * Retorna o email mascarado
     * ex: foo@bar.com => f*****o@bar.com
     *
     * @param string $email
     * @return string
     */
    function pwMaskEmail(string $email): string
    {
        return is_int(strpos($email, '@'))
            ?  substr_replace($email, '*****', 1, strpos($email, '@') - 2)
            : $email
        ;
    }
}
