<?php

function formater_date( $date_str ) {
    $mois = [
        'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
        'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'
    ];

    $d = new DateTime( $date_str );
    $mois_txt = $mois[ ( int )$d->format( 'm' ) - 1 ];

    return 'le '
    . $d->format( 'd' ) . ' '
    . $mois_txt . ' '
    . $d->format( 'Y' ) . ' à '
    . $d->format( 'H' ) . 'h'
    . $d->format( 'i' );
}