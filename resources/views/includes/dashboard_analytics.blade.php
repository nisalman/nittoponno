<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js"></script>

<script type="text/javascript">

    var label_1  = [];
    var data_1  = [];
    var data_2  = [];
    var total_login = {!! json_encode($total_login->toArray()) !!};
    var total_unique_login = {!! json_encode($total_unique_login->toArray()) !!};
    // console.log(total_login[0].date);

    total_login.forEach(function(item, index) {
        const d = new Date(item.date)
        const ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(d)
        const mo = new Intl.DateTimeFormat('en', { month: 'short' }).format(d)
        const da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(d)

        console.log(`${da}-${mo}-${ye}`)
        label_1[index] = `${da}-${mo}`;
        data_1[index] = item.count;
    });

    total_unique_login.forEach(function(item, index) {
        data_2[index] = item.count;
    });



    // console.log(label_1);
    var ctx = document.getElementById('myChart');
    ctx.height = 100;
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: label_1,
            datasets: [{
                label: 'Total Login',
                data: data_1,
                backgroundColor: [
                    'rgba(255, 99, 132, 0)',
                    'rgba(54, 162, 235, 0)',
                    'rgba(255, 206, 86, 0)',
                    'rgba(75, 192, 192, 0)',
                    'rgba(153, 102, 255, 0)',
                    'rgba(255, 159, 64, 0)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            },

                {
                    label: 'Total individual login',
                    data: data_2,
                    backgroundColor: [
                        'rgba(254, 99, 132, 0)',

                    ],
                    borderColor: [
                        'rgba(100, 99, 132, 1)',

                    ],
                    borderWidth: 1
                }

            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
