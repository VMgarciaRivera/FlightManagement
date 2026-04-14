<?php
interface GetVueloByIdPort {
    public function execute(string $id): ?VueloModel;
}