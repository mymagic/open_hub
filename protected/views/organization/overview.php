
<h1>
    <?php echo Yii::t('backend', 'Company Overview'); ?>
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
                    <button type="button" class="btn btn-danger btn-sm m-r-sm"><?php echo $stat['general']['totalOrganizations'] ?></button>
                    Total Organisations
                </td>
            </tr>
            </tbody>
        </table>

        <h3>Persona</h3>
        <table class="table">
        <tbody>
            <?php foreach($stat['persona'] as $personaTitle=>$personaCount): ?>
            <tr>
                <td>
                    <button type="button" class="btn btn-default btn-sm m-r-sm"><?php echo $personaCount ?></button>
                    <?php echo $personaTitle ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p class="text-muted">Note: A company can have multiple personas</p>
    </div>
</div>

<div class="col col-sm-3 item-flex">
    <div class="contact-box full-width">
        <h3>Country</h3> 
        <table class="table">
        <tbody>
        <?php foreach($stat['country'] as $countryTitle=>$countryCount): ?>
            <tr>
                <td>
                    <button type="button" class="btn btn-primary btn-sm m-r-sm"><?php echo $countryCount ?></button>
                    <?php echo $countryTitle ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p class="text-muted">Note: A company can have multiple industries</p>
    </div>
</div>

<div class="col col-sm-3 item-flex">
    <div class="contact-box full-width">
        <h3>Industry</h3> 
        <table class="table">
        <tbody>
        <?php foreach($stat['industry'] as $industryTitle=>$industryCount): ?>
            <tr>
                <td>
                    <button type="button" class="btn btn-primary btn-sm m-r-sm"><?php echo $industryCount ?></button>
                    <?php echo $industryTitle ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p class="text-muted">Note: A company can have multiple industries</p>
    </div>
</div>

<div class="col col-sm-3 item-flex">
    <div class="contact-box full-width">
        <h3>Impact</h3>
        <table class="table">
        <tbody>
        <?php foreach($stat['impact'] as $impactTitle=>$impactCount): ?>
            <tr>
                <td>
                    <button type="button" class="btn btn-primary btn-sm m-r-sm"><?php echo $impactCount ?></button>
                    <?php echo $impactTitle ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p class="text-muted">Note: A company can have multiple impacts</p>
    </div>
</div>

<div class="col col-sm-3 item-flex">
    <div class="contact-box full-width">
        <h3>SDG</h3>
        <table class="table">
        <tbody>
        <?php foreach($stat['sdg'] as $sdgTitle=>$sdgCount): ?>
            <tr>
                <td>
                    <button type="button" class="btn btn-primary btn-sm m-r-sm"><?php echo $sdgCount ?></button>
                    <?php echo $sdgTitle ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p class="text-muted">Note: A company can have multiple sdgs</p>
    </div>
</div>

<div class="col col-sm-3 item-flex">
    <div class="contact-box full-width">
        <h3>Data Quality</h3>
        <table class="table">
            <tbody>
            <tr>
                <td>
                    <button type="button" class="btn btn-white btn-sm m-r-sm"><?php echo $stat['quality']['noOneLiner'] ?></button>
                    Without One Liner
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" class="btn btn-white btn-sm m-r-sm"><?php echo $stat['quality']['noLogo'] ?></button>
                    Without Logo
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" class="btn btn-white btn-sm m-r-sm"><?php echo $stat['quality']['noAddressCountryCode'] ?></button>
                    Without Country
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" class="btn btn-white btn-sm m-r-sm"><?php echo $stat['quality']['noEmailAccess'] ?></button>
                    Without Email Access
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" class="btn btn-white btn-sm m-r-sm"><?php echo $stat['quality']['noPersona'] ?></button>
                    Without Persona
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" class="btn btn-white btn-sm m-r-sm"><?php echo $stat['quality']['noIndustry'] ?></button>
                    Without Industry
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" class="btn btn-white btn-sm m-r-sm"><?php echo $stat['quality']['noImpact'] ?></button>
                    Without Impact
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

</div>
</div>