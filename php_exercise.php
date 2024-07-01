<?php

declare(strict_types = 1);

// Sample data as a multi-line string
$transactionsData = <<<DATA
Date,Check #,Description,Amount
01/04/2021,7777,Transaction 1,"$150.43"
01/05/2021,,Transaction 2,"$700.25"
01/06/2021,,Transaction 3,"-$1,303.97"
01/07/2021,,Transaction 4,"$46.78"
01/08/2021,,Transaction 5,"$816.87"
01/11/2021,1934,Transaction 6,"-$1,002.53"
01/12/2021,7307,Transaction 7,"$532.22"
01/13/2021,1352,Transaction 8,"-$704.59"
01/14/2021,,Transaction 9,"$98.04"
01/15/2021,,Transaction 10,"-$204.56"
01/25/2021,,Transaction 11,"$1,056.27"
01/26/2021,,Transaction 12,"$550.10"
01/27/2021,,Transaction 13,"-$825.77"
01/28/2021,4250,Transaction 14,"$212.68"
01/29/2021,,Transaction 15,"$195.68"
02/02/2021,9915,Transaction 16,"-$463.75"
02/03/2021,,Transaction 17,"$78.02"
02/04/2021,,Transaction 18,"$268.81"
02/05/2021,,Transaction 19,"$1,360.55"
02/08/2021,,Transaction 20,"-$594.46"
02/09/2021,9125,Transaction 21,"$467.39"
02/10/2021,,Transaction 22,"$39.49"
02/11/2021,7929,Transaction 23,"-$81.87"
02/12/2021,,Transaction 24,"$255.64"
02/12/2021,,Transaction 25,"$13.51"
DATA;

// Convert data to array
$lines = explode(PHP_EOL, $transactionsData);
$headers = str_getcsv(array_shift($lines));

$transactions = [];
$totalIncome = 0.0;
$totalExpense = 0.0;

foreach ($lines as $line) {
    $transaction = str_getcsv($line);
    $amount = floatval(str_replace(['$', ','], '', $transaction[3]));
    
    if ($amount > 0) {
        $totalIncome += $amount;
    } else {
        $totalExpense += $amount;
    }
    
    $transactions[] = $transaction;
}

$netTotal = $totalIncome + $totalExpense;
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Transactions</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                text-align: center;
            }

            table tr th, table tr td {
                padding: 5px;
                border: 1px #eee solid;
            }

            tfoot tr th, tfoot tr td {
                font-size: 20px;
            }

            tfoot tr th {
                text-align: right;
            }
        </style>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th><?php echo $headers[0]; ?></th>
                    <th><?php echo $headers[1]; ?></th>
                    <th><?php echo $headers[2]; ?></th>
                    <th><?php echo $headers[3]; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($transaction[0]); ?></td>
                    <td><?php echo htmlspecialchars($transaction[1]); ?></td>
                    <td><?php echo htmlspecialchars($transaction[2]); ?></td>
                    <td><?php echo htmlspecialchars($transaction[3]); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td><?php echo '$' . number_format($totalIncome, 2); ?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td><?php echo '$' . number_format($totalExpense, 2); ?></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td><?php echo '$' . number_format($netTotal, 2); ?></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
