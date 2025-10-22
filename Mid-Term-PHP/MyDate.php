<?php
class MyDate
{
    private int $day;
    private int $month;
    private int $year;

    public function __construct(int $day, int $month, int $year)
    {
        if (!$this->isValidDate($day, $month, $year)) {
            throw new Exception("Ngày không hợp lệ: $day/$month/$year");
        }
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
    }

    private function isLeapYear(int $year): bool
    {
        return ($year % 400 == 0) || ($year % 4 == 0 && $year % 100 != 0);
    }

    private function isValidDate(int $d, int $m, int $y): bool
    {
        if ($y < 1 || $m < 1 || $m > 12 || $d < 1) return false;

        $daysInMonth = [31, ($this->isLeapYear($y) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        return $d <= $daysInMonth[$m - 1];
    }

    public function nextDay(): MyDate
    {
        $d = $this->day;
        $m = $this->month;
        $y = $this->year;

        $daysInMonth = [31, ($this->isLeapYear($y) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        $d++;
        if ($d > $daysInMonth[$m - 1]) {
            $d = 1;
            $m++;
            if ($m > 12) {
                $m = 1;
                $y++;
            }
        }

        return new MyDate($d, $m, $y);
    }

    public function getWeekday(): string
    {
        $d = $this->day;
        $m = $this->month;
        $y = $this->year;

        if ($m < 3) {
            $m += 12;
            $y--;
        }

        $k = $y % 100;
        $j = intdiv($y, 100);

        $h = ($d + intdiv(13 * ($m + 1), 5) + $k + intdiv($k, 4) + intdiv($j, 4) + 5 * $j) % 7;

        $weekdayVN = [
            0 => "Thứ Bảy",
            1 => "Chủ nhật",
            2 => "Thứ Hai",
            3 => "Thứ Ba",
            4 => "Thứ Tư",
            5 => "Thứ Năm",
            6 => "Thứ Sáu"
        ];

        return $weekdayVN[$h];
    }

    public function __toString(): string
    {
        return sprintf("%02d/%02d/%04d", $this->day, $this->month, $this->year);
    }

    /** Hàm nhập ngày từ bàn phím */
    public static function input(): MyDate
    {
        $day = (int)readline("Nhập ngày: ");
        $month = (int)readline("Nhập tháng: ");
        $year = (int)readline("Nhập năm: ");

        try {
            return new MyDate($day, $month, $year);
        } catch (Exception $e) {
            echo $e->getMessage() . PHP_EOL;
            return self::input(); // nhập lại nếu sai
        }
    }
}
