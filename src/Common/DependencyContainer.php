<?php

class DependencyContainer {
    // Aquí guardamos las instancias para no crearlas varias veces (Singleton)
    private array $instances = [];

    // Fabrica el Repositorio de PostgreSQL
    public function getVueloRepository(): VueloRepository {
        if (!isset($this->instances['VueloRepository'])) {
            $this->instances['VueloRepository'] = new VueloRepositoryPostgreSQL();
        }
        return $this->instances['VueloRepository'];
    }

    // Fabrica el Servicio de Crear Vuelo
    public function getCreateVueloService(): CreateVueloPort {
        return new CreateVueloService($this->getVueloRepository());
    }

    // Fabrica el Servicio de Listar Vuelos
    public function getListVuelosService(): ListVuelosPort {
        return new ListVuelosService($this->getVueloRepository());
    }
    
    public function getDeleteVueloService(): DeleteVueloPort {
        return new DeleteVueloService($this->getVueloRepository());
    }

    public function getUpdateVueloService(): EditVueloPort {
        return new EditVueloService($this->getVueloRepository());
    }
    
}