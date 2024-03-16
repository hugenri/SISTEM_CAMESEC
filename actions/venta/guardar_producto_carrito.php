<?php

require_once '../../clases/Cart.php';

require_once '../../model/VentaModel.php';
/*
$productID = $_POST['id'];
$catidad = $_POST['quantity'];
$response = array(); // Inicializar $response

        $ventaModel = new VentaModel(); // Asignar la instancia de VentaModel
        // Obtener detalles del producto
        $itemData = $ventaModel->getProductoId($productID);
        $cart = new Cart();
    
        // Ajustar el formato para que coincida con las expectativas de la función insert
        $productForCart = array(
            'id' => $itemData['id'],
            'name' => $itemData['nombre'],  // Ajusta esto según la estructura de tu tabla
            'imagen' => $itemData['imagen'], 
            'price' => $itemData['precio'], // Ajusta esto según la estructura de tu tabla
            'qty' => $cantidad,  // Puedes ajustar la cantidad predeterminada según tus necesidades
        );
    
        // Intentar agregar el producto al carrito
        $insertItem = $cart->insert($productForCart);
    
        $response = array(); // Inicializar $response
    
        if($insertItem){
            $cartItems = $cart->getRowCount();
            $response['status'] = 'success';
            $response['message'] = 'El producto se agregó correctamente al carrito.';
            $response['cartItems'] = $cartItems;
            return  $response; // Devolver true junto con $response
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error al agregar el producto al carrito.';
            return $response; // Devolver false junto con $response
        }

        */
        $response['status'] = 'success';
        $response['message'] = 'El producto se agregó correctamente al carrito.';
    // Enviar la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();