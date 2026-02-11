<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\OpenApi\Decorator;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\OpenApi;
use Override;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator(decorates: 'lexik_jwt_authentication.api_platform.openapi.factory')]
class LexikJwtAuthenticationOpenApiFactory implements OpenApiFactoryInterface
{
    public function __construct(
        private readonly OpenApiFactoryInterface $decorated,
    ) {
    }

    #[Override]
    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);

        $authTokenPath = $openApi->getPaths()
            ->getPath('/api/auth/token')
        ;

        if ($authTokenPath instanceof PathItem) {
            $postOperation = $authTokenPath->getPost();

            if ($postOperation instanceof Operation) {
                $newPostOperation = $postOperation
                    ->withSummary('Retrieves the JWT token.')
                    ->withDescription('Authenticate user and receive JWT token.')
                    ->withTags(['Authentication'])
                ;

                $newPathItem = $authTokenPath->withPost($newPostOperation);

                $openApi->getPaths()
                    ->addPath('/api/auth/token', $newPathItem)
                ;
            }
        }

        return $openApi;
    }
}
