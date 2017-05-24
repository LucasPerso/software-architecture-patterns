<?php

namespace Evaneos\Archi\Manager;

use Doctrine\DBAL\Connection;
use Evaneos\Archi\Models\Pokemon;
use Ramsey\Uuid\Uuid;

class PokemonDataManager {

    /** @var Connection */
    private $connection;

    /**
     * PokemonController constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return array
     */
    public function getAll() {
        $sql = 'SELECT uuid, type, level FROM pokemon.collection';
        $query = $this->connection->query($sql);

        $pokemons = array_map(function($pokemon) {
            return new Pokemon($pokemon['uuid'], $pokemon['type'], $pokemon['level']);
        }, $query->fetchAll());
        return $pokemons;
    }

    /**
     * @param string $uuid
     * @return Pokemon
     */
    public function get($uuid) {
        $sql = 'SELECT uuid, type, level FROM pokemon.collection WHERE uuid = :uuid';
        $query = $this->connection->prepare($sql);
        $query->bindValue('uuid', $uuid);
        $query->execute();
        $pokemon = $query->fetch();

        return new Pokemon($pokemon['uuid'], $pokemon['type'], $pokemon['level']);
    }

    /**
     * @param Pokemon $pokemon
     */
    public function insert($pokemon) {
        $sql = 'INSERT INTO pokemon.collection (uuid, type, level) VALUES (:uuid, :type, :level)';
        $query = $this->connection->prepare($sql);
        $query->bindValue('uuid', $pokemon->getUuid());
        $query->bindValue('type', $pokemon->getType());
        $query->bindValue('level', $pokemon->getLevel());
        $query->execute();
    }

    /**
     * @param Pokemon $pokemon
     */
    public function update($pokemon) {
        $sql= 'UPDATE pokemon.collection SET type=(:type) WHERE uuid=(:uuid)';
        $query = $this->connection->prepare($sql);
        $query->bindValue('uuid', $pokemon->getUuid());
        $query->bindValue('type', $pokemon->getType());
        $query->execute();
    }
}
