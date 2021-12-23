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
                $value = $this->pwGetOriginalAttribute($key);
                $value = !empty($value) ? Carbon::parse($value)->format('d/m/Y') : "";
            break;
            case "_fmr":
                $value = $this->pwGetOriginalAttribute($key);
                $value = !empty($value) ? Carbon::parse($value)->format('H:i') : "";
            break;
            case "_rar":
                $value = $this->pwGetOriginalAttribute($key);
                $value = !empty($value) ? Carbon::parse($value)->format('H:i:s') : "";
            break;
            case "_fdh":
                $value = $this->pwGetOriginalAttribute($key);
                $value = !empty($value) ? Carbon::parse($value)->format('d/m/Y H:i:s') : "";
            break;
            case "_dhi":
                $value = $this->pwGetOriginalAttribute($key);
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
                $value = $this->pwGetOriginalAttribute($key);
                $value = !empty($value) ? pwVerifyCpjCnpj($value) : "";
            break;

            /*
            |---------------------------------------------------
            | Valor Monetario
            |---------------------------------------------------
            */
            case "_mbr": // money br
                $value = $this->pwGetOriginalAttribute($key);
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
                $value = $this->pwGetOriginalAttribute($key, true);
        }

        return $value;
    }

    /**
     * Get original atribute
     *
     * @param string $key
     * @param bool $isOriginal
     * @return mixed
     */
    private function pwGetOriginalAttribute(string $key, bool $isOriginal = false)
    {
        if (is_int(strpos("{$key}", '_sum_'))) {
            return $this->pwSumValueRelationAttribute($key);
        }

        return parent::getAttribute(!$isOriginal ? pwOriginalKey($key) : $key );
    }

    /**
     * Faz o somatorio da coluna via relacionamento
     *
     * @param string $key
     * @return float
     */
    private function pwSumValueRelationAttribute(string $key): float
    {
        $arrayKey = pwGetCollumnRelation($key);
        return $this->{current($arrayKey)}()->sum(next($arrayKey)) ?? 0.00;
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