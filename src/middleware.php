<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

//Retorna um cabeçalho completo da API
$app->add(function ($req, $res, $next) {
    // Resolve a próxima camada do middleware
    $response = $next($req, $res);

    // Adiciona cabeçalhos de segurança e CORS
    return $response
        // Define o tipo de conteúdo como JSON
        ->withHeader('Content-Type', 'application/json')

        // Política de Segurança de Conteúdo (CSP)
        ->withHeader('Content-Security-Policy', "default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self'")

        // Impede que o navegador interprete arquivos como um tipo MIME diferente
        ->withHeader('X-Content-Type-Options', 'nosniff')

        // Impede que a página seja carregada em um iframe
        ->withHeader('X-Frame-Options', 'DENY')

        // Habilita a proteção contra XSS (Cross-Site Scripting)
        ->withHeader('X-XSS-Protection', '1; mode=block')

        // Habilita HTTPS estrito por 1 ano, incluindo subdomínios
        ->withHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload')

        // Controla o envio de informações de referência
        ->withHeader('Referrer-Policy', 'no-referrer')

        // Define permissões para recursos como geolocalização, microfone e câmera
        ->withHeader('Permissions-Policy', 'geolocation=(), microphone=(), camera=()')

        // Controla o cache do navegador
        ->withHeader('Cache-Control', 'no-cache, no-store, must-revalidate')
        ->withHeader('Pragma', 'no-cache')
        ->withHeader('Expires', '0')

        // CORS: Permite acesso de qualquer origem (*)
        ->withHeader('Access-Control-Allow-Origin', '*')

        // CORS: Métodos HTTP permitidos
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')

        // CORS: Cabeçalhos permitidos nas requisições
        ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')

        // CORS: Cabeçalhos expostos para o cliente
        ->withHeader('Access-Control-Expose-Headers', 'X-Custom-Header')

        // CORS: Permite o envio de credenciais (cookies, autenticação)
        ->withHeader('Access-Control-Allow-Credentials', 'true')

        // Configuração de cookies seguros
        ->withHeader('Set-Cookie', 'sessionid=12345; Secure; HttpOnly; SameSite=Strict')

        // Habilita a aplicação de Certificados de Transparência (Certificate Transparency)
        ->withHeader('Expect-CT', 'enforce, max-age=86400')

        // Impede políticas de domínio cruzado
        ->withHeader('X-Permitted-Cross-Domain-Policies', 'none')

        // Impede a abertura automática de downloads
        ->withHeader('X-Download-Options', 'noopen')

        // Remove o cabeçalho "X-Powered-By" para evitar expor informações do servidor
        ->withHeader('X-Powered-By', '');
});


// Middleware para coletar métricas
$app->add(function ($request, $response, $next) use (&$metrics) {
    // Incrementa o total de requisições
    $metrics['total_requests']++;

    // Incrementa a contagem por método HTTP
    $method = $request->getMethod();
    if (!isset($metrics['requests_by_method'][$method])) {
        $metrics['requests_by_method'][$method] = 0; // Inicializa o contador se o método não existir
    }
    $metrics['requests_by_method'][$method]++;
    
    // Inicia o timer para medir o tempo de resposta
    $startTime = microtime(true);

    // Processa a requisição
    $response = $next($request, $response);

    // Calcula o tempo de resposta
    $endTime = microtime(true);
    $responseTime = $endTime - $startTime;
    $metrics['response_times'][] = $responseTime;

    return $response;
});