<?php
include_once("../configuracion.php");
function generarHTMLMenu($menu) {
    $html = '<ul>';
    foreach ($menu as $item) {
        $html .= "<li>{$item['menombre']}";
        if (!empty($item['subitems'])) {
            $html .= generarHTMLMenu($item['subitems']);
        }
        $html .= '</li>';
    }
    $html .= '</ul>';
    return $html;
}

function construirMenu($menuItems) {
    $menu = [];
    foreach ($menuItems as $item) {
        if ($item['idpadre'] === null) {
            $menu[$item['idmenu']] = $item + ['subitems' => []];
        } else {
            $menu[$item['idpadre']]['subitems'][] = $item;
        }
    }
    return $menu;
}

function obtenerMenuPorRol($idRol) {
    $objMenuRol = new AbmMenuRol();
    $param = ['idrol'=>$idRol->getIdRol()];
    $menues = $objMenuRol->buscar($param);
    return $menues;
}

//$idRol = 1; // Supongamos que el rol del usuario es 1 (esto dependerá de tu sistema de autenticación)
$sesion = new Session();
$rol = $sesion->getRoles();
$idRol = $rol[0];
// Obtener menú del rol
$menuItems = obtenerMenuPorRol($idRol);

// Construir la estructura del menú
$menuEstructura = construirMenu($menuItems);

// Generar HTML del menú
$menuHTML = generarHTMLMenu($menuEstructura);

// Mostrar el menú
echo $menuHTML;



?>