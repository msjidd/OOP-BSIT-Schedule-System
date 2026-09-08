<?php
require_once __DIR__ . '/classes/Schedule.php';
require_once __DIR__ . '/classes/ClassSchedule.php';
require_once __DIR__ . '/classes/ExamSchedule.php';
require_once __DIR__ . '/classes/LaboratorySchedule.php';

session_start();

$pageTitle = 'View Schedules';
$activePage = 'view';

// Retrieve in-memory registry from session
$schedules = isset($_SESSION['schedules']) ? $_SESSION['schedules'] : [];
$lastIndex = isset($_SESSION['last_schedule']) ? $_SESSION['last_schedule'] : -1;
$justCreated = isset($_GET['created']);

// Optional filter by type
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$filtered = [];
foreach ($schedules as $s) {
    if ($filter === 'all' || $s->getType() === $filter) {
        $filtered[] = $s;
    }
}

include __DIR__ . '/includes/header.php';
?>

<div class="card">
    <h1>All Schedules</h1>
    <p class="lead">
    View all saved schedules in one place. Browse class, laboratory, and examination schedules, along with their corresponding details and time information.
    </p>

    <?php if ($justCreated): ?>
        <div class="alert alert-success">
            Schedule successfully created and processed. Data is stored in memory only (no database).
        </div>
    <?php endif; ?>
</div>

<?php if (!empty($schedules)): ?>
    <div class="card">
        <div class="filters">
            <a href="view_schedule.php" class="chip <?php echo $filter === 'all' ? 'active' : ''; ?>">All</a>
            <a href="view_schedule.php?filter=class" class="chip <?php echo $filter === 'class' ? 'active' : ''; ?>">Class</a>
            <a href="view_schedule.php?filter=exam" class="chip <?php echo $filter === 'exam' ? 'active' : ''; ?>">Exam</a>
            <a href="view_schedule.php?filter=laboratory" class="chip <?php echo $filter === 'laboratory' ? 'active' : ''; ?>">Laboratory</a>
        </div>
    </div>

    <div class="card">
        <h2>Schedule List</h2>

        <?php if (empty($filtered)): ?>
            <div class="empty">
                <div class="icon">&#128269;</div>
                <p>No schedules of this type yet.</p>
            </div>
        <?php else: ?>
            <div class="table-wrapper">
                <table class="data">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Summary</th>
                            <th>Category</th>
                            <th>Duration</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($filtered as $i => $sched): ?>
                            <?php
                            $badgeClass = $sched->getType() === 'class' ? 'badge-class'
                                : ($sched->getType() === 'exam' ? 'badge-exam' : 'badge-lab');
                            ?>
                            <tr>
                                <td><?php echo $i + 1; ?></td>
                                <td><?php echo $sched->displaySummary(); ?></td>
                                <td><?php echo $sched->getCategory(); ?></td>
                                <td><?php echo $sched->getDuration(); ?> min</td>
                                <td><span class="badge <?php echo $badgeClass; ?>"><?php echo $sched->getType(); ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

<?php else: ?>
    <div class="card">
        <div class="empty">
            <div class="icon">&#128203;</div>
            <h3>No schedules yet</h3>
            <p style="margin:10px 0 20px;">Create your first schedule using the form.</p>
            <a href="create_schedule.php" class="btn">Create Schedule</a>
        </div>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
