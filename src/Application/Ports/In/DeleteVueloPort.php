<?php
interface DeleteVueloPort {
    public function execute(DeleteVueloCommand $command): void;
}