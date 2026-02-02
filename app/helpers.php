<?php

if (!function_exists('formatIndianPrice')) {
    /**
     * Format price in Indian number format
     * 
     * @param float $amount
     * @param int $decimals
     * @return string
     */
    function formatIndianPrice($amount, $decimals = 2)
    {
        // Convert to string with decimals
        $formatted = number_format($amount, $decimals);
        
        // For Indian formatting, we need to handle the comma placement
        // Indian format: 1,23,456.78 (not 123,456.78)
        
        $parts = explode('.', $formatted);
        $integerPart = $parts[0];
        $decimalPart = isset($parts[1]) ? '.' . $parts[1] : '';
        
        // Remove existing commas
        $integerPart = str_replace(',', '', $integerPart);
        
        // Apply Indian number formatting
        if (strlen($integerPart) > 3) {
            // Get the last 3 digits
            $lastThree = substr($integerPart, -3);
            $remaining = substr($integerPart, 0, -3);
            
            // Add commas every 2 digits for the remaining part (from right to left)
            $remaining = strrev($remaining);
            $remaining = chunk_split($remaining, 2, ',');
            $remaining = strrev($remaining);
            $remaining = ltrim($remaining, ',');
            
            $integerPart = $remaining . ',' . $lastThree;
        }
        
        return $integerPart . $decimalPart;
    }
}

if (!function_exists('formatPrice')) {
    /**
     * Format price with currency symbol in Indian format
     * 
     * @param float $amount
     * @param int $decimals
     * @param string $symbol
     * @return string
     */
    function formatPrice($amount, $decimals = 2, $symbol = '₹')
    {
        return $symbol . formatIndianPrice($amount, $decimals);
    }
}