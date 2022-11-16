@extends('layouts.user')
@section('content')
<!-- Page info -->
<div class="page-top-info">
    <div class="container">
        <h4>Política de Privacidade</h4>
        <div class="site-pagination">
            <a href="{{route('home')}}">Home</a> /
            Política de Privacidade
        </div>
    </div>
</div>
<div class="container">
    <div class="footer-logo text-center">
        <a href="index.html"><img src="{{asset('./img/logo-light.png')}}" alt=""></a>
    </div>
    <blockquote class="blockquote">
        <h3 class="text-center">Política de Privacidade</h3>
        <p class="text-center institucional">
            Na Laravel Shop, privacidade e segurança são prioridades e nos comprometemos com a transparência do tratamento de dados pessoais dos nossos usuários/clientes. Por isso, esta presente Política de Privacidade estabelece como é feita a coleta, uso e transferência de informações de clientes ou outras pessoas que acessam ou usam nosso site.
Ao utilizar nossos serviços, você entende que coletaremos e usaremos suas informações pessoais nas formas descritas nesta Política, sob as normas de Proteção de Dados (LGPD, Lei Federal 13.709/2018), das disposições consumeristas da Lei Federal 8078/1990 e as demais normas do ordenamento jurídico brasileiro aplicáveis.
        </p>
    </blockquote>
    <blockquote class="blockquote">
        <h3 class="text-center">1. Quais dados coletamos sobre você e para qual finalidade?</h3>
        <p class="text-center institucional">
            Nosso site coleta e utiliza alguns dados pessoais seus, de forma a viabilizar a prestação de serviços e aprimorar a experiência de uso.
        </p>
        <h3 class="text-center">1.1. Dados pessoais fornecidos pelo titular</h3>
            <ul class="text-center list-unstyled">
                <li>*  Nome (para sua identificação)</li>
                <li>*  Número de telefone (para entrarmos em contato, caso necessário)</li>
                <li>*  Endereço (para enviar as encomendas via Correios)</li>
                <li>* E-mail (para você receber todas as etapas do seu pedido</li>
            </ul>
        </p>
    </blockquote>
    <blockquote class="blockquote">
        <h3 class="text-center">2. Como coletamos os seus dados?</h3>
        <p class="text-center institucional">
            Nesse sentido, a coleta dos seus dados pessoais ocorre da seguinte forma: <b>O seus dados</b> são usados exclusivamente para o cadastro de cliente (que é realizado por você). De maneira nenhuma podemos disponibilizar seus dados para terceiros.
          <b>Seus dados bancários</b> também são utilizados apenas para o processo de pagamento da compra. Não sendo armazenado em nosso banco de dados após a efetivação da compra.
        </p>
        <h3 class="text-center">2.1. Consentimento</h3>
        <p class="text-center institucional">É a partir do seu consentimento que tratamos os seus dados pessoais. O consentimento é a manifestação livre, informada e inequívoca pela qual você autoriza a Laravel Shop a tratar seus dados.
            Assim, em consonância com a Lei Geral de Proteção de Dados, seus dados só serão coletados, tratados e armazenados mediante prévio e expresso consentimento. 
            O seu consentimento será obtido de forma específica para cada finalidade acima descrita, evidenciando o compromisso de transparência e boa-fé da Laravel Shop para com seus usuários/clientes, seguindo as regulações legislativas pertinentes.
            Ao utilizar os serviços da Laravel Shop e fornecer seus dados pessoais, você está ciente e consentindo com as disposições desta Política de Privacidade, além de conhecer seus direitos e como exercê-los.
            A qualquer tempo e sem nenhum custo, você poderá revogar seu consentimento.
            É importante destacar que a revogação do consentimento para o tratamento dos dados pode implicar a impossibilidade da performance adequada de alguma funcionalidade do site que dependa da operação. Tais consequências serão informadas previamente.
        </p>
        <p class="text-center institucional">Em caso de dúvidas ou sugestões sobre nossa política de privacidade, entre em contato pelo e-mail <a target="_blank" href="">contato@fortunashop.com</a>.</p>
    </blockquote>
</div>
<!-- Page info end -->
@endsection
