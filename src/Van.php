<?php

namespace Tms;

/**
 * Class Van
 *
 * @package Tms
 */
class Van
{

    /**
     * @var int $count contador para id incremental
     */
    public static $count = 0;

    /**
     * @var int $id id incremental
     */
    public $id;

    /**
     * @var string $estado: disponible, ocupada
     */
    public $estado;

    /**
     * @var int $capacidad la capacidad de la van
     */
    public $capacidad;

    /**
     * @var array $pasajeros arreglo que contiene pasajeros (objetos Pasajero)
     */
    public $pasajeros;

    /**
     * @var int $x coordenada x destino
     */
    public $x;

    /**
     * @var int $y coordenada y destino
     */
    public $y;

    /**
     * Constructor
     */
    public function __construct()
    {
        //asigno id incremental
        self::$count ++;
        $this->id = self::$count;

        //estado inicial disponible
        $this->estado = 'disponible';

        $this->capacidad = 3;//capacidad
        $this->pasajeros = array();//sin pasajeros

        //posición inicial en origen
        $this->x = 0;
        $this->y = 0;
    }


    /**
     * Sube a un pasajero a una van determinada
     *
     * @param Pasajero $pasajero el pasajero
     */
    public function subirPasajero(Pasajero $pasajero)
    {
        //si no tiene pasajeros asigno centro de pasajero
        if (count($this->pasajeros) == 0)
        {
            $this->x = $pasajero->x;
            $this->y = $pasajero->y;
        }

        //asigno pasajero
        $pasajero->estado = 'servido';// cambio de estado del pasajero
        $this->pasajeros[] = $pasajero;
        //pregunto si se llenó, si es así, cambio de estado a ocupada
        if (count($this->pasajeros) == $this->capacidad) $this->estado = 'ocupada';

        //si ya tenia pasajeros entonces recalculo centro promediando los centros de los pasajeros
        if (count($this->pasajeros) >= 2)
        {
            $sumx = 0;
            $sumy = 0;
            for ($p = 0; $p < count($this->pasajeros); $p ++)
            {
                $sumx += $this->pasajeros[$p]->x;
                $sumy += $this->pasajeros[$p]->y;
            }
            $this->x = round($sumx / count($this->pasajeros));
            $this->y = round($sumy / count($this->pasajeros));
        }
    }

    /**
     * Encuentra la mejor van para asignar a un pasajero
     *
     * @param Pasajero $pasajero el pasajero
     * @param array $vans arreglo de vans
     * @return bool si el pasajero pudo ser o no asignado
     */
    static public function asignarPasajero(Pasajero $pasajero, $vans)
    {
        $radio = 100;//radio fijo para el circulo de cada van
        $puntaje = - 1;//almaceno el puntaje de la mejor van hasta el momento (el puntaje mayor gana)
        $mejor_van = null;// para guardar la mejor van

        //recorro todas las vans buscando la mejor
        for ($v = 0; $v < count($vans); $v ++)
        {
            $van = &$vans[$v];
            //solo considero las vans disponibles
            if ($van->estado == 'disponible')
            {
                //si la van está vacia
                if (count($van->pasajeros) == 0 && $puntaje == - 1)
                {
                    $mejor_van = &$van;// la asigno como mejor van
                    $puntaje = 0;// su puntaje es 0, (el puntaje es igual al número de pasajeros)

                    //si la van tiene más pasajeros que el puntaje más alto y el pasajero está en el radio de la van
                } else if (count($van->pasajeros) > $puntaje && sqrt(pow($pasajero->x - $van->x, 2) + pow($pasajero->y - $van->y, 2)) <= $radio)
                {
                    $mejor_van = &$van;// la asigno como mejor van
                    $puntaje = count($van->pasajeros);// su puntaje es igual al número de pasajeros
                }
            }
        }
        //si encontré mejor van lo subo, sino retorno falso
        if ($mejor_van != NULL)
        {
            $mejor_van->subirPasajero($pasajero);

            return true;// el pasajero fue asignado a una van
        }

        return false;// el pasajero no pudo ser asignado a una van
    }

    /**
     * Impreme el destina de una van
     */
    public function imprimeDestino()
    {
        printf('El destino de la van %d es (%d, %d)<br />', $this->id, $this->x, $this->y);
    }

    /**
     * Imprime los pasajeros de un conjunto de vans
     *
     * @param array $vans arreglo de vans
     */
    static public function imprimePasajeros($vans)
    {
        foreach ($vans as $van)
        {
            $string_pasajeros = 'sin pasajeros';
            if (count($van->pasajeros) > 0)
            {
                $pasajeros = array();
                foreach ($van->pasajeros as $pasajero) $pasajeros[] = $pasajero->id;
                $string_pasajeros = implode(',', $pasajeros);
            }
            printf('Pasajeros de la van %d (%d, %d): %s<br />', $van->id, $van->x, $van->y, $string_pasajeros);
        }
    }
}