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

    /** Kiểm tra năm nhuận */
    private function isLeapYear(int $year): bool
    {
        return ($year % 400 == 0) || ($year % 4 == 0 && $year % 100 != 0);
    }

    /** Kiểm tra ngày hợp lệ */
    private function isValidDate(int $d, int $m, int $y): bool
    {
        if ($y < 1 || $m < 1 || $m > 12 || $d < 1) return false;

        $daysInMonth = [31, ($this->isLeapYear($y) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        return $d <= $daysInMonth[$m - 1];
    }

    /** Trả về ngày kế tiếp */
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

    /** Trả về thứ mấy trong tuần (tính theo thuật toán Zeller’s Congruence) */
    public function getWeekday(): string
    {
        $d = $this->day;
        $m = $this->month;
        $y = $this->year;

        if ($m < 3) {
            $m += 12;
            $y--;
        }

        // Công thức Zeller (cho lịch Gregorius)
        $k = $y % 100;
        $j = intdiv($y, 100);

        $h = ($d + intdiv(13 * ($m + 1), 5) + $k + intdiv($k, 4) + intdiv($j, 4) + 5 * $j) % 7;
        // 0=Thứ Bảy, 1=Chủ nhật, 2=Thứ Hai,...

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
}
