<?php
namespace App\Services\Payment\Basket;
interface BasketInterface{

    /**
     * @param int $id
     * @return mixed
     */
    public function add(int $id);

    /**
     * @return mixed
     */
    public function get();

    /**
     * @param int $id
     * @return mixed
     */
    public function remove(int $id);

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id);

    /**
     * @param int $id
     * @return mixed
     */
    public function decrease(int $id);

    /**
     * @return array
     */
    public function getFull():array;
}

