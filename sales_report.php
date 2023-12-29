<?php
session_start();
include_once("../db.php");

// Handle form submission to change the timeframe
if (isset($_POST['selectTimeframe'])) {
    $selectedTimeframe = $_POST['timeframe'];
    $selectedYear = $_POST['selectedYear'];

    // Set the selected month and week based on user input
    $selectedMonth = isset($_POST['selectedMonth']) ? $_POST['selectedMonth'] : null;
    $selectedWeek = isset($_POST['selectedWeek']) ? $_POST['selectedWeek'] : null;
} else {
    // Default to yearly view if the form is not submitted
    $selectedTimeframe = 'yearly';
    $selectedYear = date("Y"); // Default to the current year
    $selectedMonth = null;
    $selectedWeek = null;
}

// Get the unique years for which there are orders
$uniqueYearsQuery = "SELECT DISTINCT YEAR(date_ordered) AS order_year FROM orders";
$uniqueYearsResult = mysqli_query($conn, $uniqueYearsQuery);
$uniqueYears = mysqli_fetch_all($uniqueYearsResult, MYSQLI_ASSOC);

// Get the unique months and weeks for the selected year
$uniqueMonthsQuery = "SELECT DISTINCT MONTH(date_ordered) AS order_month FROM orders WHERE YEAR(date_ordered) = $selectedYear";
$uniqueMonthsResult = mysqli_query($conn, $uniqueMonthsQuery);
$uniqueMonths = mysqli_fetch_all($uniqueMonthsResult, MYSQLI_ASSOC);

$uniqueWeeksQuery = "SELECT DISTINCT WEEK(date_ordered, 1) AS order_week FROM orders WHERE YEAR(date_ordered) = $selectedYear";
$uniqueWeeksResult = mysqli_query($conn, $uniqueWeeksQuery);
$uniqueWeeks = mysqli_fetch_all($uniqueWeeksResult, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include your head elements here -->
</head>

<body>

    <div class="container">
        <h2>Total Sales</h2>

        <form method="post">
            <label for="timeframe">Select Timeframe:</label>
            <select name="timeframe" id="timeframe">
                <option value="yearly" <?php echo ($selectedTimeframe == 'yearly') ? 'selected' : ''; ?>>Yearly</option>
                <option value="monthly" <?php echo ($selectedTimeframe == 'monthly') ? 'selected' : ''; ?>>Monthly</option>
                <option value="weekly" <?php echo ($selectedTimeframe == 'weekly') ? 'selected' : ''; ?>>Weekly</option>
            </select>

            <label for="selectedYear">Select Year:</label>
            <select name="selectedYear" id="selectedYear">
                <?php foreach ($uniqueYears as $year) : ?>
                    <option value="<?php echo $year['order_year']; ?>" <?php echo ($selectedYear == $year['order_year']) ? 'selected' : ''; ?>><?php echo $year['order_year']; ?></option>
                <?php endforeach; ?>
            </select>

            <?php if ($selectedTimeframe == 'monthly') : ?>
                <label for="selectedMonth">Select Month:</label>
                <select name="selectedMonth" id="selectedMonth">
                    <?php foreach ($uniqueMonths as $month) : ?>
                        <option value="<?php echo $month['order_month']; ?>" <?php echo ($selectedMonth == $month['order_month']) ? 'selected' : ''; ?>><?php echo date("F", mktime(0, 0, 0, $month['order_month'], 1)); ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>

            <?php if ($selectedTimeframe == 'weekly') : ?>
                <label for="selectedWeek">Select Week:</label>
                <select name="selectedWeek" id="selectedWeek">
                    <?php foreach ($uniqueWeeks as $week) : ?>
                        <option value="<?php echo $week['order_week']; ?>" <?php echo ($selectedWeek == $week['order_week']) ? 'selected' : ''; ?>><?php echo $week['order_week']; ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>

            <input type="submit" name="selectTimeframe" value="Show Sales">
        </form>

        <?php
        // Display total sales based on the selected timeframe
        if ($selectedTimeframe == 'yearly') {
            $totalSalesQuery = "SELECT SUM(total_amount) AS total_sales FROM orders WHERE YEAR(date_ordered) = $selectedYear";
            $totalSalesResult = mysqli_query($conn, $totalSalesQuery);
            $totalSales = mysqli_fetch_assoc($totalSalesResult);
            echo "<p>Total sales for year $selectedYear: $" . number_format($totalSales['total_sales'], 2) . "</p>";
        } elseif ($selectedTimeframe == 'monthly') {
            $totalSalesQuery = "SELECT SUM(total_amount) AS total_sales FROM orders WHERE YEAR(date_ordered) = $selectedYear AND MONTH(date_ordered) = $selectedMonth";
            $totalSalesResult = mysqli_query($conn, $totalSalesQuery);
            $totalSales = mysqli_fetch_assoc($totalSalesResult);
            echo "<p>Total sales for month " . date("F", mktime(0, 0, 0, $selectedMonth, 1)) . " in year $selectedYear: $" . number_format($totalSales['total_sales'], 2) . "</p>";
        } elseif ($selectedTimeframe == 'weekly') {
            $totalSalesQuery = "SELECT SUM(total_amount) AS total_sales FROM orders WHERE YEAR(date_ordered) = $selectedYear AND WEEK(date_ordered, 1) = $selectedWeek";
            $totalSalesResult = mysqli_query($conn, $totalSalesQuery);
            $totalSales = mysqli_fetch_assoc($totalSalesResult);
            echo "<p>Total sales for week $selectedWeek in year $selectedYear: $" . number_format($totalSales['total_sales'], 2) . "</p>";
        }
        ?>
   <?php
// Display a table of total item sales based on the selected timeframe
echo "<table class='table'>";
echo "<thead><tr><th>Item ID</th><th>Item Name</th><th>Date Ordered</th><th>Order Qty</th><th>Total Amount</th><th>Order Reference Number</th><th>Order Description</th><th>Order Confirmation Date</th></tr></thead>";
echo "<tbody>";

if ($selectedTimeframe == 'yearly') {
    $itemSalesQuery = "SELECT items.item_id, items.item_name, orders.date_ordered, orders.order_qty, orders.total_amount, orders.order_reference_number, orders.order_description, orders.order_confirmation_date
                    FROM orders
                    JOIN items ON orders.item_id = items.item_id
                    WHERE YEAR(orders.date_ordered) = $selectedYear
                    AND orders.order_status = 'D'";
} elseif ($selectedTimeframe == 'monthly') {

    $itemSalesQuery = "SELECT items.item_id, items.item_name, orders.date_ordered, orders.order_qty, orders.total_amount, orders.order_reference_number, orders.order_description, orders.order_confirmation_date
                    FROM orders
                    JOIN items ON orders.item_id = items.item_id
                    WHERE YEAR(orders.date_ordered) = $selectedYear
                    AND MONTH(orders.date_ordered) = $selectedMonth
                    AND orders.order_status = 'D'";
} elseif ($selectedTimeframe == 'weekly') {
    if ($selectedWeek == 'all' ? '' : "AND WEEK(orders.date_ordered, 1) = $selectedWeek") {
        // Display sales for all weeks in the selected month
        $itemSalesQuery = "SELECT items.item_id, items.item_name, orders.date_ordered, orders.order_qty, orders.total_amount, orders.order_reference_number, orders.order_description, orders.order_confirmation_date
                        FROM orders
                        JOIN items ON orders.item_id = items.item_id
                        WHERE YEAR(orders.date_ordered) = $selectedYear
                        AND MONTH(orders.date_ordered) = $selectedMonth
                        AND orders.order_status = 'D'";
    } else {
        // Display sales for the selected week in the selected month
        $itemSalesQuery = "SELECT items.item_id, items.item_name, orders.date_ordered, orders.order_qty, orders.total_amount, orders.order_reference_number, orders.order_description, orders.order_confirmation_date
                        FROM orders
                        JOIN items ON orders.item_id = items.item_id
                        WHERE YEAR(orders.date_ordered) = $selectedYear
                        AND MONTH(orders.date_ordered) = $selectedMonth
                        AND WEEK(orders.date_ordered, 1) = $selectedWeek
                        AND orders.order_status = 'D'";
    }
}

$itemSalesResult = mysqli_query($conn, $itemSalesQuery);

if ($itemSalesResult) {
    while ($itemSale = mysqli_fetch_assoc($itemSalesResult)) {
        echo "<tr>";
        echo "<td>{$itemSale['item_id']}</td>";
        echo "<td>{$itemSale['item_name']}</td>";
        echo "<td>{$itemSale['date_ordered']}</td>";
        echo "<td>{$itemSale['order_qty']}</td>";
        echo "<td>{$itemSale['total_amount']}</td>";
        echo "<td>{$itemSale['order_reference_number']}</td>";
        echo "<td>{$itemSale['order_description']}</td>";
        echo "<td>{$itemSale['order_confirmation_date']}</td>";
        echo "</tr>";
    }
} else {
    echo "Error executing query: " . mysqli_error($conn);
}

echo "</tbody></table>";
?>
    </div>
</body>

</html>