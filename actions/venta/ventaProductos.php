<?php

include '../clases/Cart.php';
include '../model/VentaModel.php';

class VentaProductos {
    private $ventaModel; // Propiedad para la instancia de VentaModel

    public function __construct() {
        $this->ventaModel = new VentaModel(); // Asignar la instancia de VentaModel
    }

    public function addToCart($productID, $cantidad) {
        // Obtener detalles del producto
        $itemData = $this->ventaModel->getProductoId($productID);
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
            return array(true, $response); // Devolver true junto con $response
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error al agregar el producto al carrito.';
            return array(false, $response); // Devolver false junto con $response
        }
    }
    

    public function getProductos() {
        // Obtener productos utilizando el método correspondiente de VentaModel
        $productos = $this->ventaModel->getProductos();
        
        // Devolver los productos
        return $productos;
    }
}
?>
