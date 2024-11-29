<?php 
    include '../../model/loginModel.php';
    include '../../model/chartModel.php';
    accessPermission();
    $tabTitle = "Graphique des paiements";
    $pageTitle = "Graphique des paiements";
?>

<?php include '../../assets/sidebar.php'; ?>

<div class="container mt-2">

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs mb-3" id="chartTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="daily-tab" data-bs-toggle="tab" href="#daily" role="tab" aria-controls="daily" aria-selected="true">Quotidien</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="weekly-tab" data-bs-toggle="tab" href="#weekly" role="tab" aria-controls="weekly" aria-selected="false">Hebdomadaire</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="monthly-tab" data-bs-toggle="tab" href="#monthly" role="tab" aria-controls="monthly" aria-selected="false">Mensuel</a>
        </li>
    </ul>

    <div class="card shadow mb-4">
        <div class="card-header">
            <h5>
                <strong><i class="bi bi-bar-chart-fill mx-1"></i> Graphique des paiements</strong>
            </h5>
        </div>
        <div class="card-body">


            <!-- Tab Content -->
            <div class="tab-content mt-4">
                <!-- Daily Chart -->
                <div class="tab-pane fade show active" id="daily" role="tabpanel" aria-labelledby="daily-tab">
                    <canvas id="dailyChart" style="max-height: 500px"></canvas>
                </div>
                <!-- Weekly Chart -->
                <div class="tab-pane fade" id="weekly" role="tabpanel" aria-labelledby="weekly-tab">
                    <canvas id="weeklyChart" style="max-height: 500px"></canvas>
                </div>
                <!-- Monthly Chart -->
                <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                    <canvas id="monthlyChart" style="max-height: 500px"></canvas>
                </div>
            </div>
        </div>
    </div>

    <?php include('../../assets/footer.php'); ?>
</div>

<script src="../../public/js/chart.cdn.js"></script>
<script src="../../public/js/sidebar.js"></script>
<script src="../../public/js/bootstrap.js"></script>
<script src="../../public/js/jquery.min.js"></script>
<script src="../../public/js/main.js"></script>

<script>
    // Data for Daily Chart
    var dailyLabels = <?php echo json_encode(array_column($data['daily'], 'payment_date')); ?>;
    var dailyData = <?php echo json_encode(array_column($data['daily'], 'total_amount')); ?>;

    // Data for Weekly Chart
    var weeklyLabels = <?php echo json_encode(array_column($data['weekly'], 'payment_week')); ?>;
    var weeklyData = <?php echo json_encode(array_column($data['weekly'], 'total_amount')); ?>;

    // Data for Monthly Chart
    var monthlyLabels = <?php echo json_encode(array_column($data['monthly'], 'payment_month')); ?>;
    var monthlyData = <?php echo json_encode(array_column($data['monthly'], 'total_amount')); ?>;

    // Initialize Daily Chart
    var dailyCtx = document.getElementById('dailyChart').getContext('2d');
    var dailyChart = new Chart(dailyCtx, {
        type: 'bar',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Daily Payments',
                data: dailyData,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        }
    });

    // Initialize Weekly Chart
    var weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
    var weeklyChart = new Chart(weeklyCtx, {
        type: 'bar',
        data: {
            labels: weeklyLabels,
            datasets: [{
                label: 'Weekly Payments',
                data: weeklyData,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        }
    });

    // Initialize Monthly Chart
    var monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    var monthlyChart = new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Monthly Payments',
                data: monthlyData,
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }]
        }
    });
</script>
