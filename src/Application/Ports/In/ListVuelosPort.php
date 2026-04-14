<?php
interface ListVuelosPort {
    /** @return VueloModel[] */
    public function execute(): array;
}