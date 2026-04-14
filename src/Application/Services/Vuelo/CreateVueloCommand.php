<?php
class CreateVueloCommand {
    public function __construct(
        private array $data
    ) {}

    public function getData(): array {
        return $this->data;
    }
}