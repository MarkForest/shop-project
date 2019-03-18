<div class="row">
    <h1 class="page-header">Admin Cool Panel</h1>
    <?php
    connect();
//    Country
    $selectCountry = "select * from  countries order by id";
    $resourseCountry = mysql_query($selectCountry);
//    Cities
    $selectCity = "select ci.id, ci.city, co.country from cities as ci, countries as co where co.id = ci.countryid";
    $resourseCity = mysql_query($selectCity);
//    Hotels
    $selectHotels = "select ci.id, ci.city, ho.id, ho.hotel, ho.cityid, ho.countryid, ho.stars, ho.info,co.id, co.country 
                        from cities as ci, countries as co, hotels as ho 
                        where co.id = ci.countryid and ho.cityid = ci.id";
    $selectCityCountry = "select ci.id, ci.city, co.country, co.id from countries as co, cities as ci where ci.countryid = co.id";
    $resoursseCityCountry = mysql_query($selectCityCountry);
    $resourseHotels = mysql_query($selectHotels);
//    Images
    $selectImages = "select ho.id, co.country, ci.city, ho.hotel from countries as co, cities as ci, hotels as ho 
                      where co.id = ho.countryid and ci.id = ho.cityid order by co.country";
    $resourseImages = mysql_query($selectImages);



    ?>
    <div class="col-md-6">
<!--    todo    section A: for form Countries-->
        <form action="index.php?page=4" method="post">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3>Form For Countries</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <?php while ($row = mysql_fetch_array($resourseCountry)):?>
                            <tr>
                                <td><?= $row[0]?></td>
                                <td><?= $row[1] ?></td>
                                <td><input type="checkbox" name="cb<?= $row[0]?>"></td>
                            </tr>
                        <?php endwhile;?>
                    </table>
                    <?php mysql_free_result($resourseCountry);?>
                    <div class="form-group">
                        <input type="text" name="country" placeholder="Country" class="form-control">
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="form-group">
                        <input type="submit" name="addcountry" value="Add" class="btn btn-info">
                        <input type="submit" name="delcountry" value="Delete" class="btn btn-danger">
                    </div>
                </div>
            </div>
        </form>
        <?php
            if (isset($_POST['addcountry'])) {
                $country = trim(htmlspecialchars($_POST['country']));
                if ($country == '') {
                    return false;
                }
                $insert = "insert into countries(country)values('$country')";
                mysql_query($insert);
                log_mysql(mysql_errno());
                page_reload();
            }
            if (isset($_POST['delcountry'])) {
                foreach ($_POST as $key => $value) {
                    if (substr($key, 0, 2) == "cb") {
                        $idc = substr($key, 2);
                        $delete = "delete from countries where id = $idc";
                        mysql_query($delete);
                        log_mysql(mysql_errno());
                    }
                }
                page_reload();
            }
        ?>
    </div>
    <div class="col-md-6">
<!--    todo    section B: for form Cities-->
        <form action="index.php?page=4" method="post">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3>Form For Cities</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <?php while ($row = mysql_fetch_array($resourseCity)):?>
                            <tr>
                                <td><?= $row[0]?></td>
                                <td><?= $row[1] ?></td>
                                <td><?= $row[2] ?></td>
                                <td><input type="checkbox" name="ci<?= $row[0]?>"></td>
                            </tr>
                        <?php endwhile;?>
                    </table>
                    <?php mysql_free_result($resourseCity);?>
                    <div class="form-group">
                        <select name="countryname" class="form-control">
                            <?php $res = mysql_query($selectCountry)?>
                            <?php while ($row = mysql_fetch_array($res)):?>
                                <option value="<?=$row[0]?>"><?= $row[1]?></option>
                            <?php endwhile;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="city" placeholder="City" class="form-control">
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="form-group">
                        <input type="submit" name="addcity" value="Add" class="btn btn-info">
                        <input type="submit" name="delcity" value="Delete" class="btn btn-danger">
                    </div>
                </div>
            </div>
        </form>
        <?php
            if (isset($_POST['addcity'])) {
                $city = trim(htmlspecialchars($_POST['city']));
                if ($city == '') {
                    return false;
                }
                $countryid = $_POST['countryname'];
                $insert = "insert into cities(city, countryid)values('$city', $countryid)";
                mysql_query($insert);
                log_mysql(mysql_errno());
                page_reload();
            }
            if (isset($_POST['delcity'])) {
                foreach ($_POST as $key => $value) {
                    if (substr($key, 0, 2) == "ci") {
                        $idc = substr($key, 2);
                        $delete = "delete from cities where id = $idc";
                        mysql_query($delete);
                        log_mysql(mysql_errno());
                    }
                }
                page_reload();
            }
        ?>
    </div>
    <div class="col-md-6">
<!--    todo    section C: for form Hotels-->
        <form action="index.php?page=4" method="post">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3>Form For Hotels</h3>
                </div>
                <div class="panel-body">
<!--                    Show hotels-->
                    <table class="table table-striped">
                        <?php $hackStyleArray = [];?>
                        <?php while ($row = mysql_fetch_array($resourseHotels)):?>
                            <tr>
                                <td><?= $row[2]?></td>
                                <td><?= "$row[1] - $row[9]" ?></td>
                                <td><?= $row[3]?></td>
                                <td><?= $row[6]?></td>
                                <td><input type="checkbox" name="hb<?= $row[2]?>"></td>
                            </tr>
                        <?php endwhile;?>
                    </table>
<!--                Show form-->
                    <div class="form-group">
                        <select name="hcity" class="form-control">
                            <?php while ($row = mysql_fetch_array($resoursseCityCountry)):?>
                                <option value="<?= $row[0]?>"><?= "$row[1] : $row[2]"?></option>
                                <?php $hackStyleArray[$row[0]] = $row[3];?>
                            <?php endwhile;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="hotel" placeholder="Hotel Title" class="form-control">
                    </div>
                    <div class="form-inline">
                        <label>
                            Cost: <input type="text" name="cost" placeholder="Cost" class="form-control">
                        </label>
                        <label>
                            Stars: <input type="number" name="stars" max="5" min="1" value="3" class="form-control">
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="Info">Info about</label>
                        <textarea name="info" rows="2" cols="70" placeholder="Description"></textarea>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="form-group">
                        <input type="submit" name="addhotel" value="Add" class="btn btn-info">
                        <input type="submit" name="delhotel" value="Delete" class="btn btn-danger">
                    </div>
                </div>
            </div>
        </form>
        <?php mysql_free_result($resourseHotels);?>
        <?php mysql_free_result($resoursseCityCountry);?>
        <?php
            if (isset($_POST['addhotel'])) {
                $hotel = trim(htmlspecialchars($_POST['hotel']));
                $cost = trim(htmlspecialchars($_POST['cost']));
                $stars = trim(htmlspecialchars($_POST['stars']));
                $info = trim(htmlspecialchars($_POST['info']));
                if ($hotel == '' || $cost == '' || $stars == '' || $info == '') {
                    return false;
                }
                $cityid = $_POST['hcity'];
                $countryid = $hackStyleArray[$cityid];
                $insert = "insert into hotels(hotel, cityid, countryid, stars, cost, info)
                          values('$hotel', $cityid, $countryid, $stars, $cost, '$info')";
                mysql_query($insert);
                log_mysql(mysql_errno());
                page_reload();
            }
            if (isset($_POST['delhotel'])) {
                foreach ($_POST as $key => $value) {
                    if (substr($key, 0, 2) == "hb") {
                        $idc = substr($key, 2);
                        $delete = "delete from hotels where id = $idc";
                        mysql_query($delete);
                        log_mysql(mysql_errno());
                    }
                }
                page_reload();
            }
        ?>
    </div>
    <div class="col-md-6">
<!--    todo    section D: for form Images-->
        <form action="index.php?page=4" method="post" enctype="multipart/form-data">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3>Form For Images</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <select name="hotelid" class="form-control">
                            <?php while($row = mysql_fetch_array($resourseImages)):?>
                                <option value="<?=$row[0]?>"><?="$row[1] : $row[2] : $row[3]"?></option>
                            <?php endwhile;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="file" name="file[]" multiple class="form-control">
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="form-group">
                        <input type="submit" name="addimage" value="Add" class="btn btn-info">
                    </div>
                </div>
            </div>
        </form>
        <?php
            if (isset($_POST['addimage'])) {
                foreach ($_FILES['file']['name'] as $key => $value) {
                    if ($_FILES['file']['error'][$key] != 0) {
                        echo '<script>';
                        echo "alert('Error file!!')";
                        echo '</script>';
                        continue;
                    }
                    if (move_uploaded_file($_FILES['file']['tmp_name'][$key], "images/$value")){
                        $hotelid = $_POST['hotelid'];
                        $imagepath = "images/$value";
                        $insert = "insert into images(hotelid, imagepath)values($hotelid, '$imagepath')";
                        mysql_query($insert);
                    }


                }
            }
        ?>
    </div>
</div>