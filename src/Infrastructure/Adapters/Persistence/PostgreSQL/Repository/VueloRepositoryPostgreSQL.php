<?php

class VueloRepositoryPostgreSQL implements VueloRepository {
    private PDO $connection;
    private VueloPersistenceMapper $mapper;

    public function __construct() {
        $this->connection = Connection::getInstance();
        $this->mapper = new VueloPersistenceMapper();
    }

    public function save(VueloModel $vuelo): void {
        $data = $this->mapper->fromModelToData($vuelo);
        
        $sql = "INSERT INTO vuelos (
            id, fecha_compra, fecha_salida, fecha_llegada, agencia_viajes, 
            aerolinea, numero_vuelo, estado, valor, cliente, puesto, 
            avion, aeropuerto_salida, aeropuerto_llegada, piloto
        ) VALUES (
            :id, :fecha_compra, :fecha_salida, :fecha_llegada, :agencia_viajes, 
            :aerolinea, :numero_vuelo, :estado, :valor, :cliente, :puesto, 
            :avion, :aeropuerto_salida, :aeropuerto_llegada, :piloto
        )";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($data);
    }

    public function findAll(): array {
        $sql = "SELECT * FROM vuelos ORDER BY created_at DESC";
        $stmt = $this->connection->query($sql);
        $rows = $stmt->fetchAll();

        return array_map(fn($row) => $this->mapper->fromRowToModel($row), $rows);
    }

    public function findById(VueloId $id): ?VueloModel {
        $sql = "SELECT * FROM vuelos WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['id' => $id->value()]);
        $row = $stmt->fetch();

        return $row ? $this->mapper->fromRowToModel($row) : null;
    }

    public function delete(VueloId $id): void {
        $sql = "DELETE FROM vuelos WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['id' => $id->value()]);
    }

    public function update(VueloModel $vuelo): void {
        $data = $this->mapper->fromModelToData($vuelo);
        
        $sql = "UPDATE vuelos SET 
            fecha_compra = :fecha_compra, fecha_salida = :fecha_salida, 
            fecha_llegada = :fecha_llegada, agencia_viajes = :agencia_viajes, 
            aerolinea = :aerolinea, numero_vuelo = :numero_vuelo, 
            estado = :estado, valor = :valor, cliente = :cliente, 
            puesto = :puesto, avion = :avion, aeropuerto_salida = :aeropuerto_salida, 
            aeropuerto_llegada = :aeropuerto_llegada, piloto = :piloto,
            updated_at = CURRENT_TIMESTAMP
            WHERE id = :id";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($data);
    }
}