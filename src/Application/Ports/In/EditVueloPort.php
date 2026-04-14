<?php

interface EditVueloPort {
    /**
     * @param EditVueloCommand $command
     * @return void
     */
    public function execute(EditVueloCommand $command): void;
}