<?php

namespace Evaneos\Archi\Controllers;

use Evaneos\Archi\Models\Pokemon;
use Evaneos\Archi\Services\PokemonService;
use Doctrine\DBAL\DBALException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PokemonController
{
    /**
     * @var PokemonService
     */
    private $pokemonService;

    /**
     * PokemonController constructor.
     *
     * @param $pokemonService
     */
    public function __construct($pokemonService)
    {
        $this->pokemonService = $pokemonService;
    }
    /**
     * @return JsonResponse
     *
     * @throws DBALException
     */
    public function pokedex()
    {
        $pokemons = $this->pokemonService->getAllPokemons();
        return new JsonResponse([$pokemons]);
    }

    /**
     * @param string $uuid
     *
     * @return JsonResponse
     *
     * @throws \InvalidArgumentException
     * @throws DBALException
     */
    public function getInformation($uuid)
    {
        $pokemon = $this->pokemonService->getPokemon($uuid);
        if ($pokemon === false) {
            return new JsonResponse(new \stdClass(), 404);
        }

        return new JsonResponse($pokemon);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function capture(Request $request)
    {
        $uuid = Uuid::uuid4();
        $type = $request->get('type');
        $level = (int) $request->get('level');

        $pokemon = new Pokemon($uuid, $type, $level);
        $this->pokemonService->capture($pokemon);
        return new JsonResponse([$pokemon]);
    }

    /**
     * @param string $uuid
     *
     * @return JsonResponse
     */
    public function evolve($uuid)
    {
        $pokemon = $this->pokemonService->evolve($uuid);
        return new JsonResponse($pokemon);
    }
}
