<?php
// 代码生成时间: 2025-08-12 05:03:04
use Phalcon\Mvc\Model;

class SortingAlgorithm extends Model
{
    
    /**
     * Sorts an array using bubble sort algorithm.
     *
     * @param array $array
     * @return array
     */
    public function bubbleSort(array $array): array
    {
        if (empty($array)) {
            throw new \Exception('Array is empty or not provided.');
        }
        
        $length = count($array);
        for ($i = 0; $i < $length - 1; $i++) {
            for ($j = 0; $j < $length - $i - 1; $j++) {
                if ($array[$j] > $array[$j + 1]) {
                    // Swap elements
                    $temp = $array[$j];
                    $array[$j] = $array[$j + 1];
                    $array[$j + 1] = $temp;
                }
            }
        }
        return $array;
    }

    /**
     * Sorts an array using selection sort algorithm.
     *
     * @param array $array
     * @return array
     */
    public function selectionSort(array $array): array
    {
        if (empty($array)) {
            throw new \Exception('Array is empty or not provided.');
        }
        
        $length = count($array);
        for ($i = 0; $i < $length - 1; $i++) {
            $minIndex = $i;
            for ($j = $i + 1; $j < $length; $j++) {
                if ($array[$j] < $array[$minIndex]) {
                    $minIndex = $j;
                }
            }
            // Swap elements
            $temp = $array[$i];
            $array[$i] = $array[$minIndex];
            $array[$minIndex] = $temp;
        }
        return $array;
    }

    /**
     * Sorts an array using insertion sort algorithm.
     *
     * @param array $array
     * @return array
     */
    public function insertionSort(array $array): array
    {
        if (empty($array)) {
            throw new \Exception('Array is empty or not provided.');
        }
        
        for ($i = 1; $i < count($array); $i++) {
            $key = $array[$i];
            $j = $i - 1;
            while ($j >= 0 && $array[$j] > $key) {
                $array[$j + 1] = $array[$j];
                $j--;
            }
            $array[$j + 1] = $key;
        }
        return $array;
    }

}
