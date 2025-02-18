<?php

namespace App\Resolver;

use App\GraphQL\Type\DateTimeType;
use App\Service\MutationService;
use App\Service\QueryService;
use ArrayObject;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\ArgumentInterface;
use Overblog\GraphQLBundle\Resolver\ResolverMap;

class CustomResolverMap extends ResolverMap
{

    public function __construct(
        private readonly QueryService $queryService,
        private readonly MutationService $mutationService
    )
    {}

    /**
     * @inheritDoc
     */
    protected function map(): array
    {
        return [
            'DateTime' => [self::SCALAR_TYPE => function () { return new DateTimeType(); }],
            'RootQuery'    => [
                self::RESOLVE_FIELD => function (
                    $value,
                    ArgumentInterface $args,
                    ArrayObject $context,
                    ResolveInfo $info
                ) {
                    return match ($info->fieldName) {
                        'author' => $this->queryService->findAuthorById((int)$args['id']),
                        'authors' => $this->queryService->getAllAuthors(),
                        'findBooksByAuthor' => $this->queryService->findBooksByAuthorName($args['name']),
                        'books' => $this->queryService->findAllBooks(),
                        'findBooksByGenre' => $this->queryService->findBooksByGenre($args['genre']),
                        'book' => $this->queryService->findBookById((int)$args['id']),
                        default => null
                    };
                },
            ],
            'RootMutation' => [
                self::RESOLVE_FIELD => function (
                    $value,
                    ArgumentInterface $args,
                    ArrayObject $context,
                    ResolveInfo $info
                ) {
                    return match ($info->fieldName) {
                        'createAuthor' => $this->mutationService->createAuthor($args['author']),
                        'updateBook' => $this->mutationService->updateBook((int)$args['id'], $args['book']),
                        default => null
                    };
                },
            ],
        ];
    }
}