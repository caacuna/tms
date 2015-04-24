<?php

namespace Tms;

/**
 * Class Pasajero
 *
 * @package Tms
 */
class Pasajero
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
     * @var string $estado: en_espera, servido
     */
    public $estado;

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

        //estado inicial en espera
        $this->estado = 'en_espera';

        //genero posición inicial aleatoria
        $this->x = rand(0, 1000);
        $this->y = rand(0, 1000);
    }

    /**
     * Imprime el destino de un pasajero
     */
    public function imprimeDestino()
    {
        printf('El destino del pasajero %d es (%d, %d)<br />', $this->id, $this->x, $this->y);
    }
}