<?php
function get_amount_before_tax($inclusive_amount, $tax_rate = 0.29)
{
    // Calculate the exclusive amount before tax by dividing the inclusive amount by (1 + tax rate)
    $exclusive_amount = $inclusive_amount / (1 + $tax_rate);

    // Round off the amount to 2 decimal places
    $exclusive_amount = round($exclusive_amount, 2);

    echo "Inclusive Amount:" . $inclusive_amount . "<br/>";

    // Return the exclusive amount before tax
    return $exclusive_amount;
}

// Calculate the amount before tax for Rs. 100 (inclusive of 29% tax)
$exclusive_amount = get_amount_before_tax(100);

echo "The amount before tax is Rs. " . $exclusive_amount;
