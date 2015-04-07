<?php require_once 'config.php'; ?>
<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>Indonesia</title>

    <link href="css/bootstrap.css" rel="stylesheet">
    <style>body{margin:50px 0px;}#peta{border: 1px solid #ccc;width: 100%;height: 300px;}</style>

    <script src="js/modernizr.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">Indonesia</div>
                    <div class="panel-body">
                        <form role="form">
                            <div class="form-group">
                                <label>Provinsi : </label>
                                <select id="provinsi" class="form-control show-tick" name="provinsi" data-live-search="true">
                                    <option selected>Pilih</option>
                                    <?php
                                        $data = $database->query('SELECT * FROM provinsi ORDER BY nama');
                                        foreach ($data as $key => $value) :
                                            echo '<option value="'.$value->id.'">'.$value->nama.'</option>';
                                        endforeach;
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kabupaten : </label>
                                <select id="kabupaten" class="form-control show-tick" name="kabupaten" data-live-search="true">
                                    <option selected>Pilih</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kecamatan : </label>
                                <select id="kecamatan" class="form-control show-tick" name="kecamatan" data-live-search="true">
                                    <option selected>Pilih</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kelurahan : </label>
                                <select id="kelurahan" class="form-control show-tick" name="kelurahan" data-live-search="true">
                                    <option selected>Pilih</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Koordinat : </label>
                                <input id="koordinat" class="form-control" name="name" type="text">
                            </div>
                        </form>
                        <div id="peta"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?sensor=false&language=id"></script>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/app.js"></script>
    <script>
    $(document).ready(function() {
        $('#peta').hide();

        $('#provinsi').change(function() {
            var data = {
                'from': 'provinsi',
                'call': 'kabupaten',
                'id': $('#provinsi').val()
            };

            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: $.param(data),
                success: function(data) {
                    $('#kabupaten').html(data);
                    $('#kecamatan, #kelurahan').val('').prop('selected', true);
                    $('#koordinat').val('');
                    $('#peta').hide();

                    $('select').selectpicker('refresh');
                }
            });
        });

        $('#kabupaten').change(function() {
            var data = {
                'from': 'kabupaten',
                'call': 'kecamatan',
                'id': $('#kabupaten').val()
            };

            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: $.param(data),
                success: function(data) {
                    $('#kecamatan').html(data);
                    $('#kelurahan').val('').prop('selected', true);
                    $('#koordinat').val('');
                    $('#peta').hide();

                    $('select').selectpicker('refresh');
                }
            });
        });

        $('#kecamatan').change(function() {
            var data = {
                'from': 'kecamatan',
                'call': 'kelurahan',
                'id': $('#kecamatan').val()
            };

            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: $.param(data),
                success: function(data) {
                    $('#kelurahan').html(data);
                    $('#koordinat').val('');
                    $('#peta').hide();

                    $('select').selectpicker('refresh');
                }
            });
        });

        $('#kelurahan').change(function() {
            var search = [$('#kelurahan option:selected').text(), $('#kecamatan option:selected').text(), $('#kabupaten option:selected').text(), $('#provinsi option:selected').text()].join(', ');

            $.ajax({
                type: 'POST',
                url: 'https://maps.googleapis.com/maps/api/geocode/json?address='+search+'&sensor=false',
                data: $.param(search),
                success: function(data) {
                    $('#koordinat').val(data.results[0].geometry.location.lat + ',' + data.results[0].geometry.location.lng);
                    $('#peta').show();

                    return indonesia.peta($('#peta')[0], search, data.results[0].geometry.location.lat, data.results[0].geometry.location.lng);
                }
            });
        });

        $('input').val('');

        $('select').val('').prop('selected', true);

        $('select').selectpicker();
    });
    </script>
</body>
</html>
