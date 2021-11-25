<?php
/*
Please test and check the following classes using PHP 7.
Find and fix all the issues that this file has.
Make notes for each issue that you found and tell us why that is an issue.
All the issues found with fixes should have along with them the comment / note of why that is an issue.
*/

// namespaces needed in order autoload work properly (as PSR-4 states)

class Order
{
    /** @var OrderItem[] */
    private array $orderItems; // it is a good practice to stick to one coding style. As every method parameter is types, the same should be done with private properties

    /** @var int */
    private int $countItems;

    /** @var int */
    private int $maxPrice;

    /** @var int */
    private int $sumPrice = 0; // can be initialized at first, then updated by calculateTotals()

    public function __construct(array $orderItems) // nullable type shouldn't be used here as calculateTotals() method requires $orderItems to be an array
    {
        $this->orderItems = $orderItems;
        $this->calculateTotals();
    }

    /**
     * @return OrderItem[]
     */
    public function getOrderItems(): array
    {
        return $this->orderItems;
    }

    /**
     * @param OrderItem $orderItem
     */
    public function addOrderItem(OrderItem $orderItem): void
    {
        $this->orderItems[] = $orderItem;
        $this->calculateTotals(); // this method should be called again in order to recalculate properties
    }

    /**
     * @param OrderItem $orderItem // phpdoc here was omitted. It is a good practice to stick to one coding style
     */
    public function removeOrderItem(OrderItem $orderItem): void
    {
        if (($key = array_search($orderItem, $this->orderItems)) !== false) {
            unset($this->orderItems[$key]);
        }
    }

    /**
     * @return int
     */
    public function getCountItems(): int
    {
        return $this->countItems;
    }

    /**
     * @return int
     */
    public function getMaxPrice(): int
    {
        return $this->maxPrice;
    }

    /**
     * @return int
     */
    public function getSumPrice(): int
    {
        return $this->sumPrice;
    }

    private function calculateTotals(): void
    {
        $this->countItems = count($this->orderItems);
        // $this->sumPrice = 0; unnecessary
        foreach ($this->orderItems as $curOrderItem) { // passing by reference is unnecessary here
            $this->sumPrice += $curOrderItem->getPrice();
        }
        //$this->maxPrice = reset($this->orderItems)->getPrice();
        // the method would work quicker if we will update a simple variable rather than private property on every loop
        $max = reset($this->orderItems)->getPrice();
        foreach ($this->orderItems as $curOrderItem) {
            if ($curOrderItem->getPrice() > $max) {
                $max = $curOrderItem->getPrice();
            }
        }
        $this->maxPrice = $max;
    }
}
// another class should rather be stored in separate file in the real life
class OrderItem
{ // opening tag should be on this line as PSR-12 states
    /** @var int */
    private int $price; // just a question: shouldn't the price be better the type of float?

    public function __construct($price) {
        $this->price = $price;
    }

    /**
     * @return int // phpdoc here was omitted. It is a good practice to stick to one coding style
     */
    public function getPrice() {
        return $this->price;
    }
}
