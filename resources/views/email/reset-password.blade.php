@extends('layouts.email.main')
@section('body')
    <table align="center" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
        <tbody>
            <tr>
                <td align="center" style="padding: 40px 0 30px 0;">
                    <h2>
                        Alterar senha.
                    </h2>
                    <p>
                        Olá, clique no botão abaixo para ser redirecionado onde você vai alterar sua senha de acesso.
                    </p>
                    <p>
                       <a type="button" class="mail-button-main" href="{{route('password.reset', ['token' => $token ])}}">Clique aqui</a>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
@endsection

