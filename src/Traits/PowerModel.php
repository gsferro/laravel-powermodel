<?php

namespace Gsferro\PowerModel\Traits;

use Carbon\Carbon;

trait PowerModel
{
    public function getAttribute( $key )
    {
        $suffix      = substr( $key, -4 );
        $originalKey = $this->pwOriginalKey($key);

        switch( $suffix )
        {
            /*
            |---------------------------------------------------
            | Datas
            |---------------------------------------------------
            */
            case "_fmt":
                $value = parent::getAttribute( $originalKey );
                $value = !empty( $value ) ? Carbon::parse( $value )->format( 'd/m/Y' ) : "";
            break;
            case "_fmr":
                $value = parent::getAttribute( $originalKey );
                $value = !empty( $value ) ? Carbon::parse( $value )->format( 'H:i' ) : "";
            break;
            case "_rar":
                $value = parent::getAttribute( $originalKey );
                $value = !empty( $value ) ? Carbon::parse( $value )->format( 'H:i:s' ) : "";
            break;
            case "_fdh":
                $value = parent::getAttribute( $originalKey );
                $value = !empty( $value ) ? Carbon::parse( $value )->format( 'd/m/Y H:i:s' ) : "";
            break;
            case "_dhi":
                $value = parent::getAttribute( $originalKey );
                $value = !empty( $value ) ? Carbon::parse( $value )->format( 'd/m/Y H:i' ) : "";
            break;

            // TODO Format cpf|cnpj
            /*case "_inc":
                $value = parent::getAttribute( $originalKey );
                $value = !empty( $value ) ? pwMaskCpf( $value )->format( 'd/m/Y H:i' ) : "";
            break;*/

            /*
            |---------------------------------------------------
            | Valor Monetario
            |---------------------------------------------------
            */
            case "_mbr": // money br
                $value = parent::getAttribute( $originalKey );
                $value = trim( $value ) != "" ? number_format($value, 2, ',', '.') : "";
            break;

            default:
                $value = parent::getAttribute( $key );
        }

        return $value;
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

    private function pwOriginalKey($key)
    {
        return substr($key, 0, -4);
    }
}