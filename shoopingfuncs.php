<?php

function feedshooping() {

    $url = 'http://www.farmaciacalabria.com/producto/';
    $url_image = 'http://www.farmaciacalabria.com/uploads/gallery/thumbs/';
    $folder = $_SERVER['DOCUMENT_ROOT'];
    $url_feed = $folder . '../data/shooping/';
    $culture = 'es';
    $feed_productos = "";
    $feed_cabercera = 'id' . "\t" . 'título' . "\t" . 'marca' . "\t" . 'descripción' . "\t" . 'enlace' . "\t" . 'estado' . "\t" . 'precio' . "\t" . 'disponibilidad' . "\t" . 'enlace imagen' . "\t" . 'mpn' . "\t" . 'categoría en google product' . "\t" . 'categoría' . "\n";

    $query = Doctrine_Query::create()
            ->from('Producto p')
            ->leftJoin('p.Translation t')
            ->andWhere('t.lang = ?', $culture)
            ->andWhere('p.estado = 1')
            ->andWhere('p.precio > 0');
    $productos = $query->execute();

    foreach ($productos as $p) {
        $categoriaGoogle = generacategoriaGoogle($p->getId(), $culture);

        if ($categoriaGoogle) {
            $categoriaWeb = generacategoriaWeb($p->getId(), $culture, $categoriaGoogle);
            $link_prod = $url . $p->getSlug();
            $img_prod = $url_image . '450_' . $p->getSlug() . '.jpg';
            $nombre = $p->getNombre();
            $ref = generampn($p->getReferencia());
            $precio = $p->getPrecio();
            $estado = 'nuevo';
            $stock = 'en stock';
            $id = $p->getId() . $culture;
            $marca = html_entity_decode($p->getMarca(), ENT_QUOTES, 'UTF-8');
            $descripcion = generadescripcion($p->getDescripcion());
            $feed_productos = $feed_productos . $id . "\t" . $nombre . "\t" . $marca . "\t" . $descripcion . "\t" . $link_prod . "\t" . $estado . "\t" . $precio . "\t" . $stock . "\t" . $img_prod . "\t" . $ref . "\t" . $categoriaGoogle->getCategoriaGoogleShooping() . "\t" . $categoriaWeb . "\n";
        }
    }

    try {
        $fichero = fopen($url_feed . 'shooping_' . $culture . '.txt', 'w');              // Abrir el archivo para escribir contenido
        $errorw = fwrite($fichero, $feed_cabercera . $feed_productos);        // Escribir en el archivo
        $errorc = fclose($fichero);
        $feed_generado = 'true';
    } catch (Exception $e) {
        $feed_generado = 'false';
    }

    if ($feed_generado == 'true') {
        echo('feed  generado' . "\n");
        return('true');
    } else {
        echo('Error en la generacion del fichero' . "\n" . 'ERROR: ' . $e . "\n");
        return('false');
    }
}

function generadescripcion($descripcioncortada) {

    $descripcioncortada = str_replace('<strong>Descripci&oacute;n</strong>', "", $descripcioncortada);
    $descripcioncortada = str_replace('<strong>Cantidad</strong>', "", $descripcioncortada);
    $descripcion = strip_tags($descripcioncortada);
    $descripcion = html_entity_decode($descripcion, ENT_QUOTES, 'UTF-8');
    $descripcion = eregi_replace("[\n|\r|\n\r]", ' ', $descripcion);

    return ($descripcion);
}

function generampn($ref) {
    $mpn = '';
    $aux = strrev($ref);
    $pos = strpos($aux, ' ');
    $mpn = substr($aux, 0, $pos);
    $mpn = strrev($mpn);
    $mpn = str_replace(".","",$mpn);

    return($mpn);
}

function generacategoriaGoogle($id, $culture) {
    $shopcat = NULL;
    $query = Doctrine_Query::create()
            ->from('Categorias c')
            ->leftJoin('c.Translation t')
            ->andWhere('t.lang = ?', $culture)
            ->leftJoin('c.CategoriaProducto ct')
            ->andWhere('ct.producto_id = ?', $id)
            ->andWhere('c.estado = 1');
    $categorias = $query->execute();

    foreach ($categorias as $categoria) {
        if ($categoria->getCategoriaGoogleShooping() AND $categoria->getCategoriaGoogleShooping() != '' AND $categoria->getCategoriaGoogleShooping() != ' ') {
            $shopcat = $categoria;
            break;
        }
    }
    return ($shopcat);
}

function generacategoriaWeb($id, $culture, $categoria) {

    if ($categoria) {
        $categoriaweb = '';
        $miarray = array();
        $miarray[] = $categoria->getNombre();
        $padre = $categoria->getPadre();
        while ($padre != NULL) {
            $miarray[] = $padre->getNombre();
            $padre = $padre->getPadre();
        }
        $miarray = (array_reverse($miarray));
        foreach ($miarray as $array) {
            $categoriaweb = $categoriaweb . $array . ' > ';
        }
        $categoriaweb = substr($categoriaweb, 0, -3);
    }

    return ($categoriaweb);
}
