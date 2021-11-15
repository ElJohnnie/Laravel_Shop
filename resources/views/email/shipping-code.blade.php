@extends('layouts.email.main')
@section('body')
    <table align="center" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
        <tbody>
            <tr>
                <td align="center" style="padding: 40px 0 30px 0;">
                    <h2>
                        Olá, {{ $userName }}.
                    </h2>
                    <p>
                        
                    </p>
                    <p>
                        O seu código de rastreio de seu pedido: <b>{{ $shippingCode }}</b>.
                    </p>
                    <p>
                        Com ele você pode rastrear seu pedido por: </p>
                    <p>
                        <a href="https://www2.correios.com.br/sistemas/rastreamento/">https://www2.correios.com.br/sistemas/rastreamento/</a>
                    </p>
                    <p>
                        Se seus dados foram corretamente fornecidos, você também pode rastrar pelo seu CPF.
                    </p>
                    <p>
                        Atenciosamente, Glitty Store.
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
@endsection

