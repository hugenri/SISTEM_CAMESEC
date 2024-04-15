<?php

class Cart {
    protected $cart_contents = array();

    public function __construct(){
        // Obtener el array del carrito de la sesión
        $this->cart_contents = !empty($_SESSION['cart_contents']) ? $_SESSION['cart_contents'] : NULL;

        if ($this->cart_contents === NULL){
            // Establecer algunos valores base
            $this->cart_contents = array('cart_total' => 0, 'total_items' => 0);
        }
    }

    /**
     * Devuelve el array completo del carrito
     * @return array
     */
    public function contents(){
        // Reorganizar los más nuevos primero
        $cart = array_reverse($this->cart_contents);

        // Eliminar elementos que no se deben mostrar en la tabla del carrito
        unset($cart['total_items']);
        unset($cart['cart_total']);

        return $cart;
    }

    /**
     * Devuelve los detalles de un artículo específico en el carrito
     * @param string $unique_identifier
     * @return array|bool
     */
    public function get_item($unique_identifier){
        return (in_array($unique_identifier, array('total_items', 'cart_total'), TRUE) OR ! isset($this->cart_contents[$unique_identifier]))
            ? FALSE
            : $this->cart_contents[$unique_identifier];
    }

    // Otros métodos permanecen sin cambios...

    /**
     * Inserta elementos en el carrito y lo guarda en la sesión
     * @param array $item
     * @return bool|string
     */
    public function insert($item = array()){
        if(!is_array($item) OR count($item) === 0){
            return false;
        }

        if(!isset($item['id'], $item['name'], $item['imagen'], $item['price'], $item['qty'])){
            return FALSE;
        }

        // Insertar artículo
        $item['qty'] = (int) $item['qty'];
        if($item['qty'] == 0){
            return FALSE;
        }

        $item['price'] = (float) $item['price'];
        $unique_identifier = md5($item['id']);

        $previous_quantity = isset($this->cart_contents[$unique_identifier]['qty']) ? (int) $this->cart_contents[$unique_identifier]['qty'] : 0;

        $item['rowid'] = $unique_identifier;
        $item['qty'] += $previous_quantity;

        $this->cart_contents[$unique_identifier] = $item;

        if($this->save_cart()){
            return $unique_identifier;
        }else{
            return FALSE;
        }
    }

    // Otros métodos permanecen sin cambios...

    /**
     * Actualiza el carrito
     * @param array $item
     * @return bool
     */
    public function update($item = array()){
        if (!is_array($item) OR count($item) === 0){
            return FALSE;
        }

        if (!isset($item['rowid'], $this->cart_contents[$item['rowid']])){
            return FALSE;
        }

        // Operaciones de actualización
        // ...

        $this->save_cart();
        return TRUE;
    }

    /**
     * Guarda el array del carrito en la sesión
     * @return bool
     */
    protected function save_cart(){
        $this->cart_contents['total_items'] = $this->cart_contents['cart_total'] = 0;

        foreach ($this->cart_contents as $key => $cart_item){
            // Asegurarse de que el array contenga los índices correctos
            if(!is_array($cart_item) OR !isset($cart_item['price'], $cart_item['qty'])){
                continue;
            }

            $this->cart_contents['cart_total'] += ($cart_item['price'] * $cart_item['qty']);
            $this->cart_contents['total_items'] += $cart_item['qty'];
            $this->cart_contents[$key]['subtotal'] = ($cart_item['price'] * $cart_item['qty']);
        }

        // Si el carrito está vacío, eliminarlo de la sesión
        if(count($this->cart_contents) <= 2){
            unset($_SESSION['cart_contents']);
            return FALSE;
        }else{
            $_SESSION['cart_contents'] = $this->cart_contents;
            return TRUE;
        }
    }

    /**
     * Elimina un artículo del carrito
     * @param int $unique_identifier
     * @return bool
     */
    public function remove($unique_identifier){
        // Eliminar y guardar
        unset($this->cart_contents[$unique_identifier]);
        $this->save_cart();
        return TRUE;
    }

    /**
     * Vacía el carrito y destruye la sesión
     * @return void
     */
    public function clear_cart(){
        $this->cart_contents = array('cart_total' => 0, 'total_items' => 0);
        unset($_SESSION['cart_contents']);
        return empty($this->cart_contents['total_items']) && empty($_SESSION['cart_contents']);
    }
	
	public function getRowCount(){
    // Obtener el array completo del carrito
    $cart = $this->contents();

    // Contar el número de filas en el array
    $rowCount = count($cart);

    return $rowCount;
}

/**
     * Calcula el subtotal, el IVA del 16% y el total del carrito
     * @return array
     */
    public function calculateTotal() {// da error esta funcion
        $subtotal = 0;
        foreach ($this->cart_contents as $cart_item) {
            $subtotal += $cart_item['price'] * $cart_item['qty'];
        }

        $iva = $subtotal * 0.16; // Calcula el IVA del 16%
        $total = $subtotal + $iva; // Calcula el total

        return array(
            'subtotal' => $subtotal,
            'iva' => $iva,
            'total' => $total
        );
    }

}
