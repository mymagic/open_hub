
<h1>
<a class="btn btn-xs btn-primary pull-right" href="<?php echo $this->createUrl('/event/timeline'); ?>">Timeline</a>
    <?php echo Yii::t('backend', 'Event Overview'); ?>
</h1>

<div class="row">
<div class="container-flex">

<div class="col col-sm-3 item-flex">
    <div class="contact-box full-width">
        <h3>General</h3>
        <table class="table">
            <tbody>
            <tr>
                <td>
                    <button type="button" class="btn btn-danger btn-sm m-r-sm"><?php echo $stat['general']['totalEvents']; ?></button>
                    Total Active Events
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" class="btn btn-default btn-sm m-r-sm"><?php echo $stat['general']['totalCancelledEvents']; ?></button>
                    Cancelled Events
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" class="btn btn-white btn-sm m-r-sm"><?php echo $stat['general']['totalActiveEventGroups']; ?></button>
                    Total Event Group
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>


<div class="col col-sm-3 item-flex">
    <div class="contact-box full-width">
        <h3>Registrations</h3>
        <table class="table">
            <tbody>
            <tr>
                <td>
                    <button type="button" class="btn btn-success btn-sm m-r-sm"><?php echo $stat['general']['totalRegistrations']; ?></button>
                    Registered
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" class="btn btn-primary btn-sm m-r-sm"><?php echo $stat['general']['totalAttendedRegistrations']; ?></button>
                    Attended
                </td>
            </tr>
            <tr><td></td></tr> 
            <tr>
                <td>
                    <button type="button" class="btn btn-white btn-sm m-r-sm"><?php echo $stat['gender']['female']; ?></button>
                    Registered Female
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" class="btn btn-white btn-sm m-r-sm"><?php echo $stat['gender']['male']; ?></button>
                    Registered Male
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" class="btn btn-white btn-sm m-r-sm"><?php echo $stat['gender']['unknown']; ?></button>
                    Reg. Unknown Gender
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="col col-sm-3 item-flex">
    <div class="contact-box full-width">
        <h3>Unique Registrations</h3>
        <table class="table">
            <tbody>
            <tr>
                <td>
                    <button type="button" class="btn btn-success btn-sm m-r-sm"><?php echo $stat['general']['totalUniqueRegistrations']; ?></button>
                    Registered
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" class="btn btn-primary btn-sm m-r-sm"><?php echo $stat['general']['totalUniqueAttendedRegistrations']; ?></button>
                    Attended
                </td>
            </tr>
            <tr><td></td></tr> 
            <tr>
                <td>
                    <button type="button" class="btn btn-white btn-sm m-r-sm"><?php echo $stat['gender']['uniqueFemale']; ?></button>
                    Registered Female
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" class="btn btn-white btn-sm m-r-sm"><?php echo $stat['gender']['uniqueMale']; ?></button>
                    Registered Male
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" class="btn btn-white btn-sm m-r-sm"><?php echo $stat['gender']['uniqueUnknown']; ?></button>
                    Reg. Unknown Gender
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="col col-sm-3 item-flex">
    <div class="contact-box full-width">
        <h3>Data Quality</h3>
        <table class="table">
            <tbody>
            <tr>
                <td>
                    <button type="button" class="btn btn-white btn-sm m-r-sm"><?php echo $stat['quality']['noRegistration']; ?></button>
                    Event without registration
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" class="btn btn-white btn-sm m-r-sm"><?php echo $stat['quality']['noEmail']; ?></button>
                    No Email
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" class="btn btn-white btn-sm m-r-sm"><?php echo $stat['quality']['noName']; ?></button>
                    No Name
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" class="btn btn-white btn-sm m-r-sm"><?php echo $stat['quality']['noNationality']; ?></button>
                    No Nationality
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" class="btn btn-white btn-sm m-r-sm"><?php echo $stat['quality']['noEventVendorCode']; ?></button>
                    No Event Vendor Code
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>


</div>
</div>