<main class="p-5 container-fluid">
    <div class="row w-100">

        <h2 class="mb-3 w-100"><?php print "<b>".$tour['tour_id']."</b> - ".$tour['tour_name'] ?></h2>
        <form action="../../api.php" id="update_tour" method="POST" class="w-50">
            <div class="mb-3">
                <img src="<?php print $tour['images']['image']['url'] ?>" height="200px"/>
                <label for="formFile" class="form-label"></label>
                <input class="form-control" type="file" id="formFile">
                <!-- <input type="file" id="image"> -->
            </div>
            <div class="mb-3">
                <label for="tour_name" class="form-label">Tour name</label>
                <input type="text" id="tour_name" name="tour_name" class="form-control" placeholder="Tour name" value="<?php print $tour['tour_name'] ?>" />
            </div>
            <div class="mb-3">
                <label for="tour_desc" class="form-label">Tour description</label>
                <textarea id="tour_desc" name="tour_desc" class="form-control" placeholder="Tour desc" ><?php print $tour['shortdesc'] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="time_type" class="form-label">Time Type</label>
                <select class="form-select" id="time_type" name="time_type" aria-label="Default select example">
                    <option value="strict" <?php if($tour['time_type'] === 'strict') print 'selected'; ?>>Tour start and end times (Default)</option>
                    <option value="opening_hours" <?php if($tour['time_type'] === 'opening_hours') print 'selected'; ?>>Opening Hours</option>
                    <option value="strict_start" <?php if($tour['time_type'] === 'strict_start') print 'selected'; ?>>Entry time with flexible duration</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="start_time" class="form-label">Start Time</label>
                <select class="form-select" id="start_time" name="start_time" aria-label="Default select example">
                    <option value="NOTSET" <?php if($tour['start_time'] === 'NOTSET') print 'selected'; ?>>NOT SET</option>
                    <?php for ($i = 0; $i < (24 * 60); $i = $i + 5) { 
                        $fullTime = $mainController->getFullHourByMinutes($i);?>
                        <option value="<?php print $fullTime ?>" <?php if($tour['start_time'] === $fullTime) print 'selected'; ?>><?php print $fullTime ?></option>
                    <?php } ?>
                    <option value="MULTI" <?php if($tour['start_time'] === 'MULTI') print 'selected'; ?>>MULTI</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="end_time" class="form-label">End Time</label>
                <select class="form-select" id="end_time" name="end_time" aria-label="Default select example">
                    <option value="NOTSET" <?php if($tour['end_time'] === 'NOTSET') print 'selected'; ?>>NOT SET</option>
                    <?php for ($i = 0; $i < (24 * 60); $i = $i + 5) { 
                        $fullTime = $mainController->getFullHourByMinutes($i);?>
                        <option value="<?php print $fullTime ?>" <?php if($tour['end_time'] === $fullTime) print 'selected'; ?>><?php print $fullTime ?></option>
                    <?php } ?>
                    <option value="MULTI" <?php if($tour['end_time'] === 'MULTI') print 'selected'; ?>>MULTI</option>
                </select>
            </div>
            <!-- start_timezone -->
            <div class="mb-3">
                <label for="start_timezone" class="form-label">Start Timezone</label>
                <select class="form-select" id="start_timezone" name="start_timezone" aria-label="Default select example">
                    <option value="NOTSET" <?php if($tour['start_timezone'] === 'NOTSET') print 'selected'; ?>>NOT SET</option>
                    <?php foreach(timezone_identifiers_list() as $timezone) { ?>
                        <option value="<?php print $timezone ?>" <?php if($tour['start_timezone'] === $timezone) print 'selected'; ?>><?php print $timezone ?></option>
                    <?php } ?>
                </select>
            </div>
            <!-- end_timezone -->
            <div class="mb-3">
                <label for="end_timezone" class="form-label">End Timezone</label>
                <select class="form-select" id="end_timezone" name="end_timezone" aria-label="Default select example">
                    <option value="NOTSET" <?php if($tour['end_timezone'] === 'NOTSET') print 'selected'; ?>>NOT SET</option>
                    <?php foreach(timezone_identifiers_list() as $timezone) { ?>
                        <option value="<?php print $timezone ?>" <?php if($tour['end_timezone'] === $timezone) print 'selected'; ?>><?php print $timezone ?></option>
                    <?php } ?>
                </select>
            </div>
            <!-- grade -->
            <div class="mb-3">
                <label for="grade" class="form-label">Grade</label>
                <select class="form-select" id="grade" name="grade" aria-label="Default select example">
                    <option value="1" <?php if($tour['grade'] === '1') print 'selected'; ?>>All ages / Not applicable</option>
                    <option value="2" <?php if($tour['grade'] === '2') print 'selected'; ?>>Moderate</option>
                    <option value="3" <?php if($tour['grade'] === '3') print 'selected'; ?>>Fit</option>
                    <option value="4" <?php if($tour['grade'] === '4') print 'selected'; ?>>Challenging</option>
                    <option value="5" <?php if($tour['grade'] === '5') print 'selected'; ?>>Extreme</option>
                </select>
            </div>
            <!-- accomrating -->
            <div class="mb-3">
                <label for="accomrating" class="form-label">Accomrating</label>
                <select class="form-select" id="acommrating" name="acommrating" aria-label="Default select example">
                    <option value="1" <?php if($tour['accomrating'] === '1') print 'selected'; ?>>No accommodation / Not applicable</option>
                    <option value="2" <?php if($tour['accomrating'] === '2') print 'selected'; ?>>Luxury</option>
                    <option value="3" <?php if($tour['accomrating'] === '3') print 'selected'; ?>>Moderate</option>
                    <option value="4" <?php if($tour['accomrating'] === '4') print 'selected'; ?>>Comfortable</option>
                    <option value="5" <?php if($tour['accomrating'] === '5') print 'selected'; ?>>Basic</option>
                    <option value="6" <?php if($tour['accomrating'] === '6') print 'selected'; ?>>Various levels</option>
                </select>
            </div>
            <input type="hidden" name="tour_id" value="<?php print $tour['tour_id'] ?>" />
            <button type="submit" class="btn btn-secondary">Save Changes</button>
        </form>
        
    </div>
</main>

<script type="text/javascript" src="resources/js/updateTour.js"></script>