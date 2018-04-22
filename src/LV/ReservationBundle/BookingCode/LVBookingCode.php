<?php

namespace LV\ReservationBundle\BookingCode;


class LVBookingCode
{
    /**
     * Calculer le coût totale t le nombre des billets
     * Récupérer le type d'un ticket 
     */
    
    
    
    public function getRamdomCode ($length)
            
    { 
        /*
        $pool = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        for ($i=0; $i < $length; $i++)
        {
            $key .= $pool[mt_srand(0, count($pool) -1)];
        }
        return $key;
         * 
         */
        $code = '';
        $pool = array_merge(range(0, 9), range('a', 'z'),range('A', 'Z'));

    for($i=0; $i < $length; $i++) {
        $code .= $pool[mt_rand(0, count($pool) - 1)];
    }
    return $code;
    }
}