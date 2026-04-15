<?php
class VueloController
{
    public function __construct(
        private DependencyContainer $container
    ) {}

    // endpoint para CREAR (POST)
    public function create(): void
    {
        // php puro se recibe el JSON del body así
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        try {
            $command = new CreateVueloCommand($data);
            $service = $this->container->getCreateVueloService();
            $service->execute($command);

            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => 'Vuelo creado']);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // Endpoint para listar (get)
    public function list(): void
    {
        $service = $this->container->getListVuelosService();
        $vuelos = $service->execute();

        $result = array_map(function ($vuelo) {
            return [
                'id'                => $vuelo->id()->value(),
                'fechaCompra'       => $vuelo->fechaCompra(),
                'fechaSalida'       => $vuelo->fechaSalida(),
                'fechaLlegada'      => $vuelo->fechaLlegada(),
                'agenciaViajes'     => $vuelo->agenciaViajes(),
                'aerolinea'         => $vuelo->aerolinea(),
                'numero'            => $vuelo->numero(),
                'estado'            => $vuelo->estado(),
                'valor'             => $vuelo->valor()->value(),
                'cliente'           => $vuelo->cliente(),
                'puesto'            => $vuelo->puesto(),
                'avion'             => $vuelo->avion(),
                'aeropuertoSalida'  => $vuelo->aeropuertoSalida(),
                'aeropuertoLlegada' => $vuelo->aeropuertoLlegada(),
                'piloto'            => $vuelo->piloto()
            ];
        }, $vuelos);

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    // endpoint para ELIMINAR (DELETE)
    public function delete(string $id): void
    {
        try {
            $command = new DeleteVueloCommand($id);
            $service = $this->container->getDeleteVueloService();
            $service->execute($command);

            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => "Vuelo $id eliminado"]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // endpoint para EDITAR (PUT)
    public function update(string $id): void
    {
        // se Reciben los nuevos datos del body
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        try {            
            // se agrega el ID que viene de la URL al array de datos
            $data['id'] = $id; // El ID que viene de la URL
            // se ejecuta el servicio de edición
            $command = EditVueloCommand::fromArray($data);
            $service = $this->container->getUpdateVueloService();
            $service->execute($command);

            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'message' => "Vuelo $id actualizado correctamente"
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
