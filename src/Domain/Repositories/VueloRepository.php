<?php
interface VueloRepository {
    public function save(VueloModel $vuelo): void;
    public function findById(VueloId $id): ?VueloModel;
    public function findAll(): array;
    public function update(VueloModel $vuelo): void;
    public function delete(VueloId $id): void;
}