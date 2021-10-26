<?php

/**
 * Show message in debugbar console.
 *
 * @param  mixed
 * @return void
 */
function debugbar(string $message): void
{
    $_ENV['debugbar'][] = $message;
}

/**
 * Verify if the environment is local.
 *
 * @return bool
 */
function localhost(): bool
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
 * @return void
 */
function table(object|array $query): void
{
    if (empty($query)) {
        return;
    }

    $query = json($query);

    echo '<style>table { margin-top: 5px; font-family: "Fira Code" } table,tr,th,td { border: 1px solid black; font-family: "Fira Code"; border-collapse: collapse; } </style>';

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
