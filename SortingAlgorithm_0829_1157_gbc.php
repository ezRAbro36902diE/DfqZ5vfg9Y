<?php
// 代码生成时间: 2025-08-29 11:57:56
class SortingAlgorithm {

    /**
     * Sort an array using Bubble Sort algorithm.
     *
     * @param array $array The array to sort.
     * @return array
     */
    public function bubbleSort(array $array): array {
        $n = count($array);
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                if ($array[$j] > $array[$j + 1]) {
                    // Swap the elements
                    $temp = $array[$j];
                    $array[$j] = $array[$j + 1];
                    $array[$j + 1] = $temp;
                }
            }
        }

        return $array;
    }

    /**
     * Sort an array using Selection Sort algorithm.
     *
     * @param array $array The array to sort.
     * @return array
     */
    public function selectionSort(array $array): array {
        for ($i = 0; $i < count($array) - 1; $i++) {
            // Find the minimum element in unsorted array
            $minIndex = $i;
            for ($j = $i + 1; $j < count($array); $j++) {
                if ($array[$j] < $array[$minIndex]) {
                    $minIndex = $j;
                }
            }
            // Swap the found minimum element with the first element
            $temp = $array[$minIndex];
            $array[$minIndex] = $array[$i];
            $array[$i] = $temp;
        }

        return $array;
    }

    /**
     * Sort an array using Insertion Sort algorithm.
     *
     * @param array $array The array to sort.
     * @return array
     */
    public function insertionSort(array $array): array {
        for ($i = 1; $i < count($array); $i++) {
            $key = $array[$i];
            $j = $i - 1;

            while ($j >= 0 && $array[$j] > $key) {
                $array[$j + 1] = $array[$j];
                $j = $j - 1;
            }
            $array[$j + 1] = $key;
        }

        return $array;
    }

    /**
     * Sort an array using Quick Sort algorithm.
     *
     * @param array $array The array to sort.
     * @return array
     */
    public function quickSort(array $array): array {
        if (count($array) < 2) {
            return $array;
        }

        $left = $right = array();
        $pivot = $array[0];

        for ($i = 1; $i < count($array); $i++) {
            if ($array[$i] < $pivot) {
                $left[] = $array[$i];
            } else {
                $right[] = $array[$i];
            }
        }

        return array_merge($this->quickSort($left), array($pivot), $this->quickSort($right));
    }

}
