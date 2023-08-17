<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Covid Data Table</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <select id="countryFilter" class="form-control filters">
                            <option value="">All Countries</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <input placeholder="Date" type="date" id="dateFilter" class="form-control filters">
                    </div>
                    <div class="col-md-2 mb-3">
                        <input placeholder="Confirm" type="number" id="confirmFilter" class="form-control filters">
                    </div>
                    <div class="col-md-2 mb-3">
                        <input placeholder="Deaths" type="number" id="deathsFilter" class="form-control filters">
                    </div>
                    <div class="col-md-2 mb-3">
                        <input placeholder="Recovered" type="number" id="recoveredFilter" class="form-control filters">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table id="datatable" class="table display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Country</th>
                            <th>Date</th>
                            <th>Confirmed</th>
                            <th>Deaths</th>
                            <th>Recovered</th>
                            <th>Active</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
                searching: false,
                paging: true,
                serverSide: true,
                ajax: {
                    url: 'get-covid-data',
                    data: function(d) {
                        d.country_id = $('#countryFilter').val();
                        d.date = $('#dateFilter').val();
                        d.confirmed = $('#confirmFilter').val();
                        d.deaths = $('#deathsFilter').val();
                        d.recovered = $('#recoveredFilter').val();

                        d.order_column = d.order[0].column; // Column index for ordering
                        d.order_dir = d.order[0].dir; // Ordering direction
                    },
                    dataSrc: function(response) {
                        $('#datatable_info').html('Showing page ' + (response.draw) + ' of ' + Math.ceil(response.recordsFiltered / response
                            .length) + ' (Total records: ' + response.recordsFiltered + ')');
                        return response.data;
                    }
                },
                columns: [{
                        'mRender': function(data, type, full) {
                            return full.countries.name
                        }
                    },
                    {
                        data: 'date'
                    },
                    {
                        data: 'Confirmed'
                    },
                    {
                        data: 'Deaths'
                    },
                    {
                        data: 'Recovered'
                    },
                    {
                        data: 'Active'
                    }
                ]
            });

            $(".filters").on('change keyup', function() {
                table.ajax.reload();
            })

            // Send order information to server
            table.on('order.dt', function() {
                table.ajax.reload();
            });
        });
    </script>
</body>

</html>
