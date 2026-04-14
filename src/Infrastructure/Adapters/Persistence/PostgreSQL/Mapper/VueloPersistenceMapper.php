<?php

class VueloPersistenceMapper {
    public function fromRowToModel(array $row): VueloModel {
        return VueloModel::create([
            'id'                => $row['id'],
            'fechaCompra'       => $row['fecha_compra'],
            'fechaSalida'       => $row['fecha_salida'],
            'fechaLlegada'      => $row['fecha_llegada'],
            'agenciaViajes'     => $row['agencia_viajes'],
            'aerolinea'         => $row['aerolinea'],
            'numero'            => $row['numero_vuelo'],
            'estado'            => $row['estado'],
            'valor'             => (float)$row['valor'],
            'cliente'           => $row['cliente'],
            'puesto'            => $row['puesto'],
            'avion'             => $row['avion'],
            'aeropuertoSalida'  => $row['aeropuerto_salida'],
            'aeropuertoLlegada' => $row['aeropuerto_llegada'],
            'piloto'            => $row['piloto']
        ]);
    }

    public function fromModelToData(VueloModel $model): array {
        return [
            'id'                => $model->id()->value(),
            'fecha_compra'      => $model->fechaCompra(),
            'fecha_salida'      => $model->fechaSalida(),
            'fecha_llegada'     => $model->fechaLlegada(),
            'agencia_viajes'    => $model->agenciaViajes(),
            'aerolinea'         => $model->aerolinea(),
            'numero_vuelo'      => $model->numero(),
            'estado'            => $model->estado(),
            'valor'             => $model->valor()->value(),
            'cliente'           => $model->cliente(),
            'puesto'            => $model->puesto(),
            'avion'             => $model->avion(),
            'aeropuerto_salida' => $model->aeropuertoSalida(),
            'aeropuerto_llegada'=> $model->aeropuertoLlegada(),
            'piloto'            => $model->piloto()
        ];
    }
}