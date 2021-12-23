<?php

namespace Gsferro\PowerModel\Traits;

use Carbon\Carbon;

trait PowerModel
{
    public function getAttribute($key)
    {
        switch (pwGetSufixo($key)) {
            /*
            |---------------------------------------------------
            | Datas
            |---------------------------------------------------
            */
            case "_fmt":
                $value = self::pwGetOriginalAttribute($key);
                $value = !empty($value) ? Carbon::parse($value)->format('d/m/Y') : "";
            break;
            case "_fmr":
                $value = self::pwGetOriginalAttribute($key);
                $value = !empty($value) ? Carbon::parse($value)->format('H:i') : "";
            break;
            case "_rar":
                $value = self::pwGetOriginalAttribute($key);
                $value = !empty($value) ? Carbon::parse($value)->format('H:i:s') : "";
            break;
            case "_fdh":
                $value = self::pwGetOriginalAttribute($key);
                $value = !empty($value) ? Carbon::parse($value)->format('d/m/Y H:i:s') : "";
            break;
            case "_dhi":
                $value = self::pwGetOriginalAttribute($key);
                $value = !empty($value) ? Carbon::parse($value)->format('d/m/Y H:i') : "";
            break;

            /*
            |---------------------------------------------------
            | CPF | CNPJ
            |---------------------------------------------------
            |
            | Verifica se o valor é um cpf ou cnpj e coloca a
            | mascara de acordo
            |
            */
            case "_inc":
                $value = self::pwGetOriginalAttribute($key);
                $value = !empty($value) ? pwVerifyCpjCnpj($value) : "";
            break;

            /*
            |---------------------------------------------------
            | Valor Monetario
            |---------------------------------------------------
            */
            case "_mbr": // money br
                $value = self::pwGetOriginalAttribute($key);
                $value = !empty($value) ? pwMaskMoneyBr($value) : "";
            break;

            /*
            |---------------------------------------------------
            | TODO
            |---------------------------------------------------
            |
            | IP
            | TelCel
            |
            */

            default:
                $value = self::pwGetOriginalAttribute($key);
        }

        return $value;
    }

    /**
     * Get original atribute
     *
     * @param string $key
     * @return mixed
     */
    private static function pwGetOriginalAttribute(string $key)
    {
        return parent::getAttribute(pwOriginalKey($key));
    }

    /* TODO v2
    public function setAttribute( $key, $value )
    {
        $fmtdate = FALSE;
        $fmttime = FALSE;
        $fmtcpf  = FALSE;
        $suffix  = substr( $key, -4 );

        switch( $suffix )
        {
            case "_fmt":
                $key     = $this->pwOriginalKey($key);
                $fmtdate = TRUE;
            break;
            case "_fmr":
                $key     = $this->pwOriginalKey($key);
                $fmttime = TRUE;
            break;

            case "_rem":
                $key    = $this->pwOriginalKey($key);
                $fmtcpf = TRUE;
            break;
        }

        if( $fmtdate ) $value = !empty( $value ) ? Carbon::createFromFormat( 'd/m/Y', $value ) : "";
        if( $fmttime ) $value = !empty( $value ) ? Carbon::createFromFormat( 'H:i:s', $value . ":00" ) : "";
        if( $fmtcpf )  $value = !empty( $value ) ? Helpers::FCPF( $value ) : "";

        return parent::setAttribute( $key, $value );
    }*/
}