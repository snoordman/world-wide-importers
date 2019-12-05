<div class="login-page">
    <form method="post" class="login-form">
        <h1 class="text-center">Registreer</h1>
        <div class="form-group">
            <label for="firstName">Voornaam: </label>
            <input id="firstName" type="text" class="form-control" placeholder="Voornaam" name="firstName" required="required">
        </div>
        <div class="form-group">
            <label for="lastName">Achternaam: </label>
            <input id="lastName" type="text" class="form-control" placeholder="Achternaam" name="lastName" required="required">
        </div>
        <div class="form-group">
            <label for="email">Email: </label>
            <input id="email" type="text" class="form-control" placeholder="E-mailadres" name="email" required="required">
        </div>
        <div class="form-group">
            <label for="phoneNumber">Telefoon nummer: </label>
            <input id="phoneNumber" type="text" class="form-control" placeholder="Telefoonnummer" name="phoneNumber">
        </div>
        <div class="form-group">
            <label for="password">Wachtwoord: </label>
            <input id="password" type="password" class="form-control" placeholder="Wachtwoord" name="password">
        </div>
        <div class="form-group">
            <label for="confirmPassword">Besvestig Wachtwoord: </label>
            <input id="confirmPassword" type="password" class="form-control" placeholder="Bevestig wachtwoord" name="confirmPassword">
        </div>
            <label for="countries">Land: </label>
            <select name="country" id="country">
                <?php
                foreach ($countries as $country){
                    echo "<option value='".htmlentities($country["CountryID"])."'>".htmlentities($country["CountryName"])."</option>";
                }
                ?>
            </select>
        <div class="form-group">
            <label for="province">Provincie: </label>
            <select name="province" id="province">
                <?php
                foreach ($provinces as $province){
                    echo "<option value='".htmlentities($province["StateProvinceID"])."'>".htmlentities($province["StateProvinceName"])."</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="city">Stad: </label>
            <select name="city" id="city">
                <?php
                foreach ($cities as $city){
                    echo "<option value='".htmlentities($province["CityID"])."'>".htmlentities($province["CityName"])."</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="street">Straat: </label>
            <input type="text" name="street" id="street" value="">
        </div>
        <div class="form-group">
            <label for="zip">Postcoce: </label>
            <input type="text" name="zip" id="zip" value="">
        </div>
        <?php
        if(checkPermissions("isSystemUser")){
        ?>
        <div class="form-group">
            <input id="systemUser" type="checkbox" class="form-control" placeholder="is SystemUser" name="permissions">
            <input id="employee" type="checkbox" class="form-control" placeholder="is Employee" name="permissions">
            <input id="salesPerson" type="checkbox" class="form-control" placeholder="is SalesPerson" name="permissions">
        </div>
        <?php
        }
        ?>
        <div class="form-group">
            <input type="submit" class="form-control btn-primary" value="Registreer" name="submitRegister">
        </div>
    </form>
</div>