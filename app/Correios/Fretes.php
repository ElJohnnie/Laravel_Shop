<?php 

namespace App\Correios;

class Fretes{

    public $return;
    
    public function calcFrete($cep, $wheight, $length, $height, $width, $mainHand, $service, $diameter)
    {
        $glittyCep = 95890000;
        $cepArray = explode('-', $cep);
        $cepOk = implode($cepArray);
        $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem={$glittyCep}&sCepDestino={$cepOk}&nVlPeso={$wheight}&nCdFormato=1&nVlComprimento={$length}&nVlAltura={$height}&nVlLargura={$width}&sCdMaoPropria={$mainHand}&nVlValorDeclarado=0&sCdAvisoRecebimento=n&nCdServico={$service}&nVlDiametro={$diameter}&StrRetorno=xml&nIndicaCalculo=3";
        $xml = simplexml_load_string(file_get_contents($url));
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        $res = $array["cServico"]["Valor"];
        $exploded = explode(',', $res);
        $implodedValor = implode('.', $exploded);
        $res = $array['cServico']['PrazoEntrega'];
        $exploded = explode(',', $res);
        $implodedPrazo = implode('.', $exploded);
        
        $array = [
            'valor'=> $implodedValor,
            'prazo' => $implodedPrazo
        ];
        $array = json_encode($array);
        $this->return = $array;
    }
}

?>