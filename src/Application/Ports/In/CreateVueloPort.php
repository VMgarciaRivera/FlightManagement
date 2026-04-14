<?php
interface CreateVueloPort {
    public function execute(CreateVueloCommand $command): void;
}