<?php

class DependencyContainer
{
    // Aquí guardamos las instancias para no crearlas varias veces (Singleton)
    private array $instances = [];

    // Fabrica el Repositorio de PostgreSQL
    public function getVueloRepository(): VueloRepository
    {
        if (!isset($this->instances['VueloRepository'])) {
            $this->instances['VueloRepository'] = new VueloRepositoryPostgreSQL();
        }
        return $this->instances['VueloRepository'];
    }

    //repositorio de usuarios
    public function getUserRepository(): UserRepository
    {
        if (!isset($this->instances['UserRepository'])) {
            $this->instances['UserRepository'] = new UserRepositoryPostgreSQL();
        }
        return $this->instances['UserRepository'];
    }

    // Fabrica el Servicio de Crear Vuelo
    public function getCreateVueloService(): CreateVueloPort
    {
        return new CreateVueloService($this->getVueloRepository());
    }

    // Fabrica el Servicio de Listar Vuelos
    public function getListVuelosService(): ListVuelosPort
    {
        return new ListVuelosService($this->getVueloRepository());
    }

    public function getDeleteVueloService(): DeleteVueloPort
    {
        return new DeleteVueloService($this->getVueloRepository());
    }

    public function getUpdateVueloService(): EditVueloPort
    {
        return new EditVueloService($this->getVueloRepository());
    }

    public function getLoginService(): LoginService
    {
        return new LoginService($this->getUserRepository());
    }



    public function getForgotPasswordService(): ForgotPasswordService
    {
        return new ForgotPasswordService(
            $this->getUserRepository(),
            new MailEmailSender() // El adaptador de infraestructura
        );
    }

    public function getResetPasswordService(): ResetPasswordService
    {
        return new ResetPasswordService($this->getUserRepository());
    }
}
