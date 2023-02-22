<?php
function distribute_money($total_amount, $num_people, $max_amount_per_person) {
    // Calculate the maximum amount that can be distributed to all the people
    $max_total_amount = $num_people * $max_amount_per_person;
    $distributed_amount = 0;
    echo "Total Amount: " .$total_amount ."<br>";
    echo "Total No. of People: " .$num_people."<br>";
    echo "Maximum Amount per person: " .$max_amount_per_person."<br>";
    // Check if the total amount is less than the maximum total amount
    if ($total_amount <= $max_total_amount) {
        // Distribute the total amount equally among all the people
        $distributed_amount = $total_amount;
        $amount_per_person = $total_amount / $num_people;
        echo "Each person will get Rs. " . $amount_per_person . "<br/>";
    } else {
        // Distribute the maximum amount per person to each person
        $distributed_amount = $max_total_amount;
        $amount_per_person = $max_amount_per_person;
        echo "Each person will get Rs. " . $amount_per_person . "<br/>";
    }

    // Calculate the remaining amount
    $remaining_amount = $total_amount - $distributed_amount;

    // Return the remaining amount
    return $remaining_amount;
}

// Distribute Rs. 1000 among 5 people, with a maximum of Rs. 200 per person
$remaining_amount = distribute_money(1000, 5, 400);

echo "The remaining amount is Rs. " . $remaining_amount;

?>