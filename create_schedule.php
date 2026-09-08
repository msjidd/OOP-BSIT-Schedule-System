<?php
// Reset any errors from a prior run on fresh visit
$formRequest = null;
include __DIR__ . '/includes/validator.php';

$pageTitle = 'Create Schedule';
$activePage = 'create';

// Capture validation errors carried over from processing
$errors = isset($_GET['errors']) ? json_decode($_GET['errors'], true) : [];
$data   = isset($_GET['data']) ? json_decode($_GET['data'], true) : [];
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<div class="card">
    <h1>Create a Class Schedule</h1>
    <p class="lead">
    Complete the form below to add a new class, laboratory, or examination schedule. Ensure all information is accurate before saving.
    </p>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <strong>Please fix the following:</strong>
            <ul style="margin:8px 0 0 18px;">
                <?php foreach ($errors as $e): ?>
                    <li><?php echo htmlspecialchars($e); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="process_schedule.php" method="post" novalidate>
        <div class="form-group">
            <label for="schedule_type">Schedule Type</label>
            <select name="schedule_type" id="schedule_type" required>
                <option value="">-- Select type --</option>
                <option value="class" <?php echo ($data['schedule_type'] ?? '') === 'class' ? 'selected' : ''; ?>>Class (Lecture)</option>
                <option value="exam" <?php echo ($data['schedule_type'] ?? '') === 'exam' ? 'selected' : ''; ?>>Exam (Periodical)</option>
                <option value="laboratory" <?php echo ($data['schedule_type'] ?? '') === 'laboratory' ? 'selected' : ''; ?>>Laboratory</option>
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="subject_code">Subject Code</label>
                <input type="text" id="subject_code" name="subject_code"
                       value="<?php echo htmlspecialchars($data['subject_code'] ?? ''); ?>" placeholder="e.g. ITEC200" required>
            </div>
            <div class="form-group">
                <label for="subject_name">Subject Name</label>
                <input type="text" id="subject_name" name="subject_name"
                       value="<?php echo htmlspecialchars($data['subject_name'] ?? ''); ?>" placeholder="e.g. Object Oriented Programming" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="day">Day of Week</label>
                <select name="day" id="day" required>
                    <option value="">-- Select day --</option>
                    <?php
                    $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
                    foreach ($days as $d) {
                        $sel = ($data['day'] ?? '') === $d ? 'selected' : '';
                        echo "<option value=\"$d\" $sel>$d</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="instructor">Instructor</label>
                <input type="text" id="instructor" name="instructor"
                       value="<?php echo htmlspecialchars($data['instructor'] ?? ''); ?>" placeholder="e.g. Prof. Santos" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="time" id="start_time" name="start_time"
                       value="<?php echo htmlspecialchars($data['start_time'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="time" id="end_time" name="end_time"
                       value="<?php echo htmlspecialchars($data['end_time'] ?? ''); ?>" required>
            </div>
        </div>

        <!-- Class-specific fields -->
        <div id="class-fields" style="display:none;">
            <div class="form-row">
                <div class="form-group">
                    <label for="room">Room / Building</label>
                    <input type="text" id="room" name="room"
                           value="<?php echo htmlspecialchars($data['room'] ?? ''); ?>" placeholder="e.g. AV Room B-203">
                </div>
                <div class="form-group">
                    <label for="units">Credit Units</label>
                    <input type="number" id="units" name="units" min="1" max="6"
                           value="<?php echo htmlspecialchars($data['units'] ?? ''); ?>" placeholder="e.g. 3">
                </div>
                <div class="form-group">
                    <label for="lecture_hours">Lecture Hours</label>
                    <input type="number" id="lecture_hours" name="lecture_hours" min="1" max="6"
                           value="<?php echo htmlspecialchars($data['lecture_hours'] ?? ''); ?>" placeholder="e.g. 3">
                </div>
            </div>
        </div>

        <!-- Exam-specific fields -->
        <div id="exam-fields" style="display:none;">
            <div class="form-row">
                <div class="form-group">
                    <label for="exam_type">Exam Type</label>
                    <select name="exam_type" id="exam_type">
                        <option value="">-- Select --</option>
                        <?php
                        $types = ['Prelim','Midterm','Finals','Quiz','Long Test'];
                        foreach ($types as $t) {
                            $sel = ($data['exam_type'] ?? '') === $t ? 'selected' : '';
                            echo "<option value=\"$t\" $sel>$t</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="grading_period">Grading Period</label>
                    <select name="grading_period" id="grading_period">
                        <option value="">-- Select --</option>
                        <?php
                        $periods = ['First Grading','Second Grading','Midterm','Final'];
                        foreach ($periods as $p) {
                            $sel = ($data['grading_period'] ?? '') === $p ? 'selected' : '';
                            echo "<option value=\"$p\" $sel>$p</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="has_time_limit">
                        <input type="checkbox" id="has_time_limit" name="has_time_limit" value="1"
                               <?php echo !empty($data['has_time_limit']) ? 'checked' : ''; ?>>
                        Has a time limit
                    </label>
                </div>
            </div>
        </div>

        <!-- Laboratory-specific fields -->
        <div id="laboratory-fields" style="display:none;">
            <div class="form-row">
                <div class="form-group">
                    <label for="lab_room">Laboratory Room</label>
                    <input type="text" id="lab_room" name="lab_room"
                           value="<?php echo htmlspecialchars($data['lab_room'] ?? ''); ?>" placeholder="e.g. Comp Lab 1">
                </div>
                <div class="form-group">
                    <label for="equipment">Required Equipment</label>
                    <input type="text" id="equipment" name="equipment"
                           value="<?php echo htmlspecialchars($data['equipment'] ?? ''); ?>" placeholder="e.g. PC, XAMPP, IDE">
                </div>
                <div class="form-group">
                    <label for="safety_checked">
                        <input type="checkbox" id="safety_checked" name="safety_checked" value="1"
                               <?php echo !empty($data['safety_checked']) ? 'checked' : ''; ?>>
                        Safety check passed
                    </label>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Process Schedule</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
    // Show/hide type-specific fields based on selected schedule type
    var typeSelect = document.getElementById('schedule_type');
    var classFields = document.getElementById('class-fields');
    var examFields = document.getElementById('exam-fields');
    var labFields = document.getElementById('laboratory-fields');

    function toggleFields() {
        var value = typeSelect.value;
        classFields.style.display = value === 'class' ? 'block' : 'none';
        examFields.style.display = value === 'exam' ? 'block' : 'none';
        labFields.style.display = value === 'laboratory' ? 'block' : 'none';
    }

    typeSelect.addEventListener('change', toggleFields);
    toggleFields();
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
