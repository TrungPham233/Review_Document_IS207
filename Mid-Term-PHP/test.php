<?php
require 'MyDate.php';

try {
    $date = new MyDate(19, 10, 2025);
    echo "Ngày: $date\n";
    echo "Là: " . $date->getWeekday() . "\n";

    $next = $date->nextDay();
    echo "Ngày kế tiếp: $next\n";
    echo "Là: " . $next->getWeekday() . "\n";

    // Thử ngày cuối năm
    $date2 = new MyDate(31, 12, 2024);
    echo "\nNgày: $date2\n";
    echo "Ngày sau: " . $date2->nextDay() . "\n";

} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
}