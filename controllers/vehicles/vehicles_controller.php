<?php
namespace app\controllers\vehicles;

use app\controllers\mappers\VehiclesControllerMappers;
use app\models\repositories\VehiclesRepositoryInterface;
use app\models\Vehicle;
use Exception;

class VehiclesController implements VehiclesControllerInterface{
    private VehiclesRepositoryInterface $vehicles_model;
    public function __construct(VehiclesRepositoryInterface $vehicles_model)
    {
    $this->vehicles_model = $vehicles_model;
    }

    public function get_vehicles() : array
    {
     return $this->vehicles_model->get_vehicles_all();    
    }

    public function get_availible_vehicles() : array
     {
     return $this->$vehicles_model->get_vehicles_availible();    
    }
    public function get_vehicle(int $id) : Vehicle
     {
       if (empty($id)) {
        throw new Exception("Debes elegir un vehiculo", 1);
       }    
       $vehicle =$this->vehicles_model_>find_vehicle_by_id($id);
       if (empty($vehicle)) {
        throw new Exception("El vehicle con id $id no existe ", 2);
       }
       return $vehicle;
    }
    public function vehicle_create(array $post_data) : bool 
    {
        $vehicle = VehiclesControllerMappers::to_entity($post_data);

        if ($vehicle_>get_brand()=="" || $vehicle_>get_model() =="")
             {
             throw new Exception("La marca y el modelo son obligatorios.", 3);
        }
         $max_year = (int) date("Y") + 1;
        if ($vehicle->get_year() < 1901 || $vehicle->get_year() > $max_year) {
            throw new Exception("El año debe estar entre 1901 y $max_year.", 4);
        }
        $valid_status = ["disponible", "alquilado", "mantenimiento"];
        if (!in_array($vehicle->get_status(), $valid_status)) {
            throw new Exception("El estado no es válido.", 5);
        }

        return $this->vehicles_model->save_new_vehicle($vehicle);
    }
}
?>