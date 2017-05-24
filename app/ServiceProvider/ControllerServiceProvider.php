<?php

namespace ServiceProvider;

use Evaneos\Archi\Controllers\PokemonController;
use Evaneos\Archi\Manager\PokemonDataManager;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Evaneos\Archi\Services\PokemonService;

class ControllerServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $app A container instance
     */
    public function register(Container $app)
    {
        $app['application.controllers.pokemon'] = function () use ($app) {
            return new PokemonController($app['application.services.pokemon']);
        };

        $app['application.manager.pokemon'] = function () use ($app) {
            return new PokemonDataManager($app['db']);
        };

        $app['application.services.pokemon'] = function () use ($app) {
            return new PokemonService($app['application.manager.pokemon']);
        };
    }
}
