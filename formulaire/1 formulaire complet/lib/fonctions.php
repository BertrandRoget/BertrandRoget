<?php

/**
 * table_html permet de transformer un tableau PHP en table HTML
 * @param array $array le tableau PHP a transformer
 * @param boolean $updateable Ajoute un lien d'édition si vrai
 * @param string $update_url Lien d'édition pour la ligne
 * @return string table HTML
 */
function table_html($array, $updateable = false, $update_url = '') {
    $table = '<table class="table"><tr>';
    if ($updateable)
        $table .= '<th></th>';
    foreach(array_keys($array[0]) as $key) {
        $table .= '<th>' . $key . '</th>';
    }
    $table .= '</tr>';
    foreach($array as $row) {
        $table .= '<tr>';
        if ($updateable)
            $table .= '<td class="edit"><a href="' . $update_url . '?id=' . $row['id'] .'"><img src="img/edit.png"/></a></td>';
        foreach($row as $value) {
            $table .= '<td>' . $value . '</td>';
        }
        $table .= '</tr>';
    }
    $table .= '</table>';
    
    return $table;
}

/**
 * Redirige le navigateur sur la page $location
 * @param string $location URL de redirection
 */
function redirect($location) {
    header('Location: ' . $location);
    die();
}

/**
 * Récupère la valeur dans $_GET
 * @param string $value La clé dans le tableau $_GET
 * @param string $default La valeur par défaut si $_GET['$value'] est vide
 * @return string La valeur du champ $_GET ou la valeur par défaut 
 */
function getValue($value, $default = '') {
    return !empty($_GET[$value]) ? $_GET[$value] : $default;
}

/**
 * Récupère la valeur transformer en entier dans $_GET
 * @param string $value La clé dans le tableau $_GET
 * @param string $default La valeur par défaut si $_GET['$value'] est vide
 * @return string La valeur du champ $_GET ou la valeur par défaut 
 */
function getInt($value, $default = '') {
    return (int)getValue($value, $default);
}

/**
 * Récupère la valeur dans $_POST
 * @param string $value La clé dans le tableau $_POST
 * @param string $default La valeur par défaut si $_POST['$value'] est vide
 * @return string La valeur du champ $_POST ou la valeur par défaut 
 */
function postValue($value, $default = '') {
    return !empty($_POST[$value]) ? $_POST[$value] : $default;
}

/**
 * Récupère la valeur transformer en entier dans $_POST
 * @param string $value La clé dans le tableau $_POST
 * @param string $default La valeur par défaut si $_POST['$value'] est vide
 * @return string La valeur du champ $_POST ou la valeur par défaut 
 */
function postInt($value, $default = '') {
    return (int)postValue($value, $default);
}

/**
 * getImplode génère la chaine de $_GET à passer en url
 */
function getImplode($key = '', $new_val = '') {
    if ($key != '')
        $_GET[$key] = $new_val;
    return implode('&', array_map(
        function ($value, $key) {
            return $key . '=' . $value;
        }, $_GET, array_keys($_GET)));
}