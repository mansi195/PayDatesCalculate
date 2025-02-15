<?php

class SalaryDatesGenerator {
    
    private $year;
    private $path_to_file;

    public function __construct($year, $path_to_file) {
        $this->year = $year;
        $this->path_to_file = $path_to_file;
    }

    // Function to initiate the checks and process
    public function generate() {
        $this->inputValueChecks();
        $month_dates = $this->getDates();
        $this->createOutputFile($month_dates);
    }

    // Check the inputs (year and file path)
    private function inputValueChecks() {
        // 1. Year value check
        if (!preg_match("@^\d{4}$@", $this->year)) {
            echo "Invalid year value!\n";
            exit;
        }

        // 2. Check file path
        $file_info = pathinfo($this->path_to_file);

        // a. File extension check
        if ($file_info['extension'] !== 'csv') {
            echo "Invalid file! Please enter a proper path with a CSV extension.\n";
            exit;
        }

        // b. If the directory doesn't exist, create it with permissions
        if ($file_info['dirname'] !== '.' && !file_exists($file_info['dirname'])) {
            mkdir($file_info['dirname'], 0777, true);
        }
    }

    // Function to get the salary and bonus dates
    private function getDates() {
        $all_month_dates = [];

        for ($i = 1; $i <= 12; $i++) {
            $last_date = date('Y-m-t', strtotime($this->year . '-' . $i . '-01'));                      # last date of the month
            $last_day = date('l', strtotime($last_date));                                               # day of the last date
        $month_name = date('F', strtotime($last_date));                                                 # month name

            $bonus_date = $this->year . '-' . $i . '-15';                                               # 15th day of the month
            $bonus_day = date('l', strtotime($bonus_date));                                             # day of the 15th

            if ($last_day === 'Saturday')
                $last_date = date('Y-m-d', strtotime("$last_date -1 days"));
            else if ($last_day === 'Sunday')
                $last_date = date('Y-m-d', strtotime("$last_date -2 days"));

            if ($bonus_day === 'Saturday')
                $bonus_date = date('Y-m-d', strtotime("$bonus_date + 4 days"));
            else if ($bonus_day === 'Sunday')
                $bonus_date = date('Y-m-d', strtotime("$bonus_date + 3 days"));

            $all_month_dates[$month_name] = [$last_date, $bonus_date];
        }

        return $all_month_dates;
    }

    // Create output file with salary and bonus dates
    private function createOutputFile($month_dates) {
        $file = fopen($this->path_to_file, "w");
        fputcsv($file, ['Month Name', 'Salary Pay Date', 'Bonus Pay Date']);
        foreach ($month_dates as $month => $dates) {
            fputcsv($file, [$month, $dates[0], $dates[1]]);
        }
        fclose($file);
        echo "File generated successfully at ".$this->path_to_file;
    }
}

// Get user input
$year = readline('Please input the year for which you want to create salary dates: ');
$path_to_file = readline('Output filename: ');

// Create an instance of the SalaryDatesGenerator class
$generator = new SalaryDatesGenerator($year, $path_to_file);

// Generate the salary and bonus dates and create the output file
$generator->generate();

?>