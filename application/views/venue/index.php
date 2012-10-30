<?php foreach ($venues as $venue_item) { ?>

    <h2><?php echo $venue_item['Name'] ?></h2>
    <div id="main">
        <pre><?php echo print_r($venue_item, true) ?></pre>
    </div>
    <p><a href="/venue/<?php echo $venue_item['VenueId'] ?>">View Venue</a></p>

<?php } ?>