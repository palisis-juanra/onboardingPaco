<main class="p-5 container-fluid">
    <div class="row w-100">
        
        <aside class="col-md-3">
            <h3>Choose a Channel</h3>
            <?php

            // Loop through each channel
            foreach($sentChannels as $id => $name) {
                
                print "<input type='radio' id='channel_$id' name='channels' value='$id'>";
                print "<label for='channels'>$name ($id)</label><br>";
                
            }
            
            ?>
        </aside>
        <section class="col-md-9">
            <h2>Tours</h2>
            <div id="tours">
                <div class="container">
                    <div class="row"></div>
                </div>
            </div>
        </section>
            
    </div>
</main>

<script type="text/javascript" src="resources/js/showTours.js"></script>