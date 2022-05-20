<script src="/asset/js/jquery-3.1.1.min.js"></script>
<script src="/asset/js/popper.min.js"></script>
<script src="/asset/js/bootstrap.js"></script>
<script src="/asset/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/asset/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Flot -->
<script src="/asset/js/plugins/flot/jquery.flot.js"></script>
<script src="/asset/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="/asset/js/plugins/flot/jquery.flot.spline.js"></script>
<script src="/asset/js/plugins/flot/jquery.flot.resize.js"></script>
<script src="/asset/js/plugins/flot/jquery.flot.pie.js"></script>
<script src="/asset/js/plugins/flot/jquery.flot.symbol.js"></script>
<script src="/asset/js/plugins/flot/jquery.flot.time.js"></script>

<!-- Peity -->
<script src="/asset/js/plugins/peity/jquery.peity.min.js"></script>
<script src="/asset/js/demo/peity-demo.js"></script>

<!-- Custom and plugin javascript -->
<script src="/asset/js/inspinia.js"></script>
<script src="/asset/js/plugins/pace/pace.min.js"></script>

<!-- jQuery UI -->
<script src="/asset/js/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- Jvectormap -->
<script src="/asset/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="/asset/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- EayPIE -->
<script src="/asset/js/plugins/easypiechart/jquery.easypiechart.js"></script>

<!-- Sparkline -->
<script src="/asset/js/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- Sparkline demo data  -->
<script src="/asset/js/demo/sparkline-demo.js"></script>


{{--Data Table start--}}

<script src="/asset/js/plugins/dataTables/datatables.min.js"></script>
<script src="/asset/js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
<script src="/asset/js/plugins/select2/select2.full.min.js"></script>

<script src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>


<script>
    $(document).ready(function () {
        $('#example').DataTable({
            pageLength: 150,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                    @if(Auth::user()->user_type!=getAgentId() && Auth::user()->user_type!=getModeratorId())
                {
                    extend: 'copy'
                },
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {
                    extend: 'print',
                    customize: function (win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
                @endif
            ]


        });
    });
</script>


<!-- Page-Level Scripts -->
<script>
    $(document).ready(function () {
        $('.dataTables-example').DataTable({
            pageLength: 150,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                    @if(Auth::user()->user_type!=getAgentId() && Auth::user()->user_type!=getModeratorId())
                {
                    extend: 'copy'
                },
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {
                    extend: 'print',
                    customize: function (win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
                @endif
            ]

        })
        ;

    });

</script>
{{--Data Table End--}}
<!-- Mainly scripts -->

<!-- Select2 -->
<script src="/asset/js/plugins/select2/select2.full.min.js"></script>
<script src="/asset/js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>

<script>
    $(document).ready(function () {

        $(".select2_demo_2").select2({
            placeholder: "Select a state",
            allowClear: true
        });

        $(".district_select").select2({
            placeholder: "Select a District",
            allowClear: true
        });

    });

</script>
