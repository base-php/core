<?php

/**
 * Dump the passed variables and end the script.
 *
 * @param  mixed
 * @return void
 */
function d($object)
{
    echo '<style>pre { font-family: "Fira Code"; }</style>';
    echo '<pre>';
    print_r($object);
    echo '</pre>';
    exit;
}

/**
 * Verify if the environment is local.
 *
 * @return boolean
 */
function localhost()
{
    if (strpos($_SERVER['HTTP_HOST'], 'localhost')) {
        return true;
    }
    return false;
}

/**
 * Show object/array as table.
 *
 * @param $query object|array
 * @return view
 */
function table($query)
{
    if (empty($query)) {
        return;
    }

    $query = json($query);

    echo '<style>table { margin-top: 5px; font-family: "Fira Code" } table,tr,th,td { border: 1px solid black; font-family: "Fira Code" } </style>';

    echo '<table>';

    $i = 1;

    foreach (json($query) as $item) {
        $keys = get_object_vars($item);

        echo '<tr>';

        foreach ($keys as $key => $value) {
          if ($i == 1) {
              echo '<th>' . $key . '</th>'; 
          }
        }

        $i = $i + 1;

        echo '</tr>';

        echo '<tr>';

        foreach ($keys as $key => $value) {
          echo '<td>' . $value . '</td>';
        }

        echo '</tr>';
    }

    echo '<table>';
}
