<?php
namespace Evaneos\Archi\Models;

use Assert\Assertion;


class Pokemon {
    private static $pokemonList = [
        'pikachu',
        'carapuce',
        'salameche',
        'bulbizarre',
        'chenipan',
        'aspicot',
        'coconfort',
        'dardargnan',
        'roucool',
        'rattata'
    ];
    /**
     * @var integer
     */
    public $uuid;

    /**
     * @var string
     */
    public $type;

    /**
     * @var integer
     */
    public $level;

    /**
     * Pokemon constructor.
     *
     * @param $uuid
     * @param $type
     * @param $level
     *
     */
    public function __construct($uuid, $type, $level)
    {
        Assertion::uuid($uuid);
        Assertion::string($type);
        Assertion::integer($level);
        Assertion::between($level, 1, 30);
        Assertion::inArray($type, self::$pokemonList);

        $this->uuid = $uuid;
        $this->type = $type;
        $this->level = $level;
    }

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }
}
