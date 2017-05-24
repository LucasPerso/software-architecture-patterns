<?php
namespace Evaneos\Archi\Services;

use Evaneos\Archi\Manager\PokemonDataManager;
use Evaneos\Archi\Models\Pokemon;
use Ramsey\Uuid\Uuid;

class PokemonService {
    private $pokemonDataManager;

    /**
     * PokemonService constructor.
     *
     * @param PokemonDataManager $pokemonDataManager
     */
    public function __construct($pokemonDataManager) {
        $this->pokemonDataManager = $pokemonDataManager;
    }

    public function getAllPokemons() {
        return $this->pokemonDataManager->getAll();
    }

    /**
     * @param string $uuid
     * @return Pokemon
     */
    public function getPokemon($uuid) {
        return $this->pokemonDataManager->get($uuid);
    }

    /**
     * @param Pokemon $pokemon
     * @return Pokemon
     */
    public function capture($pokemon) {
        $this->pokemonDataManager->insert($pokemon);
        return $pokemon;
    }

    /**
     * @param String $type
     * @return String
     */
    private function getEvolutionType($type) {
        switch($type) {
            case 'aspicot':
                return 'coconfort';
            case 'coconfort':
                return 'dardargnan';
            case 'bulbizarre':
                return 'herbizarre';
            case 'herbizarre':
                return 'florizarre';
            case 'salameche':
                return 'reptincelle';
            case 'reptincelle':
                return 'dracaufeu';
        }
    }

    /**
     * @param Uuid $uuid
     * @return Pokemon
     */
    public function evolve($uuid) {
        $pokemon = $this->pokemonDataManager->get($uuid);
        if ($pokemon->getLevel() > 6 && $pokemon->getLevel() < 16) {
            $evolvedPokemon = new Pokemon(
                $pokemon->getUuid(),
                $this->getEvolutionType($pokemon->getType()),
                $pokemon->getLevel()
                );
            $this->pokemonDataManager->update($evolvedPokemon);
            return $evolvedPokemon;
        }
        return;
    }
}
