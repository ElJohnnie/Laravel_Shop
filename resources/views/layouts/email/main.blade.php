<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Laravel Shop</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <style>
           .mail-button-main{
                background-color: #E74430;
                color: white;
                padding: 14px 25px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                border: outset 2px #E74430;
                border-radius: 10px;
           }
           .mail-button-main:hover{
                background-color: #E74430;
                color: white;
                padding: 14px 25px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                border: inset 2px #E74430;
                border-radius: 10px;
           }
        </style>
    </head>
    <body>
        <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse; border: 1px solid black">
            <thead align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" bgcolor="#FFFFFF" style="padding: 40px 0 30px 0; border: 1px solid black">
                        <a href="{{ route('home') }}" class="site-logo">
                            <img style="max-width: 50vw;" src="{{ asset('img/logo.png') }}" alt="">
                        </a>
                    </td>
                </tr>

            </thead>
            <tbody>
                <tr>
                    <td bgcolor="#FFFFFF">
                        @yield('body')
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td align="center" bgcolor="#EDEDED" style="padding: 40px 0 30px 0;">
                        Laravel Shop, todos os direitos reservados. 2021.
                    </td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
