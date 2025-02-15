This script is a php-based script designed to generate a CSV file containing the salary and bonus pay dates for employees.

Input
    - Year: The year for which the salary and bonus dates are generated.
    - CSV Output Path: The file path where the resulting CSV will be saved.

Output
    - A CSV file is generated at the specified output path, containing the salary and bonus pay dates for each month of the given year.

Steps Taken:
1. Created the SalaryDatesGenerator Class: This class encapsulates the logic for input validation, date calculation, and CSV generation.
2. Implemented Functionality in the SalaryDatesGenerator Class:
    - Input Validation:
        - Ensure the year is a valid 4-digit number.
        - Validate the output path: If the directory doesn't exist, the script automatically creates the necessary directories.
    - Date Calculation:
        - For each month in the specified year, calculate the salary pay date (last day of the month) and the bonus pay date (15th day of the month). 
        - Adjust these dates if they fall on a weekend (Saturday or Sunday).
    - CSV Generation:
        - Generate a CSV file containing: Month Name, Salary Pay Date, Bonus Pay Date

Conditions:
1. The input values are provided by the user through the command-line interface.
2. Only one year is entered by the user to generate dates for that specific year.