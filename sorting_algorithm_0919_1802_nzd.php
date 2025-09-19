<?php
// 代码生成时间: 2025-09-19 18:02:07
use Phalcon\Mvc\Model;

class SortingAlgorithm extends Model
{
    /**
     * Sorts an array using Bubble Sort algorithm
     *
     * @param array $array The array to sort
     * @return array The sorted array
     */
    public function bubbleSort(array $array): array
    {
        if (empty($array)) {
            throw new \Exception("Array is empty");
        }

        $n = count($array);
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
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
     * Sorts an array using Quick Sort algorithm
     *
     * @param array $array The array to sort
     * @return array The sorted array
     */
    public function quickSort(array $array): array
    {
        if (empty($array)) {
            throw new \Exception("Array is empty");
        }

        if (count($array) < 2) {
            return $array;
        }

        $pivot = $array[0];
        $left = [];
        $right = [];

        foreach (array_slice($array, 1) as $value) {
            ($value < $pivot) ? $left[] = $value : $right[] = $value;
        }

        return array_merge($this->quickSort($left), [$pivot], $this->quickSort($right));
    }
}
