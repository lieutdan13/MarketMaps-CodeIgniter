<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<table class="modelList">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Address</th>
        <th>Venue Type</th>
        <th>Actions</th>
    </tr>
<?php foreach ($venues as $venue_item) { ?>
    <tr>
        <td><?php echo $venue_item['VenueId']?></td>
        <td><?php echo $venue_item['Name']?></td>
        <td>
            <?php echo $venue_item['Address']?><br/>
            <?php echo "{$venue_item['City']}, {$venue_item['State']} {$venue_item['PostalCode']}"?><br/>
        </td>
        <td><?php echo $venue_item['VenueType']?></td>
        <td><a href="/venue/<?php echo $venue_item['VenueId'] ?>">View Venue</a></td>
    </tr>
<?php } ?>
</table>